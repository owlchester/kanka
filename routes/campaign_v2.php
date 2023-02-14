<?php

Route::get('/overview', [\App\Http\Controllers\CampaignController::class, 'index'])->name('overview');

Route::get('/leave', [\App\Http\Controllers\CampaignController::class, 'leave'])->name('leave');


// Campaign CRUD
Route::get('/edit', [\App\Http\Controllers\CampaignController::class, 'edit'])->name('edit');
Route::patch('/update', [\App\Http\Controllers\CampaignController::class, 'update'])->name('update');
Route::delete('/destroy', [\App\Http\Controllers\CampaignController::class, 'destroy'])->name('destroy');

Route::get('/modules', [\App\Http\Controllers\Campaign\ModuleController::class, 'index'])->name('modules');
Route::post('/modules/toggle/{module?}', [\App\Http\Controllers\Campaign\ModuleController::class, 'toggle'])->name('modules.toggle');

Route::get('/campaign-theme', [\App\Http\Controllers\Campaign\StyleController::class, 'theme'])->name('campaign-theme');
Route::post('/campaign-theme', [\App\Http\Controllers\Campaign\StyleController::class, 'themeSave'])->name('campaign-theme.save');

Route::get('/export', [\App\Http\Controllers\Campaign\ExportController::class, 'index'])->name('export');
Route::post('/export', [\App\Http\Controllers\Campaign\ExportController::class, 'export'])->name('export-process');

Route::get('/campaign.styles', [\App\Http\Controllers\CampaignController::class, 'css'])->name('campaign.css');
Route::get('/campaign_plugin.styles', [\App\Http\Controllers\Campaign\PluginController::class, 'css'])->name('campaign_plugins.css');


Route::get('/campaign-visibility', [\App\Http\Controllers\Campaign\VisibilityController::class, 'edit'])->name('campaign-visibility');
Route::post('/campaign-visibility', [\App\Http\Controllers\Campaign\VisibilityController::class, 'save'])->name('campaign-visibility.save');

Route::get('/campaign-applications', [\App\Http\Controllers\Campaign\SubmissionController::class, 'toggle'])->name('campaign-applications');
Route::post('/campaign-applications', [\App\Http\Controllers\Campaign\SubmissionController::class, 'toggleSave'])->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/sidebar-setup', [\App\Http\Controllers\Campaign\SidebarController::class, 'index'])->name('campaign-sidebar');
Route::post('/sidebar-setup', [\App\Http\Controllers\Campaign\SidebarController::class, 'save'])->name('campaign-sidebar-save');
Route::delete('/sidebar-setup', [\App\Http\Controllers\Campaign\SidebarController::class, 'reset'])->name('campaign-sidebar-reset');


Route::post('/follow', [\App\Http\Controllers\Campaign\FollowController::class, 'update'])->name('follow');


Route::get('/apply', [\App\Http\Controllers\Campaign\ApplyController::class, 'index'])->name('application');
Route::post('/apply', [\App\Http\Controllers\Campaign\ApplyController::class, 'save'])->name('apply-save');
Route::delete('/remove', [\App\Http\Controllers\Campaign\ApplyController::class, 'remove'])->name('apply-remove');

// Helper links
Route::get('/campaign-roles/admin', [\App\Http\Controllers\Campaign\RoleController::class, 'admin'])->name('campaign_roles.admin');
Route::get('/campaign-roles/public', [\App\Http\Controllers\Campaign\RoleController::class, 'public'])->name('campaign_roles.public');

// Recovery
Route::get('/recovery', [\App\Http\Controllers\Campaign\RecoveryController::class, 'index'])->name('recovery');
Route::post('/recovery', [\App\Http\Controllers\Campaign\RecoveryController::class, 'recover'])->name('recovery.save');

// Stats
Route::get('/stats', [\App\Http\Controllers\Campaign\StatController::class, 'index'])->name('stats');

Route::post('/styles/bulk', [\App\Http\Controllers\Campaign\StyleController::class, 'bulk'])->name('campaign_styles.bulk');
Route::post('/styles/reorder', [\App\Http\Controllers\Campaign\StyleController::class, 'reorder'])->name('styles.reorder');

Route::post('/campaign_users/{campaign_user}/update-role/{campaign_role}', [\App\Http\Controllers\Campaign\MemberController::class, 'updateRoles'])->name('campaign_users.update-roles');

