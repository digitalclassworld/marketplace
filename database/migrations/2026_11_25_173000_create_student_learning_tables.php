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
        // 1. Course Enrollments table
        if (!Schema::hasTable('course_enrollments')) {
            Schema::create('course_enrollments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('course_id')->index();
                $table->string('course_type')->default('elearn'); // 'elearn' or 'catalog'
                $table->unsignedBigInteger('order_id')->nullable()->index();
                $table->timestamp('enrolled_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->integer('progress_percent')->default(0);
                $table->unsignedBigInteger('last_watched_lesson_id')->nullable();
                $table->string('status')->default('active'); // active, completed, expired
                $table->timestamps();

                $table->unique(['user_id', 'course_id', 'course_type'], 'user_course_unique');
            });
        }

        // 2. Student Lesson Completion Progress table
        if (!Schema::hasTable('student_course_progress')) {
            Schema::create('student_course_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('course_id')->index();
                $table->unsignedBigInteger('lesson_id')->index();
                $table->boolean('completed')->default(true);
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'course_id', 'lesson_id'], 'user_course_lesson_unique');
            });
        }

        // 3. Student Personal Lecture Notes table
        if (!Schema::hasTable('student_lecture_notes')) {
            Schema::create('student_lecture_notes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('course_id')->index();
                $table->unsignedBigInteger('lesson_id')->index();
                $table->text('note');
                $table->integer('timestamp_seconds')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'course_id', 'lesson_id'], 'user_lesson_note_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_lecture_notes');
        Schema::dropIfExists('student_course_progress');
        Schema::dropIfExists('course_enrollments');
    }
};
