<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FootballMatch;
use App\Models\FootballPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FootballPredictionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $availableMatches = FootballMatch::with(['predictions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->where('is_published', true)
            ->whereNotIn('status', [FootballMatch::STATUS_FINISHED, FootballMatch::STATUS_CANCELLED])
            ->orderBy('match_date')
            ->orderBy('kickoff_time')
            ->get();

        $predictions = FootballPrediction::with(['footballMatch.coupon'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $entitlements = $user->footballCouponEntitlements()
            ->with(['coupon', 'footballMatch', 'order'])
            ->get()
            ->keyBy('football_match_id');

        return view('account.football_predictions', compact('availableMatches', 'predictions', 'entitlements'));
    }

    public function store(Request $request, FootballMatch $footballMatch)
    {
        $data = $request->validate([
            'prediction_pick' => ['nullable', Rule::in(FootballPrediction::availablePicks())],
            'home_score' => ['nullable', 'required_without:prediction_pick', 'integer', 'min:0', 'max:30'],
            'away_score' => ['nullable', 'required_without:prediction_pick', 'integer', 'min:0', 'max:30'],
        ]);

        DB::transaction(function () use ($footballMatch, $data) {
            $match = FootballMatch::whereKey($footballMatch->id)->lockForUpdate()->firstOrFail();

            if (! $match->predictionsAreOpen()) {
                abort(403, 'Predictions are closed for this match.');
            }

            $this->savePrediction($match, Auth::id(), $data);
        });

        return back()->with('success', 'Prediction saved successfully.');
    }

    public function storeMany(Request $request)
    {
        $data = $request->validate([
            'predictions' => ['required', 'array', 'min:1'],
            'predictions.*' => ['required', Rule::in(FootballPrediction::availablePicks())],
        ]);

        $userId = Auth::id();
        $matchIds = collect(array_keys($data['predictions']))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($matchIds->isEmpty()) {
            throw ValidationException::withMessages([
                'predictions' => 'Select at least one match prediction.',
            ]);
        }

        DB::transaction(function () use ($data, $matchIds, $userId) {
            $matches = FootballMatch::whereIn('id', $matchIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $errors = [];

            foreach ($data['predictions'] as $matchId => $pick) {
                $match = $matches->get((int) $matchId);

                if (! $match || ! $match->predictionsAreOpen()) {
                    $errors['predictions.' . $matchId] = 'Predictions are closed for this match.';
                }
            }

            if ($errors) {
                throw ValidationException::withMessages($errors);
            }

            foreach ($data['predictions'] as $matchId => $pick) {
                $this->savePrediction($matches->get((int) $matchId), $userId, [
                    'prediction_pick' => $pick,
                ]);
            }
        });

        return back()->with('success', 'Predictions saved successfully.');
    }

    private function savePrediction(FootballMatch $match, int $userId, array $data): void
    {
        $pick = $data['prediction_pick'] ?? null;

        if ($pick) {
            [$homeScore, $awayScore] = FootballPrediction::scoreForPick($pick);
        } else {
            $homeScore = (int) $data['home_score'];
            $awayScore = (int) $data['away_score'];
        }

        FootballPrediction::updateOrCreate(
            [
                'football_match_id' => $match->id,
                'user_id' => $userId,
            ],
            [
                'prediction_pick' => $pick,
                'home_score' => $homeScore,
                'away_score' => $awayScore,
                'status' => FootballPrediction::STATUS_PENDING,
            ]
        );
    }
}
