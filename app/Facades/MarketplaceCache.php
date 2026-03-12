<?php

namespace App\Facades;

use App\Services\Caches\MarketplaceCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class MarketplaceCache
 *
 * @see MarketplaceCacheService
 *
 * @mixin MarketplaceCacheService
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
