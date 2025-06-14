<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Images\AvatarService;
use Illuminate\Support\ServiceProvider;

class AvatarServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AvatarService::class, function () {
            $service = new AvatarService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            if (auth()->check()) {
                $service->user(auth()->user());
            }

            return $service;
        });

        $this->app->alias(AvatarService::class, 'avatar');
    }
}
