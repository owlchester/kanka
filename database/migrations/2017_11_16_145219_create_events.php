<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false);

            $table->integer('campaign_id')->unsigned()->notNull();
            $table->integer('location_id')->unsigned()->nullable();
            $table->unsignedInteger('event_id')->nullable();

            $table->longText('entry')->nullable();

            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('event_id')->references('id')->on('events')->nullOnDelete();

            // Index
            $table->index(['name', 'slug', 'type', 'date', 'is_private']);
            $table->index(['_lft', '_rgt']);
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