// Dashboard header
Route::get('/dashboard-header/{campaignDashboardWidget?}', [\App\Http\Controllers\Campaign\DashboardHeaderController::class, 'edit'])->name('dashboard-header.edit');
Route::patch('/dashboard-header', [\App\Http\Controllers\Campaign\DashboardHeaderController::class, 'update'])->name('dashboard-header.update');

// Default images
Route::get('/default-images', [\App\Http\Controllers\Campaign\DefaultImageController::class, 'index'])
    ->name('default-images');
Route::get('/default-images/create', [\App\Http\Controllers\Campaign\DefaultImageController::class, 'create'])
    ->name('default-images.create');
Route::post('/default-images/create', [\App\Http\Controllers\Campaign\DefaultImageController::class, 'store'])
    ->name('default-images.store');
Route::delete('/default-images', [\App\Http\Controllers\Campaign\DefaultImageController::class, 'destroy'])
    ->name('default-images.delete');

Route::resources([
    'campaign_users' => 'CampaignUserController',
    'campaign_submissions' => 'Campaign\SubmissionController',
    'campaign_invites' => 'CampaignInviteController',
    'campaign_roles' => 'CampaignRoleController',
    'campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
    'campaign_styles' => 'Campaign\StyleController',
    'campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',
    'images' => 'Campaign\GalleryController',
]);

Route::post('/campaign_roles/{campaign_role}/savePermissions', [\App\Http\Controllers\Campaign\RoleController::class, 'savePermissions'])->name('campaign_roles.savePermissions');
Route::post('/campaign_roles/{campaign_role}/toggle/{entity}/{action}', [\App\Http\Controllers\Campaign\RoleController::class, 'toggle'])->name('campaign_roles.toggle');
Route::post('/campaign_roles/bulk', 'CampaignRoleController@bulk')->name('campaign_roles.bulk');


// User & role search

Route::get('/members/search', [\App\Http\Controllers\Campaign\MemberController::class, 'search'])->name('users.find');
Route::get('/roles/search', [\App\Http\Controllers\Campaign\RoleController::class, 'search'])->name('roles.find');

// Marketplace plugin route
if(config('marketplace.enabled')) {
    Route::get('/plugins', [\App\Http\Controllers\Campaign\PluginController::class, 'index'])->name('campaign_plugins.index');

    Route::delete('/plugins/{plugin}/delete', [\App\Http\Controllers\Campaign\PluginController::class, 'delete'])->name('campaign_plugins.destroy');
    Route::get('/plugins/{plugin}/enable', [\App\Http\Controllers\Campaign\PluginController::class, 'enable'])->name('campaign_plugins.enable');
    Route::get('/plugins/{plugin}/disable', [\App\Http\Controllers\Campaign\PluginController::class, 'disable'])->name('campaign_plugins.disable');
    Route::post('/plugins/{plugin}/import', [\App\Http\Controllers\Campaign\PluginController::class, 'import'])->name('campaign_plugins.import');
    Route::get('/plugins/{plugin}/confirm-import', [\App\Http\Controllers\Campaign\PluginController::class, 'confirmImport'])->name('campaign_plugins.confirm-import');
    Route::get('/plugins/{plugin}/update', [\App\Http\Controllers\Campaign\PluginController::class, 'updateInfo'])->name('campaign_plugins.update-info');
    Route::post('/plugins/{plugin}/update', [\App\Http\Controllers\Campaign\PluginController::class, 'update'])->name('campaign_plugins.update');
    Route::post('/plugins/bulk', [\App\Http\Controllers\Campaign\PluginController::class, 'bulk'])->name('campaign_plugins.bulk');
}


// Campaign Dashboard Widgets
Route::get('/dashboard-setup', [\App\Http\Controllers\DashboardSetupController::class, 'index'])->name('dashboard.setup');
Route::post('/dashboard-setup', [\App\Http\Controllers\DashboardSetupController::class, 'save'])->name('dashboard.setup');
Route::post('/dashboard-setup/reorder', [\App\Http\Controllers\DashboardSetupController::class, 'reorder'])->name('dashboard.reorder');
Route::get('/dashboard/widgets/recent/{id}', [\App\Http\Controllers\DashboardController::class, 'recent'])->name('dashboard.recent');
Route::get('/dashboard/widgets/unmentioned/{id}', [\App\Http\Controllers\DashboardController::class, 'unmentioned'])->name('dashboard.unmentioned');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/add', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'add'])->name('dashboard.calendar.add');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/sub', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'sub'])->name('dashboard.calendar.sub');
Route::get('/dashboard/widgets/{campaignDashboardWidget}/render', [\App\Http\Controllers\Widgets\CalendarWidgetController::class, 'render'])->name('dashboard.calendar.render');


