<?php

use Illuminate\Support\Facades\Route;

Route::get('/w/{campaign}', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::post('/w/{campaign}/follow', 'CampaignFollowController@update')->name('campaign.follow');

Route::get('/w/{campaign}/apply', 'Campaign\ApplyController@index')->name('campaign.apply');
Route::post('/w/{campaign}/apply', 'Campaign\ApplyController@save')->name('campaign.apply.save');
Route::delete('/w/{campaign}/remove', 'Campaign\ApplyController@remove')->name('campaign.apply.remove');

Route::get('/w/{campaign}/gallery', 'Campaign\GalleryController@index')->name('campaign.gallery.index');
Route::get('/w/{campaign}/gallery/load', 'Campaign\GalleryController@load')->name('campaign.gallery.load');
Route::get('/w/{campaign}/gallery/search', 'Campaign\GalleryController@search')->name('campaign.gallery.search');
Route::post('/w/{campaign}/gallery/ajax-upload', 'Campaign\GalleryController@ajaxUpload')->name('campaign.gallery.ajax-upload');
Route::get('/w/{campaign}/gallery/ajax-gallery', 'Campaign\AjaxGalleryController@index')->name('campaign.gallery.summernote');
Route::post('/w/{campaign}/gallery/{image}/save-focus', 'Campaign\GalleryController@saveFocus')->name('campaign.gallery.save-focus');
//Route::get('/w/{campaign}/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'focus'])->name('entities.image.focus');

// Abilities
Route::get('/w/{campaign}/abilities/{ability}/abilities', 'Crud\AbilityController@abilities')->name('abilities.abilities');
Route::get('/w/{campaign}/abilities/{ability}/entities', 'Crud\AbilityController@entities')->name('abilities.entities');
Route::get('/w/{campaign}/abilities/tree', 'Crud\AbilityController@tree')->name('abilities.tree');

Route::get('/w/{campaign}/abilities/{ability}/entity-add', 'Crud\AbilityController@entityAdd')->name('abilities.entity-add');
Route::post('/w/{campaign}/abilities/{ability}/entity-add', 'Crud\AbilityController@entityStore')->name('abilities.entity-add.save');

//Ability reorder
Route::get('/w/{campaign}/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'index'])
    ->name('entities.entity_abilities.reorder');
Route::post('/w/{campaign}/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'save'])
    ->name('entities.entity_abilities.reorder-save');

// Maps
Route::get('/w/{campaign}/maps/{map}/maps', 'Maps\MapController@maps')->name('maps.maps');
Route::get('/w/{campaign}/maps/{map}/explore', 'Maps\MapController@explore')->name('maps.explore');
Route::get('/w/{campaign}/maps/{map}/chunks/', 'Maps\MapController@chunks')->name('maps.chunks');
Route::get('/w/{campaign}/maps/{map}/ticker', 'Maps\MapController@ticker')->name('maps.ticker');
Route::get('/w/{campaign}/maps/{map}/{map_marker}/details', 'Maps\MapMarkerController@details')->name('maps.markers.details');
Route::post('/w/{campaign}/maps/{map}/{map_marker}/move', 'Maps\MapMarkerController@move')->name('maps.markers.move');
Route::get('/w/{campaign}/maps/tree', 'Maps\MapController@tree')->name('maps.tree');
//Route::get('/w/{campaign}/maps/{map}/map-points', 'Maps\MapController@mapPoints')->name('maps.map-points');
Route::post('/w/{campaign}/maps/{map}/groups/bulk', 'Maps\MapGroupController@bulk')->name('maps.groups.bulk');
Route::post('/w/{campaign}/maps/{map}/groups/reorder', 'Maps\MapGroupController@reorder')->name('maps.groups.reorder-save');

Route::post('/w/{campaign}/maps/{map}/layers/bulk', 'Maps\MapLayerController@bulk')->name('maps.layers.bulk');
Route::post('/w/{campaign}/maps/{map}/layers/reorder', 'Maps\MapLayerController@reorder')->name('maps.layers.reorder-save');

Route::post('/w/{campaign}/maps/{map}/markers/bulk', 'Maps\MapMarkerController@bulk')->name('maps.markers.bulk');

// Character
Route::get('/w/{campaign}/characters/{character}/organisations', 'CharacterSubController@organisations')->name('characters.organisations');
//Route::get('/w/{campaign}/characters/{character}/map-points', 'CharacterSubController@mapPoints')->name('characters.map-points');

Route::get('/w/{campaign}/dice_rolls/{dice_roll}/roll', 'Crud\DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/w/{campaign}/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'Crud\DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');

// Locations
Route::get('/w/{campaign}/locations/tree', 'Crud\LocationController@tree')->name('locations.tree');
Route::get('/w/{campaign}/locations/{location}/characters', 'Crud\LocationController@characters')->name('locations.characters');
Route::get('/w/{campaign}/locations/{location}/locations', 'Crud\LocationController@locations')->name('locations.locations');

// Organisation menu
Route::get('/w/{campaign}/organisations/{organisation}/members', 'Organisation\MemberController@index')->name('organisations.members');
Route::get('/w/{campaign}/organisations/{organisation}/organisations', 'Organisation\OrganisationController@organisations')->name('organisations.organisations');
Route::get('/w/{campaign}/organisations/tree', 'Crud\OrganisationController@tree')->name('organisations.tree');

// Families menu
Route::get('/w/{campaign}/families/{family}/members', 'Families\MemberController@index')->name('families.members');
Route::get('/w/{campaign}/families/{family}/families', 'Families\FamilyController@index')->name('families.families');
Route::get('/w/{campaign}/families/tree', 'Crud\FamilyController@tree')->name('families.tree');
Route::get('/w/{campaign}/families/{family}/tree', [\App\Http\Controllers\Families\FamilyTreeController::class, 'index'])->name('families.family-tree');
Route::get('/w/{campaign}/families/{family}/tree/api', [\App\Http\Controllers\Families\FamilyTreeController::class, 'api'])->name('families.family-tree.api');
Route::get('/w/{campaign}/families/{entity}/tree/entity-api', [\App\Http\Controllers\Families\FamilyTreeController::class, 'entity'])->name('families.family-tree.entity-api');
Route::post('/w/{campaign}/families/{family}/tree/api', [\App\Http\Controllers\Families\FamilyTreeController::class, 'save'])->name('families.family-tree.api-save');

Route::post('/w/{campaign}/families/{family}/store-member', 'Families\MemberController@store')->name('families.members.store');
Route::get('/w/{campaign}/families/{family}/add-member', 'Families\MemberController@create')->name('families.members.create');

// Items menu
Route::get('/w/{campaign}/items/{item}/inventories', 'Crud\ItemController@inventories')->name('items.inventories');
Route::get('/w/{campaign}/items/tree', 'Crud\ItemController@tree')->name('items.tree');
Route::get('/w/{campaign}/items/{item}/items', 'Crud\ItemController@items')->name('items.items');

// Quest menus
Route::get('/w/{campaign}/quests/tree', 'Crud\QuestController@tree')->name('quests.tree');
Route::get('/w/{campaign}/quests/{quest}/quests', 'Crud\QuestController@quests')->name('quests.quests');

// Races
Route::get('/w/{campaign}/races/{race}/characters', 'Crud\RaceController@characters')->name('races.characters');
Route::get('/w/{campaign}/races/{race}/races', 'Crud\RaceController@races')->name('races.races');
Route::get('/w/{campaign}/races/tree', 'Crud\RaceController@tree')->name('races.tree');
Route::post('/w/{campaign}/races/{race}/store-member', 'CharacterRaceController@store')->name('races.members.store');
Route::get('/w/{campaign}/races/{race}/add-member', 'CharacterRaceController@create')->name('races.members.create');

// Creatures
Route::get('/w/{campaign}/creatures/{creature}/creatures', 'Crud\CreatureController@creatures')->name('creatures.creatures');
Route::get('/w/{campaign}/creatures/tree', 'Crud\CreatureController@tree')->name('creatures.tree');

// Journal
Route::get('/w/{campaign}/journals/{journal}/journals', 'Crud\JournalController@journals')->name('journals.journals');

Route::get('/w/{campaign}/events/tree', 'Crud\EventController@tree')->name('events.tree');
Route::get('/w/{campaign}/events/{event}/events', 'Crud\EventController@events')->name('events.events');

Route::get('/w/{campaign}/timelines/tree', 'Timelines\TimelineController@tree')->name('timelines.tree');
Route::get('/w/{campaign}/timelines/{timeline}/timelines', 'Timelines\TimelineController@timelines')->name('timelines.timelines');

// Tag menus
Route::get('/w/{campaign}/tags/tree', 'Crud\TagController@tree')->name('tags.tree');
Route::get('/w/{campaign}/tags/{tag}/tags', 'Crud\TagController@tags')->name('tags.tags');
Route::get('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@index')->name('tags.transfer');
Route::post('/w/{campaign}/tags/{tag}/transfer', 'Tags\TransferController@process')->name('tags.transfer');

// Tags Quick Add
Route::get('/w/{campaign}/tags/{tag}/children', 'Tags\ChildController@index')->name('tags.children');
Route::get('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@create')->name('tags.entity-add');
Route::post('/w/{campaign}/tags/{tag}/entity-add', 'Tags\ChildController@store')->name('tags.entity-add.save');

// Multi-delete for cruds
Route::post('/w/{campaign}/bulk/process', 'BulkController@process')->name('bulk.process');
Route::get('/w/{campaign}/bulk/modal', 'BulkController@modal')->name('bulk.modal');

Route::get('/w/{campaign}/notes/tree', 'Crud\NoteController@tree')->name('notes.tree');
Route::get('/w/{campaign}/journals/tree', 'Crud\JournalController@tree')->name('journals.tree');


// Calendar
Route::get('/w/{campaign}/calendars/tree', 'Crud\CalendarController@tree')->name('calendars.tree');
Route::get('/w/{campaign}/calendars/{calendar}/event', 'Crud\CalendarController@event')->name('calendars.event.create');
Route::post('/w/{campaign}/calendars/{calendar}/event', 'Crud\CalendarController@eventStore')->name('calendars.event.store');
Route::get('/w/{campaign}/calendars/{calendar}/month-list', 'Crud\CalendarController@monthList')->name('calendars.month-list');
Route::get('/w/{campaign}/calendars/{calendar}/events', 'Crud\CalendarController@events')->name('calendars.events');
Route::get('/w/{campaign}/calendars/{calendar}/today', 'Crud\CalendarController@today')->name('calendars.today');

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

Route::get('/w/{campaign}/entities/{entity}/relations_map', 'Entity\RelationController@map')->name('entities.relations_map');
Route::get('/w/{campaign}/entities/{entity}/relations/table', 'Entity\RelationController@table')->name('entities.relations_table');

// Entity
Route::post('/w/{campaign}/entities/{entity}/confirm-editing', 'EditingController@confirm')->name('entities.confirm-editing');
Route::post('/w/{campaign}/entities/{entity}/keep-alive', 'EditingController@keepAlive')->name('entities.keep-alive');

// Campaign
Route::post('/w/{campaign}/editing/confirm-editing', 'EditingController@confirmCampaign')->name('campaigns.confirm-editing');
Route::post('/w/{campaign}/editing/keep-alive', 'EditingController@keepAliveCampaign')->name('campaigns.keep-alive');

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

// Permission save
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaign_roles.savePermissions');
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/toggle/{entity}/{action}', 'CampaignRoleController@toggle')->name('campaign_roles.toggle');
Route::post('/w/{campaign}/campaign_roles/bulk', 'CampaignRoleController@bulk')->name('campaign_roles.bulk');

// Impersonator
Route::get('/w/{campaign}/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/w/{campaign}/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/w/{campaign}/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');


Route::post('/w/{campaign}/campaign_users/{campaign_user}/update-role/{campaign_role}', 'Campaign\MemberController@updateRoles')->name('campaign_users.update-roles');
Route::get('/w/{campaign}/campaign_users/{campaign_user}/delete', [\App\Http\Controllers\Campaign\MemberController::class, 'delete'])->name('campaign_users.delete');

// Recovery
Route::get('/w/{campaign}/recovery', 'Campaign\RecoveryController@index')->name('recovery');
Route::post('/w/{campaign}/recovery', 'Campaign\RecoveryController@recover')->name('recovery.save');



// Stats
Route::get('/w/{campaign}/stats', 'Campaign\StatController@index')->name('stats');

// User search
Route::get('/w/{campaign}/users/search', 'CampaignUserController@search')->name('users.find');
Route::get('/w/{campaign}/roles/search', 'CampaignRoleController@search')->name('roles.find');


Route::get('/w/{campaign}/default-images', 'Campaign\DefaultImageController@index')
    ->name('campaign.default-images');
Route::get('/w/{campaign}/default-images/create', 'Campaign\DefaultImageController@create')
    ->name('campaign.default-images.create');
Route::post('/w/{campaign}/default-images/create', 'Campaign\DefaultImageController@store')
    ->name('campaign.default-images.store');
Route::delete('/w/{campaign}/default-images', 'Campaign\DefaultImageController@destroy')
    ->name('campaign.default-images.delete');

Route::post('/w/{campaign}/gallery/folder', 'Campaign\GalleryController@folder')
    ->name('campaign.gallery.folder');

Route::get('/w/{campaign}/menu_links/{menu_link}/random', 'MenuLinkController@random')
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
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/api', 'Entity\AbilityController@api')->name('entities.entity_abilities.api');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/import', 'Entity\AbilityController@import')->name('entities.entity_abilities.import');
Route::post('/w/{campaign}/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\AbilityController@useCharge')->name('entities.entity_abilities.use');
Route::get('/w/{campaign}/entities/{entity}/entity_abilities/reset', 'Entity\AbilityController@resetCharges')->name('entities.entity_abilities.reset');

Route::get('/w/{campaign}/entities/{entity}/entity_assets/{entity_asset}/go', 'Entity\AssetController@go')->name('entities.entity_assets.go');
//Route::get('/w/{campaign}/entities/{entity}/quests', 'Entity\QuestController@index')->name('entities.quests');

Route::get('/w/{campaign}/entities/{entity}/profile', 'Entity\ProfileController@index')
    ->name('entities.profile');

//Route::get('/w/{campaign}/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    '/w/{campaign}/abilities' => 'Crud\AbilityController',
    '/w/{campaign}/calendars' => 'Crud\CalendarController',
    '/w/{campaign}/calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    //'campaigns' => 'CampaignController',
    '/w/{campaign}/campaign_users' => 'CampaignUserController',
    '/w/{campaign}/campaign_submissions' => 'Campaign\SubmissionController',
    '/w/{campaign}/characters' => 'Crud\CharacterController',
    '/w/{campaign}/characters.character_organisations' => 'CharacterOrganisationController',
    '/w/{campaign}/conversations' => 'Crud\ConversationController',
    '/w/{campaign}/conversations.conversation_participants' => 'ConversationParticipantController',
    '/w/{campaign}/conversations.conversation_messages' => 'ConversationMessageController',
    '/w/{campaign}/dice_rolls' => 'Crud\DiceRollController',
    '/w/{campaign}/dice_roll_results' => 'Crud\DiceRollResultController',
    '/w/{campaign}/events' => 'Crud\EventController',
    '/w/{campaign}/locations' => 'Crud\LocationController',
    //'locations.map_points' => 'LocationMapPointController',
    '/w/{campaign}/families' => 'Crud\FamilyController',
    '/w/{campaign}/items' => 'Crud\ItemController',
    '/w/{campaign}/journals' => 'Crud\JournalController',
    '/w/{campaign}/maps' => 'Maps\MapController',
    '/w/{campaign}/maps.map_layers' => 'Maps\MapLayerController',
    '/w/{campaign}/maps.map_groups' => 'Maps\MapGroupController',
    '/w/{campaign}/maps.map_markers' => 'Maps\MapMarkerController',
    '/w/{campaign}/menu_links' => 'MenuLinkController',
    '/w/{campaign}/organisations' => 'Crud\OrganisationController',
    '/w/{campaign}/organisations.organisation_members' => 'Organisation\MemberController',
    '/w/{campaign}/notes' => 'Crud\NoteController',
    '/w/{campaign}/quests' => 'Crud\QuestController',
    '/w/{campaign}/quests.quest_elements' => 'QuestElementController',
    '/w/{campaign}/tags' => 'Crud\TagController',
    '/w/{campaign}/timelines' => 'Timelines\TimelineController',
    '/w/{campaign}/timelines.timeline_eras' => 'Timelines\TimelineEraController',
    '/w/{campaign}/timelines.timeline_elements' => 'Timelines\TimelineElementController',
    '/w/{campaign}/campaign_invites' => 'CampaignInviteController',
    '/w/{campaign}/races' => 'Crud\RaceController',
    '/w/{campaign}/creatures' => 'Crud\CreatureController',
    '/w/{campaign}/relations' => 'RelationController',

    // Entities
    //'entities.attributes' => 'AttributeController',
    '/w/{campaign}/entities.entity_abilities' => 'Entity\AbilityController',
    '/w/{campaign}/entities.entity_notes' => 'EntityNoteController',
    '/w/{campaign}/entities.posts' => 'Entity\PostController',
    '/w/{campaign}/entities.entity_events' => 'Entity\ReminderController',
    '/w/{campaign}/entities.entity_assets' => 'Entity\AssetController',
    '/w/{campaign}/entities.inventories' => 'Entity\InventoryController',
    '/w/{campaign}/entities.relations' => 'Entity\RelationController',

    '/w/{campaign}/attribute_templates' => 'AttributeTemplateController',
    //'presets' => 'PresetController',

    // Permission manager
    '/w/{campaign}/campaign_roles' => 'CampaignRoleController',
    '/w/{campaign}/campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
    '/w/{campaign}/campaign_styles' => 'Campaign\StyleController',
    //'campaign_roles.campaign_permissions' => 'CampaignPermissions',

    '/w/{campaign}/campaign_dashboards' => 'Campaign\DashboardController',
    '/w/{campaign}/campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',

    '/w/{campaign}/preset_types.presets' => 'PresetController',

    '/w/{campaign}/images' => 'Campaign\GalleryController',
]);
Route::get('/w/{campaign}/leave-campaign', 'CampaignController@leave')->name('campaigns.leave');

// Campaign CRUD
Route::get('/w/{campaign}/edit', [\App\Http\Controllers\CampaignController::class, 'edit'])->name('campaigns.edit');
Route::patch('/w/{campaign}/update', [\App\Http\Controllers\CampaignController::class, 'update'])->name('campaigns.update');
Route::delete('/w/{campaign}/destroy', [\App\Http\Controllers\CampaignController::class, 'destroy'])->name('campaigns.destroy');


Route::post('/w/{campaign}/campaign_styles/bulk', 'Campaign\StyleController@bulk')->name('campaign_styles.bulk');
Route::post('/w/{campaign}/campaign_styles/reorder', 'Campaign\StyleController@reorder')->name('campaign_styles.reorder-save');
Route::get('/w/{campaign}/theme-builder', [\App\Http\Controllers\Campaign\ThemeBuilderController::class, 'index'])->name('campaign_styles.builder');
Route::post('/w/{campaign}/theme-builder', [\App\Http\Controllers\Campaign\ThemeBuilderController::class, 'save'])->name('campaign_styles.builder-save');
Route::delete('/w/{campaign}/theme-builder', [\App\Http\Controllers\Campaign\ThemeBuilderController::class, 'reset'])->name('campaign_styles.builder-reset');

Route::get('/w/{campaign}/dashboard-header/{campaignDashboardWidget?}', 'Campaign\DashboardHeaderController@edit')->name('campaigns.dashboard-header.edit');
Route::patch('/w/{campaign}/dashboard-header', 'Campaign\DashboardHeaderController@update')->name('campaigns.dashboard-header.update');

// Helper links
Route::get('/w/{campaign}/campaign-roles/admin', 'CampaignRoleController@admin')->name('campaigns.campaign_roles.admin');
Route::get('/w/{campaign}/campaign-roles/public', 'CampaignRoleController@public')->name('campaigns.campaign_roles.public');
Route::get('/w/{campaign}/campaign-roles/{campaign_role}/duplicate', 'CampaignRoleController@duplicate')->name('campaign_roles.duplicate');


// Marketplace plugin route
if(config('marketplace.enabled')) {
    Route::get('/w/{campaign}/plugins', 'Campaign\PluginController@index')->name('campaign_plugins.index');
    Route::delete('/w/{campaign}/plugins/{plugin}/delete', 'Campaign\PluginController@delete')->name('campaign_plugins.destroy');
    Route::get('/w/{campaign}/plugins/{plugin}/enable', 'Campaign\PluginController@enable')->name('campaign_plugins.enable');
    Route::get('/w/{campaign}/plugins/{plugin}/disable', 'Campaign\PluginController@disable')->name('campaign_plugins.disable');
    Route::post('/w/{campaign}/plugins/{plugin}/import', 'Campaign\PluginController@import')->name('campaign_plugins.import');
    Route::get('/w/{campaign}/plugins/{plugin}/confirm-import', 'Campaign\PluginController@confirmImport')->name('campaign_plugins.confirm-import');
    Route::get('/w/{campaign}/plugins/{plugin}/update', 'Campaign\PluginController@updateInfo')->name('campaign_plugins.update-info');
    Route::post('/w/{campaign}/plugins/{plugin}/update', 'Campaign\PluginController@update')->name('campaign_plugins.update');
    Route::post('/w/{campaign}/plugins/bulk', 'Campaign\PluginController@bulk')->name('campaign_plugins.bulk');
}

//Route::post('/w/{campaign}/timelines/{timeline}/timeline-era/{timeline_era}/reorder', 'Timelines\TimelineEraController@reorder')->name('timelines.reorder');
// Old Search
Route::get('/w/{campaign}/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');

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

Route::get('/w/{campaign}/search/live', [\App\Http\Controllers\Search\LiveController::class, 'index'])->name('search.live');
Route::get('/w/{campaign}/search/recent', [\App\Http\Controllers\Search\LiveController::class, 'recent'])->name('search.recent');

Route::get('/w/{campaign}/redirect', 'RedirectController@index')->name('redirect');

// Campaign Dashboard Widgets
Route::get('/w/{campaign}/dashboard-setup', 'DashboardSetupController@index')->name('dashboard.setup');
Route::post('/w/{campaign}/dashboard-setup', 'DashboardSetupController@save')->name('dashboard.setup');
Route::post('/w/{campaign}/dashboard-setup/reorder', [\App\Http\Controllers\DashboardSetupController::class, 'reorder'])->name('dashboard.reorder');
Route::get('/w/{campaign}/dashboard/widgets/recent/{id}', 'DashboardController@recent')->name('dashboard.recent');
Route::get('/w/{campaign}/dashboard/widgets/unmentioned/{id}', 'DashboardController@unmentioned')->name('dashboard.unmentioned');
Route::post('/w/{campaign}/dashboard/widgets/calendar/{campaignDashboardWidget}/add', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'add'])->name('dashboard.calendar.add');
Route::post('/w/{campaign}/dashboard/widgets/calendar/{campaignDashboardWidget}/sub', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'sub'])->name('dashboard.calendar.sub');
Route::get('/w/{campaign}/dashboard/widgets/{campaignDashboardWidget}/render', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'render'])->name('dashboard.calendar.render');

