<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
use App\Facades\Domain;
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
        $this->api()
            ->web()
            ->front()
            ->campaign()
            ->settings()
            ->auth()
            ->localess()
            ->vendor();
    }

    /**
     * Define the general "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function web(): self
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        return $this;
    }

    /**
     * Define the "api" routes for the application.
     *
     * @return void
     */
    protected function api(): self
    {
        $domain = Domain::isApp() ? Domain::api() : '';
        Route::domain($domain)->prefix('api')
            ->namespace($this->namespace)
            ->get('/health', [HealthController::class, 'index']);

        Route::domain($domain)->prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        return $this;
    }

    /**
     * Define the "front" routes that can be seen by everyone
     *
     * These routes are typically stateless.
     */
    protected function front(): self
    {
        $domain = Domain::isApp() ? Domain::front() : '';
        Route::domain($domain)->middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace($this->namespace)
            ->group(base_path('routes/front-i18n.php'));

        Route::domain($domain)->middleware(['web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/front.php'));

        return $this;
    }

    /**
     * Define the "campaign" routes for everything in a campaign
     *
     * Todo: one day, move from campaignLocalization in the controllers, and move the campaign in route binding
     */
    protected function campaign(): self
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime', 'campaign'])
            ->prefix(LaravelLocalization::setLocale() . '/' . CampaignLocalization::setCampaign())
            ->namespace($this->namespace)
            ->group(base_path('routes/campaign.php'));
        return $this;
    }

    /**
     * Define the "profile" routes of a user
     */
    protected function settings(): self
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale() . '/settings')
            ->namespace($this->namespace)
            ->group(base_path('routes/settings.php'));
        return $this;
    }

    /**
     * Define the "auth" routes for login, logout, lost password etc
     */
    protected function auth(): self
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/auth.php'))
        ;
        return $this;
    }

    /**
     * Define routes that don't have a local associated with them
     */
    protected function localess(): self
    {
        Route::middleware(['minimum'])
            ->namespace('\App\Http\Controllers')
            ->group(base_path('routes/localess.php'))
        ;
        return $this;
    }

    protected function vendor(): self
    {
        Route::middleware(['minimum'])
            ->namespace('\App\Http\Controllers')
            ->group(base_path('routes/vendor.php'))
        ;

        return $this;
    }
}
