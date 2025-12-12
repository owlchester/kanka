<?php

namespace App\Services\Campaign;

use App\Events\Campaigns\EntityTypes\EntityTypeToggled;
use App\Facades\CampaignCache;
use App\Http\Requests\UpdateModuleName;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ModuleEditService
{
    use CampaignAware;
    use EntityTypeAware;
    use PurifiableTrait;
    use UserAware;

    public function __construct(
        protected DefaultImageService $defaultImageService
    ) {}

    public function update(UpdateModuleName $request): self
    {
        $settings = $this->campaign->settings;

        $key = $this->entityType->id;
        unset($settings['modules'][$key]['s'], $settings['modules'][$key]['p'], $settings['modules'][$key]['i']);

        if ($this->campaign->boosted()) {
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

            if (! empty($singular)) {
                $settings['modules'][$key]['s'] = $singular;
            }
            if (! empty($plural)) {
                $settings['modules'][$key]['p'] = $plural;
            }
            if (! empty($icon)) {
                $settings['modules'][$key]['i'] = $icon;
            }
        }

        // Bookmarks can't have default images.
        if (($request->hasFile('default_entity_image') || $request->filled('remove-image')) && ! $this->entityType->isBookmark()) {

            $this->defaultImageService->campaign($this->campaign)
                ->user($this->user)
                ->entityType($this->entityType)
                ->destroy();

            if ($request->hasFile('default_entity_image')) {
                $this->defaultImageService->save($request);
            }
        }

        $this->campaign->settings = $settings;
        $this->campaign->updateQuietly();

        $this->campaign->setting->{$this->entityType->pluralCode()} = (int) $request->get('enabled');
        $this->campaign->setting->save();

        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');

        return $this;
    }

    /**
     * Remove the custom modules setup from the campaign
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
        CampaignCache::campaign($this->campaign)->clear();
        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');

        $this->user->campaignLog($this->campaign->id, 'modules', 'reset');

        return $this;
    }

    public function toggle(): bool
    {
        // Validate module
        $fillable = $this->campaign->setting->getFillable();
        if (! in_array($this->entityType->pluralCode(), $fillable)) {
            throw new Exception;
        }

        $this->campaign->setting->{$this->entityType->pluralCode()} = ! $this->campaign->setting->{$this->entityType->pluralCode()};
        $this->campaign->setting->saveQuietly();
        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');
        EntityTypeToggled::dispatch($this->entityType, $this->user, $this->campaign);

        return (bool) $this->campaign->setting->{$this->entityType->pluralCode()};
    }

    public function toggleFeature(string $module): bool
    {
        // Validate module
        $fillable = $this->campaign->setting->getFillable();
        if (empty($module) || ! in_array($module, $fillable)) {
            throw new Exception;
        }

        $this->campaign->setting->{$module} = ! $this->campaign->setting->{$module};
        $this->campaign->setting->saveQuietly();
        CampaignCache::campaign($this->campaign)->clear();
        Cache::forget('campaign_' . $this->campaign->id . '_sidebar');

        return (bool) $this->campaign->setting->{$module};
    }
}
