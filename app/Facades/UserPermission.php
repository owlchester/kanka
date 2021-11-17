<?php

namespace App\Facades;

use App\Models\Entity;
use App\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class UserPermission
 * Used for the Entity object
 * @package App\Facades
 *
 * @see \App\Services\UserPermission
 * @mixin \App\Services\UserPermission
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
