<?php

use App\Http\Controllers\Search\AttributeController;
use App\Http\Controllers\Search\CalendarController;
use App\Http\Controllers\Search\CampaignController;
use App\Http\Controllers\Search\FullTextController;
use App\Http\Controllers\Search\ImageController;
use App\Http\Controllers\Search\ListController;
use App\Http\Controllers\Search\LiveController;
use App\Http\Controllers\Search\MentionController;
use App\Http\Controllers\Search\MapGroupController;
use App\Http\Controllers\Search\MarkerController;
use App\Http\Controllers\Search\RecentController;
use App\Http\Controllers\Search\TemplateController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Old Search
Route::get('/w/{campaign}/search', [SearchController::class, 'search'])->name('search');

Route::get('/w/{campaign}/search/markers', [MarkerController::class, 'index'])->name('markers.find');
Route::get('/w/{campaign}/search/images', [ImageController::class, 'index'])->name('images.find');

Route::get('/w/{campaign}/search/members', [CampaignController::class, 'members'])->name('find.campaign.members');
Route::get('/w/{campaign}/search/roles', [CampaignController::class, 'roles'])->name('find.campaign.roles');

Route::get('/w/{campaign}/search/entity-calendars', [CalendarController::class, 'index'])->name('search.calendars');
Route::get('/w/{campaign}/search/months', [CalendarController::class, 'months'])->name('search.calendar-months');

Route::get('/w/{campaign}/search/entities/{entity}/attributes', [AttributeController::class, 'index'])->name('search.attributes');

// Global Entity Search
Route::get('/w/{campaign}/search/reminder-entities', [LiveController::class, 'reminderEntities'])->name('search.entities-with-reminders');
Route::get('/w/{campaign}/search/relation-entities', [LiveController::class, 'relationEntities'])->name('search.entities-with-relations');
Route::get('/w/{campaign}/search/tag-children', [LiveController::class, 'tagChildren'])->name('search.tag-children');
Route::get('/w/{campaign}/search/ability-entities', [LiveController::class, 'abilityEntities'])->name('search.ability-entities');
Route::get('/w/{campaign}/search/organisation-member', [LiveController::class, 'organisationMembers'])->name('search.organisation-member');

Route::get('/w/{campaign}/search/type/{entity_type}', [ListController::class, 'index'])->name('search-list');
Route::get('/w/{campaign}/search/{map}/map_groups', [MapGroupController::class, 'index'])->name('map-groups-list');
Route::get('/w/{campaign}/search/type/{entity_type}/templates', [TemplateController::class, 'index'])->name('search.templates');

Route::get('/w/{campaign}/search/live', [LiveController::class, 'index'])->name('search.live');
Route::get('/w/{campaign}/search/recent', [RecentController::class, 'index'])->name('search.recent');

Route::get('/w/{campaign}/search/fulltext', [FullTextController::class, 'index'])->name('search.fulltext');


Route::get('/w/{campaign}/search/mention', [MentionController::class, 'index'])->name('search.mention');
Route::post('/w/{campaign}/search/mention', [MentionController::class, 'load'])->name('search.mention.load');
