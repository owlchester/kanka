<?php

namespace App\Providers;

use App\Services\Entity\SetupService;
use Illuminate\Support\ServiceProvider;

class EntitySetupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SetupService::class, function ($app) {
            return new SetupService();
        });
        $this->app->alias(SetupService::class, 'entitysetup');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
