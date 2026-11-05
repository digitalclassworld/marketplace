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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('count')->default(0);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('type')->default('Blog'); // Blog, Page, News, Announcement
            $table->string('category')->default('Technology');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('author_name')->default('Hitesh Mohkar');
            $table->string('author_avatar')->nullable();
            $table->string('author_role')->default('Super Admin');
            $table->integer('views')->default(0);
            $table->string('status')->default('Published'); // Published, Draft, Scheduled
            $table->timestamp('published_at')->nullable();
            $table->boolean('allow_comments')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->json('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->timestamps();
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};
