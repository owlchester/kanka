<?php

namespace App\Services\Campaign;

use App\Traits\CampaignAware;
use Exception;
use Illuminate\Support\Str;

/**
 * Easily get access to a campaign's modules custom name and icon
 */
class ModuleService
{
    use CampaignAware;

    protected array $cache = [];

    protected bool $fallback = false;

    public function fallback(): self
    {
        $this->fallback = true;

        return $this;
    }

    public function singular(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleName($id)) {
            return $this->campaign->moduleName($id);
        }

        return $fallback;
    }

    public function plural(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleName($id, true)) {
            return $this->campaign->moduleName($id, true);
        }
        if (empty($fallback) && $this->fallback) {
            return $this->pluralFallback($id);
        }

        return $fallback;
    }

    public function icon(string|int $key, ?string $fallback = null): ?string
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleIcon($id)) {
            return $this->campaign->moduleIcon($id);
        }

        return $fallback;
    }

    public function duoIcon(string $entityType): string
    {
        $id = $this->id($entityType);
        if ($this->campaign->hasModuleIcon($id)) {
            return $this->campaign->moduleIcon($id);
        }
        $fallback = config('entities.icons.' . $entityType);
        if (config('fontawesome.kit')) {
            return $fallback;
        }

        return Str::replace('duotone', 'solid', $fallback);
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
