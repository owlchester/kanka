<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDashboardWidgetWidthFull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_dashboard_widgets', function (Blueprint $table) {
            $table->unsignedTinyInteger('width')->default(0);
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
            $table->dropColumn('width');
        });
    }
}
