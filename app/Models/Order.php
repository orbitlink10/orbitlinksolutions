<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_reference',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'status',
        'user_id',
        'product_id',
        'quantity',
        'company_name',
        'county_id',
        'address',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'subtotal_before_discount',
        'total_after_discount',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}


public function products()
{
    return $this->belongsToMany(Product::class, 'order_product')
                ->withPivot(['quantity', 'price'])
                ->withTimestamps();
}


// In app/Models/Order.php

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function coupon()
{
    return $this->belongsTo(Coupon::class);
}

public function couponRedemption()
{
    return $this->hasOne(CouponRedemption::class);
}

}
