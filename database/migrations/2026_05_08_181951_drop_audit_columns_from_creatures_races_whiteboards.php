<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('creatures', function (Blueprint $table) {
            $table->dropForeign('creatures_created_by_foreign');
            $table->dropForeign('creatures_updated_by_foreign');
            $table->dropColumn(['created_by', 'updated_by']);
        });

        Schema::table('races', function (Blueprint $table) {
            $table->dropForeign('races_created_by_foreign');
            $table->dropForeign('races_updated_by_foreign');
            $table->dropColumn(['created_by', 'updated_by']);
        });

        Schema::table('whiteboards', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }

    public function down(): void
    {
        Schema::table('creatures', function (Blueprint $table) {
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('races', function (Blueprint $table) {
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('whiteboards', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->nullOnDelete();
        });
    }
};
