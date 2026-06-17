<?php

namespace App\Facades;

use App\Services\Logs\UserLoggerService;
use Illuminate\Support\Facades\Facade;

/**
 * @see UserLoggerService
 *
 * @mixin UserLoggerService
 */
class UserLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user_logger';
    }
}
