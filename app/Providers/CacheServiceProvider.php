<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Services\Caches\AdCacheService;
use App\Services\Caches\BookmarkCacheService;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\CharacterCacheService;
use App\Services\Caches\EntityAssetCacheService;
use App\Services\Caches\EntityCacheService;
use App\Services\Caches\FrontCacheService;
use App\Services\Caches\MapMarkerCacheService;
use App\Services\Caches\MarketplaceCacheService;
use App\Services\Caches\PostCacheService;
use App\Services\Caches\QuestCacheService;
use App\Services\Caches\SingleUserCacheService;
use App\Services\Caches\TimelineElementCacheService;
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
        $this->app->singleton(EntityCacheService::class, function () {
            $service = new EntityCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
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
        $this->app->singleton(PostCacheService::class, function () {
            return new PostCacheService;
        });
        $this->app->singleton(CharacterCacheService::class, function () {
            $service = new CharacterCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(QuestCacheService::class, function () {
            $service = new QuestCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(MapMarkerCacheService::class, function () {
            $service = new MapMarkerCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(EntityAssetCacheService::class, function () {
            $service = new EntityAssetCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(BookmarkCacheService::class, function () {
            $service = new BookmarkCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(TimelineElementCacheService::class, function () {
            $service = new TimelineElementCacheService;
            if (CampaignLocalization::hasCampaign()) {
                $service->campaign(CampaignLocalization::getCampaign());
            }

            return $service;
        });
        $this->app->singleton(MarketplaceCacheService::class, function () {
            return new MarketplaceCacheService;
        });

        $this->app->alias(EntityCacheService::class, 'entitycache');
        $this->app->alias(CampaignCacheService::class, 'campaigncache');
        $this->app->alias(UserCacheService::class, 'usercache');
        $this->app->alias(SingleUserCacheService::class, 'singleusercache');
        $this->app->alias(PostCacheService::class, 'postcache');
        $this->app->alias(CharacterCacheService::class, 'charactercache');
        $this->app->alias(QuestCacheService::class, 'questcache');
        $this->app->alias(FrontCacheService::class, 'frontcache');
        $this->app->alias(AdCacheService::class, 'adcache');
        $this->app->alias(MapMarkerCacheService::class, 'mapmarkercache');
        $this->app->alias(EntityAssetCacheService::class, 'entityassetcache');
        $this->app->alias(BookmarkCacheService::class, 'bookmarkcache');
        $this->app->alias(TimelineElementCacheService::class, 'timelineelementcache');
        $this->app->alias(MarketplaceCacheService::class, 'marketplacecache');
    }
}
