<?php

namespace App\Services\Caches;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class BaseCache
 */
abstract class BaseCache
{
    /**
     * Wrapper for the cache forget method
     */
    protected function forget(string $key): bool
    {
//        Log::info('Cache forget', [
//            'cache' => class_basename($this),
//            'key' => $key,
//        ]);
        return Cache::forget($key);
    }

    /**
     * Wrapper for the cache get method
     */
    protected function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Wrapper for the cache put method
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
     */
    protected function has(string $key): bool
    {
        return Cache::has($key) && ! app()->environment('testing');
    }
}
