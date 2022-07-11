<?php

namespace App\Facades;

use App\Services\IdentityManager;
use Illuminate\Support\Facades\Facade;

/**
 * Class Identity
 * @package App\Facades
 *
 * @see IdentityManager
 * @mixin IdentityManager
 */
class Identity extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return IdentityManager::class;
    }
}
