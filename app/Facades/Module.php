<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Module
 *
 * @see \App\Services\Campaign\ModuleService
 *
 * @mixin \App\Services\Campaign\ModuleService
 */
class Module extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'module';
    }
}
