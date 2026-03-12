<?php

namespace App\Facades;

use App\Services\Caches\MapMarkerCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class MapMarkerCache
 *
 * @see MapMarkerCacheService
 *
 * @mixin MapMarkerCacheService
 */
class MapMarkerCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mapmarkercache';
    }
}
