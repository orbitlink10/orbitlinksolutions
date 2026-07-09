<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'phone', 'product_id', 'notification_type'];

        public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
