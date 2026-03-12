<?php

namespace App\Facades;

use App\Services\Caches\CampaignCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 *
 * @see CampaignCacheService
 *
 * @mixin CampaignCacheService
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
