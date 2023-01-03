<?php


Route::get('/', 'DashboardController@index')->name('dashboard');

Route::post('/follow', 'CampaignFollowController@update')->name('campaign.follow');

Route::get('/apply', 'Campaign\ApplyController@index')->name('campaign.apply');
Route::post('/apply', 'Campaign\ApplyController@save')->name('campaign.apply.save');
Route::delete('/remove', 'Campaign\ApplyController@remove')->name('campaign.apply.remove');

Route::get('/gallery', 'Campaign\GalleryController@index')->name('campaign.gallery.index');
Route::get('/gallery/load', 'Campaign\GalleryController@load')->name('campaign.gallery.load');
Route::get('/gallery/search', 'Campaign\GalleryController@search')->name('campaign.gallery.search');
Route::post('/gallery/ajax-upload', 'Campaign\GalleryController@ajaxUpload')->name('campaign.gallery.ajax-upload');
Route::get('/gallery/ajax-gallery', 'Campaign\AjaxGalleryController@index')->name('campaign.gallery.summernote');

// Abilities
Route::get('/abilities/{ability}/abilities', 'AbilityController@abilities')->name('abilities.abilities');
Route::get('/abilities/{ability}/entities', 'AbilityController@entities')->name('abilities.entities');
Route::get('/abilities/tree', 'AbilityController@tree')->name('abilities.tree');

Route::get('/abilities/{ability}/entity-add', 'AbilityController@entityAdd')->name('abilities.entity-add');
Route::post('/abilities/{ability}/entity-add', 'AbilityController@entityStore')->name('abilities.entity-add.save');

