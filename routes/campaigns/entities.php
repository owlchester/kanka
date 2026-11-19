<?php

use App\Http\Controllers\Bookmarks\ReorderController;
use App\Http\Controllers\Calendars\EventController;
use App\Http\Controllers\Characters\MemberController;
use App\Http\Controllers\DiceRolls\ResultsController;
use App\Http\Controllers\Entities\Apis\DocumentController;
use App\Http\Controllers\Entities\ChildrenController;
use App\Http\Controllers\Entities\CreateController;
use App\Http\Controllers\Entities\DeleteController;
use App\Http\Controllers\Entities\EditController;
use App\Http\Controllers\Entities\IndexController;
use App\Http\Controllers\Entities\ListingPreferenceController;
use App\Http\Controllers\Entity\AttributeController;
use App\Http\Controllers\Entity\Attributes\LiveApiController;
use App\Http\Controllers\Entity\Attributes\LiveController;
use App\Http\Controllers\Entity\EntryController;
use App\Http\Controllers\Entity\ImageController;
use App\Http\Controllers\Entity\Maps\ApiController as EntityMapApiController;
use App\Http\Controllers\Entity\Maps\GroupController as EntityMapGroupController;
use App\Http\Controllers\Entity\Maps\MarkerController as EntityMapMarkerController;
use App\Http\Controllers\Entity\Maps\PresetController as EntityMapPresetController;
use App\Http\Controllers\Entity\Maps\SettingsController as EntityMapSettingsController;
use App\Http\Controllers\Entity\Maps\ShowController as EntityMapShowController;
use App\Http\Controllers\Entity\Maps\TilingPromptController as EntityMapTilingPromptController;
use App\Http\Controllers\Entity\Posts\LayoutController;
use App\Http\Controllers\Entity\Posts\VisibilityController;
use App\Http\Controllers\Entity\PrivacyController;
use App\Http\Controllers\Entity\ShowController;
use App\Http\Controllers\Entity\StoryController;
use App\Http\Controllers\EntityCreatorController;
use App\Http\Controllers\Events\ParticipantController;
use App\Http\Controllers\Events\ParticipantManagerController;
use App\Http\Controllers\Families\TreeController;
use App\Http\Controllers\Filters\FormController;
use App\Http\Controllers\Filters\SaveController;
use App\Http\Controllers\Timelines\TimelineReorderController;
use App\Http\Controllers\Whiteboards\ApiController;
use App\Http\Controllers\Whiteboards\DrawController;
use App\Models\Attribute;
use App\Models\Campaign;
use Illuminate\Support\Facades\Route;

Route::get('/entities/{entity}', [ShowController::class, 'index'])->name('entities.show')->where(['entity' => '[0-9]+']);

Route::get('/entities/{entity}-{slug}', [ShowController::class, 'index'])->name('entities.show-slug');

Route::get('/t/{entityType}', [IndexController::class, 'index'])->name('entities.index');
Route::get('/t/{entityType}/api', [IndexController::class, 'api'])->name('entities.index-api');
Route::patch('/t/{entityType}/preferences', [ListingPreferenceController::class, 'update'])
    ->name('entities.listing-preferences.update');
Route::delete('/t/{entityType}/preferences', [ListingPreferenceController::class, 'destroy'])
    ->name('entities.listing-preferences.destroy');
Route::get('/t/{entityType}/create', [CreateController::class, 'index'])->name('entities.create');
Route::post('/t/{entity_type}/create', [CreateController::class, 'store'])->name('entities.store');

Route::get('/entities/{entity}/edit', [EditController::class, 'index'])->name('entities.edit');
Route::patch('/entities/{entity}/save', [EditController::class, 'save'])->name('entities.update');
Route::delete('/entities/{entity}/delete', [DeleteController::class, 'index'])->name('entities.destroy');

Route::get('/entities/{entity}/children', [ChildrenController::class, 'index'])->name('entities.children');

