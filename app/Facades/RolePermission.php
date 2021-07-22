<?php

namespace App\Facades;

use App\Models\CampaignRole;
use Illuminate\Support\Facades\Facade;

/**
 * Class RolePermission
 * Used for the Entity object
 * @package App\Facades
 *
 * @method self|static role(CampaignRole $role = null)
 * @method array permissions()
 *
 * @see \App\Services\RolePermission
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
