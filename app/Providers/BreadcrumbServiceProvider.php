<?php


namespace App\Providers;


use App\Services\BreadcrumbService;
use App\Services\MentionsService;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BreadcrumbService::class, function ($app) {
            return new BreadcrumbService();
        });

        $this->app->alias(BreadcrumbService::class, 'breadcrumb');
    }
}
