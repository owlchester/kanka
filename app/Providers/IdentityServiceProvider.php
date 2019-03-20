<?php

namespace App\Providers;

use App\Services\IdentityManager;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class IdentityServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IdentityManager::class, function ($app) {
            return new IdentityManager($app);
        });

        $this->app->alias(IdentityManager::class, 'identity');
    }
}
