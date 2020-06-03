<?php

namespace App\Services\Caches;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\User;
use Illuminate\Support\Facades\Auth;
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

    /** @var User */
    protected $user;

    /**
     * EntityCacheService constructor.
     */
    public function __construct()
    {
        $this->campaign = CampaignLocalization::getCampaign();
        $this->user = Auth::check() ? Auth::user() : null;
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
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
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
     * Wrapper for the cache forever method. Don't actually store forever as data from inactive users doesn't
     * need to be kept somewhere.
     * @param string $key
     * @param $data
     * @param int $days
     * @return bool
     */
    protected function forever(string $key, $data, int $days = 7): bool
    {
        Log::info(class_basename($this), [
            'forever' => $key,
        ]);
        return Cache::put($key, $data, $days * 86400);
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
