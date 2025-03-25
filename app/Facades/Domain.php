<?php

namespace App\Facades;

use App\Services\DomainService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin DomainService
 */
class Domain extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'domain';
    }
}
