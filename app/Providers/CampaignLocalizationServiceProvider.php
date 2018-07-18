<?php

namespace App\Providers;

use App\Services\CampaignLocalization;
use Illuminate\Support\ServiceProvider;

class CampaignLocalizationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules.handler', 'modules'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CampaignLocalization::class, function () {
            return new CampaignLocalization();
        });

        $this->app->alias(CampaignLocalization::class, 'campaignlocalization');
    }
}
