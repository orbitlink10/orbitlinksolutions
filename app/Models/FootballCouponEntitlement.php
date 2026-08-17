<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballCouponEntitlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'football_match_id',
        'coupon_id',
        'user_id',
        'order_id',
        'redeemed_at',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function footballMatch()
    {
        return $this->belongsTo(FootballMatch::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isRedeemed(): bool
    {
        return $this->redeemed_at !== null;
    }
}
