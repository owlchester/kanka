<?php

use App\Http\Controllers\Campaign\CssController;
use App\Http\Controllers\Campaign\ModuleController;
use App\Http\Controllers\Campaign\Plugins\BulkController;
use App\Http\Controllers\Campaign\Plugins\ImportController;
use App\Http\Controllers\Campaign\Plugins\ToggleController;
use App\Http\Controllers\Campaign\Plugins\UpdateController;
use App\Http\Controllers\Campaign\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/w/{campaign}', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::post('/w/{campaign}/follow', 'Campaign\FollowController@update')->name('campaign.follow');

Route::get('/w/{campaign}/apply', 'Campaign\ApplyController@index')->name('campaign.apply');
Route::post('/w/{campaign}/apply', 'Campaign\ApplyController@save')->name('campaign.apply.save');
Route::delete('/w/{campaign}/remove', 'Campaign\ApplyController@remove')->name('campaign.apply.remove');

Route::get('/w/{campaign}/gallery', 'GalleryController@index')->name('gallery');
Route::get('/w/{campaign}/gallery-index', 'GalleryController@index')->name('campaign.gallery.index');

Route::post('/w/{campaign}/gallery/ajax-upload', 'Summernote\GalleryController@upload')->name('campaign.gallery.ajax-upload');
Route::get('/w/{campaign}/gallery/ajax-gallery', 'Summernote\GalleryController@index')->name('campaign.gallery.summernote');

Route::post('/w/{campaign}/gallery/upload/file', [App\Http\Controllers\Gallery\UploadController::class, 'file'])->name('gallery.upload.file');
Route::post('/w/{campaign}/gallery/upload/files', [App\Http\Controllers\Gallery\UploadController::class, 'files'])->name('gallery.upload.files');
Route::post('/w/{campaign}/gallery/upload/url', [App\Http\Controllers\Gallery\UploadController::class, 'url'])->name('gallery.upload.url');
Route::get('/w/{campaign}/gallery/browse', [App\Http\Controllers\Gallery\BrowseController::class, 'index'])->name('gallery.browse');

Route::get('/w/{campaign}/gallery/setup', [App\Http\Controllers\Gallery\SetupController::class, 'index'])->name('gallery.setup');
Route::get('/w/{campaign}/gallery/open/{image}', [App\Http\Controllers\Gallery\ImageController::class, 'show'])->name('gallery.show');
Route::get('/w/{campaign}/gallery/search/{term?}', [App\Http\Controllers\Gallery\SearchController::class, 'index'])->name('gallery.search');
Route::post('/w/{campaign}/gallery/delete', [App\Http\Controllers\Gallery\DeleteController::class, 'destroy'])->name('gallery.delete');
Route::post('/w/{campaign}/gallery/create', [App\Http\Controllers\Gallery\CreateController::class, 'index'])->name('gallery.create');
Route::post('/w/{campaign}/gallery/update/bulk', [App\Http\Controllers\Gallery\UpdateController::class, 'bulk'])->name('gallery.update');
Route::get('/w/{campaign}/gallery/{image}', [App\Http\Controllers\Gallery\ShowController::class, 'show'])->name('gallery.file.show');
Route::post('/w/{campaign}/gallery/{image}/update', [App\Http\Controllers\Gallery\UpdateController::class, 'process'])->name('gallery.file.update');
Route::delete('/w/{campaign}/gallery/{image}/delete', [App\Http\Controllers\Gallery\DeleteController::class, 'file'])->name('gallery.file.delete');
Route::post('/w/{campaign}/gallery/{image}/update-focus', [App\Http\Controllers\Gallery\UpdateController::class, 'focus'])->name('gallery.file.update-focus');

Route::get('/w/{campaign}/gallery/{image}/visibility', [App\Http\Controllers\Gallery\VisibilityController::class, 'index'])->name('gallery.file.visibility');
Route::patch('/w/{campaign}/gallery/{image}/visibility', [App\Http\Controllers\Gallery\VisibilityController::class, 'save'])->name('gallery.file.visibility-save');

