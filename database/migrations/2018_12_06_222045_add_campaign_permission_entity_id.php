<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaignPermissionEntityId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_permissions', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->nullable()->default(null);
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
        Schema::table('campaign_permissions', function (Blueprint $table) {
            $table->dropForeign('campaign_permissions_entity_id_foreign');
            $table->dropColumn('entity_id');
        });
    }
}
