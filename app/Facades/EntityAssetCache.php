<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class EntityAssetCache
 *
 * @see \App\Services\Caches\EntityAssetCacheService
 *
 * @mixin \App\Services\Caches\EntityAssetCacheService
 */
class EntityAssetCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entityassetcache';
    }
}
