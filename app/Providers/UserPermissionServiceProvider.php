<?php

namespace App\Providers;

use App\Services\UserPermission;
use Illuminate\Support\ServiceProvider;

class UserPermissionServiceProvider extends ServiceProvider
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
        $this->app->singleton(UserPermission::class, function () {
            return new UserPermission();
        });

        $this->app->alias(UserPermission::class, 'userpermission');
    }
}
