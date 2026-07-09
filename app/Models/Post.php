<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
     
    use HasFactory;

    public function newEloquentBuilder($query)
    {
        return new PostQueryBuilder($query);
    }
}
