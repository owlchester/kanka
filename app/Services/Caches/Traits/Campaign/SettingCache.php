<?php

namespace App\Services\Caches\Traits\Campaign;

use App\Models\CampaignSetting;

trait SettingCache
{
    public function settings(): CampaignSetting
    {
        $key = $this->settingsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->setting;
        $this->forever($key, $data);
        return $data;
    }

    public function clearSettings(): self
    {
        $this->forget(
            $this->settingsKey()
        );
        return $this;
    }

    protected function settingsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_settings';
    }
}
