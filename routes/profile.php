<?php

Route::get('/settings', 'Settings\ProfileController@index')->name('settings');
Route::get('/settings/profile', 'Settings\ProfileController@index')->name('settings.profile');
Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

// Model mapping
Route::get('/settings/boost', 'Settings\BoostController@index')->name('settings.boost');

Route::post('/settings/release/{app_release}', 'Settings\ReleaseController@read')->name('settings.release');
Route::post('/settings/welcome', 'Settings\WelcomeController@read')->name('settings.welcome');

Route::get('/settings/account', 'Settings\AccountController@index')->name('settings.account');
Route::patch('/settings/account/password', 'Settings\AccountController@password')->name('settings.account.password');
Route::patch('/settings/account/email', 'Settings\AccountController@email')->name('settings.account.email');
Route::patch('/settings/account/destroy', 'Settings\AccountController@destroy')->name('settings.account.destroy');
Route::patch('/settings/account/social', 'Settings\AccountController@social')->name('settings.account.social');

Route::get('/settings/patreon', 'Settings\PatreonController@index')->name('settings.patreon');
//Route::get('/settings/patreon-callback', 'Settings\PatreonController@callback')->name('settings.patreon.callback');
Route::delete('/settings/patreon-unlink', 'Settings\PatreonController@unlink')->name('settings.patreon.unlink');

Route::get('/settings/api', 'Settings\ApiController@index')->name('settings.api');

Route::get('/settings/layout', 'Settings\LayoutController@index')->name('settings.layout');
Route::patch('/settings/layout', 'Settings\LayoutController@update')->name('settings.layout');

Route::get('/settings/subscription', 'Settings\SubscriptionController@index')->name('settings.subscription');
Route::get('/settings/subscription/change', 'Settings\SubscriptionController@change')->name('settings.subscription.change');
Route::get('/settings/subscription/callback', 'Settings\SubscriptionController@callback')->name('settings.subscription.callback');
Route::post('/settings/subscription/change', 'Settings\SubscriptionController@subscribe')->name('settings.subscription.subscribe');
Route::get('/settings/billing-information', 'Settings\BillingController@index')->name('settings.billing');
Route::patch('/settings/billing-information', 'Settings\BillingController@save')->name('settings.billing.save');

Route::post('/settings/subscription/alt-subscribe', 'Settings\SubscriptionController@altSubscribe')->name('settings.subscription.alt-subscribe');
Route::get('/settings/subscription/alt-callback', 'Settings\SubscriptionController@altCallback')->name('settings.subscription.alt-callback');

Route::get('/settings/invoices', 'Settings\InvoiceController@index')->name('settings.invoices');
Route::get('/settings/invoices/download/{invoice}', 'Settings\InvoiceController@download')->name('settings.invoices.download');

Route::get('/settings/apps', 'Settings\AppsController@index')->name('settings.apps');
Route::get('/settings/discord-me', 'Settings\Apps\DiscordController@me');
Route::delete('/settings/discord', 'Settings\Apps\DiscordController@destroy')->name('settings.discord.destroy');
Route::get('/settings/discord-callback', 'Settings\Apps\DiscordController@callback')->name('settings.discord.callback');
Route::get('/settings/discord-setup', 'Settings\Apps\DiscordController@seup');

Route::post('settings/newsletter-api', 'Settings\NewsletterApiController@update')->name('settings.newsletter-api');

Route::get('/settings/marketplace', 'Settings\MarketplaceController@index')->name('settings.marketplace');
Route::post('/settings/marketplace', 'Settings\MarketplaceController@save')->name('settings.marketplace.save');
