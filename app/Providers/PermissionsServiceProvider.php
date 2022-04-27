<?php

namespace App\Providers;

use App\Services\Permissions\EntityPermission;
use App\Services\Permissions\RolePermission;
use App\Services\Permissions\UserPermission;
use App\Services\Permissions\PermissionService;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
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
        /*
        App\Providers\EntityPermissionServiceProvider::class,
        App\Providers\UserPermissionServiceProvider::class,
        App\Providers\RolePermissionServiceProvider::class,
        */
        $this
            ->registerMain()
            ->registerUser()
            ->registerRole()
            ->registerEntity()
        ;
    }


    protected function registerMain(): self
    {
        $this->app->singleton(PermissionService::class, function () {
            return new PermissionService();
        });
        $this->app->alias(PermissionService::class, 'permissions');
        return $this;
    }

    protected function registerUser(): self
    {
        $this->app->singleton(UserPermission::class, function () {
            return new UserPermission();
        });
        $this->app->alias(UserPermission::class, 'userpermission');
        return $this;
    }

    protected function registerEntity(): self
    {
        $this->app->singleton(EntityPermission::class, function () {
            return new EntityPermission();
        });

        $this->app->alias(EntityPermission::class, 'entitypermission');
        return $this;
    }

    protected function registerRole(): self
    {
        $this->app->singleton(RolePermission::class, function () {
            return new RolePermission();
        });

        $this->app->alias(RolePermission::class, 'rolepermission');
        return $this;
    }
}
