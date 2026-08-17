<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPrediction extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CORRECT = 'correct';
    public const STATUS_INCORRECT = 'incorrect';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'football_match_id',
        'user_id',
        'home_score',
        'away_score',
        'status',
    ];

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
}
