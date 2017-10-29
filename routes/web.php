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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    'campaigns' => 'CampaignController',
    'characters' => 'CharacterController',
    'character_relation' => 'CharacterRelationController',
    'locations' => 'LocationController',
    'location_attribute' => 'LocationAttributeController',
    'families' => 'FamilyController',
    'family_member' => 'FamilyMemberController',
]);

Route::get('/search/locations', 'SearchController@locations')->name('locations.find');
Route::get('/search/characters', 'SearchController@characters')->name('characters.find');
Route::get('/search/campaigns', 'SearchController@campaigns')->name('campaigns.find');
Route::get('/search/families', 'SearchController@families')->name('families.find');
