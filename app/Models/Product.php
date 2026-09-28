<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, \App\Models\Concerns\ZivoTransactionalWrites;

    protected $fillable = [
        'name',
        'brand_name',
        'model_number',
        'key_technical_feature',
        'best_for_label',
        'sku',
        'price',
        'marked_price',
        'installer_price',
        'installer_discount_percent',
        'installer_price_tiers',
        'popular_with_installers',
        'installer_deal_label',
        'has_price',
        'quantity',
        'discount',
        'photo',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'category_id',
        'sub_category_id',
        'stock',
        'stock_status',
        'is_active',
        'google_merchant',
    ];

    protected $casts = [
        'installer_price_tiers' => 'array',
        'popular_with_installers' => 'boolean',
        'installer_price' => 'decimal:2',
        'installer_discount_percent' => 'decimal:2',
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

    public function mediaFiles()
    {
        return $this->hasMany(Media::class, 'product_id')->orderBy('id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
