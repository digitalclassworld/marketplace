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
        'is_featured',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'certificate_included' => 'boolean',
        'qa_enabled' => 'boolean',
        'is_featured' => 'boolean',
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

    public function getShortTitleAttribute(): string
    {
        $name = trim($this->title ?? '');
        if (mb_strlen($name) > 23) {
            return mb_substr($name, 0, 21) . '..';
        }
        return $name;
    }

    public function getUrlAttribute(): string
    {
        return route('course.show', $this->slug ?: $this->id);
    }

    public function getSellingPriceAttribute(): float
    {
        if ($this->discount_price > 0 && $this->discount_price < $this->price) {
            return (float)$this->discount_price;
        }
        return (float)($this->price ?? 0);
    }

    public function getOriginalPriceAttribute(): float
    {
        return (float)($this->price ?? 0);
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

    public static array $educationInstructorAvatars = [
        'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=160&auto=format&fit=crop&q=80', // Professional female lecturer
        'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=160&auto=format&fit=crop&q=80', // Academic professor with glasses
        'https://images.unsplash.com/photo-1580894732474-954992765324?w=160&auto=format&fit=crop&q=80', // University educator
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&auto=format&fit=crop&q=80', // Senior academic faculty
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=160&auto=format&fit=crop&q=80', // Mentor & instructor
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80', // Technical coach / mentor
        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80', // Online course instructor
    ];

    public static array $educationCourseThumbnails = [
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80', // Online digital study
        'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=600&auto=format&fit=crop&q=80', // Study desk with notes
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&auto=format&fit=crop&q=80', // Web Development & Coding
        'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&auto=format&fit=crop&q=80', // Student studying with laptop
        'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&auto=format&fit=crop&q=80', // Classroom seminar & workshop
        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80', // Group academic study
    ];

    public function getInstructorCategoryAttribute(): string
    {
        return $this->seller?->businessDetail?->business_category ?? $this->category;
    }

    public function getInstructorAvatarAttribute(): string
    {
        $avatar = $this->seller?->user?->avatar ?: ($this->seller?->businessDetail?->logo ?? null);
        if (!empty($avatar)) {
            $avatar = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $avatar);
            if (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://')) {
                return $avatar;
            }
            return '/' . ltrim($avatar, '/');
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->instructor_name) . '&background=0066ff&color=fff&size=160&bold=true';
    }

    public function getThumbnailAttribute(?string $value): string
    {
        if (empty($value) || str_contains($value, 'camera_placeholder')) {
            $seed = abs(crc32($this->title ?: ($this->id ?: 'edu_thumb')));
            return self::$educationCourseThumbnails[$seed % count(self::$educationCourseThumbnails)];
        }
        $value = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $value);
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return '/' . ltrim($value, '/');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail;
    }

    public function getCoverImageAttribute(?string $value): string
    {
        if (empty($value) || str_contains($value, 'camera_placeholder')) {
            return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&auto=format&fit=crop&q=80';
        }
        $value = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $value);
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return '/' . ltrim($value, '/');
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

