<?php

namespace App\Providers;

use App\Services\Campaign\LocalisationService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CampaignLocalizationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LocalisationService::class, function ($app) {
            $service = new LocalisationService;
            $service->request($app->make(Request::class));

            return $service;
        });

        $this->app->alias(LocalisationService::class, 'campaignlocalization');
    }
}
