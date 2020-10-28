<?php


namespace App\Providers;


use App\Services\DashboardService;
use App\Services\MentionsService;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DashboardService::class, function ($app) {
            return new DashboardService();
        });

        $this->app->alias(DashboardService::class, 'dashboard');
    }
}
