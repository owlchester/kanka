<?php

namespace App\Providers;

use App\Services\Tracking\DatalayerService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DatalayerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DatalayerService::class, function () {
            $service = new DatalayerService;
            if (auth()->check()) {
                $service->user(auth()->user());
            }

            return $service;
        });
        $this->app->alias(DatalayerService::class, 'datalayer');
    }
}
