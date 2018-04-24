<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablesAddSectionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'characters', 'locations', 'notes', 'families', 'organisations',
            'items', 'events', 'quests', 'calendars', 'journals'
        ];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedInteger('section_id')->nullable();
                $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
