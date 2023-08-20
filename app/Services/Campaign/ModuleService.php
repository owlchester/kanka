<?php

namespace App\Services\Campaign;

use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Exception;

class ModuleService
{
    use CampaignAware;

    protected array $cache = [];

    public function singular(string|int $key, ?string $fallback = null): string|null
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleName($id)) {
            return $this->campaign->moduleName($id);
        }
        return $fallback;
    }

    public function plural(string|int $key, ?string $fallback = null): string|null
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleName($id, true)) {
            return $this->campaign->moduleName($id, true);
        }
        return $fallback;
    }

    public function icon(string|int $key, ?string $fallback = null): string|null
    {
        $id = $this->id($key);
        if ($this->campaign->hasModuleIcon($id)) {
            return $this->campaign->moduleIcon($id);
        }
        return $fallback;
    }

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
}
