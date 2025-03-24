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
            'abilities',
            'attribute_templates',
            'calendars',
            'creatures',
            'events',
            'events',
            'families',
            'items',
            'journals',
            'locations',
            'maps',
            'notes',
            'organisations',
            'quests',
            'races',
            'tags',
            'timelines',
        ];
        foreach ($tables as $tableName) {
            if (! Schema::hasColumn($tableName, '_lft')) {
                continue;
            }
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('_lft');
                $table->dropColumn('_rgt');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
