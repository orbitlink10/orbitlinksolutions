<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    public const STATUS_UPCOMING = 'upcoming';
    public const STATUS_PREDICTION_CLOSED = 'prediction_closed';
    public const STATUS_LIVE = 'live';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'home_team',
        'away_team',
        'home_abbreviation',
        'away_abbreviation',
        'competition',
        'match_date',
        'kickoff_time',
        'prediction_closes_at',
        'status',
        'home_score',
        'away_score',
        'is_published',
        'coupon_discount_type',
        'coupon_discount_value',
        'coupon_description',
        'created_by',
        'result_published_at',
    ];

    protected $casts = [
        'match_date' => 'date',
        'prediction_closes_at' => 'datetime',
        'is_published' => 'boolean',
        'coupon_discount_value' => 'decimal:2',
        'result_published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function predictions()
    {
        return $this->hasMany(FootballPrediction::class);
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function entitlements()
    {
        return $this->hasMany(FootballCouponEntitlement::class);
    }

    public function predictionsAreOpen(): bool
    {
        return $this->is_published
            && ! in_array($this->status, [self::STATUS_FINISHED, self::STATUS_CANCELLED], true)
            && $this->prediction_closes_at->isFuture();
    }

    public function resultLabel(): string
    {
        if ($this->home_score === null || $this->away_score === null) {
            return '-';
        }

        return $this->home_score . '-' . $this->away_score;
    }
}
