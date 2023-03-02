<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Settings\ProfileController@index')
    ->name('settings');
Route::get('/profile', 'Settings\ProfileController@index')
    ->name('settings.profile');
Route::patch('/profile', 'Settings\ProfileController@update')
    ->name('settings.profile');

Route::get('/boosters', 'Settings\BoostController@index')
    ->name('settings.boost');
Route::get('/boosters/boost/{campaign}', 'Settings\BoostController@boost')
    ->name('settings.campaign-boost');
Route::get('/boosters/unboost/{campaign}', 'Settings\BoostController@unboost')
    ->name('settings.campaign-unboost');

Route::post('/release/{app_release}', 'Settings\ReleaseController@read')
    ->name('settings.release');
Route::post('/banner', 'Settings\ReleaseController@banner')
    ->name('settings.banner');

Route::get('/account', 'Settings\AccountController@index')
    ->name('settings.account');
Route::patch('/account/password', 'Settings\AccountController@password')
    ->name('settings.account.password');
Route::patch('/account/email', 'Settings\AccountController@email')
    ->name('settings.account.email');
Route::patch('/account/destroy', 'Settings\AccountController@destroy')
    ->name('settings.account.destroy');
Route::patch('/account/social', 'Settings\AccountController@social')
    ->name('settings.account.social');

Route::get('/patreon', 'Settings\PatreonController@index')
    ->name('settings.patreon');
Route::delete('/patreon-unlink', 'Settings\PatreonController@unlink')
    ->name('settings.patreon.unlink');

Route::get('/api', 'Settings\ApiController@index')
    ->name('settings.api');

Route::get('/appearance', 'Settings\AppearanceController@index')
    ->name('settings.appearance');
Route::patch('/appearance', 'Settings\AppearanceController@update')
    ->name('settings.appearance.update');

Route::get('/notification', 'Settings\NotificationController@index')
    ->name('settings.notifications');
Route::patch('/notification', 'Settings\NotificationController@update')
    ->name('settings.notifications.save');

Route::get('/subscription', 'Settings\SubscriptionController@index')
    ->name('settings.subscription');
Route::get('/subscription/change', 'Settings\SubscriptionController@change')
    ->name('settings.subscription.change');
Route::get('/subscription/callback', 'Settings\SubscriptionController@callback')
    ->name('settings.subscription.callback');
Route::post('/subscription/change', 'Settings\SubscriptionController@subscribe')
    ->name('settings.subscription.subscribe');
Route::get('/billing/payment-method', [\App\Http\Controllers\Billing\PaymentMethodController::class, 'index'])
    ->name('billing.payment-method');
Route::patch('/billing/payment-method', [\App\Http\Controllers\Billing\PaymentMethodController::class, 'save'])
    ->name('billing.payment-method.save');

Route::post('/subscription/alt-subscribe', 'Settings\SubscriptionController@altSubscribe')
    ->name('settings.subscription.alt-subscribe');
Route::get('/subscription/alt-callback', 'Settings\SubscriptionController@altCallback')
    ->name('settings.subscription.alt-callback');

Route::get('/billing/history', [\App\Http\Controllers\Billing\HistoryController::class, 'index'])
    ->name('billing.history');
Route::get('/billing/history/download/{invoice}', [\App\Http\Controllers\Billing\HistoryController::class, 'download'])
    ->name('billing.history.download');

Route::get('/bragi', 'Settings\BragiController@index')
    ->name('settings.bragi');

Route::get('/apps', 'Settings\AppsController@index')
    ->name('settings.apps');
Route::get('/discord-me', 'Settings\Apps\DiscordController@me');
Route::delete('/discord', 'Settings\Apps\DiscordController@destroy')
    ->name('settings.discord.destroy');
Route::get('/discord-callback', 'Settings\Apps\DiscordController@callback')
    ->name('settings.discord.callback');
Route::get('/discord-setup', 'Settings\Apps\DiscordController@seup');

Route::post('newsletter-api', [\App\Http\Controllers\Settings\NewsletterApiController::class, 'update'])
    ->name('settings.newsletter-api');

/*Route::get('/marketplace', 'Settings\MarketplaceController@index')
    ->name('settings.marketplace');
Route::post('/marketplace', 'Settings\MarketplaceController@save')
    ->name('settings.marketplace.save');*/

// Tutorial
Route::get('/tutorial/{tutorial}/done/{next?}', 'Settings\TutorialController@done')
    ->name('settings.tutorial.done');
Route::get('/tutorial/disable', 'Settings\TutorialController@disable')
    ->name('settings.tutorial.disable');
Route::get('/tutorial/reset', 'Settings\TutorialController@reset')
    ->name('settings.tutorial.reset');

// Campaign boosters
Route::resources([
    'campaign_boosts' => 'CampaignBoostController',
]);
Route::get(
    'campaign_boosts/{campaign_boost}/confirm',
    [\App\Http\Controllers\CampaignBoostController::class, 'confirm']
)->name('campaign_boost.confirm-destroy');

/*
--------------------------------------------------------------------------
Google2FA
--------------------------------------------------------------------------
*/
Route::post('/security/cancel2fa', 'PasswordSecurityController@cancel2FA')->name('auth.cancel-2fa');


// Generate a new Google2FA code if a User does not already have one
Route::post('/security/generate2faSecret', [
    'uses' => 'PasswordSecurityController@generate2faSecretCode',
    'as'   => 'settings.security.generate-2fa'
]);

// Enable 2FA for User
Route::post('/security/enable2fa', [
    'uses' => 'PasswordSecurityController@enable2fa',
    'as'   => 'settings.security.enable-2fa'
]);

// Disable 2FA for User
Route::post('/security/disable2fa', [
    'uses' => 'PasswordSecurityController@disable2fa',
    'as'   => 'settings.security.disable-2fa'
]);

// Verify 2FA if User has it enabled
Route::post('/security/verify2fa', function() {
    return redirect()->route('home');
})->name('auth.verify-2fa')->middleware('2fa');


/*Route::get('/security/verify2fa', function() {
    return redirect(URL()->previous());
})->name('auth.verify-2fa')->middleware('2fa');*/

/*
--------------------------------------------------------------------------
Google2FA
--------------------------------------------------------------------------
*/
