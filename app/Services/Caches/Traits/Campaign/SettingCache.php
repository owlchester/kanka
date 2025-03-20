<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait SettingCache
{
    public function settings(): Collection
    {
        return new Collection($this->primary($this->campaign->id)->get('modules'));
    }

    protected function formatSettings(): array
    {
        $settings = $this->campaign->setting->toArray();
        unset($settings['id'], $settings['campaign_id'], $settings['created_at'], $settings['updated_at']);

        return $settings;
    }
}
