<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsitePage extends Model
{
    use HasFactory;

    protected $table = 'website_pages';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'status',
        'thumbnail',
        'show_in_menu',
        'is_homepage',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'last_updated_at',
    ];

    protected $casts = [
        'show_in_menu'    => 'boolean',
        'is_homepage'     => 'boolean',
        'last_updated_at' => 'datetime',
    ];

    /**
     * Type badge color classes
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match (strtolower($this->type)) {
            'system' => 'badge-type-system',
            'custom' => 'badge-type-custom',
            'blog'   => 'badge-type-blog',
            'legal'  => 'badge-type-legal',
            default  => 'badge-type-default',
        };
    }
}

