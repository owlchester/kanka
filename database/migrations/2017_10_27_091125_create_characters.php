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
            $table->string('title')->nullable();
            $table->string('type', 45)->nullable();

            // Appearance
            $table->string('age', 20)->nullable();
            $table->string('sex', 45)->nullable();
            $table->string('image')->nullable();

            $table->timestamps();

            // Privacy
            $table->boolean('is_private')->default(false);
            $table->index(['is_private']);

            $table->boolean('is_personality_visible')->default(true);
            $table->boolean('is_dead')->default(false)->notNull();

            $table->string('header_image')->nullable();
            $table->string('system', 45)->nullable();

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
