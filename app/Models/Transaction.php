<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =['trans_id','msisdn','trans_amount','bill_ref','first_name','last_name','trans_type','businesss_code'];
    
}