// Campaign
Route::get('/w/{campaign}/editing-warning', [App\Http\Controllers\EditingController::class, 'index'])->name('campaign.editing-warning');
Route::post('/w/{campaign}/editing/confirm-editing', 'EditingController@confirmCampaign')->name('campaigns.confirm-editing');
Route::post('/w/{campaign}/editing/keep-alive', 'EditingController@keepAliveCampaign')->name('campaigns.keep-alive');

// Permission save
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/savePermissions', 'Campaign\RoleController@savePermissions')->name('campaign_roles.savePermissions');
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/toggle/{entityType}/{action}', 'Campaign\RoleController@toggle')->name('campaign_roles.toggle');
Route::post('/w/{campaign}/campaign_roles/bulk', 'Campaign\RoleController@bulk')->name('campaign_roles.bulk');

// Impersonator
Route::get('/w/{campaign}/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/w/{campaign}/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/w/{campaign}/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');

Route::get('/w/{campaign}/campaign_users/{campaign_user}/delete', [App\Http\Controllers\Campaign\MemberController::class, 'delete'])->name('campaign_users.delete');
Route::get('/w/{campaign}/campaign_user_roles/{campaign_user}', [App\Http\Controllers\Campaign\Members\RoleController::class, 'index'])->name('campaign.members.roles');
Route::post('/w/{campaign}/campaign_user_roles/{campaign_user}', [App\Http\Controllers\Campaign\Members\RoleController::class, 'save'])->name('campaign_users.update-roles');

// Recovery
Route::get('/w/{campaign}/recovery', 'Campaign\RecoveryController@index')->name('recovery');
Route::post('/w/{campaign}/recovery', 'Campaign\RecoveryController@recover')->name('recovery.save');
Route::get('/w/{campaign}/recovery-setup', 'Campaign\RecoveryController@setup')->name('recovery.setup');

// Stats
Route::get('/w/{campaign}/achievements', 'Campaign\AchievementController@index')->name('campaign.achievements');

// User search
Route::get('/w/{campaign}/users/search', 'Campaign\UserController@search')->name('users.find');
Route::get('/w/{campaign}/roles/search', 'Campaign\RoleController@search')->name('roles.find');

Route::get('/w/{campaign}/default-images', 'Campaign\DefaultImageController@index')
    ->name('campaign.default-images');
Route::get('/w/{campaign}/default-images/create', 'Campaign\DefaultImageController@create')
    ->name('campaign.default-images.create');
Route::post('/w/{campaign}/default-images/create', 'Campaign\DefaultImageController@store')
    ->name('campaign.default-images.store');
Route::delete('/w/{campaign}/default-images', 'Campaign\DefaultImageController@destroy')
    ->name('campaign.default-images.delete');
Route::delete('/w/{campaign}/default-images/reset', 'Campaign\DefaultImageController@reset')
    ->name('campaign.default-images.reset');

Route::resources([
    '/w/{campaign}/campaign_users' => 'Campaign\UserController',
    '/w/{campaign}/applications' => 'Campaign\ApplicationController',

    // Permission manager
    '/w/{campaign}/campaign_roles' => 'Campaign\RoleController',
    '/w/{campaign}/campaign_roles.campaign_role_users' => 'Campaign\RoleUserController',
    '/w/{campaign}/campaign_styles' => 'Campaign\StyleController',
    '/w/{campaign}/campaign_invites' => 'Campaign\InviteController',

    '/w/{campaign}/campaign_dashboards' => 'Campaign\DashboardController',
    '/w/{campaign}/campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',

    '/w/{campaign}/preset_types.presets' => 'PresetController',

    '/w/{campaign}/webhooks' => 'Campaign\WebhookController',
    '/w/{campaign}/entity_types' => 'Campaign\EntityTypeController',
]);
Route::get('/w/{campaign}/leave', 'Campaign\LeaveController@index')->name('campaign.leave');
Route::post('/w/{campaign}/leave-for-real', 'Campaign\LeaveController@process')->name('campaign.leave-process');

// Campaign CRUD
Route::get('/w/{campaign}/edit', [App\Http\Controllers\Crud\CampaignController::class, 'edit'])->name('campaigns.edit');
Route::patch('/w/{campaign}/update', [App\Http\Controllers\Crud\CampaignController::class, 'update'])->name('campaigns.update');

