<?php

namespace App\Providers;

use App\Services\EntityPermission;
use Illuminate\Support\ServiceProvider;

class EntityPermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules.handler', 'modules'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EntityPermission::class, function () {
            return new EntityPermission();
        });

        $this->app->alias(EntityPermission::class, 'entitypermission');
    }
}
