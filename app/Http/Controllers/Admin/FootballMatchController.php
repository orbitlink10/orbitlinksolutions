<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\FootballMatch;
use App\Services\FootballPromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FootballMatchController extends Controller
{
    public function __construct(private FootballPromotionService $footballPromotionService)
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = FootballMatch::with('coupon')->withCount('predictions');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('home_team', 'like', "%{$search}%")
                    ->orWhere('away_team', 'like', "%{$search}%")
                    ->orWhere('competition', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $matches = $query->latest('match_date')->paginate(25);

        return view('admin.football.index', compact('matches'));
    }

    public function create()
    {
        return view('admin.football.create', [
            'match' => new FootballMatch([
                'status' => FootballMatch::STATUS_UPCOMING,
                'is_published' => true,
                'coupon_discount_type' => Coupon::TYPE_PERCENTAGE,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['created_by'] = Auth::id();

        $match = FootballMatch::create($data);

        return redirect()->route('admin.football-matches.show', $match)->with('success', 'Football match created successfully.');
    }

    public function show(FootballMatch $footballMatch)
    {
        $footballMatch->load(['coupon', 'predictions.user', 'entitlements.user', 'entitlements.order']);

        return view('admin.football.show', ['match' => $footballMatch]);
    }

    public function edit(FootballMatch $footballMatch)
    {
        return view('admin.football.edit', ['match' => $footballMatch]);
    }

    public function update(Request $request, FootballMatch $footballMatch)
    {
        if ($footballMatch->status === FootballMatch::STATUS_FINISHED) {
            return back()->with('error', 'Finished matches cannot be edited.');
        }

        $footballMatch->update($this->validatedData($request));

        return redirect()->route('admin.football-matches.show', $footballMatch)->with('success', 'Football match updated successfully.');
    }

    public function result(FootballMatch $footballMatch)
    {
        $footballMatch->load('predictions')->loadCount('predictions');

        return view('admin.football.result', ['match' => $footballMatch]);
    }

    public function publishResult(Request $request, FootballMatch $footballMatch)
    {
        $data = $request->validate([
            'home_score' => ['required', 'integer', 'min:0', 'max:30'],
            'away_score' => ['required', 'integer', 'min:0', 'max:30'],
        ]);

        $result = $this->footballPromotionService->publishResult(
            $footballMatch,
            (int) $data['home_score'],
            (int) $data['away_score'],
            Auth::user()
        );

        return redirect()
            ->route('admin.football-matches.show', $footballMatch)
            ->with('success', "Result published. Coupon {$result['code']} created for {$result['winners_count']} winner(s).");
    }

    private function validatedData(Request $request): array
    {
        $statuses = [
            FootballMatch::STATUS_UPCOMING,
            FootballMatch::STATUS_PREDICTION_CLOSED,
            FootballMatch::STATUS_LIVE,
            FootballMatch::STATUS_FINISHED,
            FootballMatch::STATUS_CANCELLED,
        ];

        $data = $request->validate([
            'home_team' => ['required', 'string', 'max:120'],
            'away_team' => ['required', 'string', 'max:120'],
            'home_abbreviation' => ['nullable', 'string', 'max:10'],
            'away_abbreviation' => ['nullable', 'string', 'max:10'],
            'competition' => ['nullable', 'string', 'max:120'],
            'match_date' => ['required', 'date'],
            'kickoff_time' => ['nullable', 'date_format:H:i'],
            'prediction_closes_at' => ['required', 'date'],
            'status' => ['required', Rule::in($statuses)],
            'is_published' => ['nullable', 'boolean'],
            'coupon_discount_type' => ['required', Rule::in([Coupon::TYPE_PERCENTAGE, Coupon::TYPE_FIXED])],
            'coupon_discount_value' => ['required', 'numeric', 'min:0.01'],
            'coupon_description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['home_abbreviation'] = $this->footballPromotionService->normalizeAbbreviation(
            $data['home_abbreviation'] ?: $this->footballPromotionService->suggestAbbreviation($data['home_team'])
        );
        $data['away_abbreviation'] = $this->footballPromotionService->normalizeAbbreviation(
            $data['away_abbreviation'] ?: $this->footballPromotionService->suggestAbbreviation($data['away_team'])
        );

        validator($data, [
            'home_abbreviation' => ['required', 'regex:/^[A-Z0-9]{2}$/'],
            'away_abbreviation' => ['required', 'regex:/^[A-Z0-9]{2}$/'],
        ])->validate();

        if ($data['coupon_discount_type'] === Coupon::TYPE_PERCENTAGE && (float) $data['coupon_discount_value'] > 100) {
            validator([], [])->after(function ($validator) {
                $validator->errors()->add('coupon_discount_value', 'Percentage discounts cannot be greater than 100.');
            })->validate();
        }

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
