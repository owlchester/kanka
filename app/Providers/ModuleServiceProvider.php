<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Campaign\ModuleService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModuleService::class, function ($app) {
            $campaign = CampaignLocalization::getCampaign();
            return (new ModuleService())->campaign($campaign);
        });
        $this->app->alias(ModuleService::class, 'module');
    }
}
