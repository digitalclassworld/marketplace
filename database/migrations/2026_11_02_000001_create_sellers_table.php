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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('seller_code', 50)->unique();
            $table->string('account_type', 50); // Individual / Freelancer, Institute / Company, Agency
            $table->string('seller_status', 30)->default('Pending Approval'); // Pending Approval, Active, Rejected, Suspended, Inactive
            $table->string('verification_status', 30)->default('Not Verified'); // Not Verified, Pending Verification, Verified, Verification Failed
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('seller_status');
            $table->index('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
