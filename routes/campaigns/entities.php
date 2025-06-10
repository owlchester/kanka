<?php

use Illuminate\Support\Facades\Route;

Route::get('/w/{campaign}/entities/{entity}', [App\Http\Controllers\Entity\ShowController::class, 'index'])->name('entities.show')->where(['entity' => '[0-9]+']);

Route::get('/w/{campaign}/entities/{entity}-{slug}', [App\Http\Controllers\Entity\ShowController::class, 'index'])->name('entities.show-slug');

Route::get('/w/{campaign}/t/{entityType}', [App\Http\Controllers\Entities\IndexController::class, 'index'])->name('entities.index');
Route::get('/w/{campaign}/t/{entityType}/api', [App\Http\Controllers\Entities\IndexController::class, 'api'])->name('entities.index-api');
Route::get('/w/{campaign}/t/{entityType}/create', [App\Http\Controllers\Entities\CreateController::class, 'index'])->name('entities.create');
Route::post('/w/{campaign}/t/{entity_type}/create', [App\Http\Controllers\Entities\CreateController::class, 'store'])->name('entities.store');

Route::get('/w/{campaign}/entities/{entity}/edit', [App\Http\Controllers\Entities\EditController::class, 'index'])->name('entities.edit');
Route::patch('/w/{campaign}/entities/{entity}/save', [App\Http\Controllers\Entities\EditController::class, 'save'])->name('entities.update');
Route::delete('/w/{campaign}/entities/{entity}/delete', [App\Http\Controllers\Entities\DeleteController::class, 'index'])->name('entities.destroy');

Route::get('/w/{campaign}/entities/{entity}/children', [App\Http\Controllers\Entities\ChildrenController::class, 'index'])->name('entities.children');

// Abilities
Route::get('/w/{campaign}/abilities/{ability}/abilities', 'Abilities\AbilityController@index')->name('abilities.abilities');
Route::get('/w/{campaign}/abilities/{ability}/entities', 'Abilities\EntityController@index')->name('abilities.entities');

Route::get('/w/{campaign}/abilities/{ability}/entity-add', 'Abilities\EntityController@create')->name('abilities.entity-add');
Route::post('/w/{campaign}/abilities/{ability}/entity-add', 'Abilities\EntityController@store')->name('abilities.entity-add.save');

// Ability reorder
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/reorder', [App\Http\Controllers\Entity\Abilities\ReorderController::class, 'index'])
    ->name('entities.entity_abilities.reorder');
Route::post('/w/{campaign}/entities/{entity}/entity_abilities/reorder', [App\Http\Controllers\Entity\Abilities\ReorderController::class, 'save'])
    ->name('entities.entity_abilities.reorder-save');

// Maps
Route::get('/w/{campaign}/maps/{map}/maps', 'Maps\MapController@index')->name('maps.maps');
Route::get('/w/{campaign}/maps/{map}/explore', 'Maps\ExploreController@index')->name('maps.explore');
Route::get('/w/{campaign}/maps/{map}/chunks/', 'Maps\ExploreController@chunks')->name('maps.chunks');
Route::get('/w/{campaign}/maps/{map}/ticker', 'Maps\ExploreController@ticker')->name('maps.ticker');
Route::get('/w/{campaign}/maps/{map}/preview', 'Maps\PreviewController@index')->name('maps.preview');
Route::get('/w/{campaign}/maps/{map}/{map_marker}/details', 'Maps\Markers\DetailController@index')->name('maps.markers.details');
Route::post('/w/{campaign}/maps/{map}/{map_marker}/move', 'Maps\Markers\MoveController@index')->name('maps.markers.move');
Route::post('/w/{campaign}/maps/{map}/groups/bulk', 'Maps\Bulks\GroupController@index')->name('maps.groups.bulk');
Route::post('/w/{campaign}/maps/{map}/groups/reorder', 'Maps\Reorders\GroupController@index')->name('maps.groups.reorder-save');

Route::post('/w/{campaign}/maps/{map}/layers/bulk', 'Maps\Bulks\LayerController@index')->name('maps.layers.bulk');
Route::post('/w/{campaign}/maps/{map}/layers/reorder', 'Maps\Reorders\LayerController@index')->name('maps.layers.reorder-save');
Route::post('/w/{campaign}/maps/{map}/layers/{map_layer}/migrate', 'Maps\Layers\MigrateController@index')->name('maps.layers.migrate');

