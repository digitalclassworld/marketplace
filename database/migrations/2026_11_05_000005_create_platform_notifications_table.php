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
        Schema::create('platform_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('channel')->default('Push Notification'); // Push Notification, In-App, Email, SMS
            $table->string('type')->default('Promotion'); // Promotion, Course, System, Update, Reminder, Welcome, Engagement, Product, Event
            $table->string('audience')->default('All Users'); // All Users, Students, Sellers, Institutes, Registered Users
            $table->unsignedInteger('audience_count')->default(0);
            $table->json('platforms')->nullable(); // ["Website", "Android App", "iOS App", "Email"]
            $table->string('status')->default('Sent'); // Sent, Scheduled, Draft, Failed
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('image_url')->nullable();
            $table->string('target_link')->nullable();
            $table->unsignedInteger('recipients_count')->default(0);
            $table->unsignedInteger('opened_count')->default(0);
            $table->unsignedInteger('clicked_count')->default(0);
            $table->string('created_by')->nullable()->default('Super Admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_notifications');
    }
};
