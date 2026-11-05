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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name');
            $table->string('user_email')->nullable();
            $table->string('user_city')->nullable();
            $table->string('user_avatar')->nullable();
            
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->text('review_text');
            $table->string('review_type')->default('Course'); // Course, Service, Product, Business
            
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_title');
            $table->string('item_thumbnail')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable()->index();
            $table->string('seller_name')->nullable();
            $table->string('category')->nullable();
            $table->string('order_id')->nullable();
            $table->date('enrolled_on')->nullable();
            $table->date('completed_on')->nullable();
            
            $table->json('photos')->nullable();
            $table->string('status')->default('Approved'); // Approved, Pending, Rejected, Flagged
            $table->integer('helpful_upvotes')->default(0);
            $table->integer('helpful_downvotes')->default(0);
            $table->text('admin_notes')->nullable();
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
