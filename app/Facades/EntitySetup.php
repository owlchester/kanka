<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class EntitySetup
 *
 * @see \App\Services\Entity\SetupService
 *
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
