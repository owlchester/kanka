<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->date('date')->nullable();
            $table->integer('campaign_id')->unsigned()->notNull();
            $table->integer('character_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();

            // Overview
            $table->longText('entry')->nullable();

            $table->string('price')->nullable();
            $table->string('size')->nullable();


            // Privacy
            $table->boolean('is_private')->default(false);

            $table->timestamps();


            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('character_id')->references('id')->on('characters')->nullOnDelete();

            // Index
            $table->index(['name', 'slug', 'type', 'is_private']);
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
