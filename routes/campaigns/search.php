<?php

use Illuminate\Support\Facades\Route;

// Old Search
Route::get('/w/{campaign}/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

Route::get('/w/{campaign}/search/markers', [App\Http\Controllers\Search\MarkerController::class, 'index'])->name('markers.find');
Route::get('/w/{campaign}/search/images', 'Search\ImageSearchController@index')->name('images.find');

Route::get('/w/{campaign}/search/members', 'Search\CampaignSearchController@members')->name('find.campaign.members');
Route::get('/w/{campaign}/search/roles', 'Search\CampaignSearchController@roles')->name('find.campaign.roles');

// Entity Search
Route::get('/w/{campaign}/search/entity-calendars', 'Search\CalendarController@index')->name('search.calendars');
Route::get('/w/{campaign}/search/attributes/{entity}', 'Search\AttributeSearchController@index')->name('search.attributes');

// Global Entity Search
Route::get('/w/{campaign}/search/reminder-entities', 'Search\LiveController@reminderEntities')->name('search.entities-with-reminders');
Route::get('/w/{campaign}/search/relation-entities', 'Search\LiveController@relationEntities')->name('search.entities-with-relations');
Route::get('/w/{campaign}/search/tag-children', 'Search\LiveController@tagChildren')->name('search.tag-children');
Route::get('/w/{campaign}/search/ability-entities', 'Search\LiveController@abilityEntities')->name('search.ability-entities');
Route::get('/w/{campaign}/search/organisation-member', 'Search\LiveController@organisationMembers')->name('search.organisation-member');
Route::get('/w/{campaign}/search/months', 'Search\CalendarController@months')->name('search.calendar-months');

Route::get('/w/{campaign}/search/type/{entity_type}', [App\Http\Controllers\Search\ListController::class, 'index'])->name('search-list');

Route::get('/w/{campaign}/search/live', [App\Http\Controllers\Search\LiveController::class, 'index'])->name('search.live');
Route::get('/w/{campaign}/search/recent', [App\Http\Controllers\Search\RecentController::class, 'index'])->name('search.recent');

Route::get('/w/{campaign}/search/fulltext', [App\Http\Controllers\Search\FullTextController::class, 'index'])->name('search.fulltext');
