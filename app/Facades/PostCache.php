<?php

namespace App\Facades;

use App\Models\AppRelease;
use App\Services\Caches\PostCacheService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class PostCache
 * @package App\Facades
 *
 * @see PostCacheService
 * @mixin PostCacheService
 */
class PostCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'postcache';
    }
}
