<?php

namespace App\Facades;

use App\Services\Caches\EntityAssetCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class EntityAssetCache
 *
 * @see EntityAssetCacheService
 *
 * @mixin EntityAssetCacheService
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
