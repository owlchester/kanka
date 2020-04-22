<?php

use Illuminate\Database\Seeder;

class CampaignBoostCount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boosts = \App\Models\CampaignBoost::with('campaign')->get();
        $count = 0;
        foreach ($boosts as $boost) {
            $boost->campaign->boost_count = 1;
            $boost->campaign->update();
            $count++;
        }
    }
}
