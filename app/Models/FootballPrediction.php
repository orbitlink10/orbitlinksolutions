<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPrediction extends Model
{
    use HasFactory;

    public const PICK_HOME = 'home';
    public const PICK_DRAW = 'draw';
    public const PICK_AWAY = 'away';

    public const STATUS_PENDING = 'pending';
    public const STATUS_CORRECT = 'correct';
    public const STATUS_INCORRECT = 'incorrect';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'football_match_id',
        'user_id',
        'prediction_pick',
        'home_score',
        'away_score',
        'status',
    ];

    public static function availablePicks(): array
    {
        return [
            self::PICK_HOME,
            self::PICK_DRAW,
            self::PICK_AWAY,
        ];
    }

    public static function pickLabels(): array
    {
        return [
            self::PICK_HOME => 'Home',
            self::PICK_DRAW => 'Draw',
            self::PICK_AWAY => 'Away',
        ];
    }

    public static function scoreForPick(string $pick): array
    {
        return match ($pick) {
            self::PICK_HOME => [1, 0],
            self::PICK_DRAW => [0, 0],
            self::PICK_AWAY => [0, 1],
            default => [0, 0],
        };
    }

    public static function pickForScore(int $homeScore, int $awayScore): string
    {
        if ($homeScore > $awayScore) {
            return self::PICK_HOME;
        }

        if ($homeScore < $awayScore) {
            return self::PICK_AWAY;
        }

        return self::PICK_DRAW;
    }

    public function predictionLabel(): string
    {
        if ($this->prediction_pick) {
            return self::pickLabels()[$this->prediction_pick] ?? ucfirst($this->prediction_pick);
        }

        return $this->home_score . '-' . $this->away_score;
    }

    public function footballMatch()
    {
        return $this->belongsTo(FootballMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExactScore(FootballMatch $match): bool
    {
        return (int) $this->home_score === (int) $match->home_score
            && (int) $this->away_score === (int) $match->away_score;
    }

    public function matchesResult(FootballMatch $match): bool
    {
        if ($this->prediction_pick) {
            return $this->prediction_pick === self::pickForScore((int) $match->home_score, (int) $match->away_score);
        }

        return $this->isExactScore($match);
    }
}
