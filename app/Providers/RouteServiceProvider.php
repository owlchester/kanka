<?php

namespace App\Providers;

use App\Facades\CampaignLocalization;
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
        //

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
        $this->mapAdminRoutes();
        $this->mapPartnerRoutes();
        $this->mapAuthRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     *
     */
    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace($this->namespace)
            ->group(base_path('routes/front.php'));
    }

    protected function mapCampaignRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime', 'campaign'])
            ->prefix(LaravelLocalization::setLocale() . '/' . CampaignLocalization::setCampaign())
            ->namespace($this->namespace)
            ->group(base_path('routes/campaign.php'));
    }

    /**
     *
     */
    protected function mapProfileRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale() . '/settings')
            ->namespace($this->namespace)
            ->group(base_path('routes/profile.php'));
    }

    /**
     *
     */
    protected function mapAdminRoutes()
    {
        ////Route::namespace('Admin')->name('admin.')->middleware(['moderator'])->prefix('admin')->group(function () {
        Route::middleware(['web', 'moderator', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale() . '/admin')
            ->namespace('App\Http\Controllers\Admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     *
     */
    protected function mapPartnerRoutes()
    {
        Route::middleware(['web', 'auth', 'partner', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix('partner')
            ->namespace('App\Http\Controllers\Partner')
            ->name('partner.')
            ->group(base_path('routes/partner.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
            ->prefix(LaravelLocalization::setLocale())
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/auth.php'))
        ;
    }
}