//Ability reorder
Route::get('/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'index'])
    ->name('entities.entity_abilities.reorder');
Route::post('/entity/{entity}/abilities/reorder', [\App\Http\Controllers\Entity\AbilityReorderController::class, 'save'])
    ->name('entities.entity_abilities.reorder-save');

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
//Route::get('/characters/{character}/map-points', 'CharacterSubController@mapPoints')->name('characters.map-points');

Route::get('/dice_rolls/{dice_roll}/roll', 'DiceRollController@roll')->name('dice_rolls.roll');
Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');
//Route::get('/dice_rolls/{dice_roll}/map-points', 'DiceRollController@mapPoints')->name('dice_rolls.map-points');

// Locations
Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
Route::any('/locations/{location}/map', 'LocationController@map')->name('locations.map');
Route::any('/locations/{location}/maps', 'LocationController@maps')->name('locations.maps');
Route::get('/locations/{location}/map-points', 'LocationController@mapPoints')->name('locations.map-points');
Route::any('/locations/{location}/map/admin', 'LocationController@mapAdmin')->name('locations.map.admin');
Route::post('/locations/{location}/map_points/{map_point}/move', 'LocationMapPointController@move')->name('locations.map_points.move');

Route::get('/locations/{location}/characters', 'LocationController@characters')->name('locations.characters');
Route::get('/locations/{location}/locations', 'LocationController@locations')->name('locations.locations');

// Organisation menu
Route::get('/organisations/{organisation}/members', 'OrganisationController@members')->name('organisations.members');
Route::get('/organisations/{organisation}/organisations', 'OrganisationController@organisations')->name('organisations.organisations');
Route::get('/organisations/tree', 'OrganisationController@tree')->name('organisations.tree');
//Route::get('/organisations/{organisation}/map-points', 'OrganisationController@mapPoints')->name('organisations.map-points');

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
//Route::get('/tags/{tag}/map-points', 'TagController@mapPoints')->name('tags.map-points');

// Tags Quick Add
Route::get('/tags/{tag}/entity-add', 'TagController@entityAdd')->name('tags.entity-add');
Route::post('/tags/{tag}/entity-add', 'TagController@entityStore')->name('tags.entity-add.save');

// Multi-delete for cruds
Route::post('/bulk/process', 'BulkController@process')->name('bulk.process');
Route::get('/bulk/modal', 'BulkController@modal')->name('bulk.modal');

// Notes
//Route::get('/notes/{note}/map-points', 'NoteController@mapPoints')->name('notes.map-points');
Route::get('/notes/tree', 'NoteController@tree')->name('notes.tree');

Route::get('/journals/tree', 'JournalController@tree')->name('journals.tree');

// Events
//Route::get('/events/{event}/map-points', 'EventController@mapPoints')->name('events.map-points');

// Calendar
Route::get('/calendars/tree', 'CalendarController@tree')->name('calendars.tree');
Route::get('/calendars/{calendar}/event', 'CalendarController@event')->name('calendars.event.create');
Route::post('/calendars/{calendar}/event', 'CalendarController@eventStore')->name('calendars.event.store');
Route::get('/calendars/{calendar}/month-list', 'CalendarController@monthList')->name('calendars.month-list');
Route::get('/calendars/{calendar}/events', 'CalendarController@events')->name('calendars.events');
Route::get('/calendars/{calendar}/today', 'CalendarController@today')->name('calendars.today');
//Route::get('/calendars/{calendar}/map-points', 'CalendarController@mapPoints')->name('calendars.map-points');

//        Route::get('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');

// Conversations
//Route::get('/conversations/{conversation}/map-points', 'ConversationController@mapPoints')->name('conversations.map-points');

// Attribute multi-save
Route::get('/entities/{entity}/attributes', [\App\Http\Controllers\Entity\AttributeController::class, 'index'])->name('entities.attributes');
Route::get('/entities/{entity}/attributes/edit', [\App\Http\Controllers\Entity\AttributeController::class, 'edit'])->name('entities.attributes.edit');
Route::post('/entities/{entity}/attributes/save', [\App\Http\Controllers\Entity\AttributeController::class, 'save'])->name('entities.attributes.save');
Route::get('/entities/{entity}/attributes/live-edit/', [\App\Http\Controllers\Entity\AttributeController::class, 'liveEdit'])
    ->name('entities.attributes.live.edit');
Route::post('/entities/{entity}/attributes/live-edit/{attribute}/save', [\App\Http\Controllers\Entity\AttributeController::class, 'liveSave'])
    ->name('entities.attributes.live.save');

Route::model('attribute', \App\Models\Attribute::class);


Route::get('/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'edit'])->name('entities.story.reorder');
Route::post('/entities/{entity}/story-reorder', [\App\Http\Controllers\Entity\StoryController::class, 'save'])->name('entities.story.reorder-save');
Route::get('/entities/{entity}/story-more', [\App\Http\Controllers\Entity\StoryController::class, 'more'])->name('entities.story.load-more');

// Image of entities
Route::get('/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'focus'])->name('entities.image.focus');
Route::post('/entities/{entity}/image-focus', [\App\Http\Controllers\Entity\ImageController::class, 'saveFocus'])->name('entities.image.save-focus');

Route::get('/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'replace'])->name('entities.image.replace');
Route::post('/entities/{entity}/image-replace', [\App\Http\Controllers\Entity\ImageController::class, 'update'])->name('entities.image.replace.save');

// Quick privacy toggle
Route::get('/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'index'])->name('entities.quick-privacy');
Route::post('/entities/{entity}/privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.quick-privacy.toggle');
//Route::post('/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');


// Entity update entry
Route::get('/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'edit'])->name('entities.entry.edit');
Route::patch('/entities/{entity}/entry', [\App\Http\Controllers\Entity\EntryController::class, 'update'])->name('entities.entry.update');

Route::get('/entities/{entity}/relations_map', 'Entity\RelationController@map')->name('entities.relations_map');
Route::get('/entities/{entity}/relations/table', 'Entity\RelationController@table')->name('entities.relations_table');

// Entity
Route::post('/entities/{entity}/confirm-editing', 'EditingController@confirm')->name('entities.confirm-editing');
Route::post('/entities/{entity}/keep-alive', 'EditingController@keepAlive')->name('entities.keep-alive');

// Campaign
Route::post('/editing/campaigns/{campaign}/confirm-editing', 'EditingController@confirmCampaign')->name('campaigns.confirm-editing');
Route::post('/editing/campaigns/{campaign}/keep-alive', 'EditingController@keepAliveCampaign')->name('campaigns.keep-alive');

// Posts
Route::post('/editing/posts/{entity}/{post}/confirm-editing', 'EditingController@confirmPost')->name('posts.confirm-editing');
Route::post('/editing/posts/{entity}/{post}/keep-alive', 'EditingController@keepAlivePost')->name('posts.keep-alive');

// Quest Elements
Route::post('/editing/quest-elements/{quest_element}/confirm-editing', 'EditingController@confirmQuestElement')->name('quest-elements.confirm-editing');
Route::post('/editing/quest-elements/{quest_element}/keep-alive', 'EditingController@keepAliveQuestElement')->name('quest-elements.keep-alive');

// Timeline Elements
Route::post('/editing/timeline-elements/{timeline_element}/confirm-editing', 'EditingController@confirmTimelineElement')->name('timeline-elements.confirm-editing');
Route::post('/editing/timeline-elements/{timeline_element}/keep-alive', 'EditingController@keepAliveTimelineElement')->name('timeline-elements.keep-alive');

// Permission save
Route::post('/campaign_roles/{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaign_roles.savePermissions');
Route::post('/campaign_roles/{campaign_role}/toggle/{entity}/{action}', 'CampaignRoleController@toggle')->name('campaign_roles.toggle');
Route::post('/campaign_roles/bulk', 'CampaignRoleController@bulk')->name('campaign_roles.bulk');

// Impersonator
Route::get('/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');


Route::post('/campaign_users/{campaign_user}/update-role/{campaign_role}', 'Campaign\MemberController@updateRoles')->name('campaign_users.update-roles');

// Recovery
Route::get('/recovery', 'Campaign\RecoveryController@index')->name('recovery');
Route::post('/recovery', 'Campaign\RecoveryController@recover')->name('recovery.save');



// Stats
Route::get('/stats', 'Campaign\StatController@index')->name('stats');

// User search
Route::get('/users/search', 'CampaignUserController@search')->name('users.find');
Route::get('/roles/search', 'CampaignRoleController@search')->name('roles.find');


Route::get('/default-images', 'Campaign\DefaultImageController@index')
    ->name('campaign.default-images');
Route::get('/default-images/create', 'Campaign\DefaultImageController@create')
    ->name('campaign.default-images.create');
Route::post('/default-images/create', 'Campaign\DefaultImageController@store')
    ->name('campaign.default-images.store');
Route::delete('/default-images', 'Campaign\DefaultImageController@destroy')
    ->name('campaign.default-images.delete');

Route::post('/gallery/folder', 'Campaign\GalleryController@folder')
    ->name('campaign.gallery.folder');

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

// Entity Abilities API
Route::get('/entities/{entity}/abilities', 'Entity\AbilityController@index')->name('entities.abilities');
Route::get('/entities/{entity}/entity_abilities/api', 'Entity\AbilityController@api')->name('entities.entity_abilities.api');
Route::get('/entities/{entity}/entity_abilities/import', 'Entity\AbilityController@import')->name('entities.entity_abilities.import');
Route::post('/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\AbilityController@useCharge')->name('entities.entity_abilities.use');
Route::get('/entities/{entity}/entity_abilities/reset', 'Entity\AbilityController@resetCharges')->name('entities.entity_abilities.reset');

Route::get('/entities/{entity}/entity_assets/{entity_asset}/go', 'Entity\AssetController@go')->name('entities.entity_assets.go');
Route::get('/entities/{entity}/quests', 'Entity\QuestController@index')->name('entities.quests');

Route::get('/entities/{entity}/profile', 'Entity\ProfileController@index')
    ->name('entities.profile');

//Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
Route::resources([
    'abilities' => 'AbilityController',
    'calendars' => 'CalendarController',
    'calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
    'campaigns' => 'CampaignController',
    'campaign_users' => 'CampaignUserController',
    'campaign_submissions' => 'Campaign\SubmissionController',
    'characters' => 'CharacterController',
    'characters.character_organisations' => 'CharacterOrganisationController',
    'conversations' => 'ConversationController',
    'conversations.conversation_participants' => 'ConversationParticipantController',
    'conversations.conversation_messages' => 'ConversationMessageController',
    'dice_rolls' => 'DiceRollController',
    'dice_roll_results' => 'DiceRollResultController',
    'events' => 'EventController',
    'locations' => 'LocationController',
    'locations.map_points' => 'LocationMapPointController',
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
    'campaign_invites' => 'CampaignInviteController',
    'races' => 'RaceController',
    'creatures' => 'CreatureController',
    'relations' => 'RelationController',

    // Entities
    //'entities.attributes' => 'AttributeController',
    'entities.entity_abilities' => 'Entity\AbilityController',
    'entities.entity_notes' => 'EntityNoteController',
    'entities.posts' => 'Entity\PostController',
    'entities.entity_events' => 'EntityEventController',
    //'entities.entity_files' => 'EntityFileController',
    //'entities.entity_links' => 'Entity\LinkController',
    //'entities.entity_aliases' => 'Entity\AliasController',
    'entities.entity_assets' => 'Entity\AssetController',
    'entities.inventories' => 'Entity\InventoryController',
    'entities.relations' => 'Entity\RelationController',

    'attribute_templates' => 'AttributeTemplateController',
    //'presets' => 'PresetController',

    // Permission manager
    'campaign_roles' => 'CampaignRoleController',
    'campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
    'campaign_styles' => 'Campaign\StyleController',
    //'campaigns.campaign_roles.campaign_permissions' => 'CampaignPermissions',

    'campaign_dashboards' => 'Campaign\DashboardController',
    'campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',

    'preset_types.presets' => 'PresetController',

    'images' => 'Campaign\GalleryController',
]);
Route::get('/leave-campaign', 'CampaignController@leave')->name('campaigns.leave');


Route::post('/campaign_styles/bulk', 'Campaign\StyleController@bulk')->name('campaign_styles.bulk');
Route::post('/campaign_styles/reorder', 'Campaign\StyleController@reorder')->name('campaign_styles.reorder-save');

Route::get('/campaigns/{campaign}/dashboard-header/{campaignDashboardWidget?}', 'Campaign\DashboardHeaderController@edit')->name('campaigns.dashboard-header.edit');
Route::patch('/campaigns/{campaign}/dashboard-header', 'Campaign\DashboardHeaderController@update')->name('campaigns.dashboard-header.update');

// Helper links
Route::get('/campaign-roles/admin', 'CampaignRoleController@admin')->name('campaigns.campaign_roles.admin');
Route::get('/campaign-roles/public', 'CampaignRoleController@public')->name('campaigns.campaign_roles.public');

// Marketplace plugin route
if(config('marketplace.enabled')) {
    Route::get('/plugins', 'Campaign\PluginController@index')->name('campaign_plugins.index');
    Route::delete('/plugins/{plugin}/delete', 'Campaign\PluginController@delete')->name('campaign_plugins.destroy');
    Route::get('/plugins/{plugin}/enable', 'Campaign\PluginController@enable')->name('campaign_plugins.enable');
    Route::get('/plugins/{plugin}/disable', 'Campaign\PluginController@disable')->name('campaign_plugins.disable');
    Route::post('/plugins/{plugin}/import', 'Campaign\PluginController@import')->name('campaign_plugins.import');
    Route::get('/plugins/{plugin}/confirm-import', 'Campaign\PluginController@confirmImport')->name('campaign_plugins.confirm-import');
    Route::get('/plugins/{plugin}/update', 'Campaign\PluginController@updateInfo')->name('campaign_plugins.update-info');
    Route::post('/plugins/{plugin}/update', 'Campaign\PluginController@update')->name('campaign_plugins.update');
    Route::post('/plugins/bulk', 'Campaign\PluginController@bulk')->name('campaign_plugins.bulk');
}

//Route::post('/timelines/{timeline}/timeline-era/{timeline_era}/reorder', 'Timelines\TimelineEraController@reorder')->name('timelines.reorder');
// Old Search
Route::get('/search', 'SearchController@search')->name('search');

// Misc Model Search
Route::get('/search/calendars', 'Search\MiscController@calendars')->name('calendars.find');
Route::get('/search/characters', 'Search\MiscController@characters')->name('characters.find');
Route::get('/search/campaigns', 'Search\MiscController@campaigns')->name('campaigns.find');
Route::get('/search/events', 'Search\MiscController@events')->name('events.find');
Route::get('/search/families', 'Search\MiscController@families')->name('families.find');
Route::get('/search/item', 'Search\MiscController@items')->name('items.find');
Route::get('/search/locations', 'Search\MiscController@locations')->name('locations.find');
Route::get('/search/notes', 'Search\MiscController@notes')->name('notes.find');
Route::get('/search/journals', 'Search\MiscController@journals')->name('journals.find');
Route::get('/search/timelines', 'Search\MiscController@timelines')->name('timelines.find');
Route::get('/search/organisations', 'Search\MiscController@organisations')->name('organisations.find');
Route::get('/search/tags', 'Search\MiscController@tags')->name('tags.find');
Route::get('/search/dice-rolls', 'Search\MiscController@diceRolls')->name('dice_rolls.find');
Route::get('/search/quests', 'Search\MiscController@quests')->name('quests.find');
Route::get('/search/conversations', 'Search\MiscController@conversations')->name('conversations.find');
Route::get('/search/races', 'Search\MiscController@races')->name('races.find');
Route::get('/search/creatures', 'Search\MiscController@creatures')->name('creatures.find');
Route::get('/search/abilities', 'Search\MiscController@abilities')->name('abilities.find');
Route::get('/search/maps', 'Search\MiscController@maps')->name('maps.find');
Route::get('/search/markers', 'Search\MiscController@markers')->name('markers.find');
Route::get('/search/attribute-templates', 'Search\MiscController@attributeTemplates')->name('attribute_templates.find');
Route::get('/search/images', 'Search\ImageSearchController@index')->name('images.find');

Route::get('/search/members', 'Search\CampaignSearchController@members')->name('find.campaign.members');
Route::get('/search/roles', 'Search\CampaignSearchController@roles')->name('find.campaign.roles');

// Entity Search
Route::get('/search/entity-calendars', 'Search\CalendarController@index')->name('search.calendars');
Route::get('/search/attributes/{entity}', 'Search\AttributeSearchController@index')->name('search.attributes');

// Global Entity Search
Route::get('/search/reminder-entities', 'Search\LiveController@reminderEntities')->name('search.entities-with-reminders');
Route::get('/search/relation-entities', 'Search\LiveController@relationEntities')->name('search.entities-with-relations');
Route::get('/search/tag-children', 'Search\LiveController@tagChildren')->name('search.tag-children');
Route::get('/search/ability-entities', 'Search\LiveController@abilityEntities')->name('search.ability-entities');
Route::get('/search/organisation-member', 'Search\LiveController@organisationMembers')->name('search.organisation-member');
Route::get('/search/months', 'Search\CalendarController@months')->name('search.calendar-months');
Route::get('/search/live', 'Search\LiveController@index')->name('search.live');

Route::get('/redirect', 'RedirectController@index')->name('redirect');

// Campaign Dashboard Widgets
Route::get('/dashboard-setup', 'DashboardSetupController@index')->name('dashboard.setup');
Route::post('/dashboard-setup', 'DashboardSetupController@save')->name('dashboard.setup');
Route::post('/dashboard-setup/reorder', [\App\Http\Controllers\DashboardSetupController::class, 'reorder'])->name('dashboard.reorder');
Route::get('/dashboard/widgets/recent/{id}', 'DashboardController@recent')->name('dashboard.recent');
Route::get('/dashboard/widgets/unmentioned/{id}', 'DashboardController@unmentioned')->name('dashboard.unmentioned');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/add', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'add'])->name('dashboard.calendar.add');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/sub', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'sub'])->name('dashboard.calendar.sub');
Route::get('/dashboard/widgets/{campaignDashboardWidget}/render', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'render'])->name('dashboard.calendar.render');

// Move
Route::get('/entities/{entity}/move', 'Entity\MoveController@index')->name('entities.move');
Route::post('/entities/{entity}/move', 'Entity\MoveController@move')->name('entities.move');
Route::get('/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@index')->name('posts.move');
Route::post('/entities/{entity}/posts/{post}/move', 'Entity\PostMoveController@move')->name('posts.move');

// Transform
Route::get('/entities/{entity}/transform', 'Entity\TransformController@index')->name('entities.transform');
Route::post('/entities/{entity}/transform', 'Entity\TransformController@transform')->name('entities.transform');

Route::get('/entities/{entity}/tooltip', 'EntityTooltipController@show')->name('entities.tooltip');

Route::get('/entities/{entity}/json-export', 'Entity\ExportController@json')->name('entities.json-export');

//Route::get('/entities/copy-to-campaign/{entity}', 'EntityController@copyToCampaign')->name('entities.copy_to_campaign');
//Route::post('/entities/copy-to-campaign/{entity}', 'EntityController@copyEntityToCampaign')->name('entities.copy_to_campaign');

// Entity files
Route::get('/entities/{entity}/files', 'EntityController@files')->name('entities.files');
Route::get('/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
Route::get('/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');
Route::get('/entities/{entity}/timelines', 'Entity\TimelineController@index')->name('entities.timelines');
Route::get('/entities/{entity}/map-markers', 'Entity\MapPointController@index')->name('entities.map-markers');
//Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

// Inventory
Route::get('/entities/{entity}/inventory', 'Entity\InventoryController@index')->name('entities.inventory');

// Export
Route::get('/entities/export/{entity}', 'EntityController@export')->name('entities.export');
Route::get('/entities/{entity}/html-export', 'Entity\ExportController@html')->name('entities.html-export');

Route::get('/entities/{entity}/template', 'EntityController@template')->name('entities.template');

// Attribute template
Route::get('/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@apply')->name('entities.attributes.template');
Route::post('/entities/{entity}/attribute-template', 'Entity\AttributeTemplateController@applyTemplate')->name('entities.attributes.template');

Route::get('/entities/{entity}/permissions', 'PermissionController@view')->name('entities.permissions');
Route::post('/entities/{entity}/permissions', 'PermissionController@store')->name('entities.permissions');

// The campaign management sub pages
Route::get('/overview', 'CampaignController@index')->name('campaign');
Route::get('/modules', 'CampaignSettingController@index')->name('campaign.modules');
Route::post('/modules/toggle/{module?}', 'CampaignSettingController@toggle')->name('campaign.modules.toggle');
Route::get('/campaign-theme', 'Campaign\StyleController@theme')->name('campaign-theme');
Route::post('/campaign-theme', 'Campaign\StyleController@themeSave')->name('campaign-theme.save');
Route::get('/campaign-export', 'Campaign\ExportController@index')->name('campaign.export');
Route::post('/campaign-export', 'Campaign\ExportController@export')->name('campaign.export-process');
Route::get('/campaign.styles', 'CampaignController@css')->name('campaign.css');
Route::get('/campaign_plugin.styles', 'Campaign\PluginController@css')->name('campaign_plugins.css');
Route::get('/campaign-visibility', 'Campaign\VisibilityController@edit')->name('campaign-visibility');
Route::post('/campaign-visibility', 'Campaign\VisibilityController@save')->name('campaign-visibility.save');

Route::get('/campaign-applications', 'Campaign\SubmissionController@toggle')->name('campaign-applications');
Route::post('/campaign-applications', 'Campaign\SubmissionController@toggleSave')->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/sidebar-setup', 'Campaign\SidebarController@index')->name('campaign-sidebar');
Route::post('/sidebar-setup', 'Campaign\SidebarController@save')->name('campaign-sidebar-save');
Route::delete('/sidebar-setup/reset', 'Campaign\SidebarController@reset')->name('campaign-sidebar-reset');

Route::get('/presets/type/{preset_type}/list', [\App\Http\Controllers\PresetController::class, 'presets'])->name('presets.list');
Route::get('/presets/type/{preset_type}/create', [\App\Http\Controllers\PresetController::class, 'create'])->name('presets.create');
Route::post('/presets/type/{preset_type}/store', [\App\Http\Controllers\PresetController::class, 'store'])->name('presets.store');
Route::post('/presets/{preset}/load', [\App\Http\Controllers\PresetController::class, 'load'])->name('presets.show');

Route::model('preset_type', \App\Models\PresetType::class);

// Entity quick creator
Route::get('/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::post('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');

Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
