<?php

namespace App\Facades;

use App\Services\Tracking\DatalayerService;
use Illuminate\Support\Facades\Facade;

/**
 * Class DataLayer
 *
 * @see DatalayerService
 *
 * @mixin DatalayerService
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
