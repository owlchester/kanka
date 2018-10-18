<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalendarAddColourAndMoon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->text('epochs')->nullable();
            $table->text('moons')->nullable();
        });

        Schema::table('entity_events', function (Blueprint $table) {
            $table->string('colour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropColumn('epochs');
            $table->dropColumn('moons');
        });

        Schema::table('entity_events', function (Blueprint $table) {
            $table->dropColumn('colour');
        });
    }
}
