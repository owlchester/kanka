<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCalendarsAddParentAndVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendars', function(Blueprint $table) {
            $table->unsignedInteger('calendar_id')->nullable();

            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');
        });

        Schema::table('calendar_weather', function(Blueprint $table) {
            $table->string('visibility', 10)->default('all');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('calendars', function(Blueprint $table) {
            $table->dropColumn('calendar_id');
        });

        Schema::table('calendar_weather', function(Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
}
