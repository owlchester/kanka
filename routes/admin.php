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

    Route::resources([
        'faqs' => 'FaqController',
        'patrons' => 'PatronController',
        'campaigns' => 'CampaignController',
        'community-votes' => 'CommunityVoteController',
        'app-releases' => 'ReleaseController'
    ]);

    Route::model('patron', \App\User::class);
});
