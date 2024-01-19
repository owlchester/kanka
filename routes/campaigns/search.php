<?php

use Illuminate\Support\Facades\Route;

// Old Search
Route::get('/w/{campaign}/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

// Misc Model Search
Route::get('/w/{campaign}/search/calendars', 'Search\MiscController@calendars')->name('calendars.find');
Route::get('/w/{campaign}/search/characters', 'Search\MiscController@characters')->name('characters.find');
Route::get('/w/{campaign}/search/campaigns', 'Search\MiscController@campaigns')->name('campaigns.find');
Route::get('/w/{campaign}/search/events', 'Search\MiscController@events')->name('events.find');
Route::get('/w/{campaign}/search/families', 'Search\MiscController@families')->name('families.find');
Route::get('/w/{campaign}/search/item', 'Search\MiscController@items')->name('items.find');
Route::get('/w/{campaign}/search/locations', 'Search\MiscController@locations')->name('locations.find');
Route::get('/w/{campaign}/search/notes', 'Search\MiscController@notes')->name('notes.find');
Route::get('/w/{campaign}/search/journals', 'Search\MiscController@journals')->name('journals.find');
Route::get('/w/{campaign}/search/timelines', 'Search\MiscController@timelines')->name('timelines.find');
Route::get('/w/{campaign}/search/organisations', 'Search\MiscController@organisations')->name('organisations.find');
Route::get('/w/{campaign}/search/tags', 'Search\MiscController@tags')->name('tags.find');
Route::get('/w/{campaign}/search/dice-rolls', 'Search\MiscController@diceRolls')->name('dice_rolls.find');
Route::get('/w/{campaign}/search/quests', 'Search\MiscController@quests')->name('quests.find');
Route::get('/w/{campaign}/search/conversations', 'Search\MiscController@conversations')->name('conversations.find');
Route::get('/w/{campaign}/search/races', 'Search\MiscController@races')->name('races.find');
Route::get('/w/{campaign}/search/creatures', 'Search\MiscController@creatures')->name('creatures.find');
Route::get('/w/{campaign}/search/abilities', 'Search\MiscController@abilities')->name('abilities.find');
Route::get('/w/{campaign}/search/maps', 'Search\MiscController@maps')->name('maps.find');
Route::get('/w/{campaign}/search/markers', 'Search\MiscController@markers')->name('markers.find');
Route::get('/w/{campaign}/search/attribute-templates', 'Search\MiscController@attributeTemplates')->name('attribute_templates.find');
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

Route::get('/w/{campaign}/search/live', [App\Http\Controllers\Search\LiveController::class, 'index'])->name('search.live');
Route::get('/w/{campaign}/search/recent', [App\Http\Controllers\Search\RecentController::class, 'index'])->name('search.recent');


//Game System Search
Route::get('/w/{campaign}/search/systems', [App\Http\Controllers\Search\GameSystemSearchController::class, 'index'])->name('search.systems');
