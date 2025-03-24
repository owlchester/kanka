<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->integer('campaign_id')->unsigned();

            // Overview
            $table->longText('entry')->nullable();
            $table->string('title')->nullable();
            $table->string('type', 45)->nullable();

            // Appearance
            $table->string('age', 20)->nullable();
            $table->string('sex', 45)->nullable();
            $table->string('pronouns', 45)->nullable();
            $table->string('image')->nullable();

            $table->timestamps();

            $table->boolean('is_private')->default(false);
            $table->boolean('is_personality_pinned')->default(false);
            $table->boolean('is_appearance_pinned')->default(false);

            $table->index(['is_private']);

            $table->boolean('is_personality_visible')->default(true);
            $table->boolean('is_dead')->default(false);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Index
            $table->index(['name']);
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
