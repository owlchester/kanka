<?php


namespace App\Providers;


use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\EntityCacheService;
use App\Services\Caches\PostCacheService;
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
        $this->app->singleton(EntityCacheService::class, function ($app) {
            return new EntityCacheService();
        });
        $this->app->singleton(CampaignCacheService::class, function ($app) {
            return new CampaignCacheService();
        });
        $this->app->singleton(UserCacheService::class, function ($app) {
            return new UserCacheService();
        });
        $this->app->singleton(PostCacheService::class, function ($app) {
            return new PostCacheService();
        });

        $this->app->alias(EntityCacheService::class, 'entitycache');
        $this->app->alias(CampaignCacheService::class, 'campaigncache');
        $this->app->alias(UserCacheService::class, 'usercache');
        $this->app->alias(PostCacheService::class, 'postcache');
    }
}
