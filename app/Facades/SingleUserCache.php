<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class UserCache
 * @package App\Facades
 *
 * @see \App\Services\Caches\SingleUserCacheService
 * @mixin \App\Services\Caches\SingleUserCacheService
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
