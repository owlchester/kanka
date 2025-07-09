<?php

namespace App\Facades;

use App\Services\Caches\ReleaseCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * @see ReleaseCacheService
 *
 * @mixin ReleaseCacheService
 */
class ReleaseCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'releasecache';
    }
}
