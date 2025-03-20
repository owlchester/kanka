<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class EntityLogger
 *
 * @see \App\Services\Entity\LoggerService
 *
 * @mixin \App\Services\Entity\LoggerService
 */
class EntityLogger extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entitylogger';
    }
}
