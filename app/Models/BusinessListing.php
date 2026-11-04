<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'business_name',
        'slug',
        'category',
        'listing_type',
        'sub_category',
        'established_year',
        'employees_count',
        'tagline',
        'description',
        'features',
        'phone',
        'whatsapp_number',
        'email',
        'website',
        'address',
        'city',
        'state',
        'pincode',
        'map_location',
        'logo',
        'cover_image',
        'video_url',
        'plan_name',
        'plan_price',
        'add_ons',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'features'    => 'array',
        'add_ons'     => 'array',
        'plan_price'  => 'decimal:2',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}