Route::post('/w/{campaign}/campaign_styles/bulk', 'Campaign\StyleController@bulk')->name('campaign_styles.bulk');
Route::get('/w/{campaign}/campaign_styles/{campaign_style}/toggle', [App\Http\Controllers\Campaign\StyleController::class, 'toggle'])->name('campaign_styles.toggle');
Route::post('/w/{campaign}/campaign_styles/reorder', 'Campaign\StyleController@reorder')->name('campaign_styles.reorder-save');
Route::get('/w/{campaign}/theme-builder', [App\Http\Controllers\Campaign\ThemeBuilderController::class, 'index'])->name('campaign_styles.builder');
Route::post('/w/{campaign}/theme-builder', [App\Http\Controllers\Campaign\ThemeBuilderController::class, 'save'])->name('campaign_styles.builder-save');
Route::delete('/w/{campaign}/theme-builder', [App\Http\Controllers\Campaign\ThemeBuilderController::class, 'reset'])->name('campaign_styles.builder-reset');

Route::get('/w/{campaign}/dashboard-header/{campaignDashboardWidget?}', 'Campaign\DashboardHeaderController@edit')->name('campaigns.dashboard-header.edit');
Route::patch('/w/{campaign}/dashboard-header', 'Campaign\DashboardHeaderController@update')->name('campaigns.dashboard-header.update');

// Helper links
Route::get('/w/{campaign}/campaign-roles/admin', 'Campaign\RoleController@admin')->name('campaigns.campaign_roles.admin');
Route::get('/w/{campaign}/campaign-roles/public', 'Campaign\RoleController@public')->name('campaigns.campaign_roles.public');
Route::get('/w/{campaign}/campaign-roles/{campaign_role}/duplicate', 'Campaign\RoleController@duplicate')->name('campaign_roles.duplicate');

// Marketplace plugin route
if (config('marketplace.enabled')) {
    Route::get('/w/{campaign}/plugins', 'Campaign\PluginController@index')->name('campaign_plugins.index');
    Route::delete('/w/{campaign}/plugins/{plugin}/delete', 'Campaign\PluginController@delete')->name('campaign_plugins.destroy');
    Route::get('/w/{campaign}/plugins/{plugin}/enable', [ToggleController::class, 'enable'])->name('campaign_plugins.enable');
    Route::get('/w/{campaign}/plugins/{plugin}/disable', [ToggleController::class, 'disable'])->name('campaign_plugins.disable');

    Route::get('/w/{campaign}/plugins/{plugin}/confirm-import', [ImportController::class, 'index'])->name('campaign_plugins.confirm-import');
    Route::post('/w/{campaign}/plugins/{plugin}/import', [ImportController::class, 'process'])->name('campaign_plugins.import');

    Route::get('/w/{campaign}/plugins/{plugin}/update', [UpdateController::class, 'index'])->name('campaign_plugins.update-info');
    Route::post('/w/{campaign}/plugins/{plugin}/update', [UpdateController::class, 'update'])->name('campaign_plugins.update');

    Route::post('/w/{campaign}/plugins/bulk', [BulkController::class, 'index'])->name('campaign_plugins.bulk');
}

// Campaign Dashboard Widgets
Route::get('/w/{campaign}/dashboard-setup', [App\Http\Controllers\Dashboards\SetupController::class, 'index'])->name('dashboard.setup');
Route::post('/w/{campaign}/dashboard-setup/reorder', [App\Http\Controllers\Dashboards\SetupController::class, 'save'])->name('dashboard.reorder');
Route::get('/w/{campaign}/dashboard/widgets/recent/{id}', 'DashboardController@recent')->name('dashboard.recent');
Route::get('/w/{campaign}/dashboard/widgets/unmentioned/{id}', 'DashboardController@unmentioned')->name('dashboard.unmentioned');
Route::post('/w/{campaign}/dashboard/widgets/calendar/{campaignDashboardWidget}/add', [App\Http\Controllers\Widgets\CalendarWidgetController::class, 'add'])->name('dashboard.calendar.add');
Route::post('/w/{campaign}/dashboard/widgets/calendar/{campaignDashboardWidget}/sub', [App\Http\Controllers\Widgets\CalendarWidgetController::class, 'sub'])->name('dashboard.calendar.sub');
Route::get('/w/{campaign}/dashboard/widgets/{campaignDashboardWidget}/render', [App\Http\Controllers\Widgets\CalendarWidgetController::class, 'render'])->name('dashboard.calendar.render');

