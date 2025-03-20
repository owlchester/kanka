<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\ImagesService;
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
        $this->app->singleton(ImgService::class, function () {
            return new ImgService;
        });
        $this->app->singleton(ImagesService::class, function () {
            $service = new ImagesService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });

        $this->app->alias(ImgService::class, 'img');
        $this->app->alias(ImagesService::class, 'images');
    }
}
