<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->boolean('characters')->default(true);
            $table->boolean('events')->default(true);
            $table->boolean('families')->default(true);
            $table->boolean('items')->default(true);
            $table->boolean('journals')->default(true);
            $table->boolean('locations')->default(true);
            $table->boolean('notes')->default(true);
            $table->boolean('organisations')->default(true);
            $table->boolean('menu_links')->default(true);
            $table->boolean('maps')->default(true);
            $table->boolean('inventories')->default(true);
            $table->boolean('entity_attributes')->default(true);
            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_settings');
    }
}