Route::post('/w/{campaign}/maps/{map}/markers/bulk', 'Maps\Bulks\MarkerController@index')->name('maps.markers.bulk');

// Character
Route::get('/w/{campaign}/characters/{character}/organisations', 'Characters\OrganisationController@index')->name('characters.organisations');
Route::get('/w/{campaign}/characters/{character}/races/management', 'Characters\Races\ManagementController@index')->name('characters.races.management');
Route::post('/w/{campaign}/characters/{character}/races/save', 'Characters\Races\ManagementController@save')->name('characters.races.save');
Route::get('/w/{campaign}/characters/{character}/families/management', 'Characters\Families\ManagementController@index')->name('characters.families.management');
Route::post('/w/{campaign}/characters/{character}/families/save', 'Characters\Families\ManagementController@save')->name('characters.families.save');

Route::get('/w/{campaign}/dice_rolls/{dice_roll}/roll', 'Crud\DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/w/{campaign}/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'Crud\DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');
Route::get('/w/{campaign}/dice_rolls/results', [App\Http\Controllers\DiceRolls\ResultsController::class, 'index'])->name('dice_rolls.results');

// Locations
Route::get('/w/{campaign}/locations/{location}/characters', 'Locations\CharacterController@index')->name('locations.characters');
Route::get('/w/{campaign}/locations/{location}/locations', 'Locations\LocationController@index')->name('locations.locations');
Route::get('/w/{campaign}/locations/{location}/events', 'Locations\EventController@index')->name('locations.events');
Route::get('/w/{campaign}/locations/{location}/quests', 'Locations\QuestController@index')->name('locations.quests');

// Organisation menu
Route::get('/w/{campaign}/organisations/{organisation}/members', 'Organisation\MemberController@index')->name('organisations.members');
Route::get('/w/{campaign}/organisations/{organisation}/organisations', 'Organisation\OrganisationController@organisations')->name('organisations.organisations');

// Families menu
Route::get('/w/{campaign}/families/{family}/members', 'Families\MemberController@index')->name('families.members');
Route::get('/w/{campaign}/families/{family}/families', 'Families\FamilyController@index')->name('families.families');
Route::get('/w/{campaign}/families/{family}/tree', [App\Http\Controllers\Families\TreeController::class, 'index'])->name('families.family-tree');
Route::get('/w/{campaign}/families/{family}/tree/api', [App\Http\Controllers\Families\Trees\ApiController::class, 'index'])->name('families.family-tree.api');
Route::get('/w/{campaign}/families/{entity}/tree/entity-api', [App\Http\Controllers\Families\Trees\ApiController::class, 'entity'])->name('families.family-tree.entity-api');
Route::post('/w/{campaign}/families/{family}/tree/api', [App\Http\Controllers\Families\Trees\ApiController::class, 'save'])->name('families.family-tree.api-save');

Route::post('/w/{campaign}/families/{family}/store-member', 'Families\MemberController@store')->name('families.members.store');
Route::get('/w/{campaign}/families/{family}/add-member', 'Families\MemberController@create')->name('families.members.create');

// Items menu
Route::get('/w/{campaign}/items/{item}/inventories', 'Items\EntityController@index')->name('items.inventories');
Route::get('/w/{campaign}/items/{item}/items', 'Items\ItemController@index')->name('items.items');

// Quest menus
Route::get('/w/{campaign}/quests/{quest}/quests', 'Quests\QuestController@index')->name('quests.quests');

// Races
Route::get('/w/{campaign}/races/{race}/characters', 'Races\MemberController@index')->name('races.characters');
Route::get('/w/{campaign}/races/{race}/races', 'Races\RaceController@index')->name('races.races');
Route::get('/w/{campaign}/races/{race}/member', 'Races\MemberController@create')->name('races.members.create');
Route::post('/w/{campaign}/races/{race}/member', 'Races\MemberController@store')->name('races.members.store');

// Creatures
Route::get('/w/{campaign}/creatures/{creature}/creatures', 'Creatures\CreatureController@index')->name('creatures.creatures');

// Journal
Route::get('/w/{campaign}/journals/{journal}/journals', 'Journals\JournalController@index')->name('journals.journals');

Route::get('/w/{campaign}/events/{event}/events', 'Events\EventController@index')->name('events.events');

Route::get('/w/{campaign}/timelines/{timeline}/timelines', 'Timelines\TimelineController@index')->name('timelines.timelines');

// Tag menus
Route::get('/w/{campaign}/tags/{tag}/tags', 'Tags\TagController@index')->name('tags.tags');
Route::get('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@index')->name('tags.transfer');
Route::get('/w/{campaign}/tags/{tag}/transfer-posts', 'Tags\TransferController@postIndex')->name('tags.transfer.posts');
Route::post('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@process')->name('tags.transfer-process');
Route::post('/w/{campaign}/tags/{tag}/transfer-posts', 'Tags\TransferController@processPosts')->name('tags.transfer.posts-process');

// Tags Quick Add
Route::get('/w/{campaign}/tags/{tag}/children', 'Tags\ChildController@index')->name('tags.children');
Route::get('/w/{campaign}/tags/{tag}/posts', 'Tags\PostController@index')->name('tags.posts');
Route::get('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@create')->name('tags.entity-add');
Route::post('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@store')->name('tags.entity-add.save');

Route::get('/w/{campaign}/entities/{entity}/tags/add', 'Entity\TagController@create')->name('entity.tags-add');
Route::post('/w/{campaign}/entities/{entity}/tags/add', 'Entity\TagController@store')->name('entity.tags-add.save');

// Multi-delete for cruds
Route::post('/w/{campaign}/bulk/process', 'BulkController@index')->name('bulk.process');
Route::get('/w/{campaign}/bulk/modal', 'BulkController@modal')->name('bulk.modal');

// Calendar
Route::get('/w/{campaign}/calendars/{calendar}/event', 'Calendars\EventController@create')->name('calendars.event.create');
Route::post('/w/{campaign}/calendars/{calendar}/event', 'Calendars\EventController@store')->name('calendars.event.store');
Route::get('/w/{campaign}/calendars/{calendar}/month-list', 'Crud\CalendarController@monthList')->name('calendars.month-list');
Route::get('/w/{campaign}/calendars/{calendar}/events', 'Calendars\EventController@index')->name('calendars.events');
Route::get('/w/{campaign}/calendars/{calendar}/today', 'Crud\CalendarController@today')->name('calendars.today');
Route::get('/w/{campaign}/calendars/{calendar}/validate-length', [App\Http\Controllers\Calendars\EventController::class, 'eventLength'])->name('calendars.event-length');

Route::post('/w/{campaign}/calendars/{calendar}/calendar-events/bulk', 'Calendars\Bulks\EntityEventController@index')->name('calendars.entity-events.bulk');

//        Route::get('/w/{campaign}/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/w/{campaign}/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');

// Attribute multi-save
Route::get('/w/{campaign}/entities/{entity}/attributes', [App\Http\Controllers\Entity\AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/w/{campaign}/entities/{entity}/attributes-dashboard', [App\Http\Controllers\Entity\AttributeController::class, 'dashboard'])->name('entities.attributes-dashboard');
Route::get('/w/{campaign}/entities/{entity}/attributes/edit', [App\Http\Controllers\Entity\AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/w/{campaign}/entities/{entity}/attributes/save', [App\Http\Controllers\Entity\AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/w/{campaign}/entities/{entity}/attributes/live-edit/', [App\Http\Controllers\Entity\AttributeController::class, 'liveEdit'])
    ->name('entities.attributes.live.edit');
Route::get('/w/{campaign}/entities/{entity}/attributes/live-edit/{attribute}', [App\Http\Controllers\Entity\Attributes\LiveController::class, 'index'])
    ->name('entities.attributes.live.edit2');
Route::post('/w/{campaign}/entities/{entity}/attributes/live-edit/{attribute}/save', [App\Http\Controllers\Entity\Attributes\LiveController::class, 'save'])
    ->name('entities.attributes.live.save');

Route::get('/w/{campaign}/entities/{entity}/attributes/live-api', [App\Http\Controllers\Entity\Attributes\LiveApiController::class, 'index'])
    ->name('entities.attributes.live-api.index');
Route::post('/w/{campaign}/entities/{entity}/attributes/live-api', [App\Http\Controllers\Entity\Attributes\LiveApiController::class, 'store'])
    ->name('entities.attributes.live-api.create');
Route::post('/w/{campaign}/entities/{entity}/attributes/live-api/{attribute}', [App\Http\Controllers\Entity\Attributes\LiveApiController::class, 'update'])
    ->name('entities.attributes.live-api.update');
Route::post('/w/{campaign}/entities/{entity}/attributes/live-api/{attribute}/delete', [App\Http\Controllers\Entity\Attributes\LiveApiController::class, 'destroy'])
    ->name('entities.attributes.live-api.delete');

Route::model('attribute', App\Models\Attribute::class);

Route::get('/w/{campaign}/entities/{entity}/story-reorder', [App\Http\Controllers\Entity\StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/w/{campaign}/entities/{entity}/story-reorder', [App\Http\Controllers\Entity\StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/w/{campaign}/entities/{entity}/story-more', [App\Http\Controllers\Entity\StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/w/{campaign}/entities/{entity}/image-focus', [App\Http\Controllers\Entity\ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/w/{campaign}/entities/{entity}/image-focus', [App\Http\Controllers\Entity\ImageController::class, 'saveFocus'])->name('entities.image.save-focus');

Route::get('/w/{campaign}/entities/{entity}/image-replace', [App\Http\Controllers\Entity\ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/w/{campaign}/entities/{entity}/image-replace', [App\Http\Controllers\Entity\ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/w/{campaign}/entities/{entity}/privacy', [App\Http\Controllers\Entity\PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/w/{campaign}/entities/{entity}/privacy', [App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');
// Route::post('/w/{campaign}/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');

// Entity update entry
Route::get('/w/{campaign}/entities/{entity}/entry', [App\Http\Controllers\Entity\EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('w/{campaign}/entities/{entity}/entry', [App\Http\Controllers\Entity\EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/w/{campaign}/entities/{entity}/connection/map', 'Entity\Connections\MapController@index')->name('entities.relations_map');
Route::get('/w/{campaign}/entities/{entity}/connection/table', 'Entity\Connections\TableController@index')->name('entities.relations_table');

// Entity
Route::post('/w/{campaign}/entities/{entity}/confirm-editing', 'EditingController@confirm')->name('entities.confirm-editing');
Route::post('/w/{campaign}/entities/{entity}/keep-alive', 'EditingController@keepAlive')->name('entities.keep-alive');

// Posts
Route::post('/w/{campaign}/editing/posts/{entity}/{post}/confirm-editing', 'EditingController@confirmPost')->name('posts.confirm-editing');
Route::post('/w/{campaign}/editing/posts/{entity}/{post}/keep-alive', 'EditingController@keepAlivePost')->name('posts.keep-alive');
Route::get('/w/{campaign}/posts/{entity}/{post}/visibility', [App\Http\Controllers\Entity\Posts\VisibilityController::class, 'index'])->name('posts.edit.visibility');
Route::post('/w/{campaign}/posts/{entity}/{post}/visibility/update', [App\Http\Controllers\Entity\Posts\VisibilityController::class, 'update'])->name('posts.update.visibility');

// Quest Elements
Route::post('/w/{campaign}/editing/quest-elements/{quest_element}/confirm-editing', 'EditingController@confirmQuestElement')->name('quest-elements.confirm-editing');
Route::post('/w/{campaign}/editing/quest-elements/{quest_element}/keep-alive', 'EditingController@keepAliveQuestElement')->name('quest-elements.keep-alive');

// Timeline Elements
Route::post('/w/{campaign}/editing/timeline-elements/{timeline_element}/confirm-editing', 'EditingController@confirmTimelineElement')->name('timeline-elements.confirm-editing');
Route::post('/w/{campaign}/editing/timeline-elements/{timeline_element}/keep-alive', 'EditingController@keepAliveTimelineElement')->name('timeline-elements.keep-alive');
Route::get('/w/{campaign}/timeline/{timeline}/era/{timeline_era}/list', 'Timelines\TimelineEraController@positionList')->name('timelines.era-list');

Route::get('/w/{campaign}/bookmarks/{bookmark}/random', 'Bookmarks\RandomController@index')
    ->name('bookmarks.random');

Route::get('/w/{campaign}/timelines/{timeline}/reorder', [App\Http\Controllers\Timelines\TimelineReorderController::class, 'index'])
    ->name('timelines.reorder');
Route::post('/w/{campaign}/timelines/{timeline}/reorder', [App\Http\Controllers\Timelines\TimelineReorderController::class, 'save'])
    ->name('timelines.reorder-save');
Route::post('/w/{campaign}/timelines/{timeline}/eras/bulk', 'Timelines\TimelineEraController@bulk')->name('timelines.eras.bulk');

Route::get('/w/{campaign}/bookmarks/reorder', [App\Http\Controllers\Bookmarks\ReorderController::class, 'index'])
    ->name('bookmarks.reorder');
Route::post('/w/{campaign}/bookmarks/reorder', [App\Http\Controllers\Bookmarks\ReorderController::class, 'save'])
    ->name('bookmarks.reorder-save');
Route::get('/w/{campaign}/entity_types/{entity_type}/bookmark-form', [App\Http\Controllers\Filters\SaveController::class, 'render'])->name('filters.modal_form');

// Entity Abilities API
Route::get('/w/{campaign}/entities/{entity}/abilities', 'Entity\AbilityController@index')->name('entities.abilities');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/api', 'Entity\Abilities\ApiController@index')->name('entities.entity_abilities.api');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/import', 'Entity\Abilities\ImportController@index')->name('entities.entity_abilities.import');
Route::post('/w/{campaign}/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\Abilities\ChargeController@use')->name('entities.entity_abilities.use');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/reset', 'Entity\Abilities\ChargeController@reset')->name('entities.entity_abilities.reset');

Route::get('/w/{campaign}/entities/{entity}/entity_assets/{entity_asset}/go', 'Entity\AssetController@go')->name('entities.entity_assets.go');

Route::get('/w/{campaign}/entities/{entity}/profile', 'Entity\ProfileController@index')
    ->name('entities.profile');

Route::get('/w/{campaign}/entity_types/{entity_type}/filter-form', [App\Http\Controllers\Filters\FormController::class, 'index'])->name('filters.form');
Route::get('/w/{campaign}/connection/filter-form', [App\Http\Controllers\Filters\FormController::class, 'connection'])->name('filters.form-connection');

Route::get('/w/{campaign}/filters/{entity_type}/save', [App\Http\Controllers\Filters\SaveController::class, 'save'])->name('save-filters');

// Route::get('/w/{campaign}/my-campaigns', 'CampaignController@index')->name('campaign');
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
    '/w/{campaign}/events' => 'Crud\EventController',
    '/w/{campaign}/locations' => 'Crud\LocationController',
    '/w/{campaign}/families' => 'Crud\FamilyController',
    '/w/{campaign}/items' => 'Crud\ItemController',
    '/w/{campaign}/journals' => 'Crud\JournalController',
    '/w/{campaign}/maps' => 'Crud\MapController',
    '/w/{campaign}/maps.map_layers' => 'Maps\LayerController',
    '/w/{campaign}/maps.map_groups' => 'Maps\GroupController',
    '/w/{campaign}/maps.map_markers' => 'Maps\MarkerController',
    '/w/{campaign}/bookmarks' => 'Crud\BookmarkController',
    '/w/{campaign}/organisations' => 'Crud\OrganisationController',
    '/w/{campaign}/organisations.organisation_members' => 'Organisation\MemberController',
    '/w/{campaign}/notes' => 'Crud\NoteController',
    '/w/{campaign}/quests' => 'Crud\QuestController',
    '/w/{campaign}/quests.quest_elements' => 'Quests\ElementController',
    '/w/{campaign}/tags' => 'Crud\TagController',
    '/w/{campaign}/timelines' => 'Crud\TimelineController',
    '/w/{campaign}/timelines.timeline_eras' => 'Timelines\TimelineEraController',
    '/w/{campaign}/timelines.timeline_elements' => 'Timelines\TimelineElementController',
    '/w/{campaign}/races' => 'Crud\RaceController',
    '/w/{campaign}/creatures' => 'Crud\CreatureController',
    '/w/{campaign}/relations' => 'RelationController',

    // Entities
    // 'entities.attributes' => 'AttributeController',
    '/w/{campaign}/entities.entity_abilities' => 'Entity\AbilityController',
    '/w/{campaign}/entities.posts' => 'Entity\PostController',
    '/w/{campaign}/entities.reminders' => 'Entity\ReminderController',
    '/w/{campaign}/reminders' => 'Events\ReminderController',
    '/w/{campaign}/entities.entity_assets' => 'Entity\AssetController',
    '/w/{campaign}/entities.inventories' => 'Entity\InventoryController',
    '/w/{campaign}/entities.relations' => 'Entity\RelationController',

    '/w/{campaign}/attribute_templates' => 'Crud\AttributeTemplateController',
    // 'presets' => 'PresetController',
]);

Route::get('/w/{campaign}/redirect', 'RedirectController@index')->name('redirect');

// Move
Route::get('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@index')->name('entities.move');
Route::post('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@move')->name('entities.move-process');
Route::get('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\Posts\MoveController@index')->name('posts.move');
Route::post('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\Posts\MoveController@move')->name('posts.move-process');

// Transform
Route::get('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@index')->name('entities.transform');
Route::post('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@transform')->name('entities.transform-process');

Route::get('/w/{campaign}/entities/{entity}/tooltip', 'Entity\TooltipController@show')->name('entities.tooltip');

// Entity files
Route::get('/w/{campaign}/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
Route::get('/w/{campaign}/entities/{entity}/post/{post}/logs', 'Entity\Posts\LogController@index')->name('entities.posts.logs');
Route::get('/w/{campaign}/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');

// Inventory
Route::get('/w/{campaign}/entities/{entity}/inventory', 'Entity\InventoryController@index')
    ->name('entities.inventory');
Route::post('/w/{campaign}/entities/{entity}/inventory/copy_from', 'Entity\CopyInventoryController@store')
    ->name('entities.inventory.copy.store');
Route::get('/w/{campaign}/entities/{entity}/inventory/copy', 'Entity\CopyInventoryController@index')
    ->name('entities.inventory.copy');
Route::get('/w/{campaign}/entities/{entity}/inventory/{inventory}/details', 'Entity\Inventory\DetailController@index')
    ->name('entities.inventory.details');
Route::delete('/w/{campaign}/entities/{entity}/inventory/{inventory}/delete_section', 'Entity\InventorySectionController@delete')
    ->name('entities.inventory.delete.section');

// Export
Route::get('/w/{campaign}/entities/{entity}/html-export', 'Entity\ExportController@html')->name('entities.html-export');
Route::get('/w/{campaign}/entities/{entity}.json', 'Entity\ExportController@json')->name('entities.json.export');
Route::get('/w/{campaign}/entities/{entity}.md', 'Entity\ExportController@markdown')->name('entities.markdown.export');

Route::get('/w/{campaign}/entities/{entity}/template', 'Entity\TemplateController@update')->name('entities.template');
Route::get('/w/{campaign}/posts/{post}/template', 'Entity\Posts\TemplateController@update')->name('posts.template');

// Attribute template
Route::get('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@index')->name('entities.attributes.template');
Route::post('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@process')->name('entities.attributes.template-process');

Route::get('/w/{campaign}/entities/{entity}/permissions', 'Entity\PermissionController@view')->name('entities.permissions');
Route::post('/w/{campaign}/entities/{entity}/permissions', 'Entity\PermissionController@store')->name('entities.permissions-process');

Route::get('/w/{campaign}/entities/{entity}/preview', 'Entity\PreviewController@index')->name('entities.preview');

// Entity quick creator
Route::get('/w/{campaign}/entity-creator', [App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/w/{campaign}/entity-creator/{entity_type}', [App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::get('/w/{campaign}/entity-creator-post', [App\Http\Controllers\EntityCreatorController::class, 'post'])->name('entity-creator.post');
Route::post('/w/{campaign}/entity-creator/{entity_type}', [App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');
Route::post('/w/{campaign}/entity-creator-post', [App\Http\Controllers\EntityCreatorController::class, 'storePost'])->name('entity-creator.store-post');
