<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FootballMatch;
use App\Models\FootballPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'home_score' => ['required', 'integer', 'min:0', 'max:30'],
            'away_score' => ['required', 'integer', 'min:0', 'max:30'],
        ]);

        DB::transaction(function () use ($footballMatch, $data) {
            $match = FootballMatch::whereKey($footballMatch->id)->lockForUpdate()->firstOrFail();

            if (! $match->predictionsAreOpen()) {
                abort(403, 'Predictions are closed for this match.');
            }

            FootballPrediction::updateOrCreate(
                [
                    'football_match_id' => $match->id,
                    'user_id' => Auth::id(),
                ],
                [
                    'home_score' => (int) $data['home_score'],
                    'away_score' => (int) $data['away_score'],
                    'status' => FootballPrediction::STATUS_PENDING,
                ]
            );
        });

        return back()->with('success', 'Prediction saved successfully.');
    }
}
