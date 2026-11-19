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
        if (Schema::hasTable('business_listings')) {
            Schema::table('business_listings', function (Blueprint $table) {
                if (!Schema::hasColumn('business_listings', 'area')) {
                    $table->string('area', 150)->nullable()->after('address');
                }
                if (!Schema::hasColumn('business_listings', 'landmark')) {
                    $table->string('landmark', 255)->nullable()->after('area');
                }
            });
        }

        if (Schema::hasTable('seller_business_details')) {
            Schema::table('seller_business_details', function (Blueprint $table) {
                if (!Schema::hasColumn('seller_business_details', 'area')) {
                    $table->string('area', 150)->nullable()->after('address');
                }
                if (!Schema::hasColumn('seller_business_details', 'landmark')) {
                    $table->string('landmark', 255)->nullable()->after('area');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('business_listings')) {
            Schema::table('business_listings', function (Blueprint $table) {
                if (Schema::hasColumn('business_listings', 'landmark')) {
                    $table->dropColumn('landmark');
                }
                if (Schema::hasColumn('business_listings', 'area')) {
                    $table->dropColumn('area');
                }
            });
        }

        if (Schema::hasTable('seller_business_details')) {
            Schema::table('seller_business_details', function (Blueprint $table) {
                if (Schema::hasColumn('seller_business_details', 'landmark')) {
                    $table->dropColumn('landmark');
                }
                if (Schema::hasColumn('seller_business_details', 'area')) {
                    $table->dropColumn('area');
                }
            });
        }
    }
};
