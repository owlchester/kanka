<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 *
 * @see \App\Services\Caches\CampaignCacheService
 *
 * @mixin \App\Services\Caches\CampaignCacheService
 */
class CampaignCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'campaigncache';
    }
}
