<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarWeather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_weather', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('calendar_id');
            $table->string('weather', 20);
            $table->string('temperature', 45)->nullable();
            $table->string('precipitation', 45)->nullable();
            $table->string('wind', 45)->nullable();
            $table->string('effect', 45)->nullable();

            $table->unsignedMediumInteger('day');
            $table->unsignedMediumInteger('month');
            $table->integer('year');
            $table->timestamps();

            $table->index(['day', 'month', 'year']);

            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendar_weather');
    }
}
