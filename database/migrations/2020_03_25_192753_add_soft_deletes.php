<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'entities',
            'characters',
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
            'dice_rolls',
            'conversations',
            'attribute_templates',
            'abilities',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