// Move
Route::get('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@index')->name('entities.move');
Route::post('/w/{campaign}/entities/{entity}/move', 'Entity\MoveController@move')->name('entities.move');
Route::get('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@index')->name('posts.move');
Route::post('/w/{campaign}/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@move')->name('posts.move');

// Transform
Route::get('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@index')->name('entities.transform');
Route::post('/w/{campaign}/entities/{entity}/transform', 'Entity\TransformController@transform')->name('entities.transform');

Route::get('/w/{campaign}/entities/{entity}/tooltip', 'Entity\TooltipController@show')->name('entities.tooltip');

Route::get('/w/{campaign}/entities/{entity}/json-export', 'Entity\ExportController@json')->name('entities.json-export');

// Entity files
Route::get('/w/{campaign}/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
Route::get('/w/{campaign}/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');

// Inventory
Route::get('/w/{campaign}/entities/{entity}/inventory', 'Entity\InventoryController@index')->name('entities.inventory');

// Export
Route::get('/w/{campaign}/entities/export/{entity}', 'EntityController@export')->name('entities.export');
Route::get('/w/{campaign}/entities/{entity}/html-export', 'Entity\ExportController@html')->name('entities.html-export');

Route::get('/w/{campaign}/entities/{entity}/template', 'EntityController@template')->name('entities.template');

// Attribute template
Route::get('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@apply')->name('entities.attributes.template');
Route::post('/w/{campaign}/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@applyTemplate')->name('entities.attributes.template');

Route::get('/w/{campaign}/entities/{entity}/permissions', 'PermissionController@view')->name('entities.permissions');
Route::post('/w/{campaign}/entities/{entity}/permissions', 'PermissionController@store')->name('entities.permissions');


Route::get('/w/{campaign}/entities/{entity}/preview', 'Entity\PreviewController@index')->name('entities.preview');

// The campaign management sub pages
Route::get('/w/{campaign}/overview', 'CampaignController@index')->name('overview');
Route::get('/w/{campaign}/modules', 'CampaignSettingController@index')->name('campaign.modules');
Route::post('/w/{campaign}/modules/toggle/{module?}', 'CampaignSettingController@toggle')->name('campaign.modules.toggle');
Route::get('/w/{campaign}/campaign-theme', 'Campaign\StyleController@theme')->name('campaign-theme');
Route::post('/w/{campaign}/campaign-theme', 'Campaign\StyleController@themeSave')->name('campaign-theme.save');
Route::get('/w/{campaign}/campaign-export', 'Campaign\ExportController@index')->name('campaign.export');
Route::post('/w/{campaign}/campaign-export', 'Campaign\ExportController@export')->name('campaign.export-process');
Route::get('/w/{campaign}/campaign.styles', [\App\Http\Controllers\CampaignController::class, 'css'])->name('campaign.css');
Route::get('/w/{campaign}/campaign_plugin.styles', 'Campaign\PluginController@css')->name('campaign_plugins.css');
Route::get('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@edit')->name('campaign-visibility');
Route::post('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@save')->name('campaign-visibility.save');

Route::get('/w/{campaign}/modules/{entity_type}/edit', [\App\Http\Controllers\Campaign\ModuleController::class, 'edit'])->name('modules.edit');
Route::patch('/w/{campaign}/modules/{entity_type}/update', [\App\Http\Controllers\Campaign\ModuleController::class, 'update'])->name('modules.update');
Route::delete('/w/{campaign}/modules/reset', [\App\Http\Controllers\Campaign\ModuleController::class, 'reset'])->name('modules.reset');

Route::get('/w/{campaign}/campaign-applications', 'Campaign\SubmissionController@toggle')->name('campaign-applications');
Route::post('/w/{campaign}/campaign-applications', 'Campaign\SubmissionController@toggleSave')->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@index')->name('campaign-sidebar');
Route::post('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@save')->name('campaign-sidebar-save');
Route::delete('/w/{campaign}/sidebar-setup/reset', 'Campaign\SidebarController@reset')->name('campaign-sidebar-reset');

Route::get('/w/{campaign}/presets/type/{preset_type}/list', [\App\Http\Controllers\PresetController::class, 'presets'])->name('presets.list');
Route::get('/w/{campaign}/presets/type/{preset_type}/create', [\App\Http\Controllers\PresetController::class, 'create'])->name('presets.create');
Route::post('/w/{campaign}/presets/type/{preset_type}/store', [\App\Http\Controllers\PresetController::class, 'store'])->name('presets.store');
Route::post('/w/{campaign}/presets/{preset}/load', [\App\Http\Controllers\PresetController::class, 'load'])->name('presets.show');

Route::model('preset_type', \App\Models\PresetType::class);

// Entity quick creator
Route::get('/w/{campaign}/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/w/{campaign}/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::post('/w/{campaign}/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');

Route::get('/w/{campaign}/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');

Route::get('/w/{campaign}/bragi', [\App\Http\Controllers\Bragi\BragiController::class, 'index'])->name('bragi');
Route::post('/w/{campaign}/bragi', [\App\Http\Controllers\Bragi\BragiController::class, 'generate'])->name('bragi.generate');
