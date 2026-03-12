<?php

namespace App\Facades;

use App\Services\Campaign\ModuleService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Module
 *
 * @see ModuleService
 *
 * @mixin ModuleService
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
