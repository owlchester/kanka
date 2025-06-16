<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\DashboardService;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DashboardService::class, function () {
            return new DashboardService;
        });

        $this->app->alias(DashboardService::class, 'dashboard');
    }
}
