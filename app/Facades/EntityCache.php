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
 * @method static array typeSuggestion(MiscModel $model)
 * @method static self|EntityCacheService clearSuggestion(MiscModel $model)
 * @method static Entity|null entity(int $id)
 * @method static bool clearEntity(int $id)
 * @method static \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne child(Entity $entity))
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
