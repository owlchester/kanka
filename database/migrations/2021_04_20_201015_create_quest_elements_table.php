<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_elements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('quest_id')->unsigned();
            $table->integer('entity_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();

            $table->string('role', 191)->nullable();
            $table->longText('description')->nullable();
            $table->string('visibility', 10)->nullable();
            $table->string('colour', 10)->nullable();

            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_elements');
    }
}
