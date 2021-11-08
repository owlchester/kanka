<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateCampaignInvites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')
                ->after('campaign_id')
                ->default(\App\Models\CampaignInvite::TYPE_LINK);
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE campaign_invites SET type_id = ' . \App\Models\CampaignInvite::TYPE_EMAIL . ' WHERE type = \'email\'');

        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->dropColumn('type');
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
            $table->string('type', 10)
                ->after('campaign_id')
                ->default('link');
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE campaign_invites SET type = \'email\' WHERE type_id = ' . \App\Models\CampaignInvite::TYPE_EMAIL);

        Schema::table('campaign_invites', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
