<?php

use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\FrontendPrepareController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\Roadmap\FeatureController;
use App\Http\Controllers\Roadmap\RoadmapController;
use App\Http\Controllers\Search\GameSystemSearchController;
use App\Http\Controllers\Settings\SubscriptionApiController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Spotlights\ApplicationController;
use App\Http\Controllers\User\EmailValidationController;
use App\Http\Controllers\User\ProfileController;
use App\Models\Feature;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::group(['prefix' => 'subscription-api'], function () {
    Route::get('setup-intent', 'Settings\SubscriptionApiController@setupIntent');
    Route::post('payments', 'Settings\SubscriptionApiController@paymentMethods');
    Route::get('payment-methods', 'Settings\SubscriptionApiController@getPaymentMethods');
    Route::post('remove-payment', 'Settings\SubscriptionApiController@removePaymentMethod');
    Route::get('check-coupon/{tier}', [SubscriptionApiController::class, 'checkCoupon'])
        ->name('subscription.check-coupon');
});

Route::get('users/{user}', [ProfileController::class, 'show'])->name('users.profile');

Route::get('/_ccapi/country', [CookieConsentController::class, 'index'])
    ->name('cookieconsent.country');

Route::get('/frontend-prepare', [FrontendPrepareController::class, 'index']);

Route::get('/_setup', [SetupController::class, 'index']);
Route::get('/up', [HealthController::class, 'index']);

Route::model('feature', Feature::class);
Route::get('roadmap', [RoadmapController::class, 'index'])->name('roadmap');
Route::get('roadmap/{feature}', [FeatureController::class, 'show'])->name('roadmap.feature.show');
Route::post('roadmap/{feature}/upvote', [FeatureController::class, 'upvote'])->name('roadmap.upvote');
Route::post('roadmap/submit', [FeatureController::class, 'store'])->name('roadmap.store');

Route::get('spotlights', [ApplicationController::class, 'index'])->name('spotlights.application');
Route::get('spotlights/{campaign}', [ApplicationController::class, 'form'])->name('spotlights.form');
Route::post('spotlights/{campaign}/save', [ApplicationController::class, 'save'])->name('spotlights.save');
Route::post('spotlights/retract/{campaign}', [ApplicationController::class, 'retract'])->name('spotlights.retract');

Route::get('/validation/{userValidation}', [EmailValidationController::class, 'validateEmail'])->name('validation.email');

// Game System Search
Route::get('/search/systems', [GameSystemSearchController::class, 'index'])->name('search.systems');

Route::get('/r/{referral}', [ReferralController::class, 'index'])->name('referrals');

Route::get('/datagrids/subscription', [\App\Http\Controllers\Datagrids\SubscriptionController::class, 'index'])->name('datagrids.subscription');
