<?php

namespace App\Providers;

use App\Services\Permissions\EntityPermission;
use App\Services\Permissions\PermissionService;
use App\Services\Permissions\RolePermission;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $this->app->scoped(PermissionService::class);
        $this->app->alias(PermissionService::class, 'permissions');

        $this->app->scoped(EntityPermission::class);
        $this->app->scoped(RolePermission::class);
    }
}
