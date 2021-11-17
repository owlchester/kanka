<?php

namespace App\Facades;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @see \App\Services\Caches\EntityCacheService
 * @mixin \App\Services\Caches\EntityCacheService
 */
class EntityCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entitycache';
    }
}
