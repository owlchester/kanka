<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Permissions\EntityPermission;
use App\Services\Permissions\RolePermission;
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
        App\Providers\RolePermissionServiceProvider::class,
        */
        $this
            ->registerMain()
            //->registerUser()
            ->registerRole()
            ->registerEntity()
        ;
    }

    /**
     * @return $this
     */
    protected function registerMain(): self
    {
        $this->app->singleton(PermissionService::class, function () {
            $service = new PermissionService();
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            return $service;
        });
        $this->app->alias(PermissionService::class, 'permissions');
        return $this;
    }

    /**
     * @return $this
     */
    protected function registerEntity(): self
    {
        $this->app->singleton(EntityPermission::class, function () {
            /** @var EntityPermission $service */
            $service = new EntityPermission();
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            return $service;
        });

        $this->app->alias(EntityPermission::class, 'entitypermission');
        return $this;
    }

    /**
     * @return $this
     */
    protected function registerRole(): self
    {
        $this->app->singleton(RolePermission::class, function () {
            return new RolePermission();
        });

        $this->app->alias(RolePermission::class, 'rolepermission');
        return $this;
    }
}
