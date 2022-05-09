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
            $table->unsignedInteger('item_id')->nullable();
            $table->string('name', 45)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->string('position')->nullable();
            $table->string('visibility', 10)->default('all');

            $table->text('description')->nullable();

            $table->boolean('copy_item_entry')->nullable()->default(false);
            $table->boolean('is_equipped')->default(false);
            $table->timestamps();

            // Index
            $table->index(['position']);


            // If we delete the entity or target, remove mentions
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
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
        Schema::dropIfExists('inventories');
    }
}
