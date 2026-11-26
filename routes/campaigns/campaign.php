<?php

use App\Http\Controllers\Attributes\ApiController;
use App\Http\Controllers\Campaign\CategoryStatusController;
use App\Http\Controllers\Campaign\CssController;
use App\Http\Controllers\Campaign\EntityTypeController;
use App\Http\Controllers\Campaign\LogController;
use App\Http\Controllers\Campaign\MemberController;
use App\Http\Controllers\Campaign\Members\RoleController;
use App\Http\Controllers\Campaign\ModuleController;
use App\Http\Controllers\Campaign\Plugins\BulkController;
use App\Http\Controllers\Campaign\Plugins\ImportController;
use App\Http\Controllers\Campaign\Plugins\ToggleController;
use App\Http\Controllers\Campaign\Plugins\UpdateController;
use App\Http\Controllers\Campaign\ShareController;
use App\Http\Controllers\Campaign\StatController;
use App\Http\Controllers\Campaign\StyleController;
use App\Http\Controllers\Campaign\ThemeBuilderController;
use App\Http\Controllers\Campaign\VanityController;
use App\Http\Controllers\Campaign\WebController;
use App\Http\Controllers\Campaign\WebhookController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\Crud\CampaignController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboards\GettingStartedController;
use App\Http\Controllers\Dashboards\OnboardingWidgetController;
use App\Http\Controllers\EditingController;
use App\Http\Controllers\Gallery\BrowseController;
use App\Http\Controllers\Gallery\CreateController;
use App\Http\Controllers\Gallery\DeleteController;
use App\Http\Controllers\Gallery\ImageController;
use App\Http\Controllers\Gallery\ItemsController;
use App\Http\Controllers\Gallery\ReplaceController;
use App\Http\Controllers\Gallery\SearchController;
use App\Http\Controllers\Gallery\SetupController;
use App\Http\Controllers\Gallery\ShowController;
use App\Http\Controllers\Gallery\TiptapController;
use App\Http\Controllers\Gallery\UploadController;
use App\Http\Controllers\Gallery\VisibilityController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Onboarding\InitialController;
use App\Http\Controllers\Onboarding\QuickCreateController;
use App\Http\Controllers\PresetController;
use App\Http\Controllers\Templates\LoadController;
use App\Http\Controllers\Widgets\CalendarWidgetController;
use App\Models\PresetType;
use Illuminate\Support\Facades\Route;

