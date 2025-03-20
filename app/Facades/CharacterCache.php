<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CharacterCache
 *
 * @see \App\Services\Caches\CharacterCacheService
 *
 * @mixin \App\Services\Caches\CharacterCacheService
 */
class CharacterCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'charactercache';
    }
}
