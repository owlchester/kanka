<?php

namespace App\Services\Caches;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class BaseCache
 * @package App\Services\Caches
 */
abstract class BaseCache
{
    /** @var Campaign */
    protected $campaign;

    /**
     * EntityCacheService constructor.
     */
    public function __construct()
    {
        $this->campaign = CampaignLocalization::getCampaign();
    }

    /**
     * Set the campaign
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * Wrapper for the cache forget method
     * @param string $key
     * @return bool
     */
    protected function forget(string $key): bool
    {
        Log::info(class_basename($this), [
            'forget' => $key,
        ]);
        return Cache::forget($key);
    }

    /**
     * Wrapper for the cache get method
     * @param string $key
     * @return mixed
     */
    protected function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Wrapper for the cache put method
     * @param string $key
     * @param $data
     * @param int $ttl
     * @return bool
     */
    protected function put(string $key, $data, int $ttl): bool
    {
        Log::info(class_basename($this), [
            'put' => $key,
        ]);
        return Cache::put($key, $data, $ttl);
    }

    /**
     * Wrapper for the cache has metho
     * @param string $key
     * @return bool
     */
    protected function has(string $key): bool
    {
        return Cache::has($key);
    }
}
