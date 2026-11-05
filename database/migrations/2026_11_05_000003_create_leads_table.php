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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->string('city')->default('Ahmedabad, Gujarat');
            $table->string('source')->default('Meta Ads'); // Meta Ads, Google Ads, Website, WhatsApp, Referral, Others
            $table->string('campaign')->default('Institute ERP');
            $table->string('platform')->default('Website');
            $table->string('status')->default('New'); // New, Contacted, Qualified, Demo Scheduled, Converted, Not Interested, Follow Up
            $table->string('assigned_to')->nullable(); // Manish, Prakash, Tushar
            $table->date('next_follow_up')->nullable();
            $table->string('interested_in')->nullable();
            $table->string('budget')->nullable();
            $table->text('remarks')->nullable();
            $table->json('activities')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

