<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class BookmarkCache
 * @package App\Facades
 *
 * @see \App\Services\Caches\BookmarkCacheService
 * @mixin \App\Services\Caches\BookmarkCacheService
 */
class BookmarkCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bookmarkcache';
    }
}
