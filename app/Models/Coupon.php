<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_FIXED = 'fixed';
    public const SOURCE_MANUAL = 'manual';
    public const SOURCE_FOOTBALL = 'football_match';

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'is_active',
        'usage_limit',
        'used_count',
        'expires_at',
        'source',
        'football_match_id',
        'created_by',
        'redeemed_by_user_id',
        'redeemed_order_id',
        'redeemed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'expires_at' => 'datetime',
        'redeemed_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function footballMatch()
    {
        return $this->belongsTo(FootballMatch::class);
    }

    public function redemptions()
    {
        return $this->hasMany(CouponRedemption::class);
    }

    public function entitlements()
    {
        return $this->hasMany(FootballCouponEntitlement::class);
    }

    public function redeemedBy()
    {
        return $this->belongsTo(User::class, 'redeemed_by_user_id');
    }

    public function redeemedOrder()
    {
        return $this->belongsTo(Order::class, 'redeemed_order_id');
    }

    public function isFootballCoupon(): bool
    {
        return $this->source === self::SOURCE_FOOTBALL;
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function hasRemainingGlobalUses(): bool
    {
        return $this->usage_limit === null || $this->used_count < $this->usage_limit;
    }
}
