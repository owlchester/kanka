<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateCampaignSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $campaigns = \App\Models\Campaign::get();
        foreach ($campaigns as $campaign) {
            $setting = \App\Models\CampaignSetting::create([
                'campaign_id' => $campaign->id,
            ]);
            unset($setting);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $campaigns = \App\Models\Campaign::get();
        foreach ($campaigns as $campaign) {
            $campaign->setting->delete();
        }
    }
}
