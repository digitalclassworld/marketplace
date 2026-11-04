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
        Schema::table('sellers', function (Blueprint $table) {
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('approved_by');
            $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            $table->foreignId('rejected_by')->nullable()->after('rejected_at')->constrained('users')->nullOnDelete();
            $table->timestamp('suspended_at')->nullable()->after('rejected_by');
            $table->foreignId('suspended_by')->nullable()->after('suspended_at')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn('rejection_reason');
            $table->dropColumn('rejected_at');
            $table->dropConstrainedForeignId('rejected_by');
            $table->dropColumn('suspended_at');
            $table->dropConstrainedForeignId('suspended_by');
        });
    }
};

