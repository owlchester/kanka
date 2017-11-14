<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserCampaignRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('campaign_role', 20)->null();
        });

        $users = \App\User::with('campaign')->get();
        foreach ($users as $user) {
            if ($user->campaign) {
                $role = \App\CampaignUser::where('campaign_id', $user->campaign->id)->where('user_id', $user->id)->first();
                if ($role) {
                    $user->campaign_role = $role->role;
                    $user->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('campaign_role');
        });
    }
}
