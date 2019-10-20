<?php
/**
 * Admin and moderation routes
 */

Route::namespace('Admin')->name('admin.')->middleware(['moderator'])->prefix('admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::resourc('/faqs', 'Admin\FaqController@index')->name('admin.faqs.index');

    Route::resources([
        'faqs' => 'FaqController',
        'patrons' => 'PatronController',
        'campaigns' => 'CampaignController',
    ]);

    Route::model('patron', \App\User::class);
});