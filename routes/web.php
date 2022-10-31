<?php

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

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');
    Route::get('/login-as-user/{user}', 'Auth\AuthController@loginAsUser')->name('login-as-user');

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
    ], function () {
        Route::get('/', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@index')->name('index');
        Route::get('/{version}/{page?}', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@show')->where('page', '(.*)')->name('show');
    });
});

if (app()->environment('local')) {
    Route::get('email-test', 'Tests\EmailTestController@index');
}
