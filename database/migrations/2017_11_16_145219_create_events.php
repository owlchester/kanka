<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false);

            $table->integer('campaign_id')->unsigned();
            $table->integer('location_id')->unsigned()->nullable();
            $table->unsignedInteger('event_id')->nullable();

            $table->longText('entry')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('event_id')->references('id')->on('events')->nullOnDelete();

            // Index
            $table->index(['name', 'type', 'date', 'is_private']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
