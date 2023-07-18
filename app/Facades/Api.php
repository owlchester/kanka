<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Api
 * @package App\Facades
 *
 * @mixin \App\Services\Api\ApiHelperService
 */
class Api extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api';
    }
}
