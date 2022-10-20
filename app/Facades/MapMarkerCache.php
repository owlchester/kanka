<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MapMarkerCache
 * @package App\Facades
 *
 * @see \App\Services\Caches\MapMarkerCacheService
 * @mixin \App\Services\Caches\MapMarkerCacheService
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
