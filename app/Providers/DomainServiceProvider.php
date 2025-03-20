<?php

namespace App\Providers;

use App\Services\DomainService;
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
        $this->app->singleton(DomainService::class, function () {
            return new DomainService;
        });

        $this->app->alias(DomainService::class, 'domain');
    }
}
