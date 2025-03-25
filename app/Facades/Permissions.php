<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Permissions
 * Used for the Entity object
 *
 * @see \App\Services\Permissions\PermissionService
 *
 * @mixin \App\Services\Permissions\PermissionService
 */
class Permissions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'permissions';
    }
}