// Gallery
Route::get('/gallery', [\App\Http\Controllers\Campaign\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/load', [\App\Http\Controllers\Campaign\GalleryController::class, 'load'])->name('gallery.load');
Route::get('/gallery/search', [\App\Http\Controllers\Campaign\GalleryController::class, 'search'])->name('gallery.search');
Route::post('/gallery/ajax-upload', [\App\Http\Controllers\Campaign\GalleryController::class, 'ajaxUpload'])->name('gallery.ajax-upload');
Route::post('/gallery/folder', [\App\Http\Controllers\Campaign\GalleryController::class, 'folder'])
    ->name('gallery.folder');
// Gallery view in summernote
Route::get('/gallery/ajax-gallery', [\App\Http\Controllers\Campaign\AjaxGalleryController::class, 'index'])->name('gallery.summernote');


// General campaign features
Route::get('/history', [\App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');

// Bragi plugin for summernote
Route::get('/bragi', [\App\Http\Controllers\Bragi\BragiController::class, 'index'])->name('bragi');
Route::post('/bragi', [\App\Http\Controllers\Bragi\BragiController::class, 'generate'])->name('bragi.generate');

// Map market presets
Route::get('/presets/type/{preset_type}/list', [\App\Http\Controllers\PresetController::class, 'presets'])->name('presets.list');
Route::get('/presets/type/{preset_type}/create', [\App\Http\Controllers\PresetController::class, 'create'])->name('presets.create');
Route::post('/presets/type/{preset_type}/store', [\App\Http\Controllers\PresetController::class, 'store'])->name('presets.store');
Route::post('/presets/{preset}/load', [\App\Http\Controllers\PresetController::class, 'load'])->name('presets.show');

Route::resources([
    'preset_types.presets' => \App\Http\Controllers\PresetController::class,
]);

// Edit warning for entity
Route::post('/editing/entities/{entity}/confirm-editing', [\App\Http\Controllers\EditingController::class, 'confirmEntity'])->name('entities.confirm-editing');
Route::post('/editing/entities/{entity}/keep-alive', [\App\Http\Controllers\EditingController::class, 'keepAliveEntity'])->name('entities.keep-alive');
Route::post('/editing/campaign/confirm-editing', [\App\Http\Controllers\EditingController::class, 'confirmCampaign'])->name('campaign.confirm-editing');
Route::post('/editing/campaign/keep-alive', [\App\Http\Controllers\EditingController::class, 'keepAliveCampaign'])->name('campaign.keep-alive');
Route::post('/editing/posts/{entity}/{post}/confirm-editing', [\App\Http\Controllers\EditingController::class, 'confirmPost'])->name('posts.confirm-editing');
Route::post('/editing/posts/{entity}/{post}/keep-alive', [\App\Http\Controllers\EditingController::class, 'keepAlivePost'])->name('posts.keep-alive');
Route::post('/editing/quest-elements/{quest_element}/confirm-editing', [\App\Http\Controllers\EditingController::class, 'confirmQuestElement'])->name('quest-elements.confirm-editing');
Route::post('/editing/quest-elements/{quest_element}/keep-alive', [\App\Http\Controllers\EditingController::class, 'keepAliveQuestElement'])->name('quest-elements.keep-alive');
Route::post('/editing/timeline-elements/{timeline_element}/confirm-editing', [\App\Http\Controllers\EditingController::class, 'confirmTimelineElement'])->name('timeline-elements.confirm-editing');
Route::post('/editing/timeline-elements/{timeline_element}/keep-alive', [\App\Http\Controllers\EditingController::class, 'keepAliveTimelineElement'])->name('timeline-elements.keep-alive');


// Quick Creator
Route::get('/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
Route::get('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
Route::post('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');


// Old search


Route::get('/search/calendars', [\App\Http\Controllers\Search\MiscController::class, 'calendars'])->name('calendars.find');
Route::get('/search/characters', [\App\Http\Controllers\Search\MiscController::class, 'characters'])->name('characters.find');
Route::get('/search/campaigns', [\App\Http\Controllers\Search\MiscController::class, 'campaigns'])->name('campaigns.find');
Route::get('/search/events', [\App\Http\Controllers\Search\MiscController::class, 'events'])->name('events.find');
Route::get('/search/families', [\App\Http\Controllers\Search\MiscController::class, 'families'])->name('families.find');
Route::get('/search/item', [\App\Http\Controllers\Search\MiscController::class, 'items'])->name('items.find');
Route::get('/search/locations', [\App\Http\Controllers\Search\MiscController::class, 'locations'])->name('locations.find');
Route::get('/search/notes', [\App\Http\Controllers\Search\MiscController::class, 'notes'])->name('notes.find');
Route::get('/search/journals', [\App\Http\Controllers\Search\MiscController::class, 'journals'])->name('journals.find');
Route::get('/search/timelines', [\App\Http\Controllers\Search\MiscController::class, 'timelines'])->name('timelines.find');
Route::get('/search/organisations', [\App\Http\Controllers\Search\MiscController::class, 'organisations'])->name('organisations.find');
Route::get('/search/tags', [\App\Http\Controllers\Search\MiscController::class, 'tags'])->name('tags.find');
Route::get('/search/dice-rolls', [\App\Http\Controllers\Search\MiscController::class, 'diceRolls'])->name('dice_rolls.find');
Route::get('/search/quests', [\App\Http\Controllers\Search\MiscController::class, 'quests'])->name('quests.find');
Route::get('/search/conversations', [\App\Http\Controllers\Search\MiscController::class, 'conversations'])->name('conversations.find');
Route::get('/search/races', [\App\Http\Controllers\Search\MiscController::class, 'races'])->name('races.find');
Route::get('/search/creatures', [\App\Http\Controllers\Search\MiscController::class, 'creatures'])->name('creatures.find');
Route::get('/search/abilities', [\App\Http\Controllers\Search\MiscController::class, 'abilities'])->name('abilities.find');
Route::get('/search/maps', [\App\Http\Controllers\Search\MiscController::class, 'maps'])->name('maps.find');
Route::get('/search/markers', [\App\Http\Controllers\Search\MiscController::class, 'markers'])->name('markers.find');
Route::get('/search/attribute-templates', [\App\Http\Controllers\Search\MiscController::class, 'attributeTemplates'])->name('attribute_templates.find');

// Misc Model Search
Route::get('/search/images', [\App\Http\Controllers\Search\ImageSearchController::class, 'index'])->name('images.find');

//Route::get('/search/members', [\App\Http\Controllers\Search\CampaignSearchController::class, 'members'])->name('find.campaign.members');
//Route::get('/search/roles', [\App\Http\Controllers\Search\CampaignSearchController::class, 'roles'])->name('find.campaign.roles');

// Entity Search
Route::get('/search/entity-calendars', [\App\Http\Controllers\Search\CalendarController::class, 'index'])->name('search.calendars');
Route::get('/search/attributes/{entity}', [\App\Http\Controllers\Search\AttributeSearchController::class, 'index'])->name('search.attributes');

// Global Entity Search
Route::get('/search/live', [\App\Http\Controllers\Search\LiveController::class, 'index'])->name('search.live');
Route::get('/search/reminder-entities', [\App\Http\Controllers\Search\LiveController::class, 'reminderEntities'])->name('search.entities-with-reminders');
Route::get('/search/relation-entities', [\App\Http\Controllers\Search\LiveController::class, 'relationEntities'])->name('search.entities-with-relations');
Route::get('/search/tag-children', [\App\Http\Controllers\Search\LiveController::class, 'tagChildren'])->name('search.tag-children');
Route::get('/search/ability-entities', [\App\Http\Controllers\Search\LiveController::class, 'abilityEntities'])->name('search.ability-entities');
Route::get('/search/organisation-member', [\App\Http\Controllers\Search\LiveController::class, 'organisationMembers'])->name('search.organisation-member');
Route::get('/search/months', [\App\Http\Controllers\Search\CalendarController::class, 'months'])->name('search.calendar-months');

// The good old search
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
