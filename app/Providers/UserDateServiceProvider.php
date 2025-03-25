<?php

namespace App\Providers;

use App\Services\Users\DateService;
use Illuminate\Support\ServiceProvider;

class UserDateServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DateService::class, function () {
            return new DateService;
        });

        $this->app->alias(DateService::class, 'userdate');
    }
}
