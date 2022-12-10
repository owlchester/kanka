<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class TimelineElementCache
 * @package App\Facades
 *
 * @see \App\Services\Caches\TimelineElementCacheService
 * @mixin \App\Services\Caches\TimelineElementCacheService
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
