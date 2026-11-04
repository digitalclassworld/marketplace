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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('promotion_code')->unique();
            $table->string('listing_type')->default('Course'); // Course, Service, Product, Business Listing
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->string('listing_title');
            $table->string('listing_thumbnail')->nullable();
            $table->decimal('original_price', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->default(0);
            $table->integer('discount_percentage')->default(20);
            
            // Promotion Type & Pricing
            $table->string('promotion_type')->default('Featured Listing'); // Featured Listing (1000), Banner Promotion (1500), Discount Offer (1000), Social Media Kit (2000), Email Campaign (2500)
            $table->decimal('charge_amount', 10, 2)->default(1000);
            $table->integer('duration_days')->default(14);
            $table->date('start_date');
            $table->date('end_date');
            
            // Status & Performance Tracking
            $table->string('status')->default('Active'); // Active, Scheduled, Completed, Paused
            $table->integer('views_count')->default(0);
            $table->integer('clicks_count')->default(0);
            $table->integer('sales_count')->default(0);
            $table->decimal('revenue_generated', 10, 2)->default(0);
            
            $table->string('banner_template')->default('purple_gradient');
            $table->string('target_audience')->nullable()->default('All Marketplace Visitors & Students');
            $table->string('payment_status')->default('Paid'); // Paid, Pending
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });

        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('coupon_code');
            $table->string('discount_type')->default('percentage'); // percentage, flat
            $table->decimal('discount_value', 10, 2)->default(10);
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->string('applicable_to')->default('all'); // all, courses, services, products
            $table->integer('usage_limit')->default(100);
            $table->integer('used_count')->default(0);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->string('status')->default('Active'); // Active, Expired, Disabled
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
        Schema::dropIfExists('promotions');
    }
};

