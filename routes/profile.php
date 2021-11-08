<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'Settings\ProfileController@index')
    ->name('settings');
Route::get('/profile', 'Settings\ProfileController@index')
    ->name('settings.profile');
Route::patch('/profile', 'Settings\ProfileController@update')
    ->name('settings.profile');

Route::get('/boost', 'Settings\BoostController@index')
    ->name('settings.boost');

Route::post('/release/{app_release}', 'Settings\ReleaseController@read')
    ->name('settings.release');
Route::post('/banner', 'Settings\ReleaseController@banner')
    ->name('settings.banner');
Route::post('/welcome', 'Settings\WelcomeController@read')
    ->name('settings.welcome');

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

Route::get('/layout', 'Settings\LayoutController@index')
    ->name('settings.layout');
Route::patch('/layout', 'Settings\LayoutController@update')
    ->name('settings.layout');

Route::get('/subscription', 'Settings\SubscriptionController@index')
    ->name('settings.subscription');
Route::get('/subscription/change', 'Settings\SubscriptionController@change')
    ->name('settings.subscription.change');
Route::get('/subscription/callback', 'Settings\SubscriptionController@callback')
    ->name('settings.subscription.callback');
Route::post('/subscription/change', 'Settings\SubscriptionController@subscribe')
    ->name('settings.subscription.subscribe');
Route::get('/billing-information', 'Settings\BillingController@index')
    ->name('settings.billing');
Route::patch('/billing-information', 'Settings\BillingController@save')
    ->name('settings.billing.save');

Route::post('/subscription/alt-subscribe', 'Settings\SubscriptionController@altSubscribe')
    ->name('settings.subscription.alt-subscribe');
Route::get('/subscription/alt-callback', 'Settings\SubscriptionController@altCallback')
    ->name('settings.subscription.alt-callback');

Route::get('/invoices', 'Settings\InvoiceController@index')
    ->name('settings.invoices');
Route::get('/invoices/download/{invoice}', 'Settings\InvoiceController@download')
    ->name('settings.invoices.download');

Route::get('/apps', 'Settings\AppsController@index')
    ->name('settings.apps');
Route::get('/discord-me', 'Settings\Apps\DiscordController@me');
Route::delete('/discord', 'Settings\Apps\DiscordController@destroy')
    ->name('settings.discord.destroy');
Route::get('/discord-callback', 'Settings\Apps\DiscordController@callback')
    ->name('settings.discord.callback');
Route::get('/discord-setup', 'Settings\Apps\DiscordController@seup');

Route::post('newsletter-api', 'Settings\NewsletterApiController@update')
    ->name('settings.newsletter-api');

Route::get('/marketplace', 'Settings\MarketplaceController@index')
    ->name('settings.marketplace');
Route::post('/marketplace', 'Settings\MarketplaceController@save')
    ->name('settings.marketplace.save');
