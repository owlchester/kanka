<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RolePermission
 * Used for the Entity object
 *
 * @see \App\Services\Permissions\RolePermission
 *
 * @mixin \App\Services\Permissions\RolePermission
 */
class RolePermission extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rolepermission';
    }
}
