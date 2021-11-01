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

            $table->string('type')->nullable();


            // Overview
            $table->longText('entry')->nullable();

            // Appearance
            $table->string('age', 25)->nullable();
            $table->string('sex', 45)->nullable();

            $table->boolean('is_personality_visible')->default(true);


            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Index
            $table->index(['name', 'slug']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
