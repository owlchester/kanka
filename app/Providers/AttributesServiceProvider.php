<?php


namespace App\Providers;


use App\Services\AttributeService;
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
        $this->app->singleton(AttributeService::class, function ($app) {
            return new AttributeService();
        });

        $this->app->alias(AttributeService::class, 'attributes');
    }
}
