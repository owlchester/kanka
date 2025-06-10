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
            Schema::table($tablename, function (Blueprint $table) {
                $table->dropColumn('type');
                $table->dropColumn('entry');
            });
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
