<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('visibility_id')->default(1);

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
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

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
