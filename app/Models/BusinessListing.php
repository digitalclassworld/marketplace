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

    public function getRatingAttribute(): float
    {
        return isset($this->features['rating']) ? (float)$this->features['rating'] : 4.6;
    }

    public function getReviewsCountAttribute(): int
    {
        return isset($this->features['reviews_count']) ? (int)$this->features['reviews_count'] : 110;
    }

    public function getBadgeAttribute(): ?string
    {
        return $this->features['badge'] ?? ($this->listing_type === 'Featured' ? 'Featured' : ($this->listing_type === 'Verified' ? 'Verified' : null));
    }

    public function getTagsListAttribute(): array
    {
        if (isset($this->features['tags']) && is_array($this->features['tags'])) {
            return $this->features['tags'];
        }
        if (!empty($this->sub_category)) {
            return array_map('trim', explode(',', $this->sub_category));
        }
        return ['Verified', 'Professional'];
    }

    public function getAreaTextAttribute(): string
    {
        $area = $this->features['area'] ?? null;
        if ($area && $this->city) {
            return $area . ', ' . $this->city;
        }
        return $this->address ?: ($this->city ?: 'Ahmedabad');
    }

    public function getDisplayImageAttribute(): string
    {
        return $this->cover_image ?: ($this->logo ?: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=500&auto=format&fit=crop&q=80');
    }
}

