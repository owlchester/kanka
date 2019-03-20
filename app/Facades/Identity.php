<?php

namespace App\Facades;

use App\Services\IdentityManager;
use Illuminate\Support\Facades\Facade;

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
