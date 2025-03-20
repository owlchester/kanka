<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MarketplaceCache
 *
 * @see \App\Services\Caches\MarketplaceCacheService
 *
 * @mixin \App\Services\Caches\MarketplaceCacheService
 */
class MarketplaceCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'marketplacecache';
    }
}
