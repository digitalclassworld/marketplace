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
}
