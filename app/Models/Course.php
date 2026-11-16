<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'language',
        'level',
        'short_description',
        'description',
        'thumbnail',
        'cover_image',
        'video_url',
        'gallery',
        'is_free',
        'price',
        'discount_price',
        'access_type',
        'certificate_included',
        'qa_enabled',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'certificate_included' => 'boolean',
        'qa_enabled' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'gallery' => 'array',
        'approved_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(CourseContent::class)->orderBy('sort_order', 'asc');
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
        return 0.0;
    }

    public function getReviewsCountAttribute(): string
    {
        return '0';
    }

    public function getStudentsCountAttribute(): string
    {
        return '';
    }

    public function getDurationAttribute(): string
    {
        return 'Flexible';
    }

    public function getDiscountPercentageAttribute(): string
    {
        if ($this->price > 0 && $this->discount_price > 0 && $this->discount_price < $this->price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100) . '% OFF';
        }
        return '50% OFF';
    }

    public function getInstructorNameAttribute(): string
    {
        return $this->seller?->businessDetail?->business_name 
            ?? $this->seller?->store_name 
            ?? 'Digital Class Academy';
    }

    public function getInstructorCategoryAttribute(): string
    {
        return $this->seller?->businessDetail?->business_category ?? $this->category;
    }

    public function getInstructorAvatarAttribute(): string
    {
        return $this->seller?->user?->avatar 
            ?? $this->seller?->businessDetail?->logo 
            ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=60&auto=format&fit=crop&q=80';
    }

    public function getThumbnailAttribute(?string $value): string
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80';
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset($value);
    }

    public function getCoverImageAttribute(?string $value): string
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&auto=format&fit=crop&q=80';
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset($value);
    }

    public function getBadgeAttribute(): ?string
    {
        return null;
    }

    public function getModeAttribute(): string
    {
        return ($this->id % 3 === 0) ? 'Offline' : 'Online';
    }
}

