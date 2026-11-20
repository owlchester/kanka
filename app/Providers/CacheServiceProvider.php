<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Caches\AdCacheService;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\ReleaseCacheService;
use App\Services\Caches\SingleUserCacheService;
use App\Services\Caches\UserCacheService;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CampaignCacheService::class, function () {
            $service = new CampaignCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(UserCacheService::class, function () {
            $service = new UserCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }
            if (auth()->check()) {
                $service->user(auth()->user());
            }

            return $service;
        });
        $this->app->singleton(SingleUserCacheService::class, function () {
            return new SingleUserCacheService;
        });
        $this->app->singleton(ReleaseCacheService::class, function () {
            return new ReleaseCacheService;
        });

        $this->app->alias(CampaignCacheService::class, 'campaigncache');
        $this->app->alias(UserCacheService::class, 'usercache');
        $this->app->alias(SingleUserCacheService::class, 'singleusercache');
        $this->app->alias(ReleaseCacheService::class, 'releasecache');
        $this->app->alias(AdCacheService::class, 'adcache');
    }
}
