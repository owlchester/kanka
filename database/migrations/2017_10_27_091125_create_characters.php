<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->integer('campaign_id')->unsigned()->notNull();

            // Overview
            $table->longText('history')->nullable();

            // Appearance
            $table->mediumInteger('age')->nullable();
            $table->string('height', 10)->nullable();
            $table->string('weight', 10)->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('race', 45)->nullable();
            $table->string('eye_colour', 12)->nullable();
            $table->string('hair', 45)->nullable();
            $table->string('skin', 45)->nullable();
            $table->string('image')->nullable();

            // Social
            $table->text('traits')->nullable();
            $table->text('goals')->nullable();
            $table->text('fears')->nullable();
            $table->text('mannerisms')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Index
            $table->index(['name', 'slug', 'race']);
        });

        Schema::create('character_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_id')->unsigned()->notNull();
            $table->integer('second_id')->unsigned()->notNull();
            $table->string('relation', 45)->notNull();
            $table->timestamps();

            // Foreign
            $table->foreign('first_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('second_id')->references('id')->on('characters')->onDelete('cascade');

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
        Schema::dropIfExists('character_relation');
        Schema::dropIfExists('characters');
    }
}
