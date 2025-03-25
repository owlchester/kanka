<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDashboardWidgetsAddTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_dashboard_widget_tags', function (Blueprint $table) {
            $table->unsignedInteger('widget_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('widget_id')->references('id')->on('campaign_dashboard_widgets')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->unique(['widget_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_dashboard_widget_tags', function (Blueprint $table) {});
    }
}
