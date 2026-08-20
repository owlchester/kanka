<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::whenTableDoesntHaveIndex('entities', ['image_path'], function (Blueprint $table) {
            $table->index('image_path');
        });

        Schema::whenTableDoesntHaveColumn('legacy_image_migrations', 'prefix', function (Blueprint $table) {
            $table->string('prefix', 64)->nullable()->after('source_hash');
        });
        Schema::whenTableDoesntHaveIndex('legacy_image_migrations', ['prefix'], function (Blueprint $table) {
            $table->index('prefix');
        });

        if (! Schema::hasTable('legacy_image_migration_indexes')) {
            Schema::create('legacy_image_migration_indexes', function (Blueprint $table) {
                $table->id();
                $table->string('prefix', 64)->unique();
                $table->string('status', 20)->default('pending')->index();
                $table->unsignedBigInteger('source_count')->default(0);
                $table->unsignedBigInteger('reference_count')->default(0);
                $table->unsignedBigInteger('blocker_count')->default(0);
                $table->timestamp('indexed_at')->nullable();
                $table->text('error')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('legacy_image_migration_references')) {
            Schema::create('legacy_image_migration_references', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('legacy_image_migration_id')->nullable();
                $table->string('prefix', 64);
                $table->string('table_name', 64);
                $table->string('column_name', 64);
                $table->unsignedBigInteger('row_id');
                $table->char('value_hash', 64);
                $table->string('status', 20)->default('pending');
                $table->text('error')->nullable();
                $table->timestamps();

                $table->unique(
                    ['legacy_image_migration_id', 'table_name', 'column_name', 'row_id'],
                    'legacy_image_reference_unique'
                );
                $table->index(
                    ['table_name', 'column_name', 'row_id'],
                    'legacy_image_reference_row_index'
                );
            });
        }

        Schema::whenTableDoesntHaveIndex(
            'legacy_image_migration_references',
            ['legacy_image_migration_id'],
            function (Blueprint $table) {
                $table->index('legacy_image_migration_id', 'legacy_img_ref_migration_idx');
            }
        );
        Schema::whenTableDoesntHaveIndex(
            'legacy_image_migration_references',
            ['prefix'],
            function (Blueprint $table) {
                $table->index('prefix', 'legacy_img_ref_prefix_idx');
            }
        );
        Schema::whenTableDoesntHaveIndex(
            'legacy_image_migration_references',
            ['status'],
            function (Blueprint $table) {
                $table->index('status', 'legacy_img_ref_status_idx');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('legacy_image_migration_references');
        Schema::dropIfExists('legacy_image_migration_indexes');

        Schema::table('legacy_image_migrations', function (Blueprint $table) {
            $table->dropColumn('prefix');
        });

        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex(['image_path']);
        });
    }
};
