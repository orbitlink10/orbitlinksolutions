<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeldingProduct extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'material_cost',
        'labour_cost',
        'total_cost',
    ];

    /**
     * Relationship: WeldingProduct belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor: Get full URL for the image or null if none
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    protected static function booted()
{
    static::saving(function ($product) {
        if (!is_null($product->material_cost) && !is_null($product->labour_cost)) {
            $product->total_cost = $product->material_cost + $product->labour_cost;
        }
    });
}

}
