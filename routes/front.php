<?php

Route::get('/about', 'FrontController@about')->name('about');
//Route::get('/terms-of-service', 'FrontController@tos')->name('tos');
Route::get('/privacy-policy', 'FrontController@privacy')->name('privacy');
Route::get('/help', 'FrontController@help')->name('help');
Route::get('/faq', 'FaqController@index')->name('faq.index');
Route::get('/faq/{key}/{slug?}', 'FaqController@show')->name('faq.show');
Route::get('/features', 'FrontController@features')->name('features');
Route::get('/roadmap', 'FrontController@roadmap')->name('roadmap');
Route::get('/community', 'FrontController@community')->name('community');
Route::get('/public-campaigns', 'FrontController@campaigns')->name('public_campaigns');

// Slug
Route::get('/releases/{id}-{slug?}', 'ReleaseController@show');

Route::resources([
    'releases' => 'ReleaseController',
]);