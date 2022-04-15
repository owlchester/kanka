<?php

namespace App\Facades;

use App\Services\Caches\AdCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class AdCache
 * @package App\Facades
 *
 * @see AdCacheService
 * @mixin AdCacheService
 */
class AdCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'adcache';
    }
}
