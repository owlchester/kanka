<?php

Route::get('/front', 'FrontController@index')->name('front.home');
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
Route::get('/media', 'FrontController@media')->name('front.media');
Route::get('/public-campaigns', 'FrontController@campaigns')->name('front.public_campaigns');
Route::get('/contact', 'FrontController@contact')->name('front.contact');
Route::get('/pricing', 'FrontController@pricing')->name('front.pricing');
Route::get('/partners', 'FrontController@partners')->name('front.partners');
//Route::get('/news', 'Front\NewsController@index')->name('front.news');
Route::get('/newsletter', 'Front\NewsletterController@index')->name('front.newsletter');
//Route::get('/news/show/{id}-{slug?}', 'Front\NewsController@show')->name('front.news.show');

Route::get('/kb', 'Front\FaqController@index')->name('front.faqs.index');
Route::get('/kb/{faq}-{slug?}', 'Front\FaqController@show')->name('front.faqs.show');

Route::get('/features/calendars', 'Front\FeatureController@calendars')->name('front.features.calendars');
Route::get('/features/timelines', 'Front\FeatureController@timelines')->name('front.features.timelines');
Route::get('/features/secrets', 'Front\FeatureController@secrets')->name('front.features.secrets');
Route::get('/features/maps', 'Front\FeatureController@maps')->name('front.features.maps');
Route::get('/features/permissions', 'Front\FeatureController@permissions')->name('front.features.permissions');
Route::get('/features/boosters', 'Front\FeatureController@boosters')->name('front.features.boosters');
Route::get('/features/inventories-abilities', 'Front\FeatureController@inventoriesAbilities')->name('front.features.inventories-abilities');
Route::get('/features/dashboards', 'Front\FeatureController@dashboards')->name('front.features.dashboards');
Route::get('/features/relations', 'Front\FeatureController@relations')->name('front.features.relations');
//Route::get('/features/rich-text', 'Front\FeatureController@richText')->name('front.features.rich-text');

Route::get('/hall-of-fame', 'FrontController@hallOfFame')->name('front.hall-of-fame');

// Slug

Route::post('/community-votes/{community_vote}/vote', 'CommunityVoteController@vote')->name('community-votes.vote');
Route::resources([
    'community-votes' => 'CommunityVoteController',
    'community-events' => 'Front\CommunityEventController',
    'community-events.community-event-entries' => 'Front\CommunityEventEntryController',
]);

// Documentation catch all
Route::get('/documentation', 'FrontController@documentation')->name('documentation');
Route::get('/docs', 'FrontController@documentation');
Route::get('/api', 'FrontController@api');
Route::get('/docs/1.0/{sub}', 'FrontController@api');

