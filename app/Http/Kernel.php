<?php

namespace App\Http;

use App\Http\Middleware\FullSetup;
use App\Http\Middleware\PasswordConfirm;
use App\Http\Middleware\ReplicationSwitcher;
use App\Http\Middleware\Tracking;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Passport\Http\Middleware\ValidateToken;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     */
    protected $middleware = [
        Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Middleware\HttpsProtocol::class, // Force https in prod
            Middleware\LocaleChange::class, // Save language changing
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
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            Middleware\HttpsProtocol::class,
            ReplicationSwitcher::class,
        ],
        'webhooks' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            Middleware\HttpsProtocol::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $middlewareAliases = [
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        'localizeDatetime' => Middleware\LocalizeDatetime::class,
        'client' => ValidateToken::class, // Laravel Passport

        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'campaign.boosted' => Middleware\CampaignBoosted::class,
        'login.redirect' => Middleware\LoginRedirect::class,
        'translator' => Middleware\Translator::class,
        'identity' => Middleware\Identity::class,
        'password.confirm' => PasswordConfirm::class,
        'subscriptions' => Middleware\Subscriptions::class,
        'fullsetup' => FullSetup::class,
        '2fa' => Middleware\OTP::class,
        'adless' => Middleware\Adless::class,
    ];
}
