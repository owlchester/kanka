<?php

namespace App\Facades;

use App\Services\Caches\TimelineElementCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class TimelineElementCache
 *
 * @see TimelineElementCacheService
 *
 * @mixin TimelineElementCacheService
 */
class TimelineElementCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'timelineelementcache';
    }
}
