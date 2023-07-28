<?php

namespace App\Providers;

use App\Services\UserDateService;
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
        $this->app->singleton(UserDateService::class, function () {
            return new UserDateService();
        });

        $this->app->alias(UserDateService::class, 'userdate');
    }
}
