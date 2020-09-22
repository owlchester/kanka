<?php
/**
 * Admin and moderation routes
 */

Route::namespace('Admin')->name('admin.')->middleware(['moderator'])->prefix('admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::resourc('/faqs', 'Admin\FaqController@index')->name('admin.faqs.index');

    Route::get('/test-email', 'TestEmailController@index');

    Route::get('/cache', 'CacheController@index')->name('cache');
    Route::post('/cache', 'CacheController@destroy')->name('cache.destroy');
    Route::post('/cache-view', 'CacheController@view')->name('cache.view');

    Route::resources([
        'users' => 'UserController',
        'faqs' => 'FaqController',
        'patrons' => 'PatronController',
        'campaigns' => 'CampaignController',
        'community-votes' => 'CommunityVoteController',
        //'community-event-entries' => 'CommunityEventEntryController',
        'community-events' => 'CommunityEventController',
        'app-releases' => 'ReleaseController',
        'referrals' => 'ReferralController',
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

    Route::delete('users/{user}/roles', 'UserController@removeRole')->name('users.roles.destroy');
});
