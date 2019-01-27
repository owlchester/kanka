<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('entity_id')->notNull();
            $table->unsignedInteger('target_id')->notNull();

            $table->timestamps();

            // If we delete the entity or target, remove mentions
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('entities')->onDelete('cascade');
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
