<?php

namespace App\Facades;

use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class EntityCache
 *
 * @see EntityCacheService
 *
 * @mixin EntityCacheService
 */
class EntityCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entitycache';
    }
}
