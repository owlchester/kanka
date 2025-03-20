<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\AttributeMentionService;
use Illuminate\Support\ServiceProvider;

class AttributesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AttributeMentionService::class, function () {
            $service = new AttributeMentionService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });

        $this->app->alias(AttributeMentionService::class, 'attributes');
    }
}