Route::get('/entities/{entity}/map-api', [EntityMapApiController::class, 'index'])->name('entities.map-api');
Route::get('/entities/{entity}/map', [EntityMapShowController::class, 'index'])->name('entities.map');
Route::patch('/entities/{entity}/map/settings', [EntityMapSettingsController::class, 'update'])->name('entities.map-settings.update');
Route::get('/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'preview'])->name('entities.map-markers.preview');
Route::delete('/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'destroy'])->name('entities.map-markers.destroy');
Route::post('/entities/{entity}/map/markers', [EntityMapMarkerController::class, 'store'])->name('entities.map-markers.store');
Route::patch('/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'update'])->name('entities.map-markers.update');
Route::post('/entities/{entity}/map/presets', [EntityMapPresetController::class, 'store'])->name('entities.map-presets.store');
Route::patch('/entities/{entity}/map/presets/{preset}', [EntityMapPresetController::class, 'update'])->name('entities.map-presets.update');
Route::delete('/entities/{entity}/map/presets/{preset}', [EntityMapPresetController::class, 'destroy'])->name('entities.map-presets.destroy');
Route::post('/entities/{entity}/map/groups', [EntityMapGroupController::class, 'store'])->name('entities.map-groups.store');
Route::patch('/entities/{entity}/map/tiling-prompt', [EntityMapTilingPromptController::class, 'update'])->name('entities.map-tiling-prompt.update');

// Abilities
Route::get('/abilities/{ability}/abilities', 'Abilities\AbilityController@index')->name('abilities.abilities');
Route::get('/abilities/{ability}/entities', 'Abilities\EntityController@index')->name('abilities.entities');

Route::get('/abilities/{ability}/entity-add', 'Abilities\EntityController@create')->name('abilities.entity-add');
Route::post('/abilities/{ability}/entity-add', 'Abilities\EntityController@store')->name('abilities.entity-add.save');

// Ability reorder
Route::get('/entities/{entity}/entity_abilities/reorder', [App\Http\Controllers\Entity\Abilities\ReorderController::class, 'index'])
    ->name('entities.entity_abilities.reorder');
Route::post('/entities/{entity}/entity_abilities/reorder', [App\Http\Controllers\Entity\Abilities\ReorderController::class, 'save'])
    ->name('entities.entity_abilities.reorder-save');

// Maps
Route::get('/maps/{map}/maps', 'Maps\MapController@index')->name('maps.maps');
Route::get('/maps/{map}/explore', 'Maps\ExploreController@index')->name('maps.explore');
Route::get('/maps/{map}/{map_marker}/details', 'Maps\Markers\DetailController@index')->name('maps.markers.details');
Route::post('/maps/{map}/{map_marker}/move', 'Maps\Markers\MoveController@index')->name('maps.markers.move');
Route::post('/maps/{map}/groups/bulk', 'Maps\Bulks\GroupController@index')->name('maps.groups.bulk');
Route::post('/maps/{map}/groups/reorder', 'Maps\Reorders\GroupController@index')->name('maps.groups.reorder-save');

Route::post('/maps/{map}/layers/bulk', 'Maps\Bulks\LayerController@index')->name('maps.layers.bulk');
Route::post('/maps/{map}/layers/reorder', 'Maps\Reorders\LayerController@index')->name('maps.layers.reorder-save');
Route::post('/maps/{map}/layers/{map_layer}/migrate', 'Maps\Layers\MigrateController@index')->name('maps.layers.migrate');

Route::post('/maps/{map}/markers/bulk', 'Maps\Bulks\MarkerController@index')->name('maps.markers.bulk');

// Character
Route::get('/characters/{character}/organisations', [MemberController::class, 'index'])->name('characters.organisations');
Route::get('/characters/{character}/races/management', 'Characters\Races\ManagementController@index')->name('characters.races.management');
Route::post('/characters/{character}/races/save', 'Characters\Races\ManagementController@save')->name('characters.races.save');
Route::get('/characters/{character}/families/management', 'Characters\Families\ManagementController@index')->name('characters.families.management');
Route::post('/characters/{character}/families/save', 'Characters\Families\ManagementController@save')->name('characters.families.save');

Route::get('/dice_rolls/{dice_roll}/roll', 'Crud\DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'Crud\DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');
Route::get('/dice_rolls/results', [ResultsController::class, 'index'])->name('dice_rolls.results');

// Locations
Route::get('/locations/{location}/characters', 'Locations\CharacterController@index')->name('locations.characters');
Route::get('/locations/{location}/locations', 'Locations\LocationController@index')->name('locations.locations');
Route::get('/locations/{location}/events', 'Locations\EventController@index')->name('locations.events');
Route::get('/locations/{location}/quests', 'Locations\QuestController@index')->name('locations.quests');

// Organisation menu
Route::get('/organisations/{organisation}/members', 'Organisation\MemberController@index')->name('organisations.members');
Route::post('/organisations/{organisation}/organisation-members/bulk', 'Organisation\Bulks\MemberController@index')->name('organisations.organisation_members.bulk');
Route::get('/organisations/{organisation}/organisations', 'Organisation\OrganisationController@organisations')->name('organisations.organisations');

// Families menu
Route::get('/families/{family}/members', 'Families\MemberController@index')->name('families.members');
Route::get('/families/{family}/families', 'Families\FamilyController@index')->name('families.families');
Route::get('/families/{family}/tree', [TreeController::class, 'index'])->name('families.family-tree');
Route::get('/families/{family}/tree/api', [App\Http\Controllers\Families\Trees\ApiController::class, 'index'])->name('families.family-tree.api');
Route::get('/families/{entity}/tree/entity-api', [App\Http\Controllers\Families\Trees\ApiController::class, 'entity'])->name('families.family-tree.entity-api');
Route::post('/families/{family}/tree/api', [App\Http\Controllers\Families\Trees\ApiController::class, 'save'])->name('families.family-tree.api-save');

Route::post('/families/{family}/store-member', 'Families\MemberController@store')->name('families.members.store');
Route::get('/families/{family}/add-member', 'Families\MemberController@create')->name('families.members.create');

// Items menu
Route::get('/items/{item}/inventories', 'Items\EntityController@index')->name('items.inventories');
Route::get('/items/{item}/items', 'Items\ItemController@index')->name('items.items');

// Quest menus
Route::get('/quests/{quest}/quests', 'Quests\QuestController@index')->name('quests.quests');

// Notes menus
Route::get('/notes/{note}/notes', 'Notes\NoteController@index')->name('notes.notes');

// Races
Route::get('/races/{race}/characters', 'Races\MemberController@index')->name('races.characters');
Route::get('/races/{race}/races', 'Races\RaceController@index')->name('races.races');
Route::get('/races/{race}/member', 'Races\MemberController@create')->name('races.members.create');
Route::post('/races/{race}/member', 'Races\MemberController@store')->name('races.members.store');

// Creatures
Route::get('/creatures/{creature}/creatures', 'Creatures\CreatureController@index')->name('creatures.creatures');

// Journal
Route::get('/journals/{journal}/journals', 'Journals\JournalController@index')->name('journals.journals');

Route::get('/events/{event}/events', 'Events\EventController@index')->name('events.events');
Route::get('/events/{event}/participants', [ParticipantController::class, 'index'])->name('events.participants.index');
Route::put('/events/{event}/participants', [ParticipantManagerController::class, 'update'])->name('events.participants.update');
Route::post('/events/{event}/participants', [ParticipantController::class, 'store'])->name('events.participants.store');
Route::delete('/events/{event}/participants/{participant}', [ParticipantController::class, 'destroy'])->name('events.participants.destroy');
Route::post('/events/{event}/groups', [ParticipantController::class, 'storeGroup'])->name('events.groups.store');
Route::delete('/events/{event}/groups/{group}', [ParticipantController::class, 'destroyGroup'])->name('events.groups.destroy');

Route::get('/timelines/{timeline}/timelines', 'Timelines\TimelineController@index')->name('timelines.timelines');

// Tag menus
Route::get('/tags/{tag}/tags', 'Tags\TagController@index')->name('tags.tags');
Route::get('/tags/{tag}/transfer', 'Tags\TransferController@index')->name('tags.transfer');
Route::get('/tags/{tag}/transfer-posts', 'Tags\TransferController@postIndex')->name('tags.transfer.posts');
Route::post('/tags/{tag}/transfer', 'Tags\TransferController@process')->name('tags.transfer-process');
Route::post('/tags/{tag}/transfer-posts', 'Tags\TransferController@processPosts')->name('tags.transfer.posts-process');

// Tags Quick Add
Route::get('/tags/{tag}/children', 'Tags\ChildController@index')->name('tags.children');
Route::get('/tags/{tag}/posts', 'Tags\PostController@index')->name('tags.posts');
Route::get('/tags/{tag}/entity-add', 'Tags\ChildController@create')->name('tags.entity-add');
Route::post('/tags/{tag}/entity-add', 'Tags\ChildController@store')->name('tags.entity-add.save');

Route::get('/entities/{entity}/tags/add', 'Entity\TagController@create')->name('entity.tags-add');
Route::post('/entities/{entity}/tags/add', 'Entity\TagController@store')->name('entity.tags-add.save');

// Multi-delete for cruds
Route::post('/bulk/process', 'BulkController@index')->name('bulk.process');

// Calendar
Route::get('/calendars/{calendar}/event', 'Calendars\EventController@create')->name('calendars.event.create');
Route::post('/calendars/{calendar}/event', 'Calendars\EventController@store')->name('calendars.event.store');
Route::get('/calendars/{calendar}/month-list', 'Crud\CalendarController@monthList')->name('calendars.month-list');
Route::get('/calendars/{calendar}/events', 'Calendars\EventController@index')->name('calendars.events');
Route::get('/calendars/{calendar}/today', 'Crud\CalendarController@today')->name('calendars.today');
Route::get('/calendars/{calendar}/validate-length', [EventController::class, 'eventLength'])->name('calendars.event-length');

Route::post('/calendars/{calendar}/calendar-events/bulk', 'Calendars\Bulks\EntityEventController@index')->name('calendars.entity-events.bulk');

//        Route::get('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');

// Attribute multi-save
Route::get('/entities/{entity}/attributes', [AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/entities/{entity}/attributes-dashboard', [AttributeController::class, 'dashboard'])->name('entities.attributes-dashboard');
Route::get('/entities/{entity}/attributes/edit', [AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/entities/{entity}/attributes/save', [AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/entities/{entity}/attributes/live-edit/', [AttributeController::class, 'liveEdit'])
    ->name('entities.attributes.live.edit');
Route::get('/entities/{entity}/attributes/live-edit/{attribute}', [LiveController::class, 'index'])
    ->name('entities.attributes.live.edit2');
Route::post('/entities/{entity}/attributes/live-edit/{attribute}/save', [LiveController::class, 'save'])
    ->name('entities.attributes.live.save');

Route::get('/entities/{entity}/attributes/live-api', [LiveApiController::class, 'index'])
    ->name('entities.attributes.live-api.index');
Route::post('/entities/{entity}/attributes/live-api', [LiveApiController::class, 'store'])
    ->name('entities.attributes.live-api.create');
Route::post('/entities/{entity}/attributes/live-api/{attribute}', [LiveApiController::class, 'update'])
    ->name('entities.attributes.live-api.update');
Route::post('/entities/{entity}/attributes/live-api/{attribute}/delete', [LiveApiController::class, 'destroy'])
    ->name('entities.attributes.live-api.delete');

Route::model('attribute', Attribute::class);

Route::get('/entities/{entity}/story-reorder', [StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/entities/{entity}/story-reorder', [StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/entities/{entity}/story-more', [StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/entities/{entity}/image-focus', [ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/entities/{entity}/image-focus', [ImageController::class, 'saveFocus'])->name('entities.image.save-focus');
Route::get('/entities/{entity}/image-focus/{image}', [ImageController::class, 'focusImage'])->name('entities.image.focus-data');

Route::get('/entities/{entity}/image-replace', [ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/entities/{entity}/image-replace', [ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/entities/{entity}/privacy', [PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/entities/{entity}/privacy', [PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');
// Route::post('/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');

// Entity update entry
Route::get('/entities/{entity}/entry', [EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('/entities/{entity}/entry', [EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/entities/{entity}/connection/map', 'Entity\Connections\MapController@index')->name('entities.relations_map');
Route::get('/entities/{entity}/connection/table', 'Entity\Connections\TableController@index')->name('entities.relations_table');

// Entity
Route::post('/entities/{entity}/confirm-editing', 'EditingController@confirm')->name('entities.confirm-editing');
Route::post('/entities/{entity}/keep-alive', 'EditingController@keepAlive')->name('entities.keep-alive');

// Posts
Route::post('/editing/posts/{entity}/{post}/confirm-editing', 'EditingController@confirmPost')->name('posts.confirm-editing');
Route::post('/editing/posts/{entity}/{post}/keep-alive', 'EditingController@keepAlivePost')->name('posts.keep-alive');
Route::get('/posts/{entity}/{post}/visibility', [VisibilityController::class, 'index'])->name('posts.edit.visibility');
Route::post('/posts/{entity}/{post}/visibility/update', [VisibilityController::class, 'update'])->name('posts.update.visibility');

// Quest Elements
Route::post('/editing/quest-elements/{quest_element}/confirm-editing', 'EditingController@confirmQuestElement')->name('quest-elements.confirm-editing');
Route::post('/editing/quest-elements/{quest_element}/keep-alive', 'EditingController@keepAliveQuestElement')->name('quest-elements.keep-alive');

// Timeline Elements
Route::post('/editing/timeline-elements/{timeline_element}/confirm-editing', 'EditingController@confirmTimelineElement')->name('timeline-elements.confirm-editing');
Route::post('/editing/timeline-elements/{timeline_element}/keep-alive', 'EditingController@keepAliveTimelineElement')->name('timeline-elements.keep-alive');
Route::get('/timeline/{timeline}/era/{timeline_era}/list', 'Timelines\TimelineEraController@positionList')->name('timelines.era-list');

Route::get('/bookmarks/{bookmark}/random', 'Bookmarks\RandomController@index')
    ->name('bookmarks.random');

Route::get('/timelines/{timeline}/reorder', [TimelineReorderController::class, 'index'])
    ->name('timelines.reorder');
Route::post('/timelines/{timeline}/reorder', [TimelineReorderController::class, 'save'])
    ->name('timelines.reorder-save');
Route::post('/timelines/{timeline}/eras/bulk', 'Timelines\TimelineEraController@bulk')->name('timelines.eras.bulk');

Route::get('/bookmarks/reorder', [ReorderController::class, 'index'])
    ->name('bookmarks.reorder');
Route::post('/bookmarks/reorder', [ReorderController::class, 'save'])
    ->name('bookmarks.reorder-save');
Route::get('/entity_types/{entity_type}/bookmark-form', [SaveController::class, 'render'])->name('filters.modal_form');

// Entity Abilities API
Route::get('/entities/{entity}/abilities', 'Entity\AbilityController@index')->name('entities.abilities');
Route::get('/entities/{entity}/entity_abilities/api', 'Entity\Abilities\ApiController@index')->name('entities.entity_abilities.api');
Route::get('/entities/{entity}/entity_abilities/import', 'Entity\Abilities\ImportController@import')->name('entities.entity_abilities.import');
Route::get('/entities/{entity}/entity_abilities/import-confirm', 'Entity\Abilities\ImportController@index')->name('entities.entity_abilities.import.confirm');
Route::post('/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\Abilities\ChargeController@use')->name('entities.entity_abilities.use');
Route::get('/entities/{entity}/entity_abilities/reset', 'Entity\Abilities\ChargeController@reset')->name('entities.entity_abilities.reset');

Route::get('/entities/{entity}/entity_assets/{entity_asset}/go', 'Entity\AssetController@go')->name('entities.entity_assets.go');

Route::get('/entities/{entity}/profile', 'Entity\ProfileController@index')
    ->name('entities.profile');

Route::get('/entity_types/{entity_type}/filter-form', [FormController::class, 'index'])->name('filters.form');
Route::get('/connection/filter-form', [FormController::class, 'connection'])->name('filters.form-connection');

Route::get('/filters/{entity_type}/save', [SaveController::class, 'save'])->name('save-filters');

// Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    '/abilities' => 'Crud\AbilityController',
    '/calendars' => 'Crud\CalendarController',
    '/calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    '/characters' => 'Crud\CharacterController',
    '/characters.character_organisations' => 'Characters\MembershipController',
    '/conversations' => 'Crud\ConversationController',
    '/conversations.conversation_participants' => 'ConversationParticipantController',
    '/conversations.conversation_messages' => 'ConversationMessageController',
    '/dice_rolls' => 'Crud\DiceRollController',
    '/events' => 'Crud\EventController',
    '/locations' => 'Crud\LocationController',
    '/families' => 'Crud\FamilyController',
    '/items' => 'Crud\ItemController',
    '/journals' => 'Crud\JournalController',
    '/maps' => 'Crud\MapController',
    '/maps.map_layers' => 'Maps\LayerController',
    '/maps.map_groups' => 'Maps\GroupController',
    '/maps.map_markers' => 'Maps\MarkerController',
    '/bookmarks' => 'Crud\BookmarkController',
    '/organisations' => 'Crud\OrganisationController',
    '/organisations.organisation_members' => 'Organisation\MemberController',
    '/notes' => 'Crud\NoteController',
    '/quests' => 'Crud\QuestController',
    '/quests.quest_elements' => 'Quests\ElementController',
    '/tags' => 'Crud\TagController',
    '/timelines' => 'Crud\TimelineController',
    '/timelines.timeline_eras' => 'Timelines\TimelineEraController',
    '/timelines.timeline_elements' => 'Timelines\TimelineElementController',
    '/races' => 'Crud\RaceController',
    '/creatures' => 'Crud\CreatureController',
    '/relations' => 'RelationController',
    '/reminders' => 'ReminderUpdateController',

    // Entities
    // 'entities.attributes' => 'AttributeController',
    '/entities.entity_abilities' => 'Entity\AbilityController',
    '/entities.posts' => 'Entity\PostController',
    '/entities.reminders' => 'Entity\ReminderController',
    '/entities.entity_assets' => 'Entity\AssetController',
    '/entities.inventories' => 'Entity\InventoryController',
    '/entities.relations' => 'Entity\RelationController',

    '/attribute_templates' => 'Crud\AttributeTemplateController',
    '/whiteboards' => 'Whiteboards\CrudController',
    // 'presets' => 'PresetController',
]);

// Move
Route::get('/entities/{entity}/move', 'Entity\MoveController@index')->name('entities.move');
Route::post('/entities/{entity}/move', 'Entity\MoveController@move')->name('entities.move-process');
Route::get('/entities/{entity}/posts/{post}/move', 'Entity\Posts\MoveController@index')->name('posts.move');
Route::post('/entities/{entity}/posts/{post}/move', 'Entity\Posts\MoveController@move')->name('posts.move-process');
Route::get('/entities/{entity}/post-layouts', [LayoutController::class, 'index'])->name('posts.layouts');

// Transform
Route::get('/entities/{entity}/transform', 'Entity\TransformController@index')->name('entities.transform');
Route::post('/entities/{entity}/transform', 'Entity\TransformController@transform')->name('entities.transform-process');

Route::get('/entities/{entity}/tooltip', 'Entity\TooltipController@show')->name('entities.tooltip');

// Entity files
Route::get('/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
Route::get('/entities/{entity}/post/{post}/logs', 'Entity\Posts\LogController@index')->name('entities.posts.logs');
Route::get('/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');

// Inventory
Route::get('/entities/{entity}/inventory', 'Entity\InventoryController@index')
    ->name('entities.inventory');
Route::post('/entities/{entity}/inventory/generate/store', 'Entity\GenerateInventoryController@store')
    ->name('entities.inventory.generate.store');
Route::get('/entities/{entity}/inventory/generate', 'Entity\GenerateInventoryController@index')
    ->name('entities.inventory.generate');
Route::post('/entities/{entity}/inventory/copy_from', 'Entity\CopyInventoryController@store')
    ->name('entities.inventory.copy.store');
Route::get('/entities/{entity}/inventory/copy', 'Entity\CopyInventoryController@index')
    ->name('entities.inventory.copy');
Route::get('/entities/{entity}/inventory/{inventory}/details', 'Entity\Inventory\DetailController@index')
    ->name('entities.inventory.details');
Route::delete('/entities/{entity}/inventory/{inventory}/delete_section', 'Entity\InventorySectionController@delete')
    ->name('entities.inventory.delete.section');

// Export
Route::get('/entities/{entity}/html-export', 'Entity\ExportController@html')->name('entities.html-export');
Route::get('/entities/{entity}.json', 'Entity\ExportController@json')->name('entities.json.export');
Route::get('/entities/{entity}.md', 'Entity\ExportController@markdown')->name('entities.markdown.export');

// Share
Route::get('/entities/{entity}/share', 'Entity\ShareController@setup')->name('entities.share.setup');
Route::post('/entities/{entity}/share', 'Entity\ShareController@save')->name('entities.share.save');

Route::get('/entities/{entity}/template', 'Entity\TemplateController@update')->name('entities.template');
Route::get('/posts/{post}/template', 'Entity\Posts\TemplateController@update')->name('posts.template');

// Archive
Route::get('/entities/{entity}/archive', 'Entity\ArchiveController@update')->name('entities.archive');

// Attribute template
Route::get('/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@index')->name('entities.attributes.template');
Route::post('/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@process')->name('entities.attributes.template-process');

Route::get('/entities/{entity}/permissions', 'Entity\PermissionController@view')->name('entities.permissions');
Route::post('/entities/{entity}/permissions', 'Entity\PermissionController@store')->name('entities.permissions-process');

Route::get('/entities/{entity}/preview', 'Entity\PreviewController@index')->name('entities.preview');

// Entity quick creator
Route::get('/entity-creator', [EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/entity-creator/{entity_type}', [EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::get('/entity-creator-post', [EntityCreatorController::class, 'post'])->name('entity-creator.post');
Route::post('/entity-creator/{entity_type}', [EntityCreatorController::class, 'store'])->name('entity-creator.store');
Route::post('/entity-creator-post', [EntityCreatorController::class, 'storePost'])->name('entity-creator.store-post');

// Whiteboards
Route::get('/whiteboards/{whiteboard}/draw', [DrawController::class, 'show'])->name('whiteboards.draw');
Route::get('/whiteboards/{whiteboard}/api', [ApiController::class, 'index'])->name('whiteboards.api');
Route::put('/whiteboards/{whiteboard}/api', [ApiController::class, 'store'])->name('whiteboards.shapes.store');
Route::patch('/whiteboards/{whiteboard}/api/{whiteboard_shape}', [ApiController::class, 'update'])->name('whiteboards.shapes.update');
Route::delete('/whiteboards/{whiteboard}/api/{whiteboard_shape}', [ApiController::class, 'destroy'])->name('whiteboards.shapes.delete');
Route::post('/whiteboards/{whiteboard}/api/{whiteboard_shape}/stroke', [ApiController::class, 'stroke'])->name('whiteboards.shapes.stroke');

Route::get('/entities/{entity}/api/document', [DocumentController::class, 'index'])->name('entities.api.document');