// The campaign management subpages
Route::get('/w/{campaign}/overview', 'Crud\CampaignController@show')->name('overview');
Route::get('/w/{campaign}/modules', 'Campaign\ModuleController@index')->name('campaign.modules');
Route::post('/w/{campaign}/modules/toggle/{entity_type}', [ModuleController::class, 'toggle'])->name('campaign.modules.toggle');
Route::post('/w/{campaign}/features/toggle/{module}', [ModuleController::class, 'toggleFeature'])->name('campaign.features.toggle');

// Route::get('/w/{campaign}/entity_types/create', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'create'])->name('campaign.entity_types.create');
// Route::post('/w/{campaign}/entity_types/create', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'store'])->name('campaign.entity_types.store');
//
// Route::get('/w/{campaign}/entity_types/{entity_type}/edit', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'edit'])->name('campaign.entity_types.edit');
// Route::patch('/w/{campaign}/entity_types/{entity_type}/update', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'update'])->name('campaign.entity_types.update');
Route::post('/w/{campaign}/entity_types/{entity_type}/toggle', [App\Http\Controllers\Campaign\EntityTypeController::class, 'toggle'])->name('entity_types.toggle');
// Route::delete('/w/{campaign}/entity_types/{entity_type}/delete', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'delete'])->name('campaign.entity_types.destroy');
Route::get('/w/{campaign}/entity_types/{entity_type}/confirm', [App\Http\Controllers\Campaign\EntityTypeController::class, 'confirm'])->name('entity_types.confirm');

Route::get('/w/{campaign}/campaign-theme', 'Campaign\StyleController@theme')->name('campaign-theme');
Route::post('/w/{campaign}/campaign-theme', 'Campaign\StyleController@themeSave')->name('campaign-theme.save');
Route::get('/w/{campaign}/campaign-export', 'Campaign\ExportController@index')->name('campaign.export');
Route::post('/w/{campaign}/campaign-export', 'Campaign\ExportController@export')->name('campaign.export-process');
Route::get('/w/{campaign}/campaign-import', 'Campaign\ImportController@index')->name('campaign.import');
Route::post('/w/{campaign}/campaign-import', 'Campaign\ImportController@store')->name('campaign.import-process');
Route::get('/w/{campaign}/campaign-{ts}.styles', [CssController::class, 'index'])->name('campaign.css');
Route::get('/w/{campaign}/campaign_plugin-{ts}.styles', 'Campaign\Plugins\CssController@index')->name('campaign_plugins.css');
Route::get('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@edit')->name('campaign-visibility');
Route::post('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@save')->name('campaign-visibility.save');

