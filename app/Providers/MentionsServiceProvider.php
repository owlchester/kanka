<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\MentionsService;
use Illuminate\Support\ServiceProvider;

class MentionsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MentionsService::class, function () {
            $service = new MentionsService();
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            return $service;
        });

        $this->app->alias(MentionsService::class, 'mentions');
    }
}
