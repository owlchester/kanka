<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacterRaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_race', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('character_id');
            $table->unsignedInteger('race_id');
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();
            $table->foreign('race_id')->references('id')->on('races')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
