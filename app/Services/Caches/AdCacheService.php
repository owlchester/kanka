<?php

namespace App\Services\Caches;

use App\Models\Ad;
use Illuminate\Support\Facades\Cache;

class AdCacheService
{
    /** @var Ad|bool|null */
    protected $ad;

    protected bool $ads = true;

    protected ?int $currentId;

    public function adless(): self
    {
        $this->ads = false;
        return $this;
    }

    public function canHaveAds(): bool
    {
        return $this->ads;
    }

    public function get(): Ad|null
    {
        return $this->ad;
    }

    public function newId(bool $reset = false): self
    {
        if (!$reset && isset($this->currentId)) {
            $this->currentId++;
        } else {
            $this->currentId = 1;
        }
        return $this;
    }

    public function id(string $key): string
    {
        if ($this->currentId === 1) {
            return $key;
        }
        return $key . '_' . $this->currentId;
    }

    public function test(int $section, int $id): bool
    {
        $this->ad = Ad::select(['id', 'html'])->section($section)->where('id', $id)->first();
        return !empty($this->ad);
    }

    public function show(): string
    {
        return (string) $this->ad->html;
    }

    /**
     * Check if there is an ad to be displayed
     */
    public function has(int $section): bool
    {
        $this->load($section);
        return (bool) (!empty($this->ad));
    }

    /**
     * Load the ad in memory
     */
    protected function load(int $section): self
    {
        if (!config('app.admin')) {
            return $this;
        }
        $key = $this->cacheKey($section);
        if (cache()->has($key)) {
            $this->ad = cache()->get($key);
            return $this;
        }
        $this->ad = Ad::select(['id', 'html'])->section($section)->where('is_active', true)->first();
        // Save a "false" model in the db to avoid re-calling the db each time
        if (empty($this->ad)) {
            $this->ad = false;
        }
        cache()->put($key, $this->ad, 86400);

        return $this;
    }

    /**
     * Ad cache key for section
     */
    protected function cacheKey(int $section): string
    {
        return 'ad_section_' . $section;
    }
}
