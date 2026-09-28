<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZivoApiKey extends Model
{
    protected $guarded = [];

    protected $hidden = ['key_hash'];

    protected $casts = ['expires_at' => 'datetime', 'revoked_at' => 'datetime'];
}
