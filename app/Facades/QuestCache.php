<?php

namespace App\Facades;

use App\Services\Caches\QuestCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class QuestCache
 *
 * @see QuestCacheService
 *
 * @mixin QuestCacheService
 */
class QuestCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'questcache';
    }
}
