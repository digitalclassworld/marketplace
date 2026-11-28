<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'product_type',
        'description',
        'sku',
        'mrp',
        'price',
        'stock_quantity',
        'weight_grams',
        'shipping_details',
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
        'mrp' => 'decimal:2',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'weight_grams' => 'integer',
        'gallery' => 'array',
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

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->mrp > $this->price && $this->mrp > 0) {
            return (int) round((($this->mrp - $this->price) / $this->mrp) * 100);
        }
        return 0;
    }

    public function getThumbnailAttribute(?string $value): string
    {
        if (empty($value) || str_contains($value, 'camera_placeholder')) {
            return 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80';
        }
        $value = preg_replace('/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\//', '/', $value);
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return '/' . ltrim($value, '/');
    }

    public function getDisplayThumbnailAttribute(): string
    {
        return $this->thumbnail;
    }

    public function getSellerNameAttribute(): string
    {
        return $this->seller?->businessDetail?->business_name
            ?? $this->seller?->user?->name
            ?? 'Digital Class Store';
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = \Illuminate\Support\Str::slug($title);
        if (empty($slug)) {
            $slug = 'product';
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

