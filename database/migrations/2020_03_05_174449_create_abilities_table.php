<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('abilities');

        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('campaign_id');
            //            $table->unsignedInteger('character_id')->nullable();
            //            $table->unsignedInteger('location_id')->nullable();
            $table->unsignedInteger('ability_id')->nullable();
            $table->boolean('is_private')->default(false);

            // Overview
            $table->longText('entry')->nullable();
            $table->string('charges', 120)->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');

            // Index
            $table->index(['name', 'type']);
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('abilities')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('abilities');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('abilities');
        });
    }
}
