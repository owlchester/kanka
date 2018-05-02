<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calendar_id')->unsigned();
            $table->integer('entity_id')->unsigned();
            $table->string('date');
            $table->boolean('is_recurring')->defaultValue(false);
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->index(['date', 'is_recurring']);

            // Foreign
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_events');
    }
}
