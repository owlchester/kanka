<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalendarDateToQuestAndJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->integer('calendar_id')->unsigned()->nullable();
            $table->smallInteger('calendar_year')->nullable();
            $table->smallInteger('calendar_month')->nullable();
            $table->smallInteger('calendar_day')->nullable();

            $table->index(['calendar_year', 'calendar_month', 'calendar_day'], 'quests_calendar_index');
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->integer('calendar_id')->unsigned()->nullable();
            $table->smallInteger('calendar_year')->nullable();
            $table->smallInteger('calendar_month')->nullable();
            $table->smallInteger('calendar_day')->nullable();

            $table->index(['calendar_year', 'calendar_month', 'calendar_day'], 'journals_calendar_index');
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('quests', function (Blueprint $table) {
            $table->dropIndex('quests_calendar_index');
            $table->dropColumn('calendar_id');
            $table->dropColumn('calendar_year');
            $table->dropColumn('calendar_month');
            $table->dropColumn('calendar_day');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->dropIndex('journals_calendar_index');
            $table->dropColumn('calendar_id');
            $table->dropColumn('calendar_year');
            $table->dropColumn('calendar_month');
            $table->dropColumn('calendar_day');
        });
    }
}
