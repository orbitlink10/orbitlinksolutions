<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\FootballCouponEntitlement;
use App\Models\FootballMatch;
use App\Models\FootballPrediction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FootballPromotionService
{
    private const COMMON_ABBREVIATIONS = [
        'MANCHESTER UNITED' => 'MA',
        'ARSENAL' => 'AR',
        'CHELSEA' => 'CH',
        'LIVERPOOL' => 'LI',
        'MANCHESTER CITY' => 'MC',
        'TOTTENHAM' => 'TO',
    ];

    public function suggestAbbreviation(string $teamName): string
    {
        $normalizedName = strtoupper(trim(preg_replace('/\s+/', ' ', $teamName)));

        if (isset(self::COMMON_ABBREVIATIONS[$normalizedName])) {
            return self::COMMON_ABBREVIATIONS[$normalizedName];
        }

        $letters = preg_replace('/[^A-Z0-9]/', '', $normalizedName);

        return str_pad(substr($letters, 0, 2), 2, 'X');
    }

    public function normalizeAbbreviation(string $abbreviation): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $abbreviation));
    }

    public function generateCouponCode(FootballMatch $match, int $homeScore, int $awayScore): string
    {
        return strtoupper(
            $this->normalizeAbbreviation($match->home_abbreviation)
            . $homeScore
            . $this->normalizeAbbreviation($match->away_abbreviation)
            . $awayScore
        );
    }

    public function publishResult(FootballMatch $match, int $homeScore, int $awayScore, User $admin): array
    {
        return DB::transaction(function () use ($match, $homeScore, $awayScore, $admin) {
            $match = FootballMatch::whereKey($match->id)->lockForUpdate()->firstOrFail();
            $couponCode = $this->generateCouponCode($match, $homeScore, $awayScore);

            if (
                $match->status === FootballMatch::STATUS_FINISHED
                && (int) $match->home_score === $homeScore
                && (int) $match->away_score === $awayScore
                && $match->coupon
            ) {
                return $this->syncPredictionResults($match->fresh(), $match->coupon, $homeScore, $awayScore);
            }

            if ($match->status === FootballMatch::STATUS_FINISHED && $match->coupon) {
                throw ValidationException::withMessages([
                    'home_score' => 'This match result has already been published.',
                ]);
            }

            $existingCoupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

            if ($existingCoupon && (int) $existingCoupon->football_match_id !== (int) $match->id) {
                throw ValidationException::withMessages([
                    'home_score' => "Coupon code {$couponCode} already exists. Edit the team abbreviations before publishing.",
                ]);
            }

            $coupon = $existingCoupon ?: Coupon::create([
                'code' => $couponCode,
                'description' => $match->coupon_description
                    ?: "{$match->home_team} vs {$match->away_team} Correct Score Reward",
                'discount_type' => $match->coupon_discount_type,
                'discount_value' => $match->coupon_discount_value,
                'is_active' => true,
                'usage_limit' => null,
                'used_count' => 0,
                'source' => Coupon::SOURCE_FOOTBALL,
                'football_match_id' => $match->id,
                'created_by' => $admin->id,
            ]);

            $match->forceFill([
                'home_score' => $homeScore,
                'away_score' => $awayScore,
                'status' => FootballMatch::STATUS_FINISHED,
                'is_published' => true,
                'result_published_at' => now(),
            ])->save();

            return $this->syncPredictionResults($match->fresh(), $coupon->fresh(), $homeScore, $awayScore);
        });
    }

    private function syncPredictionResults(FootballMatch $match, Coupon $coupon, int $homeScore, int $awayScore): array
    {
        $correctPredictions = FootballPrediction::where('football_match_id', $match->id)
            ->where('home_score', $homeScore)
            ->where('away_score', $awayScore)
            ->get();

        FootballPrediction::where('football_match_id', $match->id)
            ->where('status', FootballPrediction::STATUS_PENDING)
            ->update(['status' => FootballPrediction::STATUS_INCORRECT]);

        FootballPrediction::whereIn('id', $correctPredictions->pluck('id'))
            ->update(['status' => FootballPrediction::STATUS_CORRECT]);

        foreach ($correctPredictions as $prediction) {
            FootballCouponEntitlement::firstOrCreate([
                'football_match_id' => $match->id,
                'coupon_id' => $coupon->id,
                'user_id' => $prediction->user_id,
            ]);
        }

        return [
            'match' => $match,
            'coupon' => $coupon,
            'code' => $coupon->code,
            'winners_count' => $correctPredictions->count(),
        ];
    }
}
