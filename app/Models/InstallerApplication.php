<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallerApplication extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'company_name',
        'county',
        'town',
        'business_type',
        'years_in_business',
        'monthly_purchases',
        'main_brands',
        'preferred_categories',
        'buys_for_projects',
        'whatsapp_number',
        'business_registration_number',
        'kra_pin',
        'supporting_document_path',
        'marketing_consent',
        'status',
        'approved_discount_percent',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'buys_for_projects' => 'boolean',
        'marketing_consent' => 'boolean',
        'approved_discount_percent' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_SUSPENDED => 'Suspended',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
