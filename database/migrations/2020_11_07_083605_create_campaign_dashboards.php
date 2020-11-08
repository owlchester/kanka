<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDashboards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('campaign_dashboard_roles');
        Schema::dropIfExists('campaign_dashboards');

        Schema::create('campaign_dashboards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name', 100);

            $table->index(['campaign_id', 'name']);
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('campaign_dashboard_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_dashboard_id');
            $table->unsignedInteger('campaign_role_id');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_visible')->default(false);

            $table->index(['is_default']);
            $table->timestamps();

            $table->foreign('campaign_dashboard_id')->references('id')->on('campaign_dashboards')->onDelete('cascade');
            $table->foreign('campaign_role_id')->references('id')->on('campaign_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_dashboard_roles');
        Schema::dropIfExists('campaign_dashboards');
    }
}
