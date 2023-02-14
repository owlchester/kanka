<?php

Route::get('/', 'DashboardController@index')->name('dashboard');

// Abilities
Route::get('/abilities/{ability}/abilities', 'AbilityController@abilities')->name('abilities.abilities');
Route::get('/abilities/{ability}/entities', 'AbilityController@entities')->name('abilities.entities');
Route::get('/abilities/tree', 'AbilityController@tree')->name('abilities.tree');

Route::get('/abilities/{ability}/entity-add', 'AbilityController@entityAdd')->name('abilities.entity-add');
Route::post('/abilities/{ability}/entity-add', 'AbilityController@entityStore')->name('abilities.entity-add.save');


// Maps
Route::get('/maps/{map}/maps', 'Maps\MapController@maps')->name('maps.maps');
Route::get('/maps/{map}/explore', 'Maps\MapController@explore')->name('maps.explore');
Route::get('/maps/{map}/chunks/', 'Maps\MapController@chunks')->name('maps.chunks');
Route::get('/maps/{map}/ticker', 'Maps\MapController@ticker')->name('maps.ticker');
Route::get('/maps/{map}/{map_marker}/details', 'Maps\MapMarkerController@details')->name('maps.markers.details');
Route::post('/maps/{map}/{map_marker}/move', 'Maps\MapMarkerController@move')->name('maps.markers.move');
Route::get('/maps/tree', 'Maps\MapController@tree')->name('maps.tree');
//Route::get('/maps/{map}/map-points', 'Maps\MapController@mapPoints')->name('maps.map-points');
Route::post('/maps/{map}/groups/bulk', 'Maps\MapGroupController@bulk')->name('maps.groups.bulk');
Route::post('/maps/{map}/groups/reorder', 'Maps\MapGroupController@reorder')->name('maps.groups.reorder-save');

Route::post('/maps/{map}/layers/bulk', 'Maps\MapLayerController@bulk')->name('maps.layers.bulk');
Route::post('/maps/{map}/layers/reorder', 'Maps\MapLayerController@reorder')->name('maps.layers.reorder-save');

Route::post('/maps/{map}/markers/bulk', 'Maps\MapMarkerController@bulk')->name('maps.markers.bulk');

// Character
Route::get('/characters/{character}/organisations', 'CharacterSubController@organisations')->name('characters.organisations');

Route::get('/dice_rolls/{dice_roll}/roll', 'DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');

// Locations
Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
Route::get('/locations/{location}/characters', 'LocationController@characters')->name('locations.characters');
Route::get('/locations/{location}/locations', 'LocationController@locations')->name('locations.locations');

// Organisation menu
Route::get('/organisations/{organisation}/members', 'OrganisationController@members')->name('organisations.members');
Route::get('/organisations/{organisation}/organisations', 'OrganisationController@organisations')->name('organisations.organisations');
Route::get('/organisations/tree', 'OrganisationController@tree')->name('organisations.tree');

// Families menu
Route::get('/families/{family}/members', 'FamilyController@members')->name('families.members');
Route::get('/families/{family}/families', 'FamilyController@families')->name('families.families');
Route::get('/families/tree', 'FamilyController@tree')->name('families.tree');

// Items menu
Route::get('/items/{item}/inventories', 'ItemController@inventories')->name('items.inventories');
Route::get('/items/tree', 'ItemController@tree')->name('items.tree');
Route::get('/items/{item}/items', 'ItemController@items')->name('items.items');

// Quest menus
Route::get('/quests/tree', 'QuestController@tree')->name('quests.tree');
Route::get('/quests/{quest}/quests', 'QuestController@quests')->name('quests.quests');

// Races
Route::get('/races/{race}/characters', 'RaceController@characters')->name('races.characters');
Route::get('/races/{race}/races', 'RaceController@races')->name('races.races');
Route::get('/races/tree', 'RaceController@tree')->name('races.tree');

// Creatures
Route::get('/creatures/{creature}/creatures', 'CreatureController@creatures')->name('creatures.creatures');
Route::get('/creatures/tree', 'CreatureController@tree')->name('creatures.tree');

// Journal
Route::get('/journals/{journal}/journals', 'JournalController@journals')->name('journals.journals');

Route::get('/events/tree', 'EventController@tree')->name('events.tree');
Route::get('/events/{event}/events', 'EventController@events')->name('events.events');

Route::get('/timelines/tree', 'Timelines\TimelineController@tree')->name('timelines.tree');
Route::get('/timelines/{timeline}/timelines', 'Timelines\TimelineController@timelines')->name('timelines.timelines');

