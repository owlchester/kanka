<?php

use App\Facades\AdCache;
use App\Facades\ApiLog;
use App\Facades\Attributes;
use App\Facades\Avatar;
use App\Facades\Breadcrumb;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
use App\Facades\Domain;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\EntitySetup;
use App\Facades\FormCopy;
use App\Facades\Img;
use App\Facades\ImportIdMapper;
use App\Facades\Limit;
use App\Facades\Mentions;
use App\Facades\UserCache;
use App\Providers\AppServiceProvider;
use App\Providers\AttributesServiceProvider;
use App\Providers\AvatarServiceProvider;
use App\Providers\BreadcrumbServiceProvider;
use App\Providers\CampaignLocalizationServiceProvider;
use App\Providers\DashboardServiceProvider;
use App\Providers\DatagridRendererProvider;
use App\Providers\DatalayerServiceProvider;
use App\Providers\DomainServiceProvider;
use App\Providers\EntitySetupServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\ImgServiceProvider;
use App\Providers\ImporterServiceProvider;
use App\Providers\LimitServiceProvider;
use App\Providers\Logs\ApiLogServiceProvider;
use App\Providers\MentionsServiceProvider;
use App\Providers\ModuleServiceProvider;
use App\Providers\PermissionsServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Intervention\Image\Facades\Image;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use PragmaRX\Google2FALaravel\Facade;
use PragmaRX\Google2FALaravel\ServiceProvider;
use Stevebauman\Purify\Facades\Purify;
use Stevebauman\Purify\PurifyServiceProvider;
use Vsch\TranslationManager\ManagerServiceProvider;
use Vsch\TranslationManager\TranslationServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Miscellany'),
    'email' => env('APP_EMAIL', 'you@example.com'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
     * If the app is hosted along the admin, will enable the community aspects of Kanka.
     */
    'admin' => env('APP_ADMIN', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),
    'site_name' => env('APP_SITE_NAME', 'my self hosted worldbuilding app'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    'version' => env('APP_VERSION', '@develop'),

    'ignore_develop_warning' => env('APP_IGNORE_DEVELOP_WARNING', false),

    /*
     * Determine if cron job results need to be logged in the database
     */
    'log_jobs' => env('APP_LOG_JOBS', false),

    /*
    |-------------------------------------------
    | API Version
    |-------------------------------------------
    |
    | This value is the version of your api. It's used when there's no specified
    | version on the routes, so it will take this as the default, or current.
     */

    'api_latest' => '1',

    'force_https' => env('APP_FORCE_HTTPS', false),

    'lazy' => env('APP_LAZY', false),

    /**
     * Default user country fallback, used for local development to simulate a user from a specific country
     */
    'default_country' => env('DEFAULT_COUNTRY', 'CH'),

    /**
     * Leaflet version.
     */
    'leaflet_source' => env('LEAFLET_SOURCE', '1.9.4'),
    'leaflet_css' => env('LEAFLET_CSS', 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY='),
    'leaflet_js' => env('LEAFLET_JS', 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        AuthServiceProvider::class,
        BroadcastServiceProvider::class,
        BusServiceProvider::class,
        CacheServiceProvider::class,
        ConsoleSupportServiceProvider::class,
        CookieServiceProvider::class,
        DatabaseServiceProvider::class,
        EncryptionServiceProvider::class,
        FilesystemServiceProvider::class,
        FoundationServiceProvider::class,
        HashServiceProvider::class,
        MailServiceProvider::class,
        NotificationServiceProvider::class,
        PaginationServiceProvider::class,
        PipelineServiceProvider::class,
        QueueServiceProvider::class,
        RedisServiceProvider::class,
        PasswordResetServiceProvider::class,
        SessionServiceProvider::class,
        // Illuminate\Translation\TranslationServiceProvider::class,
        ValidationServiceProvider::class,
        ViewServiceProvider::class,
        PassportServiceProvider::class,

        /*
         * Package Service Providers...
         */
        PurifyServiceProvider::class,
        SocialiteServiceProvider::class,

        ManagerServiceProvider::class,
        TranslationServiceProvider::class,
        // Illuminate\Translation\TranslationServiceProvider::class,

        // RichanFongdasen\EloquentBlameable\ServiceProvider::class,
        ServiceProvider::class,

        /*
         * Application Service Providers...
         */
        AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        AvatarServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class,
        CampaignLocalizationServiceProvider::class,
        MentionsServiceProvider::class,
        BreadcrumbServiceProvider::class,
        App\Providers\CacheServiceProvider::class,
        ImgServiceProvider::class,
        AttributesServiceProvider::class,
        DashboardServiceProvider::class,
        DatalayerServiceProvider::class,
        DatagridRendererProvider::class,
        PermissionsServiceProvider::class,
        EntitySetupServiceProvider::class,
        ModuleServiceProvider::class,
        ApiLogServiceProvider::class,
        DomainServiceProvider::class,
        LimitServiceProvider::class,
        ImporterServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Artisan::class,
        'Auth' => Auth::class,
        'Blade' => Blade::class,
        'Broadcast' => Broadcast::class,
        'Bus' => Bus::class,
        'Cache' => Cache::class,
        'Config' => Config::class,
        'Cookie' => Cookie::class,
        'Crypt' => Crypt::class,
        'DB' => DB::class,
        'Eloquent' => Model::class,
        'Event' => Event::class,
        'File' => File::class,
        'Gate' => Gate::class,
        'Hash' => Hash::class,
        'Lang' => Lang::class,
        'Log' => Log::class,
        'Mail' => Mail::class,
        'Notification' => Notification::class,
        'Password' => Password::class,
        'Queue' => Queue::class,
        'Redirect' => Redirect::class,
        'Redis' => Redis::class,
        'Request' => Request::class,
        'Response' => Response::class,
        'Route' => Route::class,
        'Schema' => Schema::class,
        'Session' => Session::class,
        'Storage' => Storage::class,
        'URL' => URL::class,
        'Validator' => Validator::class,
        'View' => View::class,
        'Vite' => Vite::class,

        // Third party
        'Purify' => Purify::class,
        'Socialite' => Socialite::class,
        'Image' => Image::class,
        'LaravelLocalization' => LaravelLocalization::class,

        // Kanka
        'Avatar' => Avatar::class,
        'CampaignLocalization' => CampaignLocalization::class,
        'EntityPermission' => EntityPermission::class,
        'Mentions' => Mentions::class,
        'Breadcrumb' => Breadcrumb::class,
        'FormCopy' => FormCopy::class,
        'EntityCache' => EntityCache::class,
        'CampaignCache' => CampaignCache::class,
        'AdCache' => AdCache::class,
        'UserCache' => UserCache::class,
        'Img' => Img::class,
        'Attributes' => Attributes::class,
        'Datagrid' => Datagrid::class,
        'EntitySetup' => EntitySetup::class,
        'Google2FA' => Facade::class,
        'ApiLog' => ApiLog::class,
        'Domain' => Domain::class,
        'Limit' => Limit::class,
        'ImportIdMapper' => ImportIdMapper::class,
    ],

];
