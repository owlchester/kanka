<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\Preset;

class PresetObserver
{
    use PurifiableTrait;

    public function saving(Preset $preset)
    {
        $preset->campaign_id = CampaignLocalization::getCampaign()->id;
        $preset->name = $this->purify(trim($preset->name));

        // Clean up config
        $config = $preset->config;
        foreach ($config as $key => $value) {
            if ($value === null) {
                unset($config[$key]);
            }
        }

        $preset->config = $config;
    }
}
