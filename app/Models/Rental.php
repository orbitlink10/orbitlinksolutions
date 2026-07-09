<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'start_date',
        'end_date',
        'quantity',
        'damage_protection',
        'wifi_router',
    ];
}
