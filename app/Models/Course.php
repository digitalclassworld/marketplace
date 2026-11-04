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
        // Deterministic rating based on ID
        $ratings = [4.8, 4.6, 4.7, 4.6, 4.5, 4.7, 4.6, 4.8, 4.5, 4.7];
        return $ratings[($this->id ?? 1) % count($ratings)];
    }

    public function getReviewsCountAttribute(): string
    {
        $reviews = ['1.2K', '860', '560', '430', '320', '780', '640', '920', '510', '390'];
        return $reviews[($this->id ?? 1) % count($reviews)];
    }

    public function getStudentsCountAttribute(): string
    {
        $counts = ['12,450', '9,420', '6,850', '5,120', '4,680', '8,250', '7,920', '10,450', '6,120', '5,600'];
        return $counts[($this->id ?? 1) % count($counts)] . ' students';
    }

    public function getDurationAttribute(): string
    {
        $durations = ['12h 30m', '8h 20m', '10h 15m', '20h', '16h 30m', '6h 45m', '8h 10m', '7h 20m', '10h 30m', '6h 25m'];
        return $durations[($this->id ?? 1) % count($durations)];
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

    public function getBadgeAttribute(): ?string
    {
        return ($this->id == 1 || str_contains(strtolower($this->title), 'digital marketing')) ? 'Bestseller' : null;
    }

    public function getModeAttribute(): string
    {
        return ($this->id % 3 === 0) ? 'Offline' : 'Online';
    }
}

