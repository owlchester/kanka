<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            if (Schema::hasColumn('characters', 'status_id')) {
                $table->dropColumn('status_id');
            }
        });

        Schema::table('quests', function (Blueprint $table) {
            if (Schema::hasColumn('quests', 'status_id')) {
                $table->dropColumn('status_id');
            }
        });

        Schema::table('creatures', function (Blueprint $table) {
            if (Schema::hasIndex('creatures', 'creatures_is_dead_index')) {
                $table->dropIndex('creatures_is_dead_index');
            }
            if (Schema::hasIndex('creatures', 'creatures_is_extinct_index')) {
                $table->dropIndex('creatures_is_extinct_index');
            }
            if (Schema::hasColumn('creatures', 'is_dead')) {
                $table->dropColumn('is_dead');
            }
            if (Schema::hasColumn('creatures', 'is_extinct')) {
                $table->dropColumn('is_extinct');
            }
        });

        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasIndex('locations', 'locations_is_destroyed_index')) {
                $table->dropIndex('locations_is_destroyed_index');
            }
            if (Schema::hasColumn('locations', 'is_destroyed')) {
                $table->dropColumn('is_destroyed');
            }
        });

        Schema::table('organisations', function (Blueprint $table) {
            if (Schema::hasIndex('organisations', 'organisations_is_defunct_index')) {
                $table->dropIndex('organisations_is_defunct_index');
            }
            if (Schema::hasColumn('organisations', 'is_defunct')) {
                $table->dropColumn('is_defunct');
            }
        });

        Schema::table('races', function (Blueprint $table) {
            if (Schema::hasIndex('races', 'races_is_extinct_index')) {
                $table->dropIndex('races_is_extinct_index');
            }
            if (Schema::hasColumn('races', 'is_extinct')) {
                $table->dropColumn('is_extinct');
            }
        });

        Schema::table('families', function (Blueprint $table) {
            if (Schema::hasIndex('families', 'families_is_extinct_index')) {
                $table->dropIndex('families_is_extinct_index');
            }
            if (Schema::hasColumn('families', 'is_extinct')) {
                $table->dropColumn('is_extinct');
            }
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
