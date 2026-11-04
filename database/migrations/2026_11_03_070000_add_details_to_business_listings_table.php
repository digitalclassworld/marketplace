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
        Schema::table('business_listings', function (Blueprint $table) {
            $table->string('listing_type', 100)->nullable()->after('category');
            $table->string('sub_category', 100)->nullable()->after('listing_type');
            $table->string('established_year', 20)->nullable()->after('sub_category');
            $table->string('employees_count', 50)->nullable()->after('established_year');
            $table->json('features')->nullable()->after('description');
            $table->string('cover_image')->nullable()->after('logo');
            $table->string('video_url')->nullable()->after('cover_image');
            $table->string('whatsapp_number', 50)->nullable()->after('phone');
            $table->string('map_location')->nullable()->after('pincode');
            $table->string('plan_name', 50)->default('Premium Listing')->after('map_location');
            $table->decimal('plan_price', 10, 2)->default(1499.00)->after('plan_name');
            $table->json('add_ons')->nullable()->after('plan_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_listings', function (Blueprint $table) {
            $table->dropColumn([
                'listing_type',
                'sub_category',
                'established_year',
                'employees_count',
                'features',
                'cover_image',
                'video_url',
                'whatsapp_number',
                'map_location',
                'plan_name',
                'plan_price',
                'add_ons',
            ]);
        });
    }
};

