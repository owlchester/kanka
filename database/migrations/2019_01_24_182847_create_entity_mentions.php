<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityMentions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_mentions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->integer('entity_note_id')->unsigned()->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->unsignedInteger('target_id');
            $table->timestamps();

            // If we delete the entity or target, remove mentions
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('entity_note_id')->references('id')->on('entity_notes')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entity_mentions');
    }
}
