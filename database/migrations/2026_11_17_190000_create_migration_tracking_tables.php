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
        if (!Schema::hasTable('migration_batches')) {
            Schema::create('migration_batches', function (Blueprint $table) {
                $table->id();
                $table->string('batch_code', 50)->unique();
                $table->enum('mode', ['dry_run', 'live'])->default('dry_run');
                $table->string('source_file')->default('digitxix_elm.sql');
                $table->string('status', 30)->default('in_progress'); // in_progress, completed, failed
                $table->integer('total_records_processed')->default(0);
                $table->integer('total_records_migrated')->default(0);
                $table->integer('total_records_skipped')->default(0);
                $table->integer('total_exceptions')->default(0);
                $table->timestamp('started_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('migration_id_mappings')) {
            Schema::create('migration_id_mappings', function (Blueprint $table) {
                $table->id();
                $table->string('entity_type', 50); // user, seller_tutor, seller_affiliate, course, listing, order, review
                $table->string('old_id', 100);
                $table->unsignedBigInteger('new_id');
                $table->string('unique_key', 255)->nullable(); // e.g. email or slug
                $table->timestamps();

                $table->unique(['entity_type', 'old_id'], 'uq_migration_entity_old_id');
                $table->index(['entity_type', 'new_id'], 'idx_migration_entity_new_id');
            });
        }

        if (!Schema::hasTable('migration_logs')) {
            Schema::create('migration_logs', function (Blueprint $table) {
                $table->id();
                $table->string('batch_code', 50);
                $table->string('entity_type', 50);
                $table->string('level', 20)->default('info'); // info, warning, error, duplicate
                $table->string('old_id', 100)->nullable();
                $table->unsignedBigInteger('new_id')->nullable();
                $table->text('message');
                $table->timestamps();

                $table->index('batch_code');
                $table->index('entity_type');
            });
        }

        if (!Schema::hasTable('migration_exceptions')) {
            Schema::create('migration_exceptions', function (Blueprint $table) {
                $table->id();
                $table->string('batch_code', 50);
                $table->string('entity_type', 50);
                $table->string('old_id', 100);
                $table->string('reason');
                $table->longText('payload')->nullable();
                $table->boolean('resolved')->default(false);
                $table->timestamps();

                $table->index('batch_code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migration_exceptions');
        Schema::dropIfExists('migration_logs');
        Schema::dropIfExists('migration_id_mappings');
        Schema::dropIfExists('migration_batches');
    }
};
