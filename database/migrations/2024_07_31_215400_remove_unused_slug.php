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
            'characters',
            'conversations',
            'creatures',
            'dice_rolls',
            'events',
            'families',
            'items',
            'journals',
            'locations',
            'maps',
            'notes',
            'organisations',
            'quests',
            'timelines',
        ];
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
               $table->dropColumn('slug');
            });
        }
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
