<?php

namespace App\Facades;

use App\Services\Entity\LoggerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class EntityLogger
 *
 * @see LoggerService
 *
 * @mixin LoggerService
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
