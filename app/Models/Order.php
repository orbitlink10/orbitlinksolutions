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

}
