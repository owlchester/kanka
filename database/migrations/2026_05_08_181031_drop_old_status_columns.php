<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });

        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });

        Schema::table('creatures', function (Blueprint $table) {
            $table->dropColumn('is_dead');
            $table->dropColumn('is_extinct');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('is_destroyed');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn('is_defunct');
        });

        Schema::table('races', function (Blueprint $table) {
            $table->dropColumn('is_extinct');
        });

        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('is_extinct');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->unsignedTinyInteger('status_id')->default(0);
        });

        Schema::table('quests', function (Blueprint $table) {
            $table->unsignedTinyInteger('status_id')->default(0);
        });

        Schema::table('creatures', function (Blueprint $table) {
            $table->boolean('is_dead')->default(false);
            $table->boolean('is_extinct')->default(false);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->boolean('is_destroyed')->default(false);
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->boolean('is_defunct')->default(false);
        });

        Schema::table('races', function (Blueprint $table) {
            $table->boolean('is_extinct')->default(false);
        });

        Schema::table('families', function (Blueprint $table) {
            $table->boolean('is_extinct')->default(false);
        });
    }
};
