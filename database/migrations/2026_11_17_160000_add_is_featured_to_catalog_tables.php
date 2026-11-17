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
        if (Schema::hasTable('services') && !Schema::hasColumn('services', 'is_featured')) {
            Schema::table('services', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false)->after('status');
            });
        }

        if (Schema::hasTable('courses') && !Schema::hasColumn('courses', 'is_featured')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false)->after('status');
            });
        }

        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'is_featured')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false)->after('status');
            });
        }

        if (Schema::hasTable('business_listings') && !Schema::hasColumn('business_listings', 'is_featured')) {
            Schema::table('business_listings', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'is_featured')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }

        if (Schema::hasTable('courses') && Schema::hasColumn('courses', 'is_featured')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'is_featured')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }

        if (Schema::hasTable('business_listings') && Schema::hasColumn('business_listings', 'is_featured')) {
            Schema::table('business_listings', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }
    }
};
