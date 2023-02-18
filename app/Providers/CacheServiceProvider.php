<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Caches\AdCacheService;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\CharacterCacheService;
use App\Services\Caches\MarketplaceCacheService;
use App\Services\Caches\QuestCacheService;
use App\Services\Caches\MapMarkerCacheService;
use App\Services\Caches\TimelineElementCacheService;
use App\Services\Caches\EntityCacheService;
use App\Services\Caches\FrontCacheService;
use App\Services\Caches\PostCacheService;
use App\Services\Caches\UserCacheService;
use App\Services\Caches\UserCampaignCacheService;
use App\Services\Caches\SingleUserCacheService;
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
        $this->app->singleton(EntityCacheService::class, function () {
            return new EntityCacheService();
        });
        $this->app->singleton(CampaignCacheService::class, function () {
            return new CampaignCacheService();
        });
        $this->app->singleton(UserCacheService::class, function () {
            return new UserCacheService();
        });
        /*$this->app->singleton(UserCampaignCacheService::class, function () {
            return new UserCampaignCacheService();
        });*/
        $this->app->singleton(SingleUserCacheService::class, function () {
            $service = new SingleUserCacheService();
            if (auth()->check()) {
                $service->user(auth()->user());
            }
            return $service;
        });
        $this->app->singleton(PostCacheService::class, function () {
            return new PostCacheService();
        });
        $this->app->singleton(CharacterCacheService::class, function () {
            return new CharacterCacheService();
        });
        $this->app->singleton(QuestCacheService::class, function () {
            return new QuestCacheService();
        });
        $this->app->singleton(MapMarkerCacheService::class, function () {
            return new MapMarkerCacheService();
        });
        $this->app->singleton(TimelineElementCacheService::class, function () {
            return new TimelineElementCacheService();
        });
        $this->app->singleton(MarketplaceCacheService::class, function () {
            return new MarketplaceCacheService();
        });

        $this->app->alias(EntityCacheService::class, 'entitycache');
        $this->app->alias(CampaignCacheService::class, 'campaigncache');
        $this->app->alias(UserCacheService::class, 'usercache');
        //$this->app->alias(UserCampaignCacheService::class, 'usercampaigncache');
        $this->app->alias(SingleUserCacheService::class, 'singleusercache');
        $this->app->alias(PostCacheService::class, 'postcache');
        $this->app->alias(CharacterCacheService::class, 'charactercache');
        $this->app->alias(QuestCacheService::class, 'questcache');
        $this->app->alias(FrontCacheService::class, 'frontcache');
        $this->app->alias(AdCacheService::class, 'adcache');
        $this->app->alias(MapMarkerCacheService::class, 'mapmarkercache');
        $this->app->alias(TimelineElementCacheService::class, 'timelineelementcache');
        $this->app->alias(MarketplaceCacheService::class, 'marketplacecache');
    }
}
