<?php

namespace App\Providers;

use App\Services\RolePermission;
use Illuminate\Support\ServiceProvider;

class RolePermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RolePermission::class, function () {
            return new RolePermission();
        });

        $this->app->alias(RolePermission::class, 'rolepermission');
    }
}
