<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'short_description',
        'description',
        'tags',
        'delivery_days',
        'package_name',
        'price',
        'package_features',
        'buyer_requirements',
        'thumbnail',
        'cover_image',
        'video_url',
        'gallery',
        'is_featured',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'delivery_days' => 'integer',
        'price' => 'decimal:2',
        'gallery' => 'array',
        'tags' => 'array',
        'package_features' => 'array',
        'is_featured' => 'boolean',
        'approved_at' => 'datetime',
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

    public static array $defaultServiceThumbnails = [
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format&fit=crop&q=80',
    ];

    public function getThumbnailAttribute(?string $value): string
    {
        if (empty($value) || str_contains($value, 'camera_placeholder')) {
            $seed = abs(crc32($this->title ?: ($this->id ?: 'service_thumb')));
            return self::$defaultServiceThumbnails[$seed % count(self::$defaultServiceThumbnails)];
        }
        $value = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $value);
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return '/' . ltrim($value, '/');
    }

    public function getCoverImageAttribute(?string $value): string
    {
        if (empty($value) || str_contains($value, 'camera_placeholder')) {
            return 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&auto=format&fit=crop&q=80';
        }
        $value = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $value);
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return '/' . ltrim($value, '/');
    }

    public function getProviderAvatarAttribute(): string
    {
        $avatar = $this->seller?->user?->avatar ?: ($this->seller?->businessDetail?->logo ?? null);
        if (!empty($avatar)) {
            $avatar = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $avatar);
            if (str_starts_with($avatar, 'http://') || str_starts_with($avatar, 'https://')) {
                return $avatar;
            }
            return '/' . ltrim($avatar, '/');
        }

        $name = $this->seller?->businessDetail?->business_name ?? ($this->seller?->user?->name ?? 'Service Provider');
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0066ff&color=fff&size=160&bold=true';
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = \Illuminate\Support\Str::slug($title);
        if (empty($slug)) {
            $slug = 'service';
        }
        $originalSlug = $slug;
        $count = 1;
        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        return $slug;
    }
}

