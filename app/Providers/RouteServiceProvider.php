<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Facades\Domain;
use App\Http\Controllers\Api\v1\HealthController;
use App\Http\Middleware\LastCampaign;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Plugin;
use App\Models\Tier;
use App\Models\UserValidation;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        parent::boot();

        Route::model('plugin', Plugin::class);
        Route::model('tier', Tier::class);

        // This is important, ensures only campaigns the user has access get injected in the route model binding.
        Route::bind('campaign', function (string $value) {
            return Campaign::acl($value)->firstOrFail();
        });
        Route::model('entityType', EntityType::class);
        Route::model('userValidation', UserValidation::class);
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->api()
            ->web()
            ->campaign()
            ->settings()
            ->auth()
            ->webhooks()
            ->vendor();
    }

    /**
     * Define the general "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function web(): self
    {
        Route::middleware(['web', 'adless'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::middleware(['web', 'adless'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web-i18n.php'));

        return $this;
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function api(): self
    {
        $domain = Domain::isApi() ? Domain::api() : '';
        $prefix = Domain::isApi() ? null : 'api';
        $prefixName = Domain::isApi() ? null : 'api.';
        Route::domain($domain)
            ->prefix($prefix)
            ->namespace($this->namespace)
            ->get('/health', [HealthController::class, 'index']);

        Route::domain($domain)
            ->name($prefixName)
            ->prefix($prefix)
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        return $this;
    }

    /**
     * Define the "campaign" routes for everything in a campaign
     *
     * Todo: one day, move from campaignLocalization in the controllers, and move the campaign in route binding
     */
    protected function campaign(): self
    {
        $domain = Domain::isApi() ? Domain::app() : null;
        Route::domain($domain)
            ->middleware(['web', LastCampaign::class])
            ->namespace($this->namespace)
            ->group(base_path('routes/campaigns/campaign.php'));

        Route::domain($domain)
            ->middleware(['web', LastCampaign::class])
            ->namespace($this->namespace)
            ->group(base_path('routes/campaigns/entities.php'));

        Route::domain($domain)
            ->middleware(['web', LastCampaign::class])
            ->namespace($this->namespace)
            ->group(base_path('routes/campaigns/bulks.php'));

        Route::domain($domain)
            ->middleware(['web', LastCampaign::class])
            ->namespace($this->namespace)
            ->group(base_path('routes/campaigns/search.php'));

        return $this;
    }

    /**
     * Define the "profile" routes of a user
     */
    protected function settings(): self
    {
        Route::middleware(['web', 'adless'])
            ->prefix('settings')
            ->namespace($this->namespace)
            ->group(base_path('routes/settings.php'));

        return $this;
    }

    /**
     * Define the "auth" routes for login, logout, lost password etc
     */
    protected function auth(): self
    {
        Route::middleware(['web', 'adless'])
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/auth.php'));

        return $this;
    }

    protected function vendor(): self
    {
        Route::middleware(['minimum'])
            ->namespace('\App\Http\Controllers')
            ->group(base_path('routes/vendor.php'));

        return $this;
    }

    protected function webhooks(): self
    {
        Route::middleware(['webhooks'])
            ->namespace($this->namespace)
            ->group(base_path('routes/webhooks.php'));

        return $this;
    }
}
