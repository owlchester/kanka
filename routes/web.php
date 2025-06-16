<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::group(['prefix' => 'subscription-api'], function () {
    Route::get('setup-intent', 'Settings\SubscriptionApiController@setupIntent');
    Route::post('payments', 'Settings\SubscriptionApiController@paymentMethods');
    Route::get('payment-methods', 'Settings\SubscriptionApiController@getPaymentMethods');
    Route::post('remove-payment', 'Settings\SubscriptionApiController@removePaymentMethod');
    Route::get('check-coupon/{tier}', [App\Http\Controllers\Settings\SubscriptionApiController::class, 'checkCoupon'])
        ->name('subscription.check-coupon');
});

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
)->name('cashier.webhook');

Route::get('users/{user}', [App\Http\Controllers\User\ProfileController::class, 'show'])->name('users.profile');

Route::get('/_ccapi/country', [App\Http\Controllers\CookieConsentController::class, 'index'])
    ->name('cookieconsent.country');

Route::get('/frontend-prepare', [App\Http\Controllers\FrontendPrepareController::class, 'index']);

Route::get('/_setup', [App\Http\Controllers\SetupController::class, 'index']);
Route::get('/up', [App\Http\Controllers\HealthController::class, 'index']);

Route::model('feature', App\Models\Feature::class);
Route::get('roadmap', [App\Http\Controllers\Roadmap\RoadmapController::class, 'index'])->name('roadmap');
Route::get('roadmap/{feature}', [App\Http\Controllers\Roadmap\FeatureController::class, 'show'])->name('roadmap.feature.show');
Route::post('roadmap/{feature}/upvote', [App\Http\Controllers\Roadmap\FeatureController::class, 'upvote'])->name('roadmap.upvote');
Route::post('roadmap/submit', [App\Http\Controllers\Roadmap\FeatureController::class, 'store'])->name('roadmap.store');

Route::get('/validation/{userValidation}', [App\Http\Controllers\User\EmailValidationController::class, 'validateEmail'])->name('validation.email');

// Game System Search
Route::get('/search/systems', [App\Http\Controllers\Search\GameSystemSearchController::class, 'index'])->name('search.systems');

Route::prefix('oauth')->group(function () {
        Route::get('/tokens', [
            'uses' => '\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@forUser',
            'as' => 'tokens.index',
        ]);

        Route::delete('/tokens/{token_id}', [
            'uses' => '\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@destroy',
            'as' => 'tokens.destroy',
        ]);

        Route::get('/clients', [
            'uses' => '\Laravel\Passport\Http\Controllers\ClientController@forUser',
            'as' => 'clients.index',
        ]);

        Route::post('/clients', [
            'uses' => '\Laravel\Passport\Http\Controllers\ClientController@store',
            'as' => 'clients.store',
        ]);

        Route::put('/clients/{client_id}', [
            'uses' => '\Laravel\Passport\Http\Controllers\ClientController@update',
            'as' => 'clients.update',
        ]);

        Route::delete('/clients/{client_id}', [
            'uses' => '\Laravel\Passport\Http\Controllers\ClientController@destroy',
            'as' => 'clients.destroy',
        ]);

        Route::get('/scopes', [
            'uses' => '\Laravel\Passport\Http\Controllers\ScopeController@all',
            'as' => 'scopes.index',
        ]);

        Route::get('/personal-access-tokens', [
            'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@forUser',
            'as' => 'personal.tokens.index',
        ]);

        Route::post('/personal-access-tokens', [
            'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@store',
            'as' => 'personal.tokens.store',
        ]);

        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@destroy',
            'as' => 'personal.tokens.destroy',
        ]);
});