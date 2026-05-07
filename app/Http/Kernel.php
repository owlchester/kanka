<?php

namespace App\Http;

use App\Http\Middleware\PasswordConfirm;
use App\Http\Middleware\ReplicationSwitcher;
use App\Http\Middleware\Tracking;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Passport\Http\Middleware\ValidateToken;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        Middleware\TrustProxies::class,
        HandleCors::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        Middleware\TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
            // Middleware\HttpsProtocol::class, // Force https in prod
            Middleware\LocaleChange::class, // Save language changing
            Middleware\LocalizeDatetime::class,
            Tracking::class,
            Middleware\CheckIfUserBanned::class,
            Middleware\OTP::class,
            ReplicationSwitcher::class,
        ],
        'api' => [
            // Do this in the routes 'throttle:rate_limit,1',
            'bindings',
            Middleware\ApiLogMiddleware::class,
        ],
        // Used for locale-less routes like our sitemaps, go/, auth/callbacks, webhooks
        'minimum' => [
            Middleware\EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
            Middleware\HttpsProtocol::class,
            ReplicationSwitcher::class,
        ],
        'webhooks' => [
            SubstituteBindings::class,
            Middleware\HttpsProtocol::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $middlewareAliases = [
        'localize' => LaravelLocalizationRoutes::class,
        'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => LocaleSessionRedirect::class,
        'localeViewPath' => LaravelLocalizationViewPath::class,
        'localizeDatetime' => Middleware\LocalizeDatetime::class,
        'client' => ValidateToken::class, // Laravel Passport

        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'can' => Authorize::class,
        'guest' => Middleware\RedirectIfAuthenticated::class,
        'throttle' => ThrottleRequests::class,
        'login.redirect' => Middleware\LoginRedirect::class,
        'translator' => Middleware\Translator::class,
        'identity' => Middleware\Identity::class,
        'password.confirm' => PasswordConfirm::class,
        'subscriptions' => Middleware\Subscriptions::class,
        '2fa' => Middleware\OTP::class,
        'adless' => Middleware\Adless::class,
    ];
}
