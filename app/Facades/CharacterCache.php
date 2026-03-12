<?php

namespace App\Facades;

use App\Services\Caches\CharacterCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class CharacterCache
 *
 * @see CharacterCacheService
 *
 * @mixin CharacterCacheService
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
