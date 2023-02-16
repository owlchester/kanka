<?php

Route::get('/', 'DashboardController@index')->name('dashboard');

// Trees
Route::get('/abilities/tree', 'AbilityController@tree')->name('abilities.tree');
Route::get('/maps/tree', 'Maps\MapController@tree')->name('maps.tree');
Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
Route::get('/organisations/tree', 'OrganisationController@tree')->name('organisations.tree');
Route::get('/families/tree', 'FamilyController@tree')->name('families.tree');
Route::get('/items/tree', 'ItemController@tree')->name('items.tree');
Route::get('/quests/tree', 'QuestController@tree')->name('quests.tree');
Route::get('/races/tree', 'RaceController@tree')->name('races.tree');
Route::get('/creatures/tree', 'CreatureController@tree')->name('creatures.tree');
Route::get('/events/tree', 'EventController@tree')->name('events.tree');
Route::get('/timelines/tree', 'Timelines\TimelineController@tree')->name('timelines.tree');
Route::get('/tags/tree', 'TagController@tree')->name('tags.tree');
Route::get('/notes/tree', 'NoteController@tree')->name('notes.tree');
Route::get('/journals/tree', 'JournalController@tree')->name('journals.tree');
Route::get('/calendars/tree', 'CalendarController@tree')->name('calendars.tree');



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

    'attribute_templates' => 'AttributeTemplateController',
    //'presets' => 'PresetController',
]);
