<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Vsch\TranslationManager\Translator;


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime' ]
], function () {

//    Route::get('/mail', function () {
////        return new App\Mail\WelcomeEmail(Auth::user());
////    });
    Route::get('/', 'HomeController@index')->name('home');

    // Frontend stuff
    require base_path('routes/front.php');

    Auth::routes(['register' => config('auth.register_enabled')]);

    require base_path('routes/profile.php');

    Route::resources([
        'campaign_boost' => 'CampaignBoostController',
    ]);

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');
    Route::get('/helper/dice', 'HelperController@dice')->name('helpers.dice');
    Route::get('/helper/public', 'HelperController@public')->name('helpers.public');
    Route::get('/helper/map', 'HelperController@map')->name('helpers.map');
    Route::get('/helper/filters', 'HelperController@filters')->name('helpers.filters');
    Route::get('/helper/age', 'HelperController@age')->name('helpers.age');
    Route::get('/helper/attributes', 'HelperController@attributes')->name('helpers.attributes');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');

    Route::get('/start', 'StartController@index')->name('start');
    Route::post('/start', 'StartController@store')->name('start');

    // Invitation's campaign comes from the token.
    Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');

    Route::group([
        'prefix' => CampaignLocalization::setCampaign(),
        'middleware' => ['campaign']
    ], function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::post('/follow', 'CampaignFollowController@update')->name('campaign.follow');

        // Abilities
        Route::get('/abilities/{ability}/map-points', 'AbilityController@mapPoints')->name('abilities.map-points');
        Route::get('/abilities/{ability}/abilities', 'AbilityController@abilities')->name('abilities.abilities');
        Route::get('/abilities/tree', 'AbilityController@tree')->name('abilities.tree');

        // Maps
        Route::get('/maps/{map}/maps', 'Maps\MapController@maps')->name('maps.maps');
        Route::get('/maps/{map}/explore', 'Maps\MapController@explore')->name('maps.explore');
        Route::get('/maps/{map}/ticker', 'Maps\MapController@ticker')->name('maps.ticker');
        Route::get('/maps/{map}/{map_marker}/details', 'Maps\MapMarkerController@details')->name('maps.markers.details');
        Route::post('/maps/{map}/{map_marker}/move', 'Maps\MapMarkerController@move')->name('maps.markers.move');
        Route::get('/maps/tree', 'Maps\MapController@tree')->name('maps.tree');

        // Character
        Route::get('/characters/random', 'CharacterController@random')->name('characters.random');
        Route::get('/characters/{character}/quests', 'CharacterSubController@quests')->name('characters.quests');
        Route::get('/characters/{character}/organisations', 'CharacterSubController@organisations')->name('characters.organisations');
        Route::get('/characters/{character}/items', 'CharacterSubController@items')->name('characters.items');
        Route::get('/characters/{character}/map', 'CharacterSubController@map')->name('characters.map');
        Route::get('/characters/{character}/map_data', 'CharacterSubController@mapData')->name('characters.map_data');
        Route::get('/characters/{character}/dice_rolls', 'CharacterSubController@diceRolls')->name('characters.dice_rolls');
        Route::get('/characters/{character}/conversations', 'CharacterSubController@conversations')->name('characters.conversations');
        Route::get('/characters/{character}/journals', 'CharacterSubController@journals')->name('characters.journals');
        Route::get('/characters/{character}/map-points', 'CharacterSubController@mapPoints')->name('characters.map-points');

        Route::get('/dice_rolls/{dice_roll}/roll', 'DiceRollController@roll')->name('dice_rolls.roll');
        Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');
        Route::get('/dice_rolls/{dice_roll}/map-points', 'DiceRollController@mapPoints')->name('dice_rolls.map-points');

        // Locations
        Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
        Route::any('/locations/{location}/map', 'LocationController@map')->name('locations.map');
        Route::any('/locations/{location}/maps', 'LocationController@maps')->name('locations.maps');
        Route::get('/locations/{location}/map-points', 'LocationController@mapPoints')->name('locations.map-points');
        Route::any('/locations/{location}/map/admin', 'LocationController@mapAdmin')->name('locations.map.admin');
        Route::post('/locations/{location}/map_points/{map_point}/move', 'LocationMapPointController@move')->name('locations.map_points.move');

        Route::get('/locations/{location}/events', 'LocationController@events')->name('locations.events');
        Route::get('/locations/{location}/characters', 'LocationController@characters')->name('locations.characters');
        Route::get('/locations/{location}/families', 'LocationController@families')->name('locations.families');
        Route::get('/locations/{location}/items', 'LocationController@items')->name('locations.items');
        Route::get('/locations/{location}/locations', 'LocationController@locations')->name('locations.locations');
        Route::get('/locations/{location}/organisations', 'LocationController@organisations')->name('locations.organisations');
        Route::get('/locations/{location}/quests', 'LocationController@quests')->name('locations.quests');
        Route::get('/locations/{location}/journals', 'LocationController@journals')->name('locations.journals');

        // Organisation menu
        Route::get('/organisations/{organisation}/members', 'OrganisationController@members')->name('organisations.members');
        Route::get('/organisations/{organisation}/quests', 'OrganisationController@quests')->name('organisations.quests');
        Route::get('/organisations/{organisation}/organisations', 'OrganisationController@organisations')->name('organisations.organisations');
        Route::get('/organisations/tree', 'OrganisationController@tree')->name('organisations.tree');
        Route::get('/organisations/{organisation}/map-points', 'OrganisationController@mapPoints')->name('organisations.map-points');

        // Families menu
        Route::get('/families/{family}/members', 'FamilyController@members')->name('families.members');
        Route::get('/families/{family}/all-members', 'FamilyController@allMembers')->name('families.all-members');

        Route::get('/families/{family}/families', 'FamilyController@families')->name('families.families');
        Route::get('/families/tree', 'FamilyController@tree')->name('families.tree');
        Route::get('/families/{family}/map-points', 'FamilyController@mapPoints')->name('families.map-points');

        // Items menu
        Route::get('/items/{item}/quests', 'ItemController@quests')->name('items.quests');
        Route::get('/items/{item}/map-points', 'ItemController@mapPoints')->name('items.map-points');
        Route::get('/items/{item}/inventories', 'ItemController@inventories')->name('items.inventories');

        // Quest menus
        Route::get('/quests/{quest}/characters', 'QuestController@characters')->name('quests.characters');
        Route::get('/quests/{quest}/locations', 'QuestController@locations')->name('quests.locations');
        Route::get('/quests/{quest}/items', 'QuestController@items')->name('quests.items');
        Route::get('/quests/{quest}/organisations', 'QuestController@organisations')->name('quests.organisations');
        Route::get('/quests/tree', 'QuestController@tree')->name('quests.tree');
        Route::get('/quests/{quest}/map-points', 'QuestController@mapPoints')->name('quests.map-points');

        // Races
        Route::get('/races/{race}/characters', 'RaceController@characters')->name('races.characters');
        Route::get('/races/{race}/races', 'RaceController@races')->name('races.races');
        Route::get('/races/tree', 'RaceController@tree')->name('races.tree');
        Route::get('/races/{race}/map-points', 'RaceController@mapPoints')->name('races.map-points');

        // Journal
        Route::get('/journals/{journal}/map-points', 'JournalController@mapPoints')->name('journals.map-points');
        Route::get('/journals/{journal}/journals', 'JournalController@journals')->name('journals.journals');

        // Tag menus
        Route::get('/tags/tree', 'TagController@tree')->name('tags.tree');
        Route::get('/tags/{tag}/tags', 'TagController@tags')->name('tags.tags');
        Route::get('/tags/{tag}/children', 'TagController@children')->name('tags.children');
        Route::get('/tags/{tag}/map-points', 'TagController@mapPoints')->name('tags.map-points');

        // Tags Quick Add
        Route::get('/tags/{tag}/entity-add', 'TagController@entityAdd')->name('tags.entity-add');
        Route::post('/tags/{tag}/entity-add', 'TagController@entityStore')->name('tags.entity-add');

        // Multi-delete for cruds
        Route::post('/bulk/process', 'BulkController@process')->name('bulk.process');
        Route::get('/bulk/modal', 'BulkController@modal')->name('bulk.modal');

        // Attribute Templates Menu
        Route::get('/attribute_templates/{attribute_template}/attribute_templates', 'AttributeTemplateController@attributeTemplates')->name('attribute_templates.attribute_templates');

        // Notes
        Route::get('/notes/{note}/map-points', 'NoteController@mapPoints')->name('notes.map-points');
        Route::get('/notes/tree', 'NoteController@tree')->name('notes.tree');

        Route::get('/journals/tree', 'JournalController@tree')->name('journals.tree');

        // Events
        Route::get('/events/{event}/map-points', 'EventController@mapPoints')->name('events.map-points');

        // Calendar
        Route::get('/calendars/tree', 'CalendarController@tree')->name('calendars.tree');
        Route::get('/calendars/{calendar}/event', 'CalendarController@event')->name('calendars.event.create');
        Route::post('/calendars/{calendar}/event', 'CalendarController@eventStore')->name('calendars.event.store');
        Route::get('/calendars/{calendar}/month-list', 'CalendarController@monthList')->name('calendars.month-list');
        Route::get('/calendars/{calendar}/events', 'CalendarController@events')->name('calendars.events');
        Route::get('/calendars/{calendar}/today', 'CalendarController@today')->name('calendars.today');
        Route::get('/calendars/{calendar}/map-points', 'CalendarController@mapPoints')->name('calendars.map-points');

//        Route::get('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@form')->name('calendars.weather.create');
//        Route::post('/calendars/{calendar}/weather', 'Calendar\CalendarWeatherController@store')->name('calendars.weather.store');

        // Conversations
        Route::get('/conversations/{conversation}/map-points', 'ConversationController@mapPoints')->name('conversations.map-points');

        // Attribute multi-save
        Route::post('/entities/{entity}/attributes/saveMany', [\App\Http\Controllers\AttributeController::class, 'saveMany'])->name('entities.attributes.saveMany');
        Route::post('/entities/{entity}/toggle-privacy', [\App\Http\Controllers\Entity\PrivacyController::class, 'toggle'])->name('entities.privacy.toggle');

        Route::get('/entities/{entity}/relations_map', 'Entity\RelationController@map')->name('entities.relations_map');

        // Permission save
        Route::post('/campaign_roles/{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaign_roles.savePermissions');

        // Impersonator
        Route::get('/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
        Route::get('/members/back', 'Campaign\MemberController@back')->name('identity.back');

        // Recovery
        Route::get('/recovery', 'Campaign\RecoveryController@index')->name('recovery');
        Route::post('/recovery', 'Campaign\RecoveryController@recover')->name('recovery');


        Route::get('/default-images', 'Campaign\DefaultImageController@index')->name('campaign.default-images');
        Route::get('/default-images/create', 'Campaign\DefaultImageController@create')->name('campaign.default-images.create');
        Route::post('/default-images/create', 'Campaign\DefaultImageController@store')->name('campaign.default-images.store');
        Route::delete('/default-images', 'Campaign\DefaultImageController@destroy')->name('campaign.default-images');


        // Entity Abilities API
        Route::get('/entities/{entity}/entity_abilities/api', 'Entity\AbilityController@api')->name('entities.entity_abilities.api');
        Route::post('/entities/{entity}/entity_abilities/{entity_ability}/use', 'Entity\AbilityController@useCharge')->name('entities.entity_abilities.use');
        Route::get('/entities/{entity}/entity_abilities/reset', 'Entity\AbilityController@resetCharges')->name('entities.entity_abilities.reset');

        //Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
        Route::resources([
            'abilities' => 'AbilityController',
            'calendars' => 'CalendarController',
            'calendar_event' => 'CalendarEventController',
            'calendars.calendar_weather' => 'Calendar\CalendarWeatherController',
            'campaigns' => 'CampaignController',
            'campaign_users' => 'CampaignUserController',
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
            'quests.quest_locations' => 'QuestLocationController',
            'quests.quest_characters' => 'QuestCharacterController',
            'quests.quest_items' => 'QuestItemController',
            'quests.quest_organisations' => 'QuestOrganisationController',
            'tags' => 'TagController',
            'timelines' => 'Timelines\TimelineController',
            'timelines.timeline_eras' => 'Timelines\TimelineEraController',
            'timelines.timeline_elements' => 'Timelines\TimelineElementController',
            'sections' => 'SectionController',
            'campaign_invites' => 'CampaignInviteController',
            'races' => 'RaceController',

            // Entities
            'entities.attributes' => 'AttributeController',
            'entities.entity_abilities' => 'Entity\AbilityController',
            'entities.entity_notes' => 'EntityNoteController',
            'entities.entity_events' => 'EntityEventController',
            'entities.entity_files' => 'EntityFileController',
            'entities.inventories' => 'Entity\InventoryController',
            'entities.relations' => 'Entity\RelationController',

            'attribute_templates' => 'AttributeTemplateController',

            // Permission manager
            'campaign_roles' => 'CampaignRoleController',
            'campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
            //'campaigns.campaign_roles.campaign_permissions' => 'CampaignPermissions',

            'campaign_dashboard_widgets' => 'CampaignDashboardWidgetController',
        ]);
        Route::get('/campaigns/{campaign}/leave', 'CampaignController@leave')->name('campaigns.leave');
        Route::post('/campaigns/{campaign}/campaign_settings', 'CampaignSettingController@save')->name('campaigns.settings.save');

        // Marketplace plugin route
        if(config('marketplace.enabled')) {
            Route::get('/plugins', 'Campaign\CampaignPluginController@index')->name('campaign_plugins.index');
            Route::delete('/plugins/{plugin}/delete', 'Campaign\CampaignPluginController@delete')->name('campaign_plugins.destroy');
            Route::get('/plugins/{plugin}/enable', 'Campaign\CampaignPluginController@enable')->name('campaign_plugins.enable');
            Route::get('/plugins/{plugin}/disable', 'Campaign\CampaignPluginController@disable')->name('campaign_plugins.disable');
            Route::get('/plugins/{plugin}/update', 'Campaign\CampaignPluginController@updateInfo')->name('campaign_plugins.update-info');
            Route::post('/plugins/{plugin}/update', 'Campaign\CampaignPluginController@update')->name('campaign_plugins.update');

        }

        Route::post('/timelines/{timeline}/timeline-era/{timeline_era}/reorder', 'Timelines\TimelineEraController@reorder')->name('timelines.reorder');
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
        Route::get('/search/organisations', 'Search\MiscController@organisations')->name('organisations.find');
        Route::get('/search/tags', 'Search\MiscController@tags')->name('tags.find');
        Route::get('/search/dice-rolls', 'Search\MiscController@diceRolls')->name('dice_rolls.find');
        Route::get('/search/quests', 'Search\MiscController@quests')->name('quests.find');
        Route::get('/search/conversations', 'Search\MiscController@conversations')->name('conversations.find');
        Route::get('/search/races', 'Search\MiscController@races')->name('races.find');
        Route::get('/search/abilities', 'Search\MiscController@abilities')->name('abilities.find');
        Route::get('/search/maps', 'Search\MiscController@maps')->name('maps.find');
        Route::get('/search/attribute-templates', 'Search\MiscController@attributeTemplates')->name('attribute_templates.find');

        Route::get('/search/members', 'Search\CampaignSearchController@members')->name('find.campaign.members');
        Route::get('/search/roles', 'Search\CampaignSearchController@roles')->name('find.campaign.roles');

        // Entity Search
        Route::get('/search/entity-calendars', 'Search\CalendarController@index')->name('search.calendars');
        Route::get('/search/attributes/{entity}', 'Search\AttributeSearchController@index')->name('search.attributes');

        // Global Entity Search
        Route::get('/search/reminder-entities', 'Search\LiveController@reminderEntities')->name('search.entities-with-reminders');
        Route::get('/search/relation-entities', 'Search\LiveController@relationEntities')->name('search.entities-with-relations');
        Route::get('/search/tag-children', 'Search\LiveController@tagChildren')->name('search.tag-children');
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

        // Dashboard Widget Forms

        // Entity Files
//        Route::get('/entities/{entity}/entity_files', 'EntityFileController@index')->name('entities.entity_files.index');
//        Route::post('/entities/{entity}/entity_files', 'EntityFileController@store')->name('entities.entity_files.store');
//        Route::get('/entities/{entity}/entity_files/{entity_file}', 'EntityFileController@destroy')->name('entities.entity_files.destroy');
//        Route::post('/entities/{entity}/entity_files/{entity_file}/rename', 'EntityFileController@rename')->name('entities.entity_files.rename');

        // Move
        Route::get('/entities/move/{entity}', 'EntityController@move')->name('entities.move');
        Route::post('/entities/move/{entity}', 'EntityController@post')->name('entities.move');

        Route::get('/entities/{entity}/tooltip', 'EntityTooltipController@show')->name('entities.tooltip');

        Route::get('/entities/{entity}/json-export', 'Entity\ExportController@json')->name('entities.json-export');

        Route::get('/entities/copy-to-campaign/{entity}', 'EntityController@copyToCampaign')->name('entities.copy_to_campaign');
        Route::post('/entities/copy-to-campaign/{entity}', 'EntityController@copyEntityToCampaign')->name('entities.copy_to_campaign');

        // Entity files
        Route::get('/entities/{entity}/files', 'EntityController@files')->name('entities.files');
        Route::get('/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
        Route::get('/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');
        Route::get('/entities/{entity}/timelines', 'Entity\TimelineController@index')->name('entities.timelines');
        //Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

        // Inventory
        Route::get('/entities/{entity}/inventory', 'Entity\InventoryController@index')->name('entities.inventory');

        // Export
        Route::get('/entities/export/{entity}', 'EntityController@export')->name('entities.export');

        Route::get('/entities/{entity}/template', 'EntityController@template')->name('entities.template');

        // Attribute template
        Route::get('/entities/{entity}/attribute/template', 'AttributeController@template')->name('entities.attributes.template');
        Route::post('/entities/{entity}/attribute/template', 'AttributeController@applyTemplate')->name('entities.attributes.template');
        Route::get('/entities/{entity}/permissions', 'PermissionController@view')->name('entities.permissions');
        Route::post('/entities/{entity}/permissions', 'PermissionController@store')->name('entities.permissions');

        Route::post('/entities/create', 'EntityController@create')->name('entities.create');

        // The campaign management sub pages
        Route::get('/campaign', 'CampaignController@index')->name('campaign');
        Route::get('/campaign/settings', 'CampaignSettingController@index')->name('campaign_settings');
        Route::post('/campaign/settings', 'CampaignSettingController@save')->name('campaign_settings.save');
        Route::get('/campaign/export', 'CampaignExportController@index')->name('campaign_export');
        Route::post('/campaign/export', 'CampaignExportController@export')->name('campaign_export.save');
        Route::get('/campaign.styles', 'CampaignController@css')->name('campaign.css');
        Route::get('/campaign_plugin.styles', 'Campaign\CampaignPluginController@css')->name('campaign_plugins.css');



        // Entity quick creator
        Route::get('/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
        Route::get('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
        Route::post('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');
    });

    // Notification
    Route::get('/notifications/delete/{id}', 'NotificationController@delete')->name('notifications.delete');
    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    Route::get('/notifications/refresh', 'NotificationController@refresh')->name('notifications.refresh');

    // Third party hooks
    Route::get('/lfgm-hooks/sync/{uuid}', 'LFGM\HookController@sync')->name('lfgm.sync');
    Route::post('/lfgm-hooks/sync/{uuid}', 'LFGM\HookController@saveSync')->name('lfgm.syncSave');

    // 3rd party
    Route::group(['middleware' => ['auth', 'translator'], 'prefix' => 'translations'], function () {
        Translator::routes();
    });

    // Admin/Moderation tools
    require base_path('routes/admin.php');

    // API docs
    Route::group([
        'prefix'     => config('larecipe.docs.route'),
        'domain'     => config('larecipe.domain', null),
        'as'         => 'larecipe.',
        'middleware' => 'web'
    ], function() {
        Route::get('/', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@index')->name('index');
        Route::get('/{version}/{page?}', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@show')->where('page', '(.*)')->name('show');
    });

});

// Auth callback without language segment in url
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::group(['prefix' => 'subscription-api'], function () {
    Route::get('setup-intent', 'Settings\SubscriptionApiController@setupIntent');
    Route::post('payments', 'Settings\SubscriptionApiController@paymentMethods');
    Route::get('payment-methods', 'Settings\SubscriptionApiController@getPaymentMethods');
    Route::post('remove-payment', 'Settings\SubscriptionApiController@removePaymentMethod');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Stripe
Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);

// Language sitemaps
Route::get('/{locale}/sitemap.xml', 'Front\SitemapController@language')->name('front.sitemap');

// Rss feeds
Route::feeds();
