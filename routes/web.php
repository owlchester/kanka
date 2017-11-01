<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@edit')->name('profile');
Route::patch('/profile', 'ProfileController@update')->name('profile.update');


// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

//Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    'campaigns' => 'CampaignController',
    'campaign_user' => 'CampaignUserController',
    'characters' => 'CharacterController',
    'character_relation' => 'CharacterRelationController',
    'locations' => 'LocationController',
    'location_attribute' => 'LocationAttributeController',
    'families' => 'FamilyController',
    'family_relation' => 'FamilyRelationController',
    'items' => 'ItemController',
    'journals' => 'JournalController',
]);

Route::get('/search/locations', 'SearchController@locations')->name('locations.find');
Route::get('/search/characters', 'SearchController@characters')->name('characters.find');
Route::get('/search/campaigns', 'SearchController@campaigns')->name('campaigns.find');
Route::get('/search/families', 'SearchController@families')->name('families.find');
Route::get('/search', 'SearchController@search')->name('search');

Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');
