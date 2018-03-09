<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAdminToCampaignRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_roles', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->notNull();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_roles', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