// Tag menus
Route::get('/tags/tree', 'TagController@tree')->name('tags.tree');
Route::get('/tags/{tag}/tags', 'TagController@tags')->name('tags.tags');
Route::get('/tags/{tag}/children', 'TagController@children')->name('tags.children');

// Tags Quick Add
Route::get('/tags/{tag}/entity-add', 'TagController@entityAdd')->name('tags.entity-add');
Route::post('/tags/{tag}/entity-add', 'TagController@entityStore')->name('tags.entity-add.save');

// Multi-delete for cruds
Route::post('/bulk/process', 'BulkController@process')->name('bulk.process');
Route::get('/bulk/modal', 'BulkController@modal')->name('bulk.modal');

Route::get('/notes/tree', 'NoteController@tree')->name('notes.tree');
Route::get('/journals/tree', 'JournalController@tree')->name('journals.tree');


// Calendar
Route::get('/calendars/tree', 'CalendarController@tree')->name('calendars.tree');
Route::get('/calendars/{calendar}/event', 'CalendarController@event')->name('calendars.event.create');
Route::post('/calendars/{calendar}/event', 'CalendarController@eventStore')->name('calendars.event.store');
Route::get('/calendars/{calendar}/month-list', 'CalendarController@monthList')->name('calendars.month-list');
Route::get('/calendars/{calendar}/events', 'CalendarController@events')->name('calendars.events');
Route::get('/calendars/{calendar}/today', 'CalendarController@today')->name('calendars.today');

//        Route::get('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');



// Impersonator
Route::get('/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');




Route::get('/menu_links/{menu_link}/random', 'MenuLinkController@random')
    ->name('menu_links.random');

Route::get('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'index'])
    ->name('timelines.reorder');
Route::post('/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'save'])
    ->name('timelines.reorder-save');
Route::post('/timelines/{timeline}/eras/bulk', 'Timelines\TimelineEraController@bulk')->name('timelines.eras.bulk');

Route::get('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'reorder'])
    ->name('quick-links.reorder');
Route::post('/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'save'])
    ->name('quick-links.reorder-save');


Route::resources([
    'abilities' => 'AbilityController',
    'calendars' => 'CalendarController',
    'calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    'characters' => 'CharacterController',
    'characters.character_organisations' => 'CharacterOrganisationController',
    'conversations' => 'ConversationController',
    'conversations.conversation_participants' => 'ConversationParticipantController',
    'conversations.conversation_messages' => 'ConversationMessageController',
    'dice_rolls' => 'DiceRollController',
    'dice_roll_results' => 'DiceRollResultController',
    'events' => 'EventController',
    'locations' => 'LocationController',
    'families' => 'FamilyController',
    'items' => 'ItemController',
    'journals' => 'JournalController',
    'maps' => 'Maps\MapController',
    'maps.map_layers' => 'Maps\MapLayerController',
    'maps.map_groups' => 'Maps\MapGroupController',
    'maps.map_markers' => 'Maps\MapMarkerController',
    'menu_links' => 'MenuLinkController',
    'organisations' => 'OrganisationController',
    'organisations.organisation_members' => 'OrganisationMemberController',
    'notes' => 'NoteController',
    'quests' => 'QuestController',
    'quests.quest_elements' => 'QuestElementController',
    'tags' => 'TagController',
    'timelines' => 'Timelines\TimelineController',
    'timelines.timeline_eras' => 'Timelines\TimelineEraController',
    'timelines.timeline_elements' => 'Timelines\TimelineElementController',
    'races' => 'RaceController',
    'creatures' => 'CreatureController',
    'relations' => 'RelationController',

    'entities.entity_abilities' => 'Entity\AbilityController',
    'entities.entity_notes' => 'EntityNoteController',
    'entities.posts' => 'Entity\PostController',
    'entities.entity_events' => 'EntityEventController',
    'entities.entity_assets' => 'Entity\AssetController',
    'entities.inventories' => 'Entity\InventoryController',
    'entities.relations' => 'Entity\RelationController',

    'attribute_templates' => 'AttributeTemplateController',
    //'presets' => 'PresetController',

    'campaign_dashboards' => 'Campaign\DashboardController',

]);


Route::get('/search', 'SearchController@search')->name('search');

Route::get('/campaign.styles', 'CampaignController@css')->name('campaign.css');
Route::get('/campaign_plugin.styles', 'Campaign\PluginController@css')->name('campaign_plugins.css');

