<?php

namespace App\Providers;

use App\Services\Entity\LoggerService;
use Illuminate\Support\ServiceProvider;

class EntitySetupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoggerService::class, function () {
            $s = new LoggerService;
            if (auth()->check()) {
                $s->user(auth()->user());
            }

            return $s;
        });
        $this->app->alias(LoggerService::class, 'entitylogger');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
