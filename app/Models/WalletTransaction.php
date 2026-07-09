<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description', 'amount', 'balance'];

    /**
     * Define the relationship between WalletTransaction and User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}