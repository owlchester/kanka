<?php

namespace App\Facades;

use App\Models\Entity;
use Illuminate\Support\Facades\Facade;

/**
 * Class UserPermission
 * Used for the Entity object
 *
 * @see \App\Services\Permissions\UserPermission
 */
class UserPermission extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'userpermission';
    }
}
