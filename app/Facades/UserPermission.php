<?php

namespace App\Facades;

use App\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class UserPermission
 * @package App\Facades
 *
 * @method static user(User $user = null)
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
