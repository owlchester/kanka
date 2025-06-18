<?php

namespace App\Providers;

use App\Services\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DomainService::class, function ($app) {
            $service = new DomainService;
            $service->request($app->make(Request::class));

            return $service;
        });

        $this->app->alias(DomainService::class, 'domain');
    }
}
