<?php

namespace App\Services\Campaign;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\EntityType;
use Exception;
use Illuminate\Support\Str;

/**
 * Easily get access to a campaign's modules custom name and icon
 */
class ModuleService
{
    private ?Campaign $explicitCampaign = null;

    protected array $cache = [];

    protected bool $fallback = false;

    public function campaign(Campaign $campaign): self
    {
        $scoped = clone $this;
        $scoped->explicitCampaign = $campaign;

        return $scoped;
    }

    public function fallback(): self
    {
        $scoped = clone $this;
        $scoped->fallback = true;

        return $scoped;
    }

    protected function activeCampaign(): Campaign
    {
        return $this->explicitCampaign ?? CampaignLocalization::getCampaign();
    }

    public function singular(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        $campaign = $this->activeCampaign();
        if ($campaign->hasModuleName($id)) {
            return $campaign->moduleName($id);
        }

        return $fallback;
    }

    public function plural(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        $campaign = $this->activeCampaign();
        if ($campaign->hasModuleName($id, true)) {
            return $campaign->moduleName($id, true);
        }
        if (empty($fallback) && $this->fallback) {
            return $this->pluralFallback($id);
        }

        if (is_array(__($fallback))) {
            return $this->pluralFallback($id);
        }

        return __($fallback);
    }

    public function icon(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        $campaign = $this->activeCampaign();
        if ($campaign->hasModuleIcon($id)) {
            return $campaign->moduleIcon($id);
        }

        return $fallback;
    }

    public function duoIcon(EntityType $entityType): string
    {
        $campaign = $this->activeCampaign();
        if ($campaign->hasModuleIcon($entityType->id)) {
            return $campaign->moduleIcon($entityType->id);
        }

        return $this->defaultIcon($entityType);
    }

    public function defaultIcon(EntityType $entityType): string
    {
        if (config('fontawesome.kit')) {
            return 'fa-duotone ' . $entityType->icon;
        }

        return 'fa-regular ' . $entityType->icon;
    }

    /**
     * From a string or id, figure out the entity type number
     */
    protected function id(mixed $key): int
    {
        // Ints are easy and what we hope for
        if (is_int($key)) {
            return $key;
        }

        // Already cached in this page execution? Easy!
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        // If it's a plural, and this is a bit bonkers, but we want to figure out the singular
        if (Str::endsWith($key, 's')) {
            $key = Str::singular($key);
        }

        $id = config('entities.ids.' . $key);
        if (empty($id)) {
            throw new Exception('Invalid entity type id key ' . $key);
        }

        return $this->cache[$key] = (int) $id;
    }

    protected function pluralFallback(int $key)
    {
        $flipped = array_flip(config('entities.ids'));

        return __('entities.' . Str::plural($flipped[$key]));
    }
}
