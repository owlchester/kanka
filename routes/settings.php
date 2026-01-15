<?php

use App\Http\Controllers\Account\Billing\InformationController;
use App\Http\Controllers\Account\DeleteController;
use App\Http\Controllers\Account\EmailController;
use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\Account\SocialController;
use App\Http\Controllers\Billing\HistoryController;
use App\Http\Controllers\Billing\PaymentMethodController;
use App\Http\Controllers\CampaignBoostController;
use App\Http\Controllers\Layout\NavigationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordSecurityController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\ApiController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\Settings\Apps\DiscordController;
use App\Http\Controllers\Settings\AppsController;
use App\Http\Controllers\Settings\BoostController;
use App\Http\Controllers\Settings\ClientController;
use App\Http\Controllers\Settings\NewsletterApiController;
use App\Http\Controllers\Settings\NewsletterController;
use App\Http\Controllers\Settings\PatreonController;
use App\Http\Controllers\Settings\PremiumController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\ReferralController;
use App\Http\Controllers\Settings\ReleaseController;
use App\Http\Controllers\Settings\Subscription\CancellationController;
use App\Http\Controllers\Settings\Subscription\CancelledController;
use App\Http\Controllers\Settings\Subscription\FinishController;
use App\Http\Controllers\Settings\Subscription\FreeTrialController;
use App\Http\Controllers\Settings\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index'])->name('settings');
Route::get('/profile', [ProfileController::class, 'index'])->name('settings.profile');
Route::patch('/profile', [ProfileController::class, 'update'])->name('settings.profile-process');

Route::get('/account/billing/info', [InformationController::class, 'index'])->name('account.billing.info');
Route::patch('/account/billing/info', [InformationController::class, 'save'])->name('account.billing.info-save');

Route::get('/boosters', [BoostController::class, 'index'])->name('settings.boost');
Route::get('/boosters/boost/{campaign}', [BoostController::class, 'boost'])->name('settings.campaign-boost');
Route::get('/boosters/unboost/{campaign}', [BoostController::class, 'unboost'])->name('settings.campaign-unboost');

Route::post('/switch-to-premium', [PremiumController::class, 'migrate'])
    ->name('settings.switch-to-premium');
Route::get('/switch-back', [PremiumController::class, 'back'])
    ->name('settings.switch-back');
Route::get('/premium', [PremiumController::class, 'index'])->name('settings.premium');
Route::get('/boosters/premium/{campaign}', [PremiumController::class, 'premium'])->name('settings.campaign-premium');
Route::get('/boosters/unpremium/{campaign}', [PremiumController::class, 'unpremium'])->name('settings.campaign-unpremium');

Route::post('/release/{app_release}', [ReleaseController::class, 'read'])->name('settings.release');

Route::get('/account', [AccountController::class, 'index'])->name('settings.account');

Route::get('/account/password', [PasswordController::class, 'index'])->name('account.password');
Route::patch('/account/password', [PasswordController::class, 'save'])->name('account.password-save');
Route::get('/account/email', [EmailController::class, 'index'])->name('account.email');
Route::patch('/account/email', [EmailController::class, 'save'])->name('account.email-save');

Route::patch('/account/destroy', [DeleteController::class, 'destroy'])->name('settings.account.destroy');

Route::get('/account/social', [SocialController::class, 'index'])->name('account.social');
Route::patch('/account/social', [SocialController::class, 'save'])->name('account.social-save');

Route::get('/patreon', [PatreonController::class, 'index'])->name('settings.patreon');
Route::delete('/patreon-unlink', [PatreonController::class, 'unlink'])->name('settings.patreon.unlink');

Route::get('/api', [ApiController::class, 'index'])->name('settings.api');
Route::get('/api/create', [ApiController::class, 'create'])->name('settings.api.create');
Route::post('/api/store', [ApiController::class, 'store'])->name('settings.api.store');
Route::delete('/api/revoke/{token}', [ApiController::class, 'revoke'])->name('settings.api.revoke');
Route::put('/client/update/{client}', [ClientController::class, 'update'])->name('settings.client.update');
Route::get('/client/create', [ClientController::class, 'create'])->name('settings.client.create');
Route::post('/client/store', [ClientController::class, 'store'])->name('settings.client.store');
Route::get('/client/edit/{client}', [ClientController::class, 'edit'])->name('settings.client.edit');
Route::delete('/client/revoke/{client}', [ClientController::class, 'revoke'])->name('settings.client.revoke');

Route::get('/appearance', [AppearanceController::class, 'index'])->name('settings.appearance');
Route::patch('/appearance', [AppearanceController::class, 'update'])->name('settings.appearance.update');

Route::get('/newsletter', [NewsletterController::class, 'index'])->name('settings.newsletter');
Route::patch('/newsletter', [NewsletterController::class, 'update'])->name('settings.newsletter.save');

