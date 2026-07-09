<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['description', 'user_id']; // Modify this based on your table structure

    // Define relationships if needed (e.g., with User model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
