<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class QuestCache
 *
 * @see \App\Services\Caches\QuestCacheService
 *
 * @mixin \App\Services\Caches\QuestCacheService
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
