<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();

            $table->integer('campaign_id')->unsigned()->notNull();
            $table->integer('location_id')->unsigned()->nullable();

            // Overview
            $table->longText('history')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            // Index
            $table->index(['name', 'slug', 'type']);
        });

        Schema::create('organisation_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned()->notNull();
            $table->integer('character_id')->unsigned()->notNull();
            $table->string('role', 45)->notNull();
            $table->timestamps();

            // Foreign
            $table->foreign('organisation_id')->references('id')->on('organisations');
            $table->foreign('character_id')->references('id')->on('characters');

            // Index
            //$table->index([]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisation_member');
        Schema::dropIfExists('organisations');
    }
}
