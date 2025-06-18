<?php

namespace App\Providers;

use App\Services\Tracking\DatalayerService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class DatalayerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DatalayerService::class, function ($app) {
            $service = new DatalayerService;
            $service->request($app->make(Request::class));

            return $service;
        });
        $this->app->alias(DatalayerService::class, 'datalayer');
    }
}
