<?php


namespace App\Providers;


use App\Services\ImgService;
use Illuminate\Support\ServiceProvider;

class ImgServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImgService::class, function ($app) {
            return new ImgService();
        });

        $this->app->alias(ImgService::class, 'img');
    }
}
