<?php

namespace App\Providers\Logs;

use App\Services\Logs\UserLoggerService;
use Illuminate\Support\ServiceProvider;

class UserLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserLoggerService::class, fn () => new UserLoggerService);
        $this->app->alias(UserLoggerService::class, 'user_logger');
    }
}
