<?php

use \App\Http\Controllers\CalendarController;
use \App\Http\Controllers\Maps\MapController;
use \App\Http\Controllers\Maps\MapGroupController;
use \App\Http\Controllers\Maps\MapLayerController;
use \App\Http\Controllers\Maps\MapMarkerController;

Route::get('/quick-links/{menu_link}/random', [\App\Http\Controllers\MenuLinkController::class, 'random'])->name('quick-links.random');
Route::get('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'reorder'])->name('quick-links.reorder');
Route::post('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'save'])->name('quick-links.reorder-save');

Route::get('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'index'])->name('timelines.reorder');
Route::post('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'save'])->name('timelines.reorder-save');

Route::post('/timelines/{timeline}/eras/bulk', [\App\Http\Controllers\Timelines\TimelineEraController::class, 'bulk'])->name('timelines.eras.bulk');


// Tags Quick Add
Route::get('/tags/{tag}/entity-add', [\App\Http\Controllers\TagController::class, 'entityAdd'])->name('tags.entity-add');
Route::post('/tags/{tag}/entity-add', [\App\Http\Controllers\TagController::class, 'entityStore'])->name('tags.entity-add.save');

Route::get('/abilities/{ability}/entity-add', [\App\Http\Controllers\AbilityController::class, 'entityAdd'])->name('abilities.entity-add');
Route::post('/abilities/{ability}/entity-add', [\App\Http\Controllers\AbilityController::class, 'entityStore'])->name('abilities.entity-add.save');


Route::get('/dice_rolls/{dice_roll}/roll', [\App\Http\Controllers\DiceRollController::class, 'roll'])->name('dice_rolls.roll');
Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', [\App\Http\Controllers\DiceRollController::class, 'destroyRoll'])->name('dice_rolls.destroy_roll');

// Calendars
Route::get('/calendars/{calendar}/event', [CalendarController::class, 'event'])->name('calendars.event.create');
Route::post('/calendars/{calendar}/event', [CalendarController::class, 'eventStore'])->name('calendars.event.store');
Route::get('/calendars/{calendar}/month-list', [CalendarController::class, 'monthList'])->name('calendars.month-list');
Route::get('/calendars/{calendar}/events', [CalendarController::class, 'events'])->name('calendars.events');
Route::get('/calendars/{calendar}/today', [CalendarController::class, 'today'])->name('calendars.today');

// Maps
Route::get('/maps/{map}/explore', [MapController::class, 'explore'])->name('maps.explore');
Route::get('/maps/{map}/chunks/', [MapController::class, 'chunks'])->name('maps.chunks');
Route::get('/maps/{map}/ticker', [MapController::class, 'ticket'])->name('maps.ticker');

Route::post('/maps/{map}/groups/bulk', [MapGroupController::class, 'bulk'])->name('maps.groups.bulk');
Route::post('/maps/{map}/groups/reorder', [MapGroupController::class, 'reorder'])->name('maps.groups.reorder-save');

Route::post('/maps/{map}/layers/bulk', [MapLayerController::class, 'bulk'])->name('maps.layers.bulk');
Route::post('/maps/{map}/layers/reorder', [MapLayerController::class, 'reorder'])->name('maps.layers.reorder-save');

Route::post('/maps/{map}/markers/bulk', [MapMarkerController::class, 'bulk'])->name('maps.markers.bulk');

// Misc subpages
Route::get('/tags/{tag}/tags', [\App\Http\Controllers\TagController::class, 'tags'])->name('tags.tags');
Route::get('/tags/{tag}/children', [\App\Http\Controllers\TagController::class, 'children'])->name('tags.children');

Route::get('/items/{item}/inventories', 'ItemController@inventories')->name('items.inventories');
Route::get('/items/{item}/items', 'ItemController@items')->name('items.items');
Route::get('/races/{race}/characters', 'RaceController@characters')->name('races.characters');

Route::get('/families/{family}/members', 'FamilyController@members')->name('families.members');

Route::get('/organisations/{organisation}/members', 'OrganisationSubController@members')->name('organisations.members');
//Route::get('/organisations/{organisation}/organisations', 'OrganisationSubController@organisations')->name('organisations.organisations');

Route::get('/characters/{character}/organisations', 'CharacterSubController@organisations')->name('characters.organisations');

Route::get('/locations/{location}/characters', 'LocationSubController@characters')->name('locations.characters');

Route::get('/maps/{map}/{map_marker}/details', 'Maps\MapMarkerController@details')->name('maps.markers.details');
Route::post('/maps/{map}/{map_marker}/move', 'Maps\MapMarkerController@move')->name('maps.markers.move');

//Route::get('/abilities/{ability}/abilities', 'AbilitySubController@abilities')->name('abilities.abilities');
Route::get('/abilities/{ability}/entities', 'AbilitySubController@entities')->name('abilities.entities');

// Trees
Route::get('/abilities/tree', 'AbilityController@tree')->name('abilities.tree');
Route::get('/calendars/tree', 'CalendarController@tree')->name('calendars.tree');
Route::get('/creatures/tree', 'CreatureController@tree')->name('creatures.tree');
Route::get('/events/tree', 'EventController@tree')->name('events.tree');
Route::get('/families/tree', 'FamilyController@tree')->name('families.tree');
Route::get('/journals/tree', 'JournalController@tree')->name('journals.tree');
Route::get('/items/tree', 'ItemController@tree')->name('items.tree');
Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
Route::get('/maps/tree', 'Maps\MapController@tree')->name('maps.tree');
Route::get('/notes/tree', 'NoteController@tree')->name('notes.tree');
Route::get('/organisations/tree', 'OrganisationController@tree')->name('organisations.tree');
Route::get('/quests/tree', 'QuestController@tree')->name('quests.tree');
Route::get('/races/tree', 'RaceController@tree')->name('races.tree');
Route::get('/tags/tree', 'TagController@tree')->name('tags.tree');
Route::get('/timelines/tree', 'Timelines\TimelineController@tree')->name('timelines.tree');

Route::resources([
    'attribute_templates' => 'AttributeTemplateController',
    'menu_links' => 'MenuLinkController',
    'relations' => 'RelationController',

    'abilities' => 'AbilityController',
    'calendars' => 'CalendarController',
    'calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    'characters' => 'CharacterController',
    'characters.character_organisations' => 'CharacterOrganisationController',
    'conversations' => 'ConversationController',
    'conversations.conversation_participants' => 'ConversationParticipantController',
    'conversations.conversation_messages' => 'ConversationMessageController',
    'creatures' => 'CreatureController',
    'dice_rolls' => 'DiceRollController',
    'dice_roll_results' => 'DiceRollResultController',
    'events' => 'EventController',
    'families' => 'FamilyController',
    'items' => 'ItemController',
    'journals' => 'JournalController',
    'locations' => 'LocationController',
    'maps' => 'Maps\MapController',
    'maps.map_layers' => 'Maps\MapLayerController',
    'maps.map_groups' => 'Maps\MapGroupController',
    'maps.map_markers' => 'Maps\MapMarkerController',
    'notes' => 'NoteController',
    'organisations' => 'OrganisationController',
    'organisations.organisation_members' => 'OrganisationMemberController',
    'quests' => 'QuestController',
    'quests.quest_elements' => 'QuestElementController',
    'races' => 'RaceController',
    'tags' => 'TagController',
    'timelines' => 'Timelines\TimelineController',
    'timelines.timeline_eras' => 'Timelines\TimelineEraController',
    'timelines.timeline_elements' => 'Timelines\TimelineElementController',
]);
