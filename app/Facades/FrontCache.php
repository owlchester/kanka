<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 *
 * @see \App\Services\Caches\FrontCacheService
 *
 * @mixin \App\Services\Caches\FrontCacheService
 */
class FrontCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'frontcache';
    }
}
