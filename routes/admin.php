<?php
/**
 * Admin and moderation routes
 */

Route::namespace('Admin')->name('admin.')->middleware(['moderator'])->prefix('admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::resourc('/faqs', 'Admin\FaqController@index')->name('admin.faqs.index');

    Route::get('/test-email', 'TestEmailController@index');

    Route::resources([
        'faqs' => 'FaqController',
        'patrons' => 'PatronController',
        'campaigns' => 'CampaignController',
        'community-votes' => 'CommunityVoteController'
    ]);

    Route::model('patron', \App\User::class);
});
