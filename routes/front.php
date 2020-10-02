<?php

Route::get('/about', 'FrontController@about')->name('front.about');
//Route::get('/terms-of-service', 'FrontController@tos')->name('tos');
Route::get('/privacy-policy', 'FrontController@privacy')->name('front.privacy');
Route::get('/terms-and-conditions', 'FrontController@terms')->name('front.terms');
Route::get('/faq', 'FaqController@index')->name('faq.index');
Route::get('/faq/{key}/{slug?}', 'FaqController@show')->name('faq.show');
Route::get('/features', 'FrontController@features')->name('front.features');
Route::get('/gm-features', 'FrontController@gmFeatures')->name('front.gm-features');
Route::get('/worldbuilding-features', 'FrontController@wbFeatures')->name('front.worldbuilder-features');
Route::get('/roadmap', 'FrontController@roadmap')->name('front.roadmap');
Route::get('/community', 'FrontController@community')->name('front.community');
Route::get('/public-campaigns', 'FrontController@campaigns')->name('front.public_campaigns');
Route::get('/contact', 'FrontController@contact')->name('front.contact');
Route::get('/pricing', 'FrontController@pricing')->name('front.pricing');
Route::get('/news', 'Front\NewsController@index')->name('front.news');
Route::get('/newsletter', 'Front\NewsletterController@index')->name('front.newsletter');
Route::get('/news/show/{id}-{slug?}', 'Front\NewsController@show')->name('front.news.show');

// Slug
Route::get('/releases/{id}-{slug?}', 'ReleaseController@show');

Route::post('/community-votes/{community_vote}/vote', 'CommunityVoteController@vote')->name('community-votes.vote');
Route::resources([
    'releases' => 'ReleaseController',
    'community-votes' => 'CommunityVoteController',
    'community-events' => 'Front\CommunityEventController',
    'community-events.community-event-entries' => 'Front\CommunityEventEntryController',
]);

