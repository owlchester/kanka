<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Vsch\TranslationManager\Translator;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime' ]
], function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::resources([
        'campaign_boosts' => 'CampaignBoostController',
    ]);

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');
    Route::get('/helper/dice', 'HelperController@dice')->name('helpers.dice');
    Route::get('/helper/public', 'HelperController@public')->name('helpers.public');
    Route::get('/helper/map', 'HelperController@map')->name('helpers.map');
    Route::get('/helper/filters', 'HelperController@filters')->name('helpers.filters');
    Route::get('/helper/age', 'HelperController@age')->name('helpers.age');
    Route::get('/helper/attributes', 'HelperController@attributes')->name('helpers.attributes');
    Route::get('/helper/entity-templates', 'HelperController@entityTemplates')->name('helpers.entity-templates');
    Route::get('/helper/widget-filters', 'HelperController@widgetFilters')->name('helpers.widget-filters');
    Route::get('/helper/pins', 'HelperController@pins')->name('helpers.pins');
    Route::get('/helpers/api-filters', 'HelperController@apiFilters')->name('helpers.api-filters');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');

    Route::get('/start', 'StartController@index')->name('start');
    //Route::post('/start', 'StartController@store')->name('start.save');
    Route::post('/create-campaign', 'CampaignController@store')->name('create-campaign');

    // Invitation's campaign comes from the token.
    Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');

    Route::get('/troubleshooting/invite', 'TroubleshootingController@invite')->name('troubleshooting');
    Route::post('/troubleshooting/invite', 'TroubleshootingController@saveInvite')->name('troubleshooting.generate');


    Route::get('users/{user}', 'User\ProfileController@show')->name('users.profile');

    // Notification
    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    Route::get('/notifications/refresh', 'NotificationController@refresh')->name('notifications.refresh');
    Route::post('/notifications/clear-all', 'NotificationController@clearAll')->name('notifications.clear-all');

    // 3rd party
    Route::group(['middleware' => ['auth', 'translator'], 'prefix' => 'translations'], function () {
        Translator::routes();
        Route::get('/faq', 'Translations\FaqController@index')->name('translations.faq.index');
        Route::post('/faq-save', 'Translations\FaqController@save')->name('translations.faq.save');
    });

    // API docs
    Route::group([
        'prefix'     => config('larecipe.docs.route'),
        'domain'     => config('larecipe.domain', null),
        'as'         => 'larecipe.',
        'middleware' => 'web'
    ], function() {
        Route::get('/', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@index')->name('index');
        Route::get('/{version}/{page?}', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@show')->where('page', '(.*)')->name('show');
    });

});


// Auth callback without language segment in url
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::group(['prefix' => 'subscription-api'], function () {
    Route::get('setup-intent', 'Settings\SubscriptionApiController@setupIntent');
    Route::post('payments', 'Settings\SubscriptionApiController@paymentMethods');
    Route::get('payment-methods', 'Settings\SubscriptionApiController@getPaymentMethods');
    Route::post('remove-payment', 'Settings\SubscriptionApiController@removePaymentMethod');
    Route::get('check-coupon', 'Settings\SubscriptionApiController@checkCoupon')
        ->name('subscription.check-coupon');
});

// Stripe
Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);

// Language sitemaps
Route::get('/{locale}/sitemap.xml', 'Front\SitemapController@language')->name('front.sitemap');

// Rss feeds
Route::feeds();
