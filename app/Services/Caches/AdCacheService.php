<?php

namespace App\Services\Caches;

use App\Models\Ad;

class AdCacheService
{
    /** @var Ad|null */
    protected $ad;

    /**
     * @return Ad|null
     */
    public function get()
    {
        return $this->ad;
    }

    public function test(int $section, int $id)
    {
        $this->ad = Ad::select(['id', 'html'])->section($section)->where('id', $id)->first();
        return !empty($this->ad);
    }

    /**
     * @return string
     */
    public function show(): string
    {
        return (string) $this->ad->html;
    }

    /**
     * Check if there is an ad to be displayed
     * @param string $section
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function has(int $section): bool
    {
        $this->load($section);
        if (!empty($this->ad)) {
            return true;
        }
        return false;
    }

    public function clear(int $section)
    {
        $key = $this->cacheKey($section);
        cache()->forget($key);
    }

    /**
     * Load the ad in memory
     * @param int $section
     * @return $this
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function load(int $section): self
    {
        $key = $this->cacheKey($section);
        if (cache()->has($key)) {
            $this->ad = cache()->get($key);
            return $this;
        }
        $this->ad = Ad::select(['id', 'html'])->section($section)->where('is_active', true)->first();
        cache()->forever($key, $this->ad);
        return $this;
    }

    /**
     * Ad cache key for section
     * @param string $section
     * @return string
     */
    protected function cacheKey(int $section): string
    {
        return 'ad_section_' . $section;
    }
}
