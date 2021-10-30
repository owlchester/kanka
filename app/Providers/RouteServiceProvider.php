<?php

namespace App\Providers;

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
        $this->mapAdminRoutes();
        $this->mapProfileRoutes();

        //
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

    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
             ->prefix(LaravelLocalization::setLocale())
             ->namespace($this->namespace)
             ->group(base_path('routes/front.php'));
    }

    protected function mapProfileRoutes()
    {
        Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime'])
             ->prefix(LaravelLocalization::setLocale() . '/settings')
            ->namespace($this->namespace)
             ->group(base_path('routes/profile.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['no-locale', 'moderator'])
            ->prefix('admin')
            ->namespace('App\Http\Controllers\Admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

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
}
