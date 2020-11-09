<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaignWidgetsAddDashboardId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_dashboard_widgets', function (Blueprint $table) {
            $table->unsignedBigInteger('dashboard_id')->nullable();

            $table->foreign('dashboard_id')->references('id')->on('campaign_dashboards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_dashboard_widgets', function (Blueprint $table) {
            $table->dropForeign('campaign_dashboard_widgets_dashboard_id_foreign');
            $table->dropColumn('dashboard_id');
        });
    }
}
