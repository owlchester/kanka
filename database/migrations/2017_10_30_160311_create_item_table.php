<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('items');
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->date('date')->nullable();
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('location_id')->nullable();

            $table->longText('entry')->nullable();

            $table->string('price')->nullable();
            $table->string('size')->nullable();

            $table->boolean('is_private')->default(false);

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('character_id')->references('id')->on('characters')->nullOnDelete();
            $table->foreign('item_id')->references('id')->on('items')->nullOnDelete();

            // Index
            $table->index(['name', 'type', 'is_private']);
            $table->index(['price', 'size'], 'items_price_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
