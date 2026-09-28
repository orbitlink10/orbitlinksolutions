<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZivoWebhookEvent extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'available_at' => 'datetime',
        'locked_until' => 'datetime',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
    ];
}
