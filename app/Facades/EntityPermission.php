<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class EntityPermission
 *
 * @see \App\Services\Permissions\EntityPermission
 *
 * @mixin \App\Services\Permissions\EntityPermission
 */
class EntityPermission extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entitypermission';
    }
}
