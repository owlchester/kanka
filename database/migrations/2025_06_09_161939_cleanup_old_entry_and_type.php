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
        $tables = [
            // 'characters',
            'families',
            'locations',
            'organisations',
            'items',
            'notes',
            'events',
            'calendars',
            'races',
            'quests',
            'journals',
            'tags',
            'abilities',
            'maps',
            'timelines',
            'creatures',
        ];
        foreach ($tables as $tablename) {
            if (! in_array($tablename, ['families', 'items', 'events', 'calendars', 'races', 'quests', 'journals', 'tags', 'creatures'])) {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropIndex(['name_type']); // drops index that contains "type"
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            } elseif (in_array($tablename, ['items', 'races', 'creatures'])) {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropIndex(['name_type_is_private']); // drops index that contains "type"
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            } elseif ($tablename == 'events') {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropIndex(['name_type_date_is_private']); // drops index that contains "type"
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            } elseif ($tablename == 'journals') {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropIndex(['name_type_date']); // drops index that contains "type"
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            } elseif ($tablename == 'tags') {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropIndex(['name_type_is_private_is_hidden_is_auto_applied']); // drops index that contains "type"
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            } else {
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropColumn('type');
                    $table->dropColumn('entry');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
