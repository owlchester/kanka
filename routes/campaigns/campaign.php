<?php

use Illuminate\Support\Facades\Route;

Route::get('/w/{campaign}', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::post('/w/{campaign}/follow', 'Campaign\FollowController@update')->name('campaign.follow');

Route::get('/w/{campaign}/apply', 'Campaign\ApplyController@index')->name('campaign.apply');
Route::post('/w/{campaign}/apply', 'Campaign\ApplyController@save')->name('campaign.apply.save');
Route::delete('/w/{campaign}/remove', 'Campaign\ApplyController@remove')->name('campaign.apply.remove');

Route::get('/w/{campaign}/gallery', 'Campaign\GalleryController@index')->name('gallery');
Route::get('/w/{campaign}/gallery-index', 'Campaign\GalleryController@index')->name('campaign.gallery.index');
Route::get('/w/{campaign}/gallery/search', [App\Http\Controllers\Campaign\Gallery\SearchController::class, 'index'])->name('campaign.gallery.search');
Route::get('/w/{campaign}/gallery/folders/create', [App\Http\Controllers\Campaign\Gallery\FolderController::class, 'create'])->name('campaign.gallery.folders.create');
Route::post('/w/{campaign}/gallery/folders', [App\Http\Controllers\Campaign\Gallery\FolderController::class, 'store'])->name('campaign.gallery.folders.store');

Route::get('/w/{campaign}/gallery/{image}/save-focus', [App\Http\Controllers\Campaign\Gallery\FocusController::class, 'index'])->name('campaign.gallery.focus');
Route::post('/w/{campaign}/gallery/{image}/save-focus', [App\Http\Controllers\Campaign\Gallery\FocusController::class, 'save'])->name('campaign.gallery.save-focus');

Route::post('/w/{campaign}/gallery/bulk', [App\Http\Controllers\Campaign\Gallery\BulkController::class, 'delete'])->name('campaign.gallery.bulk.delete');
Route::post('/w/{campaign}/gallery/ajax-upload', 'Summernote\GalleryController@upload')->name('campaign.gallery.ajax-upload');
Route::get('/w/{campaign}/gallery/ajax-gallery', 'Summernote\GalleryController@index')->name('campaign.gallery.summernote');

Route::post('/w/{campaign}/gallery/upload/file', [App\Http\Controllers\Gallery\UploadController::class, 'file'])->name('gallery.upload.file');
Route::post('/w/{campaign}/gallery/upload/url', [App\Http\Controllers\Gallery\UploadController::class, 'url'])->name('gallery.upload.url');
Route::get('/w/{campaign}/gallery/browse', [App\Http\Controllers\Gallery\BrowseController::class, 'index'])->name('gallery.browse');


// Campaign
Route::get('/w/{campaign}/editing-warning', [App\Http\Controllers\EditingController::class, 'index'])->name('campaign.editing-warning');
Route::post('/w/{campaign}/editing/confirm-editing', 'EditingController@confirmCampaign')->name('campaigns.confirm-editing');
Route::post('/w/{campaign}/editing/keep-alive', 'EditingController@keepAliveCampaign')->name('campaigns.keep-alive');

// Permission save
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/savePermissions', 'Campaign\RoleController@savePermissions')->name('campaign_roles.savePermissions');
Route::post('/w/{campaign}/campaign_roles/{campaign_role}/toggle/{entity}/{action}', 'Campaign\RoleController@toggle')->name('campaign_roles.toggle');
Route::post('/w/{campaign}/campaign_roles/bulk', 'Campaign\RoleController@bulk')->name('campaign_roles.bulk');

// Impersonator
Route::get('/w/{campaign}/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/w/{campaign}/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/w/{campaign}/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');


Route::post('/w/{campaign}/campaign_users/{campaign_user}/update-role/{campaign_role}', 'Campaign\MemberController@updateRoles')->name('campaign_users.update-roles');
Route::get('/w/{campaign}/campaign_users/{campaign_user}/delete', [App\Http\Controllers\Campaign\MemberController::class, 'delete'])->name('campaign_users.delete');
Route::get('/w/{campaign}/campaign_user_roles/{campaign_user}', [App\Http\Controllers\Campaign\Members\RoleController::class, 'index'])->name('campaign.members.roles');

// Recovery
Route::get('/w/{campaign}/recovery', 'Campaign\RecoveryController@index')->name('recovery');
Route::post('/w/{campaign}/recovery', 'Campaign\RecoveryController@recover')->name('recovery.save');

Route::get('/w/{campaign}/recovery/posts', 'Campaign\PostRecoveryController@index')->name('recovery.posts');
Route::post('/w/{campaign}/recovery/posts', 'Campaign\PostRecoveryController@recover')->name('recovery.save.posts');

// Stats
Route::get('/w/{campaign}/achievements', 'Campaign\AchievementController@index')->name('stats');

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

Route::resources([
    '/w/{campaign}/campaign_users' => 'Campaign\UserController',
    '/w/{campaign}/campaign_submissions' => 'Campaign\SubmissionController',

    // Permission manager
    '/w/{campaign}/campaign_roles' => 'Campaign\RoleController',
    '/w/{campaign}/campaign_roles.campaign_role_users' => 'Campaign\RoleUserController',
    '/w/{campaign}/campaign_styles' => 'Campaign\StyleController',
    '/w/{campaign}/campaign_invites' => 'Campaign\InviteController',

    '/w/{campaign}/campaign_dashboards' => 'Campaign\DashboardController',
    '/w/{campaign}/campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',

    '/w/{campaign}/preset_types.presets' => 'PresetController',

    '/w/{campaign}/images' => 'Campaign\GalleryController',

    '/w/{campaign}/webhooks' => 'Campaign\WebhookController',
]);
Route::get('/w/{campaign}/leave', 'Campaign\LeaveController@index')->name('campaign.leave');
Route::post('/w/{campaign}/leave-for-real', 'Campaign\LeaveController@process')->name('campaign.leave-process');

// Campaign CRUD
Route::get('/w/{campaign}/edit', [App\Http\Controllers\Crud\CampaignController::class, 'edit'])->name('campaigns.edit');
Route::patch('/w/{campaign}/update', [App\Http\Controllers\Crud\CampaignController::class, 'update'])->name('campaigns.update');
Route::delete('/w/{campaign}/destroy', [App\Http\Controllers\Crud\CampaignController::class, 'destroy'])->name('campaigns.destroy');


Route::post('/w/{campaign}/campaign_styles/bulk', 'Campaign\StyleController@bulk')->name('campaign_styles.bulk');
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
    Route::get('/w/{campaign}/plugins/{plugin}/enable', 'Campaign\PluginController@enable')->name('campaign_plugins.enable');
    Route::get('/w/{campaign}/plugins/{plugin}/disable', 'Campaign\PluginController@disable')->name('campaign_plugins.disable');
    Route::post('/w/{campaign}/plugins/{plugin}/import', 'Campaign\PluginController@import')->name('campaign_plugins.import');
    Route::get('/w/{campaign}/plugins/{plugin}/confirm-import', 'Campaign\PluginController@confirmImport')->name('campaign_plugins.confirm-import');
    Route::get('/w/{campaign}/plugins/{plugin}/update', 'Campaign\PluginController@updateInfo')->name('campaign_plugins.update-info');
    Route::post('/w/{campaign}/plugins/{plugin}/update', 'Campaign\PluginController@update')->name('campaign_plugins.update');
    Route::post('/w/{campaign}/plugins/bulk', 'Campaign\PluginController@bulk')->name('campaign_plugins.bulk');
}