Route::get('/w/{campaign}/modules/{entity_type}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
Route::patch('/w/{campaign}/modules/{entity_type}/update', [ModuleController::class, 'update'])->name('modules.update');
Route::delete('/w/{campaign}/modules/reset', [ModuleController::class, 'reset'])->name('modules.reset');

Route::get('/w/{campaign}/campaign-applications', 'Campaign\ApplicationController@toggle')->name('campaign-applications');
Route::post('/w/{campaign}/campaign-applications', 'Campaign\ApplicationController@toggleSave')->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@index')->name('campaign-sidebar');
Route::post('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@save')->name('campaign-sidebar-save');
Route::delete('/w/{campaign}/sidebar-setup/reset', 'Campaign\SidebarController@reset')->name('campaign-sidebar-reset');

Route::get('/w/{campaign}/campaign-defaults', 'Campaign\DefaultsController@index')->name('campaign-defaults');
Route::post('/w/{campaign}/campaign-defaults', 'Campaign\DefaultsController@save')->name('campaign-defaults-save');

Route::get('/w/{campaign}/presets/type/{preset_type}/list', [App\Http\Controllers\PresetController::class, 'presets'])->name('presets.list');
Route::get('/w/{campaign}/presets/type/{preset_type}/create', [App\Http\Controllers\PresetController::class, 'create'])->name('presets.create');
Route::post('/w/{campaign}/presets/type/{preset_type}/store', [App\Http\Controllers\PresetController::class, 'store'])->name('presets.store');
Route::post('/w/{campaign}/presets/{preset}/load', [App\Http\Controllers\PresetController::class, 'load'])->name('presets.show');

Route::model('preset_type', App\Models\PresetType::class);

Route::get('/w/{campaign}/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');

Route::get('/w/{campaign}/bragi', [App\Http\Controllers\Bragi\BragiController::class, 'index'])->name('bragi');
Route::post('/w/{campaign}/bragi', [App\Http\Controllers\Bragi\BragiController::class, 'generate'])->name('bragi.generate');

Route::get('/w/{campaign}/confirm-delete', [App\Http\Controllers\ConfirmController::class, 'index'])->name('confirm-delete');
Route::post('/w/{campaign}/vanity-validate', [App\Http\Controllers\Campaign\VanityController::class, 'index'])->name('campaign.vanity-validate');

// Permission save
Route::get('/w/{campaign}/webhooks/{webhook}/toggle', [App\Http\Controllers\Campaign\WebhookController::class, 'toggle'])->name('webhooks.toggle');
Route::get('/w/{campaign}/webhooks/{webhook}/status', [App\Http\Controllers\Campaign\WebhookController::class, 'status'])->name('webhooks.status');
Route::post('/w/{campaign}/webhooks/bulk', [App\Http\Controllers\Campaign\WebhookController::class, 'bulk'])->name('webhooks.bulk');
Route::get('/w/{campaign}/webhooks/{webhook}/test', [App\Http\Controllers\Campaign\WebhookController::class, 'test'])->name('webhooks.test');

Route::get('/w/{campaign}/attributes/api/type/{entity_type}', [App\Http\Controllers\Attributes\ApiController::class, 'index'])->name('attributes.api');
Route::get('/w/{campaign}/attributes/api/entity/{entity}', [App\Http\Controllers\Attributes\ApiController::class, 'entity'])->name('attributes.api-entity');

Route::get('/w/{campaign}/templates/load', [App\Http\Controllers\Templates\LoadController::class, 'index'])->name('templates.load-attributes');

Route::get('/w/{campaign}/deletion', [App\Http\Controllers\Campaign\DeleteController::class, 'show'])->name('campaign.delete');
Route::delete('/w/{campaign}/destroy', [App\Http\Controllers\Campaign\DeleteController::class, 'destroy'])->name('campaigns.destroy');

Route::get('/w/{campaign}/sidebar/image', [App\Http\Controllers\Campaign\ImageController::class, 'index'])->name('campaign.sidebar.image');
Route::post('/w/{campaign}/sidebar/image', [App\Http\Controllers\Campaign\ImageController::class, 'save'])->name('campaign.sidebar.image-save');

Route::get('/w/{campaign}/stats', [App\Http\Controllers\Campaign\StatController::class, 'index'])->name('campaign.stats');

Route::get('/w/{campaign}/logs', [App\Http\Controllers\Campaign\LogController::class, 'index'])->name('campaign.logs');

Route::post('/w/{campaign}/onboarding/initial', [
    \App\Http\Controllers\Onboarding\InitialController::class, 'save',
])->name('campaign.onboarding.initial');
Route::post('/w/{campaign}/onboarding/initial-skip', [
    \App\Http\Controllers\Onboarding\InitialController::class, 'skip',
])->name('campaign.onboarding.initial-skip');

Route::get('/w/{campaign}/widgets/getting-started', [
    \App\Http\Controllers\Dashboards\GettingStartedController::class, 'index',
])->name('campaign.widgets.getting-started');

Route::get('/w/{campaign}/connections/web', [WebController::class, 'index'])->name('connections.web');
Route::get('/w/{campaign}/connections/web/api', [WebController::class, 'api'])->name('connections.web.api');
