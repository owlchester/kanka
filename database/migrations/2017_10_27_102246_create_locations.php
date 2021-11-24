<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cleanup
        Schema::dropIfExists('location_attributes');
        Schema::dropIfExists('locations');

        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type', 45);
            $table->string('image')->nullable();
            $table->longText('entry')->nullable();
            $table->integer('parent_location_id')->unsigned()->nullable();

            $table->timestamps();

            $table->integer('campaign_id')->unsigned()->notNull();

            // Index
            $table->index(['name', 'slug', 'type']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('parent_location_id')->references('id')->on('locations')->onDelete('cascade');
        });


        Schema::create('location_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('value')->notNull();
            $table->integer('location_id')->unsigned();
            $table->timestamps();

            // Index
            $table->index(['name']);

            // Foreign
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_attributes');
        Schema::dropIfExists('locations');
    }
}
