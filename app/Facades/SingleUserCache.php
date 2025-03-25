<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class UserCache
 *
 * @see \App\Services\Caches\UserCacheService
 *
 * @mixin \App\Services\Caches\UserCacheService
 */
class SingleUserCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'singleusercache';
    }
}
