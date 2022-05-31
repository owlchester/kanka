<?php

namespace App\Facades;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\Caches\EntityCacheService;
use Illuminate\Support\Facades\Facade;

/**
 * Class EntitySetup
 * @package App\Facades
 *
 * @see \App\Services\Entity\SetupService
 * @mixin \App\Services\Entity\SetupService
 */
class EntitySetup extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entitysetup';
    }
}
