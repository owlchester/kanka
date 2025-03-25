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
            $service = new DashboardService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });

        $this->app->alias(DashboardService::class, 'dashboard');
    }
}
