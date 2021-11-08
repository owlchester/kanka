<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvitesAddLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->string('type', 5)->default('email');
            $table->integer('validity')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->dropForeign('validity');
            $table->dropColumn('type');
        });
    }
}
