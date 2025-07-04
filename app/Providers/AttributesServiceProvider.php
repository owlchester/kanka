<?php

namespace App\Providers;

use App\Services\AttributeMentionService;
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
        $this->app->singleton(AttributeMentionService::class, function () {
            return new AttributeMentionService;
        });

        $this->app->alias(AttributeMentionService::class, 'attributes');
    }
}
