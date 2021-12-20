<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->string('name')->notNull();
            $table->string('slug')->nullable();
            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false)->notNull();

            $table->timestamps();

            // Indexes
            $table->index(['name', 'is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        Schema::create('quest_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_private')->default(false)->notNull();
            $table->timestamps();

            // Indexes
            $table->index(['is_private']);

            // Foreign
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });

        Schema::create('quest_characters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned()->nullable();
            $table->integer('character_id')->unsigned()->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_private')->default(false)->notNull();
            $table->timestamps();

            // Indexes
            $table->index(['is_private']);

            // Foreign
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('quests')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_locations');
        Schema::dropIfExists('quest_characters');
        Schema::dropIfExists('quests');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('quests');
        });
    }
}
