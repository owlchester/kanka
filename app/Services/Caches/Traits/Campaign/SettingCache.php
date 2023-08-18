<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait SettingCache
{
    public function settings(): Collection
    {
        return new Collection($this->primary()->get('modules'));
    }

    protected function formatSettings(): array
    {
        $settings = $this->campaign->setting->toArray();
        unset($settings['id']);
        unset($settings['campaign_id']);
        unset($settings['created_at']);
        unset($settings['updated_at']);
        return $settings;
    }
}
