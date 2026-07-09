<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'marked_price',
        'has_price',
        'quantity',
        'discount',
        'photo',
        'slug',
        'description',
        'meta_description',
        'category_id',
        'sub_category_id',
        'stock',
        'is_active',
        'google_merchant',
    ];





public function orders()
{
    return $this->belongsToMany(Order::class, 'order_product')
                ->withPivot(['quantity', 'price'])
                ->withTimestamps();
}

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
