<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserLog;
use App\Models\CampaignInvite;
use \Illuminate\Support\Facades\DB;

class RemoveEnums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_user', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->unsignedTinyInteger('action_id');
        });
        DB::statement("UPDATE user_logs SET action_id = " . UserLog::ACTION_LOGIN . " where action = 'login'");
        DB::statement("UPDATE user_logs SET action_id = " . UserLog::ACTION_LOGOUT . " where action = 'logout'");
        DB::statement("UPDATE user_logs SET action_id = " . UserLog::ACTION_LOGIN_FAIL . " where action = 'login_fail'");
        DB::statement("UPDATE user_logs SET action_id = " . UserLog::ACTION_UPDATE . " where action = 'update'");

        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id');
        });
        DB::statement("UPDATE campaign_invites SET type_id = " . CampaignInvite::TYPE_EMAIL . " where type = 'email'");
        DB::statement("UPDATE campaign_invites SET type_id = " . CampaignInvite::TYPE_LINK . " where type = 'link'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_user', function (Blueprint $table) {
            $table->string('role', 12);
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('action_id');
        });
        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
