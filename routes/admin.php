<?php
/**
* Admin and moderation routes
*/

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test-email', 'TestEmailController@index');

Route::get('/cache', 'CacheController@index')->name('cache');
Route::delete('/cache', 'CacheController@destroy')->name('cache.destroy');
Route::post('/cache-view', 'CacheController@view')->name('cache.view');

Route::resources([
    'users' => 'UserController',
    'faqs' => 'FaqController',
    'patrons' => 'PatronController',
    'campaigns' => 'CampaignController',
    'community-votes' => 'CommunityVoteController',
    'faq' => 'FaqController',
    'faq-categories' => 'FaqCategoryController',
    'community-events' => 'CommunityEventController',
    'app-releases' => 'ReleaseController',
    'referrals' => 'ReferralController',
    'admin_invites' => 'AdminInviteController',
    'ads' => 'AdController',
]);

Route::get('/community-events/{community_events}/entries', 'CommunityEventController@entries')
    ->name('community-events.entries');

Route::model('community-event-entries', App\Models\CommunityEventEntry::class);
Route::put('/community-event-entries/{community_event_entries}/rank', 'CommunityEventController@rank')
    ->name('community-entries.rank');

Route::model('patron', \App\User::class);

// User admin
Route::post('users/{user}/roles', 'UserController@addRole')->name('users.roles');
Route::post('users/{user}/booster-count', 'UserController@boosterCount')->name('users.booster_count');

Route::delete('users/{user}/patreon-unsync', 'UserController@removePatreon')->name('users.patreon_unsync');
Route::delete('users/{user}/roles', 'UserController@removeRole')->name('users.roles.destroy');

// Campaign admin

Route::post('campaigns/{campaign}/featured', 'CampaignController@featured')->name('campaigns.featured');

Route::get('setup', 'SetupController@index')->name('setup');
Route::get('stats/subs', 'StatsController@subs')->name('stats.subs');

