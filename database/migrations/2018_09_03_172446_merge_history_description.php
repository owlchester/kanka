<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeHistoryDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
        });
        Schema::table('characters', function (Blueprint $table) {
            $table->renameColumn('history', 'entry');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('history', 'entry');
        });
        Schema::table('families', function (Blueprint $table) {
            $table->renameColumn('history', 'entry');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
            $table->dropColumn('history');
        });
        Schema::table('journals', function (Blueprint $table) {
            $table->renameColumn('history', 'entry');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
            $table->dropColumn('history');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
        });
        Schema::table('organisations', function (Blueprint $table) {
            $table->renameColumn('history', 'entry');
        });
        Schema::table('quests', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->renameColumn('description', 'entry');
        });
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
