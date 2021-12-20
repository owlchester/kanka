<?php

namespace App\Facades;

use App\Models\Campaign;
use App\Models\MiscModel;
use App\Models\Entity;
use App\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class EntityPermission
 * @package App\Facadesf
 *
 * @see \App\Services\EntityPermission
 * @mixin \App\Services\EntityPermission
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
