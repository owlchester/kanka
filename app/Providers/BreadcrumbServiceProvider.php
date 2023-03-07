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
        $this->app->singleton(BreadcrumbService::class, function ($app) {
            $service = new BreadcrumbService();
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            } else {
                dd('Error B01: Breadcrumbs outside of a campaign');
            }
            return $service;
        });

        $this->app->alias(BreadcrumbService::class, 'breadcrumb');
    }
}
