<?php

use App\Http\Controllers\Search\AttributeController;
use App\Http\Controllers\Search\CalendarController;
use App\Http\Controllers\Search\CampaignController;
use App\Http\Controllers\Search\CommandController;
use App\Http\Controllers\Search\FullTextController;
use App\Http\Controllers\Search\ImageController;
use App\Http\Controllers\Search\ListController;
use App\Http\Controllers\Search\LiveController;
use App\Http\Controllers\Search\LogController;
use App\Http\Controllers\Search\MapGroupController;
use App\Http\Controllers\Search\MarkerController;
use App\Http\Controllers\Search\MentionController;
use App\Http\Controllers\Search\RecentController;
use App\Http\Controllers\Search\TemplateController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Old Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/search/markers', [MarkerController::class, 'index'])->name('markers.find');
Route::get('/search/images', [ImageController::class, 'index'])->name('images.find');

Route::get('/search/members', [CampaignController::class, 'members'])->name('find.members');
Route::get('/search/roles', [CampaignController::class, 'roles'])->name('find.campaign.roles');

Route::get('/search/entity-calendars', [CalendarController::class, 'index'])->name('search.calendars');
Route::get('/search/months', [CalendarController::class, 'months'])->name('search.calendar-months');

Route::get('/search/entities/{entity}/attributes', [AttributeController::class, 'index'])->name('search.attributes');

// Global Entity Search
Route::get('/search/reminder-entities', [LiveController::class, 'reminderEntities'])->name('search.entities-with-reminders');
Route::get('/search/relation-entities', [LiveController::class, 'relationEntities'])->name('search.entities-with-relations');
Route::get('/search/tag-children', [LiveController::class, 'tagChildren'])->name('search.tag-children');
Route::get('/search/ability-entities', [LiveController::class, 'abilityEntities'])->name('search.ability-entities');
Route::get('/search/organisation-member', [LiveController::class, 'organisationMembers'])->name('search.organisation-member');

Route::get('/search/type/{entity_type}', [ListController::class, 'index'])->name('search-list');
Route::get('/search/{map}/map_groups', [MapGroupController::class, 'index'])->name('map-groups-list');
Route::get('/search/type/{entity_type}/templates', [TemplateController::class, 'index'])->name('search.templates');

Route::get('/search/live', [LiveController::class, 'index'])->name('search.live');
Route::get('/search/recent', [RecentController::class, 'index'])->name('search.recent');
Route::get('/search/command', [CommandController::class, 'index'])->name('search.command');
Route::post('/search/log/{entity}', [LogController::class, 'store'])->name('search.log');

Route::get('/search/fulltext', [FullTextController::class, 'index'])->name('search.fulltext');

Route::get('/search/mention', [MentionController::class, 'index'])->name('search.mention');
Route::post('/search/mention', [MentionController::class, 'load'])->name('search.mention.load');
