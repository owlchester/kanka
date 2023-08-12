<?php

use Illuminate\Support\Facades\Route;

// Abilities
Route::get('/w/{campaign}/abilities/{ability}/abilities', 'Abilities\AbilityController@index')->name('abilities.abilities');
Route::get('/w/{campaign}/abilities/{ability}/entities', 'Abilities\EntityController@index')->name('abilities.entities');
Route::get('/w/{campaign}/abilities/tree', 'Crud\AbilityController@tree')->name('abilities.tree');

Route::get('/w/{campaign}/abilities/{ability}/entity-add', 'Abilities\EntityController@create')->name('abilities.entity-add');
Route::post('/w/{campaign}/abilities/{ability}/entity-add', 'Abilities\EntityController@store')->name('abilities.entity-add.save');

//Ability reorder
Route::get('/w/{campaign}/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\Abilities\ReorderController::class, 'index'])
    ->name('entities.entity_abilities.reorder');
Route::post('/w/{campaign}/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\Abilities\ReorderController::class, 'save'])
    ->name('entities.entity_abilities.reorder-save');

// Maps
Route::get('/w/{campaign}/maps/{map}/maps', 'Maps\MapController@index')->name('maps.maps');
Route::get('/w/{campaign}/maps/{map}/explore', 'Maps\ExploreController@index')->name('maps.explore');
Route::get('/w/{campaign}/maps/{map}/chunks/', 'Maps\ExploreController@chunks')->name('maps.chunks');
Route::get('/w/{campaign}/maps/{map}/ticker', 'Maps\ExploreController@ticker')->name('maps.ticker');
Route::get('/w/{campaign}/maps/{map}/{map_marker}/details', 'Maps\Markers\DetailController@index')->name('maps.markers.details');
Route::post('/w/{campaign}/maps/{map}/{map_marker}/move', 'Maps\Markers\MoveController@index')->name('maps.markers.move');
Route::get('/w/{campaign}/maps/tree', 'Crud\MapController@tree')->name('maps.tree');
Route::post('/w/{campaign}/maps/{map}/groups/bulk', 'Maps\Bulks\GroupController@index')->name('maps.groups.bulk');
Route::post('/w/{campaign}/maps/{map}/groups/reorder', 'Maps\Reorders\GroupController@index')->name('maps.groups.reorder-save');

Route::post('/w/{campaign}/maps/{map}/layers/bulk', 'Maps\Bulks\LayerController@index')->name('maps.layers.bulk');
Route::post('/w/{campaign}/maps/{map}/layers/reorder', 'Maps\Reorders\LayerController@index')->name('maps.layers.reorder-save');

Route::post('/w/{campaign}/maps/{map}/markers/bulk', 'Maps\Bulks\MarkerController@index')->name('maps.markers.bulk');

// Character
Route::get('/w/{campaign}/characters/{character}/organisations', 'Characters\OrganisationController@index')->name('characters.organisations');

Route::get('/w/{campaign}/dice_rolls/{dice_roll}/roll', 'Crud\DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/w/{campaign}/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'Crud\DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');

// Locations
Route::get('/w/{campaign}/locations/tree', 'Crud\LocationController@tree')->name('locations.tree');
Route::get('/w/{campaign}/locations/{location}/characters', 'Locations\CharacterController@index')->name('locations.characters');
Route::get('/w/{campaign}/locations/{location}/locations', 'Locations\LocationController@index')->name('locations.locations');

// Organisation menu
Route::get('/w/{campaign}/organisations/{organisation}/members', 'Organisation\MemberController@index')->name('organisations.members');
Route::get('/w/{campaign}/organisations/{organisation}/organisations', 'Organisation\OrganisationController@organisations')->name('organisations.organisations');
Route::get('/w/{campaign}/organisations/tree', 'Crud\OrganisationController@tree')->name('organisations.tree');

// Families menu
Route::get('/w/{campaign}/families/{family}/members', 'Families\MemberController@index')->name('families.members');
Route::get('/w/{campaign}/families/{family}/families', 'Families\FamilyController@index')->name('families.families');
Route::get('/w/{campaign}/families/tree', 'Crud\FamilyController@tree')->name('families.tree');
Route::get('/w/{campaign}/families/{family}/tree', [\App\Http\Controllers\Families\TreeController::class, 'index'])->name('families.family-tree');
Route::get('/w/{campaign}/families/{family}/tree/api', [\App\Http\Controllers\Families\Trees\ApiController::class, 'index'])->name('families.family-tree.api');
Route::get('/w/{campaign}/families/{entity}/tree/entity-api', [\App\Http\Controllers\Families\Trees\ApiController::class, 'entity'])->name('families.family-tree.entity-api');
Route::post('/w/{campaign}/families/{family}/tree/api', [\App\Http\Controllers\Families\Trees\ApiController::class, 'save'])->name('families.family-tree.api-save');

Route::post('/w/{campaign}/families/{family}/store-member', 'Families\MemberController@store')->name('families.members.store');
Route::get('/w/{campaign}/families/{family}/add-member', 'Families\MemberController@create')->name('families.members.create');

// Items menu
Route::get('/w/{campaign}/items/{item}/inventories', 'Items\EntityController@index')->name('items.inventories');
Route::get('/w/{campaign}/items/tree', 'Crud\ItemController@tree')->name('items.tree');
Route::get('/w/{campaign}/items/{item}/items', 'Items\ItemController@index')->name('items.items');

// Quest menus
Route::get('/w/{campaign}/quests/tree', 'Crud\QuestController@tree')->name('quests.tree');
Route::get('/w/{campaign}/quests/{quest}/quests', 'Crud\QuestController@quests')->name('quests.quests');

// Races
Route::get('/w/{campaign}/races/{race}/characters', 'Races\MemberController@index')->name('races.characters');
Route::get('/w/{campaign}/races/{race}/races', 'Races\RaceController@index')->name('races.races');
Route::get('/w/{campaign}/races/tree', 'Crud\RaceController@tree')->name('races.tree');
Route::get('/w/{campaign}/races/{race}/member', 'Races\MemberController@create')->name('races.members.create');
Route::post('/w/{campaign}/races/{race}/member', 'Races\MemberController@store')->name('races.members.store');

// Creatures
Route::get('/w/{campaign}/creatures/{creature}/creatures', 'Creatures\CreatureController@index')->name('creatures.creatures');
Route::get('/w/{campaign}/creatures/tree', 'Crud\CreatureController@tree')->name('creatures.tree');

// Journal
Route::get('/w/{campaign}/journals/{journal}/journals', 'Journals\JournalController@index')->name('journals.journals');

Route::get('/w/{campaign}/events/tree', 'Crud\EventController@tree')->name('events.tree');
Route::get('/w/{campaign}/events/{event}/events', 'Events\EventController@index')->name('events.events');

Route::get('/w/{campaign}/timelines/tree', 'Crud\TimelineController@tree')->name('timelines.tree');
Route::get('/w/{campaign}/timelines/{timeline}/timelines', 'Timelines\TimelineController@index')->name('timelines.timelines');

// Tag menus
Route::get('/w/{campaign}/tags/tree', 'Crud\TagController@tree')->name('tags.tree');
Route::get('/w/{campaign}/tags/{tag}/tags', 'Tags\TagController@index')->name('tags.tags');
Route::get('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@index')->name('tags.transfer');
Route::post('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@process')->name('tags.transfer');

// Tags Quick Add
Route::get('/w/{campaign}/tags/{tag}/children', 'Tags\ChildController@index')->name('tags.children');
Route::get('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@create')->name('tags.entity-add');
Route::post('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@store')->name('tags.entity-add.save');

// Multi-delete for cruds
Route::post('/w/{campaign}/bulk/process', 'BulkController@index')->name('bulk.process');
Route::get('/w/{campaign}/bulk/modal', 'BulkController@modal')->name('bulk.modal');

Route::get('/w/{campaign}/notes/tree', 'Crud\NoteController@tree')->name('notes.tree');
Route::get('/w/{campaign}/journals/tree', 'Crud\JournalController@tree')->name('journals.tree');


// Calendar
Route::get('/w/{campaign}/calendars/tree', 'Crud\CalendarController@tree')->name('calendars.tree');
Route::get('/w/{campaign}/calendars/{calendar}/event', 'Calendars\EventController@create')->name('calendars.event.create');
Route::post('/w/{campaign}/calendars/{calendar}/event', 'Calendars\EventController@store')->name('calendars.event.store');
Route::get('/w/{campaign}/calendars/{calendar}/month-list', 'Crud\CalendarController@monthList')->name('calendars.month-list');
Route::get('/w/{campaign}/calendars/{calendar}/events', 'Calendars\EventController@index')->name('calendars.events');
Route::get('/w/{campaign}/calendars/{calendar}/today', 'Crud\CalendarController@today')->name('calendars.today');
Route::get('/w/{campaign}/calendars/{calendar}/validate-length', [\App\Http\Controllers\CalendarController::class, 'eventLength'])->name('calendars.event-length');

//        Route::get('/w/{campaign}/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/w/{campaign}/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');

// Attribute multi-save
Route::get('/w/{campaign}/entities/{entity}/attributes', [\App\Http\Controllers\Entity\AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/w/{campaign}/entities/{entity}/attributes-dashboard', [\App\Http\Controllers\Entity\AttributeController::class, 'dashboard'])->name('entities.attributes-dashboard');
Route::get('/w/{campaign}/entities/{entity}/attributes/edit', [\App\Http\Controllers\Entity\AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/w/{campaign}/entities/{entity}/attributes/save', [\App\Http\Controllers\Entity\AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/w/{campaign}/entities/{entity}/attributes/live-edit/', [\App\Http\Controllers\Entity\AttributeController::class, 'liveEdit'])
    ->name('entities.attributes.live.edit');
Route::post('/w/{campaign}/entities/{entity}/attributes/live-edit/{attribute}/save', [\App\Http\Controllers\Entity\AttributeController::class, 'liveSave'])
    ->name('entities.attributes.live.save');

Route::model('attribute', \App\Models\Attribute::class);


Route::get('/w/{campaign}/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/w/{campaign}/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/w/{campaign}/entities/{entity}/story-more', [\App\Http\Controllers\Entity\StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/w/{campaign}/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/w/{campaign}/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'saveFocus'])->name('entities.image.save-focus');

Route::get('/w/{campaign}/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/w/{campaign}/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/w/{campaign}/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/w/{campaign}/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');
//Route::post('/w/{campaign}/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');


// Entity update entry
Route::get('/w/{campaign}/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/w/{campaign}/entities/{entity}/relations_map', 'Entity\Connections\MapController@index')->name('entities.relations_map');
Route::get('/w/{campaign}/entities/{entity}/relations/table', 'Entity\Connections\TableController@index')->name('entities.relations_table');

// Entity
Route::post('/w/{campaign}/entities/{entity}/confirm-editing', 'EditingController@confirm')->name('entities.confirm-editing');
Route::post('/w/{campaign}/entities/{entity}/keep-alive', 'EditingController@keepAlive')->name('entities.keep-alive');

// Posts
Route::post('/w/{campaign}/editing/posts/{entity}/{post}/confirm-editing', 'EditingController@confirmPost')->name('posts.confirm-editing');
Route::post('/w/{campaign}/editing/posts/{entity}/{post}/keep-alive', 'EditingController@keepAlivePost')->name('posts.keep-alive');

// Quest Elements
Route::post('/w/{campaign}/editing/quest-elements/{quest_element}/confirm-editing', 'EditingController@confirmQuestElement')->name('quest-elements.confirm-editing');
Route::post('/w/{campaign}/editing/quest-elements/{quest_element}/keep-alive', 'EditingController@keepAliveQuestElement')->name('quest-elements.keep-alive');

// Timeline Elements
Route::post('/w/{campaign}/editing/timeline-elements/{timeline_element}/confirm-editing', 'EditingController@confirmTimelineElement')->name('timeline-elements.confirm-editing');
Route::post('/w/{campaign}/editing/timeline-elements/{timeline_element}/keep-alive', 'EditingController@keepAliveTimelineElement')->name('timeline-elements.keep-alive');
Route::get('/w/{campaign}/timeline/{timeline}/era/{timeline_era}/list', 'Timelines\TimelineEraController@positionList')->name('timelines.era-list');


Route::get('/w/{campaign}/menu_links/{menu_link}/random', 'QuickLink\RandomController@index')
    ->name('menu_links.random');

Route::get('/w/{campaign}/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'index'])
    ->name('timelines.reorder');
Route::post('/w/{campaign}/timelines/{timeline}/reorder', [\App\Http\Controllers\Timelines\TimelineReorderController::class, 'save'])
    ->name('timelines.reorder-save');
Route::post('/w/{campaign}/timelines/{timeline}/eras/bulk', 'Timelines\TimelineEraController@bulk')->name('timelines.eras.bulk');

Route::get('/w/{campaign}/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'reorder'])
    ->name('quick-links.reorder');
Route::post('/w/{campaign}/quick-links/reorder', [\App\Http\Controllers\QuickLinkController::class, 'save'])
    ->name('quick-links.reorder-save');

// Entity Abilities API
Route::get('/w/{campaign}/entities/{entity}/abilities', 'Entity\AbilityController@index')->name('entities.abilities');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/api', 'Entity\Abilities\ApiController@index')->name('entities.entity_abilities.api');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/import', 'Entity\Abilities\ImportController@index')->name('entities.entity_abilities.import');
Route::post('/w/{campaign}/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\Abilities\ChargeController@use')->name('entities.entity_abilities.use');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/reset', 'Entity\Abilities\ChargeController@reset')->name('entities.entity_abilities.reset');

Route::get('/w/{campaign}/entities/{entity}/entity_assets/{entity_asset}/go', 'Entity\AssetController@go')->name('entities.entity_assets.go');

Route::get('/w/{campaign}/entities/{entity}/profile', 'Entity\ProfileController@index')
    ->name('entities.profile');

//Route::get('/w/{campaign}/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    '/w/{campaign}/abilities' => 'Crud\AbilityController',
    '/w/{campaign}/calendars' => 'Crud\CalendarController',
    '/w/{campaign}/calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    '/w/{campaign}/characters' => 'Crud\CharacterController',
    '/w/{campaign}/characters.character_organisations' => 'CharacterOrganisationController',
    '/w/{campaign}/conversations' => 'Crud\ConversationController',
    '/w/{campaign}/conversations.conversation_participants' => 'ConversationParticipantController',
    '/w/{campaign}/conversations.conversation_messages' => 'ConversationMessageController',
    '/w/{campaign}/dice_rolls' => 'Crud\DiceRollController',
    '/w/{campaign}/dice_roll_results' => 'Crud\DiceRollResultController',
    '/w/{campaign}/events' => 'Crud\EventController',
    '/w/{campaign}/locations' => 'Crud\LocationController',
    '/w/{campaign}/families' => 'Crud\FamilyController',
    '/w/{campaign}/items' => 'Crud\ItemController',
    '/w/{campaign}/journals' => 'Crud\JournalController',
    '/w/{campaign}/maps' => 'Crud\MapController',
    '/w/{campaign}/maps.map_layers' => 'Maps\LayerController',
    '/w/{campaign}/maps.map_groups' => 'Maps\GroupController',
    '/w/{campaign}/maps.map_markers' => 'Maps\MarkerController',
    '/w/{campaign}/menu_links' => 'Crud\MenuLinkController',
    '/w/{campaign}/organisations' => 'Crud\OrganisationController',
    '/w/{campaign}/organisations.organisation_members' => 'Organisation\MemberController',
    '/w/{campaign}/notes' => 'Crud\NoteController',
    '/w/{campaign}/quests' => 'Crud\QuestController',
    '/w/{campaign}/quests.quest_elements' => 'Quest\ElementController',
    '/w/{campaign}/tags' => 'Crud\TagController',
    '/w/{campaign}/timelines' => 'Crud\TimelineController',
    '/w/{campaign}/timelines.timeline_eras' => 'Timelines\TimelineEraController',
    '/w/{campaign}/timelines.timeline_elements' => 'Timelines\TimelineElementController',
    '/w/{campaign}/races' => 'Crud\RaceController',
    '/w/{campaign}/creatures' => 'Crud\CreatureController',
    '/w/{campaign}/relations' => 'RelationController',

    // Entities
    //'entities.attributes' => 'AttributeController',
    '/w/{campaign}/entities.entity_abilities' => 'Entity\AbilityController',
    '/w/{campaign}/entities.posts' => 'Entity\PostController',
    '/w/{campaign}/entities.entity_events' => 'Entity\ReminderController',
    '/w/{campaign}/entities.entity_assets' => 'Entity\AssetController',
    '/w/{campaign}/entities.inventories' => 'Entity\InventoryController',
    '/w/{campaign}/entities.relations' => 'Entity\RelationController',

    '/w/{campaign}/attribute_templates' => 'Crud\AttributeTemplateController',
    //'presets' => 'PresetController',
]);

Route::get('/w/{campaign}/redirect', 'RedirectController@index')->name('redirect');

// Move
Route::get('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@index')->name('entities.move');
Route::post('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@move')->name('entities.move');
Route::get('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@index')->name('posts.move');
Route::post('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@move')->name('posts.move');

// Transform
Route::get('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@index')->name('entities.transform');
Route::post('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@transform')->name('entities.transform');

Route::get('/w/{campaign}/entities/{entity}/tooltip', 'Entity\TooltipController@show')->name('entities.tooltip');


// Entity files
Route::get('/w/{campaign}/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
Route::get('/w/{campaign}/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');

// Inventory
Route::get('/w/{campaign}/entities/{entity}/inventory', 'Entity\InventoryController@index')->name('entities.inventory');

// Export
Route::get('/w/{campaign}/entities/{entity}/html-export', 'Entity\ExportController@html')->name('entities.html-export');
Route::get('/w/{campaign}/entities/{entity}/json-export', 'Entity\ExportController@json')->name('entities.json-export');

Route::get('/w/{campaign}/entities/{entity}/template', 'Entity\TemplateController@update')->name('entities.template');

// Attribute template
Route::get('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@index')->name('entities.attributes.template');
Route::post('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@process')->name('entities.attributes.template');

Route::get('/w/{campaign}/entities/{entity}/permissions', 'Entity\PermissionController@view')->name('entities.permissions');
Route::post('/w/{campaign}/entities/{entity}/permissions', 'Entity\PermissionController@store')->name('entities.permissions');


Route::get('/w/{campaign}/entities/{entity}/preview', 'Entity\PreviewController@index')->name('entities.preview');

// Entity quick creator
Route::get('/w/{campaign}/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/w/{campaign}/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::post('/w/{campaign}/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');
