<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\LimitService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LimitServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LimitService::class, function () {
            $service = new LimitService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            if (auth()->check()) {
                $service->user(auth()->user());
            }

            return $service;
        });

        $this->app->alias(LimitService::class, 'limit');
    }
}
