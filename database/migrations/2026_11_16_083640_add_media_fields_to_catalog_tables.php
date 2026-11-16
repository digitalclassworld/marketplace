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
        // 1. Courses
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('courses', 'video_url')) {
                $table->string('video_url')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('courses', 'gallery')) {
                $table->json('gallery')->nullable()->after('video_url');
            }
        });

        // 2. Services
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('services', 'video_url')) {
                $table->string('video_url')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('services', 'gallery')) {
                $table->json('gallery')->nullable()->after('video_url');
            }
        });

        // 3. Products
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('products', 'video_url')) {
                $table->string('video_url')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('products', 'gallery')) {
                $table->json('gallery')->nullable()->after('video_url');
            }
        });

        // 4. Business Listings
        Schema::table('business_listings', function (Blueprint $table) {
            if (!Schema::hasColumn('business_listings', 'gallery')) {
                $table->json('gallery')->nullable()->after('video_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'video_url', 'gallery']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'video_url', 'gallery']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'video_url', 'gallery']);
        });

        Schema::table('business_listings', function (Blueprint $table) {
            $table->dropColumn(['gallery']);
        });
    }
};
