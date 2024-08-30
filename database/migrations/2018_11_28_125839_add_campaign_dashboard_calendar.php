<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampaignDashboardCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_dashboard_widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();

            $table->unsignedInteger('entity_id')->nullable();
            $table->text('config')->nullable();
            $table->unsignedTinyInteger('position');

            $table->string('widget', 12);
            $table->unsignedTinyInteger('width')->default(0);

            $table->timestamps();

            $table->index(['campaign_id', 'position']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_dashboard_widgets');
    }
}
