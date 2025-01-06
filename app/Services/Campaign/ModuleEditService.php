<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Http\Requests\UpdateModuleName;
use App\Models\EntityType;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Exception;

class ModuleEditService
{
    use CampaignAware;
    use PurifiableTrait;

    public function update(UpdateModuleName $request, EntityType $entityType): self
    {
        $settings = $this->campaign->settings;

        $key = $entityType->id;
        unset($settings['modules'][$key]['s'], $settings['modules'][$key]['p'], $settings['modules'][$key]['i']);



        $singular = $plural = $icon = null;
        if ($request->filled('singular')) {
            $singular = $this->purify(mb_trim($request->get('singular')));
        }
        if ($request->filled('plural')) {
            $plural = $this->purify(mb_trim($request->get('plural')));
        }
        if ($request->filled('icon')) {
            $icon = $this->purify(mb_trim($request->get('icon')));
        }

        if (!empty($singular)) {
            $settings['modules'][$key]['s'] = $singular;
        }
        if (!empty($plural)) {
            $settings['modules'][$key]['p'] = $plural;
        }
        if (!empty($icon)) {
            $settings['modules'][$key]['i'] = $icon;
        }

        $this->campaign->settings = $settings;
        $this->campaign->updateQuietly();

        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');
        //$this->campaign->touchQuietly();

        return $this;
    }

    /**
     * Remove the custom modules setup from the campaign
     * @return $this
     */
    public function reset(): self
    {
        $settings = $this->campaign->settings;
        unset($settings['modules']);
        if (is_array($settings)) {
            foreach ($settings as $name => $val) {
                if (Str::startsWith($name, 'modules.')) {
                    unset($settings[$name]);
                }
            }
        }
        $this->campaign->settings = $settings;
        $this->campaign->saveQuietly();
        CampaignCache::clear();
        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');
        return $this;
    }

    public function toggle(string $module): bool
    {
        // Validate module
        $fillable = $this->campaign->setting->getFillable();
        if (empty($module) || !in_array($module, $fillable)) {
            throw new Exception();
        }

        $this->campaign->setting->{$module} = !$this->campaign->setting->{$module};
        $this->campaign->setting->saveQuietly();
        CampaignCache::clear();
        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');
        return (bool) $this->campaign->setting->{$module};
    }
}
