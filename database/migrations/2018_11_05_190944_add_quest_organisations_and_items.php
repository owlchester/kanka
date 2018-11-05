<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestOrganisationsAndItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned()->nullable();
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_private')->default(false)->notNull();
            $table->timestamps();

            // Indexes
            $table->index(['is_private']);

            // Foreign
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        });

        Schema::create('quest_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_private')->default(false)->notNull();
            $table->timestamps();

            // Indexes
            $table->index(['is_private']);

            // Foreign
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_items');
        Schema::dropIfExists('quest_organisations');
    }
}
