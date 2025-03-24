<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('created_by')->nullable();
            $table->smallInteger('length')->unsigned()->default(1);
            $table->boolean('is_recurring')->default(false);
            $table->string('comment')->nullable();
            $table->string('colour', 12)->nullable();
            $table->unsignedBigInteger('visibility_id');
            $table->unsignedMediumInteger('day');
            $table->unsignedMediumInteger('month');
            $table->integer('year');
            $table->string('recurring_until', 12)->nullable();
            $table->string('recurring_periodicity', 5)->nullable();

            $table->timestamps();

            $table->index(['is_recurring']);
            $table->index(['day', 'month', 'year']);

            // Foreign
            $table->foreign('calendar_id')->references('id')->on('calendars')->cascadeOnDelete();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('created_by')->on('users')->references('id')->nullOnDelete();
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
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
