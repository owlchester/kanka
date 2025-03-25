<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Submenus\SubmenuService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class SubmenuServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SubmenuService::class, function () {
            $service = new SubmenuService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->alias(SubmenuService::class, 'submenu');
    }
}
