<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'type',
        'category',
        'category_id',
        'author_name',
        'author_avatar',
        'author_role',
        'views',
        'status',
        'published_at',
        'allow_comments',
        'is_featured',
        'tags',
        'meta_title',
        'meta_description',
        'focus_keyword',
    ];

    protected $casts = [
        'tags'           => 'array',
        'published_at'   => 'datetime',
        'allow_comments' => 'boolean',
        'is_featured'    => 'boolean',
        'views'          => 'integer',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id')->where('is_approved', true)->latest();
    }

    /**
     * Scope for published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'Published')->latest('published_at');
    }

    /**
     * Get accessible featured image URL (handles uploads, storage, full URLs, and fallback).
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if (!empty($this->featured_image)) {
            if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
                return $this->featured_image;
            }
            if (file_exists(public_path($this->featured_image))) {
                return asset($this->featured_image);
            }
            if (file_exists(public_path('storage/' . $this->featured_image))) {
                return asset('storage/' . $this->featured_image);
            }
            return asset($this->featured_image);
        }
        return 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&auto=format&fit=crop&q=80';
    }

    /**
     * Get author avatar URL.
     */
    public function getAuthorAvatarUrlAttribute(): string
    {
        if (!empty($this->author_avatar)) {
            if (str_starts_with($this->author_avatar, 'http://') || str_starts_with($this->author_avatar, 'https://')) {
                return $this->author_avatar;
            }
            if (file_exists(public_path($this->author_avatar))) {
                return asset($this->author_avatar);
            }
            return asset($this->author_avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author_name ?: 'Admin') . '&background=0066ff&color=fff&size=100&bold=true';
    }

    /**
     * Estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags((string)$this->content));
        return max(1, (int)ceil($wordCount / 200));
    }
}

