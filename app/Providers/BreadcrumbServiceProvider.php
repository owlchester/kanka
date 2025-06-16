<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\BreadcrumbService;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BreadcrumbService::class, function () {
            return new BreadcrumbService;
        });

        $this->app->alias(BreadcrumbService::class, 'breadcrumb');
    }
}
