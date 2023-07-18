<?php

namespace App\Providers\Logs;

use App\Services\Logs\ApiLogService;
use App\Services\Api\ApiHelperService;
use Illuminate\Support\ServiceProvider;

class ApiLogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\Logs\ApiLogService::class, function ($app) {
            return new ApiLogService();
        });
        $this->app->singleton(\App\Services\Api\ApiHelperService::class, function ($app) {
            return new ApiHelperService();
        });

        $this->app->alias(ApiLogService::class, 'api_log');
        $this->app->alias(ApiHelperService::class, 'api');
    }

}
