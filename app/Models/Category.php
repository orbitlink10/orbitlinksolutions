<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_description',
        'photo',
    ];
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function boot(){
        parent::boot();

        static::creating(function($cat){
            $slugs =str_replace(' ','-',$cat->name);
            $slug =strtolower($slugs);
            $cat->slug =$slug;
        });
        static::updating(function($cat){
            $slugs =str_replace(' ','-',$cat->name);
            $slug =strtolower($slugs);
            $cat->slug =$slug;
        });

    }
}
