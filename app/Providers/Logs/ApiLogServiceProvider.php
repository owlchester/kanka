<?php

namespace App\Providers\Logs;

use App\Facades\CampaignLocalization;
use App\Services\Logs\ApiLogService;
use Illuminate\Support\ServiceProvider;

class ApiLogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiLogService::class, function () {
            $service = new ApiLogService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });

        $this->app->alias(ApiLogService::class, 'api_log');
    }
}
