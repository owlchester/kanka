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
        $tables = ['abilities', 'calendars', 'characters', 'creatures', 'events', 'families', 'items', 'journals', 'locations', 'maps', 'notes', 'organisations', 'quests', 'races', 'tags', 'timelines'];
        foreach ($tables as $tablename) {
            if (! Schema::hasColumn($tablename, 'image')) {
                continue;
            }
            Schema::table($tablename, function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
