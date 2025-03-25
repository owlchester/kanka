<?php

namespace App\Facades;

use App\Services\Caches\UserCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class UserCache
 *
 * @see UserCacheService
 *
 * @mixin UserCacheService
 */
class UserCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'usercache';
    }
}
