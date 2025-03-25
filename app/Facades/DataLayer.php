<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class DataLayer
 *
 * @see \App\Services\Tracking\DatalayerService
 *
 * @mixin \App\Services\Tracking\DatalayerService
 */
class DataLayer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'datalayer';
    }
}