Route::get('', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/follow', 'Campaign\FollowController@update')->name('campaign.follow');

Route::get('/apply', 'Campaign\ApplyController@index')->name('campaign.apply');
Route::post('/apply', 'Campaign\ApplyController@save')->name('campaign.apply.save');
Route::delete('/remove', 'Campaign\ApplyController@remove')->name('campaign.apply.remove');

Route::get('/gallery', 'GalleryController@index')->name('gallery');
Route::get('/gallery-index', 'GalleryController@index')->name('campaign.gallery.index');

Route::post('/gallery/ajax-upload', 'Summernote\GalleryController@upload')->name('campaign.gallery.ajax-upload');
Route::get('/gallery/ajax-gallery', 'Summernote\GalleryController@index')->name('campaign.gallery.summernote');

Route::post('/gallery/upload/file', [UploadController::class, 'file'])->name('gallery.upload.file');
Route::post('/gallery/upload/files', [UploadController::class, 'files'])->name('gallery.upload.files');
Route::post('/gallery/upload/url', [UploadController::class, 'url'])->name('gallery.upload.url');
Route::get('/gallery/browse', [BrowseController::class, 'index'])->name('gallery.browse');

Route::get('/gallery/tiptap', [TiptapController::class, 'index'])->name('gallery.tiptap');
Route::post('/gallery/tiptap', [UploadController::class, 'file'])->name('gallery.tiptap.save');

Route::get('/gallery/setup', [SetupController::class, 'index'])->name('gallery.setup');
Route::get('/gallery/items', [ItemsController::class, 'index'])->name('gallery.items');
Route::get('/gallery/open/{image}', [ImageController::class, 'show'])->name('gallery.show');
Route::get('/gallery/search/{term?}', [SearchController::class, 'index'])->name('gallery.search');
Route::post('/gallery/delete-preview', [DeleteController::class, 'preview'])->name('gallery.delete-preview');
Route::post('/gallery/delete', [DeleteController::class, 'destroy'])->name('gallery.delete');
Route::post('/gallery/create', [CreateController::class, 'index'])->name('gallery.create');
Route::post('/gallery/update/bulk', [App\Http\Controllers\Gallery\UpdateController::class, 'bulk'])->name('gallery.update');
Route::get('/gallery/{image}', [ShowController::class, 'show'])->name('gallery.file.show');
Route::post('/gallery/{image}/update', [App\Http\Controllers\Gallery\UpdateController::class, 'process'])->name('gallery.file.update');
Route::post('/gallery/{image}/replace', [ReplaceController::class, 'store'])->name('gallery.file.replace');
Route::delete('/gallery/{image}/delete', [DeleteController::class, 'file'])->name('gallery.file.delete');
Route::post('/gallery/{image}/update-focus', [App\Http\Controllers\Gallery\UpdateController::class, 'focus'])->name('gallery.file.update-focus');

Route::get('/gallery/{image}/visibility', [VisibilityController::class, 'index'])->name('gallery.file.visibility');
Route::patch('/gallery/{image}/visibility', [VisibilityController::class, 'save'])->name('gallery.file.visibility-save');

// Campaign
Route::get('/editing-warning', [EditingController::class, 'index'])->name('campaign.editing-warning');
Route::post('/editing/confirm-editing', 'EditingController@confirmCampaign')->name('campaigns.confirm-editing');
Route::post('/editing/keep-alive', 'EditingController@keepAliveCampaign')->name('campaigns.keep-alive');

// Permission save
Route::post('/campaign_roles/{campaign_role}/savePermissions', 'Campaign\RoleController@savePermissions')->name('campaign_roles.savePermissions');
Route::post('/campaign_roles/{campaign_role}/toggle/{entityType}/{action}', 'Campaign\RoleController@toggle')->name('campaign_roles.toggle');
Route::post('/campaign_roles/{campaign_role}/toggle-all', 'Campaign\RoleController@toggleAll')->name('campaign_roles.toggle-all');
Route::post('/campaign_roles/bulk', 'Campaign\RoleController@bulk')->name('campaign_roles.bulk');

// Impersonator
Route::get('/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
Route::get('/members/back', 'Campaign\MemberController@back')->name('identity.back');
Route::get('/members/switch/{campaign_user}/{entity}', 'Campaign\MemberController@switch')->name('identity.switch-entity');

Route::get('/campaign_users/{campaign_user}/delete', [MemberController::class, 'delete'])->name('campaign_users.delete');
Route::get('/campaign_user_roles/{campaign_user}', [RoleController::class, 'index'])->name('campaign.members.roles');
Route::post('/campaign_user_roles/{campaign_user}', [RoleController::class, 'save'])->name('campaign_users.update-roles');

// Recovery
Route::get('/recovery', 'Campaign\RecoveryController@index')->name('recovery');
Route::post('/recovery', 'Campaign\RecoveryController@recover')->name('recovery.save');
Route::get('/recovery-setup', 'Campaign\RecoveryController@setup')->name('recovery.setup');

// Stats
Route::get('/achievements', 'Campaign\AchievementController@index')->name('campaign.achievements');

// User search
Route::get('/users/search', 'Campaign\UserController@search')->name('users.find');
Route::get('/roles/search', 'Campaign\RoleController@search')->name('roles.find');

Route::get('/placeholder-images', 'Campaign\DefaultImageController@index')
    ->name('campaign.default-images');
Route::get('/placeholder-images/create', 'Campaign\DefaultImageController@create')
    ->name('campaign.default-images.create');
Route::post('/placeholder-images/create', 'Campaign\DefaultImageController@store')
    ->name('campaign.default-images.store');
Route::delete('/placeholder-images', 'Campaign\DefaultImageController@destroy')
    ->name('campaign.default-images.delete');
Route::delete('/placeholder-images/reset', 'Campaign\DefaultImageController@reset')
    ->name('campaign.default-images.reset');

Route::resources([
    '/campaign_users' => 'Campaign\UserController',
    '/applications' => 'Campaign\ApplicationController',

    // Permission manager
    '/campaign_roles' => 'Campaign\RoleController',
    '/campaign_roles.campaign_role_users' => 'Campaign\RoleUserController',
    '/campaign_styles' => 'Campaign\StyleController',
    '/campaign_invites' => 'Campaign\InviteController',

    '/campaign_dashboards' => 'Campaign\DashboardController',
    '/campaign_dashboard_widgets' => 'Campaign\DashboardWidgetController',

    '/preset_types.presets' => 'PresetController',

    '/webhooks' => 'Campaign\WebhookController',
    '/entity_types' => 'Campaign\EntityTypeController',
]);
Route::get('/leave', 'Campaign\LeaveController@index')->name('campaign.leave');
Route::post('/leave-for-real', 'Campaign\LeaveController@process')->name('campaign.leave-process');

// Campaign CRUD
Route::get('/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
Route::patch('/update', [CampaignController::class, 'update'])->name('campaigns.update');

Route::post('/campaign_styles/bulk', 'Campaign\StyleController@bulk')->name('campaign_styles.bulk');
Route::get('/campaign_styles/{campaign_style}/toggle', [StyleController::class, 'toggle'])->name('campaign_styles.toggle');
Route::post('/campaign_styles/reorder', 'Campaign\StyleController@reorder')->name('campaign_styles.reorder-save');
Route::get('/theme-builder', [ThemeBuilderController::class, 'index'])->name('campaign_styles.builder');
Route::post('/theme-builder', [ThemeBuilderController::class, 'save'])->name('campaign_styles.builder-save');
Route::delete('/theme-builder', [ThemeBuilderController::class, 'reset'])->name('campaign_styles.builder-reset');

Route::get('/dashboard/billboard/{campaignDashboardWidget?}', 'Campaign\DashboardHeaderController@edit')->name('campaigns.dashboard-header.edit');
Route::patch('/dashboard/billboard/{campaignDashboardWidget?}', 'Campaign\DashboardHeaderController@update')->name('campaigns.dashboard-header.update');

// Helper links
Route::get('/campaign-roles/admin', 'Campaign\RoleController@admin')->name('campaigns.campaign_roles.admin');
Route::get('/campaign-roles/public', 'Campaign\RoleController@public')->name('campaigns.campaign_roles.public');
Route::get('/campaign-roles/{campaign_role}/duplicate', 'Campaign\RoleController@duplicate')->name('campaign_roles.duplicate');

// Marketplace plugin route
if (config('marketplace.enabled')) {
    Route::get('/plugins', 'Campaign\PluginController@index')->name('campaign_plugins.index');
    Route::delete('/plugins/{plugin}/delete', 'Campaign\PluginController@delete')->name('campaign_plugins.destroy');
    Route::get('/plugins/{plugin}/enable', [ToggleController::class, 'enable'])->name('campaign_plugins.enable');
    Route::get('/plugins/{plugin}/disable', [ToggleController::class, 'disable'])->name('campaign_plugins.disable');

    Route::get('/plugins/{plugin}/confirm-import', [ImportController::class, 'index'])->name('campaign_plugins.confirm-import');
    Route::post('/plugins/{plugin}/import', [ImportController::class, 'process'])->name('campaign_plugins.import');

    Route::get('/plugins/{plugin}/update', [UpdateController::class, 'index'])->name('campaign_plugins.update-info');
    Route::post('/plugins/{plugin}/update', [UpdateController::class, 'update'])->name('campaign_plugins.update');

    Route::post('/plugins/bulk', [BulkController::class, 'index'])->name('campaign_plugins.bulk');
}

// Campaign Dashboard Widgets
Route::get('/dashboard-setup', [App\Http\Controllers\Dashboards\SetupController::class, 'index'])->name('dashboard.setup');
Route::post('/dashboard-setup/reorder', [App\Http\Controllers\Dashboards\SetupController::class, 'save'])->name('dashboard.reorder');
Route::get('/dashboard/widgets/recent/{id}', 'DashboardController@recent')->name('dashboard.recent');
Route::get('/dashboard/widgets/unmentioned/{id}', 'DashboardController@unmentioned')->name('dashboard.unmentioned');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/add', [CalendarWidgetController::class, 'add'])->name('dashboard.calendar.add');
Route::post('/dashboard/widgets/calendar/{campaignDashboardWidget}/sub', [CalendarWidgetController::class, 'sub'])->name('dashboard.calendar.sub');
Route::get('/dashboard/widgets/{campaignDashboardWidget}/render', [CalendarWidgetController::class, 'render'])->name('dashboard.calendar.render');

// The campaign management subpages
Route::get('/overview', 'Crud\CampaignController@show')->name('overview');
Route::get('/modules', 'Campaign\ModuleController@index')->name('campaign.modules');
Route::post('/modules/toggle/{entity_type}', [ModuleController::class, 'toggle'])->name('campaign.modules.toggle');
Route::post('/features/toggle/{module}', [ModuleController::class, 'toggleFeature'])->name('campaign.features.toggle');

// Route::get('/entity_types/create', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'create'])->name('campaign.entity_types.create');
// Route::post('/entity_types/create', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'store'])->name('campaign.entity_types.store');
//
// Route::get('/entity_types/{entity_type}/edit', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'edit'])->name('campaign.entity_types.edit');
// Route::patch('/entity_types/{entity_type}/update', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'update'])->name('campaign.entity_types.update');
Route::post('/entity_types/{entity_type}/toggle', [EntityTypeController::class, 'toggle'])->name('entity_types.toggle');
Route::get('/entity_types/{entity_type}/statuses/{status}/delete', [CategoryStatusController::class, 'confirm'])->name('entity_types.statuses.confirm');
Route::delete('/entity_types/{entity_type}/statuses/{status}', [CategoryStatusController::class, 'destroy'])->name('entity_types.statuses.destroy');
// Route::delete('/entity_types/{entity_type}/delete', [\App\Http\Controllers\Campaign\EntityTypeController::class, 'delete'])->name('campaign.entity_types.destroy');
Route::get('/entity_types/{entity_type}/confirm', [EntityTypeController::class, 'confirm'])->name('entity_types.confirm');

Route::get('/campaign-theme', 'Campaign\StyleController@theme')->name('campaign-theme');
Route::post('/campaign-theme', 'Campaign\StyleController@themeSave')->name('campaign-theme.save');
Route::get('/campaign-export', 'Campaign\ExportController@index')->name('campaign.export');
Route::post('/campaign-export', 'Campaign\ExportController@export')->name('campaign.export-process');
Route::get('/campaign-import', 'Campaign\ImportController@index')->name('campaign.import');
Route::post('/campaign-import/{campaign_import}/presign', 'Campaign\ImportController@presign')->name('campaign.import.presign');
Route::post('/campaign-import/{campaign_import}/confirm', 'Campaign\ImportController@confirm')->name('campaign.import.confirm');
Route::get('/campaign-import/{campaign_import}/csv', 'Campaign\ImportController@csv')->name('campaign.import.csv');
Route::get('/campaign-{ts}.styles', [CssController::class, 'index'])->name('campaign.css');
Route::get('/campaign_plugin-{ts}.styles', 'Campaign\Plugins\CssController@index')->name('campaign_plugins.css');
Route::get('/campaign-visibility', 'Campaign\VisibilityController@edit')->name('campaign-visibility');
Route::post('/campaign-visibility', 'Campaign\VisibilityController@save')->name('campaign-visibility.save');

Route::get('/share', [ShareController::class, 'setup'])->name('campaign.share.setup');
Route::post('/share', [ShareController::class, 'save'])->name('campaign.share.save');

Route::get('/modules/{entity_type}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
Route::patch('/modules/{entity_type}/update', [ModuleController::class, 'update'])->name('modules.update');
Route::delete('/modules/reset', [ModuleController::class, 'reset'])->name('modules.reset');

Route::get('/campaign-applications', 'Campaign\ApplicationController@toggle')->name('campaign-applications');
Route::get('/campaign-applications/setup', 'Campaign\ApplicationSetupController@setup')->name('campaign-applications.setup');
Route::post('/campaign-applications/setup', 'Campaign\ApplicationSetupController@saveSetup')->name('campaign-applications.setup.save');
Route::get('/campaign-applications/dashboard-widget', 'Campaign\ApplicationDashboardController@index')->name('campaign-applications.dashboard-widget');
Route::post('/campaign-applications/dashboard-widget', 'Campaign\ApplicationDashboardController@store')->name('campaign-applications.dashboard-widget.store');
Route::post('/campaign-applications', 'Campaign\ApplicationController@toggleSave')->name('campaign-applications.save');

// Campaign sidebar setup
Route::get('/sidebar-setup', 'Campaign\SidebarController@index')->name('campaign-sidebar');
Route::post('/sidebar-setup', 'Campaign\SidebarController@save')->name('campaign-sidebar-save');
Route::post('/sidebar-setup/v2', 'Campaign\SidebarController@saveLayout')->name('campaign-sidebar-v2-save');
Route::delete('/sidebar-setup/reset', 'Campaign\SidebarController@reset')->name('campaign-sidebar-reset');

Route::get('/campaign-defaults', 'Campaign\DefaultsController@index')->name('campaign-defaults');
Route::post('/campaign-defaults', 'Campaign\DefaultsController@save')->name('campaign-defaults-save');

Route::get('/presets/type/{preset_type}/list', [PresetController::class, 'presets'])->name('presets.list');
Route::get('/presets/type/{preset_type}/create', [PresetController::class, 'create'])->name('presets.create');
Route::post('/presets/type/{preset_type}/store', [PresetController::class, 'store'])->name('presets.store');
Route::post('/presets/{preset}/load', [PresetController::class, 'load'])->name('presets.show');

Route::model('preset_type', PresetType::class);

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

Route::get('/confirm-delete', [ConfirmController::class, 'index'])->name('confirm-delete');
Route::post('/vanity-validate', [VanityController::class, 'index'])->name('campaign.vanity-validate');

// Permission save
Route::get('/webhooks/{webhook}/toggle', [WebhookController::class, 'toggle'])->name('webhooks.toggle');
Route::get('/webhooks/{webhook}/status', [WebhookController::class, 'status'])->name('webhooks.status');
Route::post('/webhooks/bulk', [WebhookController::class, 'bulk'])->name('webhooks.bulk');
Route::get('/webhooks/{webhook}/test', [WebhookController::class, 'test'])->name('webhooks.test');

Route::get('/attributes/api/type/{entity_type}', [ApiController::class, 'index'])->name('attributes.api');
Route::get('/attributes/api/entity/{entity}', [ApiController::class, 'entity'])->name('attributes.api-entity');

Route::get('/templates/load', [LoadController::class, 'index'])->name('templates.load-attributes');

Route::get('/deletion', [App\Http\Controllers\Campaign\DeleteController::class, 'show'])->name('campaign.delete');
Route::delete('/destroy', [App\Http\Controllers\Campaign\DeleteController::class, 'destroy'])->name('campaigns.destroy');

Route::get('/sidebar/image', [App\Http\Controllers\Campaign\ImageController::class, 'index'])->name('campaign.sidebar.image');
Route::post('/sidebar/image', [App\Http\Controllers\Campaign\ImageController::class, 'save'])->name('campaign.sidebar.image-save');

Route::get('/stats', [StatController::class, 'index'])->name('campaign.stats');

Route::get('/logs', [LogController::class, 'index'])->name('campaign.logs');

Route::post('/onboarding/initial', [
    InitialController::class, 'save',
])->name('campaign.onboarding.initial');
Route::post('/onboarding/initial-skip', [
    InitialController::class, 'skip',
])->name('campaign.onboarding.initial-skip');

Route::get('/widgets/getting-started', [
    GettingStartedController::class, 'index',
])->name('campaign.widgets.getting-started');

Route::get('/onboarding/widget', [
    OnboardingWidgetController::class, 'state',
])->name('campaign.onboarding.widget.state');

Route::post('/onboarding/widget/progress', [
    OnboardingWidgetController::class, 'progress',
])->name('campaign.onboarding.widget.progress');

Route::post('/onboarding/widget/dismiss', [
    OnboardingWidgetController::class, 'dismiss',
])->name('campaign.onboarding.widget.dismiss');

Route::post('/onboarding/quick-create', [
    QuickCreateController::class, 'store',
])->name('campaign.onboarding.quick-create');

Route::get('/connections/web', [WebController::class, 'index'])->name('connections.web');
Route::get('/connections/web/api', [WebController::class, 'api'])->name('connections.web.api');
