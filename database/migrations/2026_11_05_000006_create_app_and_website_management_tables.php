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
        // 1. App Management Settings & Features
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('android'); // android, ios, pwa
            $table->string('app_name')->default('Digital Class');
            $table->string('package_name')->default('com.digitalclass.app');
            $table->string('bundle_id')->default('com.digitalclass.app');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('current_version')->default('v2.4.0');
            $table->string('status')->default('Live');
            $table->string('icon_url')->nullable();
            $table->string('splash_url')->nullable();
            $table->string('login_screen_url')->nullable();
            $table->string('home_screen_url')->nullable();
            $table->unsignedBigInteger('total_downloads')->default(90540);
            $table->unsignedBigInteger('active_users')->default(12840);
            $table->decimal('rating', 3, 1)->default(4.6);
            $table->decimal('crash_rate', 3, 1)->default(0.8);
            $table->timestamp('last_released_at')->nullable();
            $table->timestamps();
        });

        Schema::create('app_features', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('#0066ff');
            $table->boolean('is_enabled')->default(true);
            $table->integer('order_index')->default(0);
            $table->json('platforms')->nullable();
            $table->timestamps();
        });

        // 2. Website Management Pages
        Schema::create('website_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('type')->default('Custom'); // System, Custom, Blog, Legal, Landing
            $table->string('status')->default('Published'); // Published, Draft, Scheduled
            $table->string('thumbnail')->nullable();
            $table->boolean('show_in_menu')->default(true);
            $table->boolean('is_homepage')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_pages');
        Schema::dropIfExists('app_features');
        Schema::dropIfExists('app_settings');
    }
};
