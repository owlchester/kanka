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
            $table->longText('entry')->nullable();

            // Appearance
            $table->string('age', 25)->nullable();
            $table->string('sex', 45)->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Index
            $table->index(['name', 'slug']);
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