Route::get('/w/{campaign}/redirect', 'RedirectController@index')->name('redirect');

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
Route::post('/w/{campaign}/modules/toggle/{module?}', 'Campaign\ModuleController@toggle')->name('campaign.modules.toggle');
Route::get('/w/{campaign}/campaign-theme', 'Campaign\StyleController@theme')->name('campaign-theme');
Route::post('/w/{campaign}/campaign-theme', 'Campaign\StyleController@themeSave')->name('campaign-theme.save');
Route::get('/w/{campaign}/campaign-export', 'Campaign\ExportController@index')->name('campaign.export');
Route::post('/w/{campaign}/campaign-export', 'Campaign\ExportController@export')->name('campaign.export-process');
Route::get('/w/{campaign}/campaign-import', 'Campaign\ImportController@index')->name('campaign.import');
Route::post('/w/{campaign}/campaign-import', 'Campaign\ImportController@store')->name('campaign.import-process');
Route::get('/w/{campaign}/campaign-{ts}.styles', [App\Http\Controllers\Campaign\CssController::class, 'index'])->name('campaign.css');
Route::get('/w/{campaign}/campaign_plugin-{ts}.styles', 'Campaign\PluginController@css')->name('campaign_plugins.css');
Route::get('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@edit')->name('campaign-visibility');
Route::post('/w/{campaign}/campaign-visibility', 'Campaign\VisibilityController@save')->name('campaign-visibility.save');

Route::get('/w/{campaign}/modules/{entity_type}/edit', [App\Http\Controllers\Campaign\ModuleController::class, 'edit'])->name('modules.edit');
Route::patch('/w/{campaign}/modules/{entity_type}/update', [App\Http\Controllers\Campaign\ModuleController::class, 'update'])->name('modules.update');
Route::delete('/w/{campaign}/modules/reset', [App\Http\Controllers\Campaign\ModuleController::class, 'reset'])->name('modules.reset');

Route::get('/w/{campaign}/campaign-applications', 'Campaign\SubmissionController@toggle')->name('campaign-applications');
Route::post('/w/{campaign}/campaign-applications', 'Campaign\SubmissionController@toggleSave')->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@index')->name('campaign-sidebar');
Route::post('/w/{campaign}/sidebar-setup', 'Campaign\SidebarController@save')->name('campaign-sidebar-save');
Route::delete('/w/{campaign}/sidebar-setup/reset', 'Campaign\SidebarController@reset')->name('campaign-sidebar-reset');

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
Route::patch('/w/{campaign}/webhooks/{webhook}/toggle', [App\Http\Controllers\Campaign\WebhookController::class, 'toggle'])->name('webhooks.toggle');
Route::get('/w/{campaign}/webhooks/{webhook}/status', [App\Http\Controllers\Campaign\WebhookController::class, 'status'])->name('webhooks.status');
Route::post('/w/{campaign}/webhooks/bulk', [App\Http\Controllers\Campaign\WebhookController::class, 'bulk'])->name('webhooks.bulk');
Route::get('/w/{campaign}/webhooks/{webhook}/test', [App\Http\Controllers\Campaign\WebhookController::class, 'test'])->name('webhooks.test');

Route::get('/w/{campaign}/attributes/api/type/{entity_type}', [App\Http\Controllers\Attributes\ApiController::class, 'index'])->name('attributes.api');
Route::get('/w/{campaign}/attributes/api/entity/{entity}', [App\Http\Controllers\Attributes\ApiController::class, 'entity'])->name('attributes.api-entity');

Route::get('/w/{campaign}/templates/load', [App\Http\Controllers\Templates\LoadController::class, 'index'])->name('templates.load-attributes');
