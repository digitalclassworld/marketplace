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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_avatar')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('user_type')->default('Student');
            $table->string('interested_in')->nullable();
            $table->integer('previous_orders')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->string('category')->default('Course Inquiry');
            $table->string('sub_category')->nullable();
            $table->string('source')->default('Website'); // Website, WhatsApp, Email, App, Phone, Seller
            $table->string('priority')->default('Medium'); // Low, Medium, High, Urgent
            $table->string('status')->default('Open'); // Open, In Progress, Waiting, Resolved, Spam
            $table->string('assigned_to')->default('Hitesh');
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('last_reply_at')->nullable();
            $table->boolean('is_unread')->default(false);
            $table->string('attachment_name')->nullable();
            $table->string('attachment_size')->nullable();
            $table->string('attachment_url')->nullable();
            $table->json('activities')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('support_ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->index();
            $table->string('sender_type')->default('customer'); // customer, admin, system
            $table->string('sender_name')->nullable();
            $table->string('sender_avatar')->nullable();
            $table->text('message');
            $table->boolean('is_internal_note')->default(false);
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_messages');
        Schema::dropIfExists('support_tickets');
    }
};

