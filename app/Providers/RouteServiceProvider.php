<?php

namespace App\Providers;

use App\Facades\Api;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Api\v1\HealthController;
use App\Models\Plugin;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::model('plugin', Plugin::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
        $this->mapFrontRoutes();
        $this->mapCampaignRoutes();
        $this->mapProfileRoutes();
        $this->mapPartnerRoutes();
        $this->mapAuthRoutes();
        $this->mapLocalessRoutes();
    }

    /**
     * Define the general "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        if (Api::isSubdomain()) {
            return;
        }
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        // If a subdomain is setup for the api, use that
        $apiDomain = config('api.domain');
        if (!empty($apiDomain)) {
            Route::domain($apiDomain)->group(function () {
                Route::get('/health', [HealthController::class, 'index']);

                Route::group([
                    'middleware' => ['api'],
                    'namespace'  => $this->namespace,
                ], function () {
                    require base_path('routes/api.php');
                });
            });

            if (Api::isSubdomain()) {
                Route::get('/', function () {
                    if (request()->isJson()) {
                        return response()->json(['docs' => 'Visit https://kanka.io/en/api-docs/1.0/overview for the kanka docs.']);
                    } else {
                        return redirect()->to('https://kanka.io/en/api-docs/1.0/overview');
                    }
                });
            }
        }

        // Load the API routes on the main domain
        if (empty($apiDomain) || request()->getHost() !== $apiDomain) {
            Route::prefix('api')
                ->namespace($this->namespace)
                ->get('/health', [HealthController::class, 'index']);

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    /**
     * Define the "front" routes that can be seen by everyone
     *
     * These routes are typically stateless.
     */
    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime', 'not-api'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace($this->namespace)
            ->group(base_path('routes/front.php'));
    }

    /**
     * Define the "campaign" routes for everything in a campaign
     *
     * Todo: one day, move from campaignLocalization in the controllers, and move the campaign in route binding
     */
    protected function mapCampaignRoutes()
    {
        // Todo: We need these also for the API to build urls to entity.show/character.show. But we can probably remove them too from MentionsService and refactor that part.
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime', 'campaign', 'not-api'])
            ->prefix(LaravelLocalization::setLocale() . '/' . CampaignLocalization::setCampaign())
            ->namespace($this->namespace)
            ->group(base_path('routes/campaign.php'));
    }

    /**
     * Define the "profile" routes of a user
     */
    protected function mapProfileRoutes()
    {
        if (Api::isSubdomain()) {
            return;
        }
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale() . '/settings')
            ->namespace($this->namespace)
            ->group(base_path('routes/profile.php'));
    }

    /**
     * Define the "partner" routes
     */
    protected function mapPartnerRoutes()
    {
        if (Api::isSubdomain()) {
            return;
        }
        Route::middleware(['web', 'auth', 'partner', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix('partner')
            ->namespace('App\Http\Controllers\Partner')
            ->name('partner.')
            ->group(base_path('routes/partner.php'));
    }

    /**
     * Define the "auth" routes for login, logout, lost password etc
     */
    protected function mapAuthRoutes()
    {
        if (Api::isSubdomain()) {
            return;
        }
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/auth.php'))
        ;
    }

    /**
     * Define routes that don't have a local associated with them
     */
    protected function mapLocalessRoutes()
    {
        if (Api::isSubdomain()) {
            return;
        }
        Route::middleware(['minimum'])
            ->namespace('\App\Http\Controllers')
            ->group(base_path('routes/localess.php'))
        ;
    }
}