Route::get('/subscription', [SubscriptionController::class, 'index'])->name('settings.subscription');
Route::get('/subscription/change/{tier}', [SubscriptionController::class, 'change'])->name('settings.subscription.change');
Route::post('/subscription/renew', [SubscriptionController::class, 'renew'])->name('settings.subscription.renew');
Route::get('/subscription/finish', [FinishController::class, 'index'])->name('settings.subscription.finish');
Route::get('/subscription/callback', [SubscriptionController::class, 'callback'])->name('settings.subscription.callback');
Route::post('/subscription/change/{tier}', [SubscriptionController::class, 'subscribe'])->name('settings.subscription.subscribe');
Route::get('/subscription/unsubscribe', [CancellationController::class, 'index'])->name('settings.subscription.unsubscribe');
Route::post('/subscription/cancel', [CancellationController::class, 'save'])->name('settings.subscription.cancel');
Route::get('/subscription/cancelled', [CancelledController::class, 'index'])->name('settings.subscription.cancelled');
Route::get('/billing/payment-method', [PaymentMethodController::class, 'index'])->name('billing.payment-method');
Route::patch('/billing/payment-method', [PaymentMethodController::class, 'save'])->name('billing.payment-method.save');
Route::get('/billing/currency', [PaymentMethodController::class, 'currency'])->name('billing.currency');

Route::get('/subscription/free-trial', [FreeTrialController::class, 'index'])->name('settings.free-trial');
Route::post('/subscription/free-trial/accept', [FreeTrialController::class, 'accept'])->name('settings.free-trial.accept');

Route::get('/billing/history', [HistoryController::class, 'index'])->name('billing.history');
Route::get('/billing/history/download/{invoice}', [HistoryController::class, 'download'])->name('billing.history.download');

Route::get('/bragi', 'Settings\BragiController@index')
    ->name('settings.bragi');

Route::get('/apps', [AppsController::class, 'index'])
    ->name('settings.apps');
Route::get('/discord-me', [DiscordController::class, 'me']);
Route::delete('/discord', [DiscordController::class, 'destroy'])
    ->name('settings.discord.destroy');
Route::get('/discord-callback', [DiscordController::class, 'callback'])
    ->name('settings.discord.callback');
Route::get('/discord-setup', [DiscordController::class, 'seup']);

Route::post('newsletter-api', [NewsletterApiController::class, 'update'])
    ->name('settings.newsletter-api');

/*Route::get('/marketplace', 'Settings\MarketplaceController@index')
    ->name('settings.marketplace');
Route::post('/marketplace', 'Settings\MarketplaceController@save')
    ->name('settings.marketplace.save');*/

// Tutorial
// Route::get('/tutorial/{tutorial}/done/{next?}', 'Settings\TutorialController@done')
//    ->name('settings.tutorial.done');
// Route::get('/tutorial/disable', 'Settings\TutorialController@disable')
//    ->name('settings.tutorial.disable');
// Route::get('/tutorial/reset', 'Settings\TutorialController@reset')
//    ->name('settings.tutorial.reset');
Route::post('/tutorials/{code}/dismiss', [App\Http\Controllers\Settings\TutorialController::class, 'dismiss'])->name('tutorials.dismiss');
Route::patch('/tutorials/reset', [App\Http\Controllers\Settings\TutorialController::class, 'reset'])->name('tutorials.reset');

// Campaign boosters
Route::resources([
    'campaign_boosts' => CampaignBoostController::class,
]);
Route::get(
    'campaign_boosts/{campaign_boost}/confirm',
    [CampaignBoostController::class, 'confirm']
)->name('campaign_boost.confirm-destroy');

/*
--------------------------------------------------------------------------
Google2FA
--------------------------------------------------------------------------
*/
Route::post('/security/cancel2fa', [PasswordSecurityController::class, 'cancel2FA'])->name('auth.cancel-2fa');

// Generate a new Google2FA code if a User does not already have one
Route::post('/security/generate2faSecret', [PasswordSecurityController::class, 'generate2faSecretCode'])
    ->name('settings.security.generate-2fa');

// Verify 2FA if User has it enabled
Route::post('/security/verify2fa', function () {
    return redirect()->route('home');
})->name('auth.verify-2fa')->middleware('2fa');

/*Route::get('/security/verify2fa', function() {
    return redirect(URL()->previous());
})->name('auth.verify-2fa')->middleware('2fa');*/

/*
--------------------------------------------------------------------------
PayPal API
--------------------------------------------------------------------------
*/

Route::post('paypal/process-transaction/{tier}', [PayPalController::class, 'processTransaction'])
    ->name('paypal.process-transaction');
Route::get('paypal/success-transaction', [PayPalController::class, 'successTransaction'])
    ->name('paypal.transaction-success');
Route::get('paypal/cancel-transaction', [PayPalController::class, 'cancelTransaction'])
    ->name('paypal.cancel-transaction');

/*
--------------------------------------------------------------------------
Notifications
--------------------------------------------------------------------------
 */
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::get('/notifications/refresh', [NotificationController::class, 'refresh'])->name('notifications.refresh');
Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');
Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

Route::get('/layout/navigation', [NavigationController::class, 'index'])->name('layout.navigation');

Route::get('/referrals', [ReferralController::class, 'index'])->name('settings.referrals');
