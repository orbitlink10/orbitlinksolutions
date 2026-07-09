<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'h1_title',
        'h2_title',
        'h4_title',
        'description',
        'button_url',
        'button_text',
        'img_url',
    ];
}
