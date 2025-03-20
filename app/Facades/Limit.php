<?php

namespace App\Facades;

use App\Services\LimitService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin LimitService
 */
class Limit extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'limit';
    }
}
