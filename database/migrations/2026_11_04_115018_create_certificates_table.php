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
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->string('certificate_no', 64)->unique(); // e.g. DC2026-00128
                $table->string('student_id', 64)->nullable();    // e.g. STU20260045
                $table->string('student_name');                  // e.g. Meshwa Patel
                $table->string('course_title');                  // e.g. Full Stack Web Development
                $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
                $table->foreignId('seller_id')->nullable()->constrained('sellers')->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
                $table->string('duration')->default('6 Months');
                $table->string('start_date')->default('15 Apr 2026');
                $table->string('completion_date')->default('15 Oct 2026');
                $table->string('instructor_name')->default('Rajesh Sharma');
                $table->string('instructor_title')->default('Course Instructor');
                $table->string('instructor_signature')->nullable();
                $table->string('signatory_name')->default('Dr. Neha Mehta');
                $table->string('signatory_title')->default('Authorized Signatory');
                $table->string('institute_name')->default('BrightLearn Institute');
                $table->string('signatory_signature')->nullable();
                $table->boolean('is_verified')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
