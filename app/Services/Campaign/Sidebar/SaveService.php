<?php

namespace App\Services\Campaign\Sidebar;

use App\Events\Campaigns\Sidebar\SidebarReset;
use App\Events\Campaigns\Sidebar\SidebarSaved;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class SaveService
{
    use CampaignAware;
    use UserAware;

    /**
     * Save the new config into the database, somehow.
     */
    public function save(array $data): void
    {
        // Prepare the data for the database
        $ui = $this->campaign->ui_settings;

        // First we want to figure out the new "order", and later we can worry about the "overrides".
        $order = [];
        $parent = null;
        foreach ($data['order'] as $field => $value) {
            if (Str::endsWith($field, '_start')) {
                $parent = Str::before($field, '_start');
                $order[$parent] = [];

                continue;
            } elseif (Str::endsWith($field, '_end')) {
                $parent = null;

                continue;
            }

            if (! empty($parent)) {
                $order[$parent][$field] = $field;
            } else {
                $order[$field] = null;
            }
        }

        $ui['sidebar'] = [
            'order' => $order,
        ];

        // Now let's build the config.
        $labels = [];
        $icons = [];

        foreach ($data as $field => $value) {
            if (empty($value)) {
                continue;
            }
            if (Str::endsWith($field, '_label')) {
                $labels[Str::before($field, '_label')] = Purify::clean(strip_tags($value));

                continue;
            } elseif (Str::endsWith($field, '_icon')) {
                $icons[Str::before($field, '_icon')] = Purify::clean(strip_tags($value));

                continue;
            }
            // Nothing of value
        }

        // Save the new data to the campaign config
        if (! empty($labels)) {
            $ui['sidebar']['labels'] = $labels;
        } elseif (isset($ui['sidebar']['labels'])) { // @phpstan-ignore-line
            unset($ui['sidebar']['labels']);
        }

        if (! empty($icons)) {
            $ui['sidebar']['icons'] = $icons;
        } elseif (isset($ui['sidebar']['icons'])) { // @phpstan-ignore-line
            unset($ui['sidebar']['icons']);
        }

        $this->campaign->ui_settings = $ui;
        $this->campaign->save();

        SidebarSaved::dispatch($this->campaign, $this->user);

        $this->clearCache();
    }

    public function reset(): void
    {
        $ui = $this->campaign->ui_settings;
        unset($ui['sidebar']);
        $this->campaign->ui_settings = $ui;
        $this->campaign->save();

        SidebarReset::dispatch($this->campaign, $this->user);

        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    protected function cacheKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_sidebar';
    }
}
