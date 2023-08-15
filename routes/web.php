<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::group(['prefix' => 'subscription-api'], function () {
    Route::get('setup-intent', 'Settings\SubscriptionApiController@setupIntent');
    Route::post('payments', 'Settings\SubscriptionApiController@paymentMethods');
    Route::get('payment-methods', 'Settings\SubscriptionApiController@getPaymentMethods');
    Route::post('remove-payment', 'Settings\SubscriptionApiController@removePaymentMethod');
    Route::get('check-coupon', 'Settings\SubscriptionApiController@checkCoupon')
        ->name('subscription.check-coupon');
});

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
)->name('cashier.webhook');
;

Route::get('/_ccapi/country', [\App\Http\Controllers\CookieConsentController::class, 'index'])
    ->name('cookieconsent.country');

Route::get('/frontend-prepare', [\App\Http\Controllers\FrontendPrepareController::class, 'index']);
