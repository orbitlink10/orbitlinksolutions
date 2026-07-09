<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable=['name','category_id','slug'];

    public function category(){
        return $this->belongsTo(Category::class);
    }







    public static function boot(){
        Parent::boot();
        static::creating(function($sub_category){
            $slugs =str_replace(' ', '-', $sub_category->name);
            $slug =strtolower($slugs);
            $sub_category->slug =$slug;
        });
        static::updating(function($sub_category){
            $slugs = str_replace(' ', '-', $sub_category->name);
            $slug = strtolower($slugs);
            $sub_category->slug = $slug;
        });
    }
}
