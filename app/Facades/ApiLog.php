<?php

namespace App\Facades;

use App\Services\Logs\ApiLogService;
use Illuminate\Support\Facades\Facade;

/**
 * Class ApiLog
 *
 * @see ApiLogService
 *
 * @mixin ApiLogService
 */
class ApiLog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api_log';
    }
}
