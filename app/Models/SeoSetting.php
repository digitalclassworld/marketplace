<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $table = 'seo_settings';

    protected $fillable = [
        'site_title',
        'site_tagline',
        'meta_description',
        'default_keywords',
        'social_image_url',
        'favicon_url',
        'meta_robots',
        'canonical_mode',
        'enable_open_graph',
        'enable_twitter_card',
        'enable_breadcrumbs',
        'enable_json_ld',
        'course_title_template',
        'course_description_template',
        'course_url_template',
        'course_focus_keywords',
        'service_title_template',
        'service_description_template',
        'service_url_template',
        'product_title_template',
        'product_description_template',
        'product_url_template',
        'indexed_pages_count',
        'total_seo_pages_count',
        'seo_score',
        'organic_traffic',
        'sitemap_last_generated',
        'robots_txt_content',
    ];

    protected $casts = [
        'enable_open_graph'      => 'boolean',
        'enable_twitter_card'    => 'boolean',
        'enable_breadcrumbs'     => 'boolean',
        'enable_json_ld'         => 'boolean',
        'sitemap_last_generated' => 'datetime',
        'indexed_pages_count'    => 'integer',
        'total_seo_pages_count'  => 'integer',
        'seo_score'              => 'integer',
    ];
}
