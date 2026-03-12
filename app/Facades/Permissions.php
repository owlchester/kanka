<?php

namespace App\Facades;

use App\Services\Permissions\PermissionService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Permissions
 * Used for the Entity object
 *
 * @see PermissionService
 *
 * @mixin PermissionService
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
