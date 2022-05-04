<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaignPermissionsPerf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_permissions', function (Blueprint $table) {
            $table->unsignedInteger('campaign_id')->after('user_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();

            $table->unsignedInteger('entity_type_id')->after('table_name')->nullable();
            $table->foreign('entity_type_id')->references('id')->on('entity_types')->cascadeOnDelete();


            $table->unsignedTinyInteger('action')->after('key');
            $table->unsignedInteger('misc_id')->nullable()->after('entity_id');
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
            $table->dropForeign('campaign_permissions_campaign_id_foreign');
            $table->dropColumn('campaign_id');
            $table->dropForeign('campaign_permissions_entity_type_id_foreign');
            $table->dropColumn('entity_type_id');
            $table->dropColumn('action');
            $table->dropColumn('misc_id');
        });
    }
}
