<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuLinksDashboardId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_links', function (Blueprint $table) {
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
        Schema::table('menu_links', function (Blueprint $table) {
            $table->dropForeign('menu_links_dashboard_id_foreign');
            $table->dropColumn('dashboard_id');
        });
    }
}
