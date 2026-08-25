<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqSubmission extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_REVIEWING = 'reviewing';
    public const STATUS_QUOTED = 'quoted';
    public const STATUS_AWAITING_CUSTOMER = 'awaiting_customer';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'reference',
        'user_id',
        'full_name',
        'company',
        'phone',
        'email',
        'whatsapp_number',
        'project_location',
        'project_type',
        'required_delivery_date',
        'budget_range',
        'preferred_brands',
        'requirements',
        'file_path',
        'file_original_name',
        'status',
        'assigned_to',
        'admin_notes',
        'quotation_path',
        'quoted_at',
    ];

    protected $casts = [
        'required_delivery_date' => 'date',
        'quoted_at' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_REVIEWING => 'Reviewing',
            self::STATUS_QUOTED => 'Quoted',
            self::STATUS_AWAITING_CUSTOMER => 'Awaiting Customer',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
