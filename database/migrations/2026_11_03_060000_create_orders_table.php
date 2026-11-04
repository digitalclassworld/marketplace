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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
                $table->string('order_number')->unique(); // e.g. DC12568
                $table->string('customer_name');
                $table->string('customer_city')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();
                $table->string('customer_avatar')->nullable();
                $table->string('order_type'); // Course, Service, Product, Business
                $table->string('item_title');
                $table->string('item_subtext')->nullable();
                $table->string('item_thumbnail')->nullable();
                $table->decimal('amount', 10, 2)->default(0.00);
                $table->decimal('subtotal', 10, 2)->default(0.00);
                $table->decimal('discount', 10, 2)->default(0.00);
                $table->string('status', 30)->default('completed'); // completed, in_progress, shipped, processing, cancelled
                $table->timestamp('placed_at')->nullable();
                $table->json('timeline')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

