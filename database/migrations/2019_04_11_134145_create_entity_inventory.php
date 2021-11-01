<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('amount')->nullable();
            $table->string('position')->nullable();
            $table->string('visibility', 10)->default('all');
            $table->timestamps();

            // Index
            $table->index(['position']);


            // If we delete the entity or target, remove mentions
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
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
        Schema::dropIfExists('inventories');
    }
}
