<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('Digital Class - Courses, Services, Products & Business Listings');
            $table->string('site_tagline')->default('Learn. Teach. Buy. Hire. All in One Educational Marketplace.');
            $table->text('meta_description')->nullable();
            $table->text('default_keywords')->nullable();
            $table->string('social_image_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('meta_robots')->default('Index, Follow');
            $table->string('canonical_mode')->default('Auto Generated');
            $table->boolean('enable_open_graph')->default(true);
            $table->boolean('enable_twitter_card')->default(true);
            $table->boolean('enable_breadcrumbs')->default(true);
            $table->boolean('enable_json_ld')->default(true);

            // Templates for Dynamic SEO Pages
            $table->string('course_title_template')->default('{course_name} Online Course | {institute_name} | Digital Class');
            $table->text('course_description_template')->nullable();
            $table->string('course_url_template')->default('/course/{course_slug}');
            $table->text('course_focus_keywords')->nullable();

            $table->string('service_title_template')->default('{service_name} Services | {seller_name} | Digital Class');
            $table->text('service_description_template')->nullable();
            $table->string('service_url_template')->default('/service/{service_slug}');

            $table->string('product_title_template')->default('{product_name} | Buy Online | Digital Class');
            $table->text('product_description_template')->nullable();
            $table->string('product_url_template')->default('/product/{product_slug}');

            // Stats and metrics
            $table->unsignedInteger('indexed_pages_count')->default(12480);
            $table->unsignedInteger('total_seo_pages_count')->default(28540);
            $table->unsignedSmallInteger('seo_score')->default(92);
            $table->string('organic_traffic')->default('3.2M');
            $table->timestamp('sitemap_last_generated')->nullable();
            $table->text('robots_txt_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};

