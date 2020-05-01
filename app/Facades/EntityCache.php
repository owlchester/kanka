<?php

namespace App\Facades;

use App\Models\Campaign;
use App\Models\MiscModel;
use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class CampaignLocalization
 * @package App\Facades
 *
 * @method static array typeSuggestion(MiscModel $model)
 * @method static self|EntityCacheService clearSuggestion(MiscModel $model)
 *
 * @see \App\Services\Caches\EntityCacheService
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
