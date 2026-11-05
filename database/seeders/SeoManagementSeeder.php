<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeoManagementSeeder extends Seeder
{
    public function run(): void
    {
        SeoSetting::truncate();

        SeoSetting::create([
            'site_title'                  => 'Digital Class - Courses, Services, Products & Business Listings',
            'site_tagline'                => 'Learn. Teach. Buy. Hire. All in One Educational Marketplace.',
            'meta_description'            => 'Digital Class is an online marketplace for courses, services, products and business listings. Discover, learn, buy and grow with trusted educators and businesses across India.',
            'default_keywords'            => 'online courses, professional services, educational products, business listings, skill development, digital marketplace',
            'social_image_url'            => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80',
            'favicon_url'                 => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=64&q=80',
            'meta_robots'                 => 'Index, Follow',
            'canonical_mode'              => 'Auto Generated',
            'enable_open_graph'           => true,
            'enable_twitter_card'         => true,
            'enable_breadcrumbs'          => true,
            'enable_json_ld'              => true,
            'course_title_template'       => '{course_name} Online Course | {institute_name} | Digital Class',
            'course_description_template' => 'Learn {course_name} online from {institute_name}. Course duration: {duration}. Fees: {price}. Enroll now on Digital Class.',
            'course_url_template'         => '/course/{course_slug}',
            'course_focus_keywords'       => '{course_name}, online course, {category_name}, {sub_category_name}',
            'service_title_template'      => '{service_name} Services | {seller_name} | Digital Class',
            'service_description_template'=> 'Hire verified professionals for {service_name}. Starting at {price}. Satisfaction guaranteed.',
            'service_url_template'        => '/service/{service_slug}',
            'product_title_template'      => '{product_name} | Buy Online | Digital Class',
            'product_description_template'=> 'Buy {product_name} at best price with warranty and free shipping across India.',
            'product_url_template'        => '/product/{product_slug}',
            'indexed_pages_count'         => 12480,
            'total_seo_pages_count'       => 28540,
            'seo_score'                   => 92,
            'organic_traffic'             => '3.2M',
            'sitemap_last_generated'      => Carbon::parse('2026-10-30 10:20:00'),
            'robots_txt_content'          => "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /seller/dashboard\nDisallow: /checkout/\nSitemap: https://digitalclass.in/sitemap.xml",
        ]);
    }
}
