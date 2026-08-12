<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->index('image_path');
        });

        Schema::table('legacy_image_migrations', function (Blueprint $table) {
            $table->string('prefix', 64)->nullable()->after('source_hash')->index();
        });

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

        Schema::create('legacy_image_migration_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legacy_image_migration_id')->nullable()->index();
            $table->string('prefix', 64)->index();
            $table->string('table_name', 64);
            $table->string('column_name', 64);
            $table->unsignedBigInteger('row_id');
            $table->char('value_hash', 64);
            $table->string('status', 20)->default('pending')->index();
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
