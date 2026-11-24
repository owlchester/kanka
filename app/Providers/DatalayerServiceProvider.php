<?php

namespace App\Providers;

use App\Services\Tracking\DatalayerService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

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
