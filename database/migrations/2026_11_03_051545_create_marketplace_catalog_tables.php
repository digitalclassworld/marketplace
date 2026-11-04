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
        // 1. Courses Table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->default('Digital Marketing');
            $table->string('language')->default('Hindi');
            $table->string('level')->default('Beginner');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_free')->default(false);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('access_type')->default('Lifetime Access');
            $table->boolean('certificate_included')->default(true);
            $table->boolean('qa_enabled')->default(true);
            $table->string('status', 30)->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 2. Course Contents / Lectures Table
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('section_title')->default('1. Introduction');
            $table->string('lecture_title');
            $table->string('duration')->nullable(); // e.g. "12:30"
            $table->string('video_url')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        // 3. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->default('Graphic Design');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('tags')->nullable();
            $table->integer('delivery_days')->default(3);
            $table->string('package_name')->default('Basic');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->text('package_features')->nullable();
            $table->text('buyer_requirements')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('status', 30)->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 4. Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->default('Digital Assets & Tools');
            $table->string('product_type')->default('Digital'); // Digital, Physical
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('mrp', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('stock_quantity')->default(100);
            $table->integer('weight_grams')->nullable();
            $table->string('shipping_details')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('status', 30)->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 5. Business Directory Listings Table
        Schema::create('business_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->string('business_name');
            $table->string('slug')->nullable();
            $table->string('category')->default('Educational Institute');
            $table->string('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('logo')->nullable();
            $table->string('status', 30)->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('services');
        Schema::dropIfExists('products');
        Schema::dropIfExists('business_listings');
    }
};
