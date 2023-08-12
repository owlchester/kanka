<?php

namespace App\Facades;

use App\Providers\LimitServiceProvider;
use App\Services\DomainService;
use App\Services\LimitService;
use Illuminate\Support\Facades\Facade;

/**
 * @package App\Facades
 *
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
