<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserAndCampaignLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('join_token', 255)->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('last_campaign_id')->nullable()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('join_token');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_campaign_id');
        });
    }
}
