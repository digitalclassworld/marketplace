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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_avatar')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_online_status')->default('Online');
            $table->string('subject_title')->default('General Enquiry');
            $table->string('subject_type')->default('Course Enquiry');
            $table->string('subject_thumbnail')->nullable();
            $table->string('category')->default('inquiries'); // 'orders', 'inquiries', 'support'
            $table->string('status')->default('In Progress'); // 'In Progress', 'Active', 'Resolved'
            $table->integer('total_messages')->default(0);
            $table->integer('unread_count')->default(0);
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->date('active_since')->nullable();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id')->index();
            $table->string('sender_type')->default('seller'); // 'seller', 'customer', 'admin'
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->text('message');
            $table->string('attachment_url')->nullable();
            $table->string('attachment_type')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};

