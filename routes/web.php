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

    Route::get('/', 'HomeController@index')->name('home');

    // Frontend stuff
    Route::get('/about', 'FrontController@about')->name('about');
    //Route::get('/terms-of-service', 'FrontController@tos')->name('tos');
    Route::get('/privacy-policy', 'FrontController@privacy')->name('privacy');
    Route::get('/help', 'FrontController@help')->name('help');
    Route::get('/faq', 'FaqController@index')->name('faq.index');
    Route::get('/faq/{key}/{slug?}', 'FaqController@show')->name('faq.show');
    Route::get('/features', 'FrontController@features')->name('features');
    Route::get('/roadmap', 'FrontController@roadmap')->name('roadmap');
    Route::get('/community', 'FrontController@community')->name('community');
    Route::get('/public-campaigns', 'FrontController@campaigns')->name('public_campaigns');

    Auth::routes();

    Route::get('/settings/profile', 'Settings\ProfileController@index')->name('settings.profile');
    Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

    Route::post('/settings/release/{release}', 'Settings\ReleaseController@read')->name('settings.release');
    Route::post('/settings/welcome', 'Settings\WelcomeController@read')->name('settings.welcome');

    Route::get('/settings/account', 'Settings\AccountController@index')->name('settings.account');
    Route::patch('/settings/account/password', 'Settings\AccountController@password')->name('settings.account.password');
    Route::patch('/settings/account/email', 'Settings\AccountController@email')->name('settings.account.email');
    Route::patch('/settings/account/destroy', 'Settings\AccountController@destroy')->name('settings.account.destroy');
    Route::patch('/settings/account/social', 'Settings\AccountController@social')->name('settings.account.social');

    Route::get('/settings/patreon', 'Settings\PatreonController@index')->name('settings.patreon');
    Route::get('/settings/patreon-callback', 'Settings\PatreonController@callback')->name('settings.patreon.callback');

    Route::get('/settings/api', 'Settings\ApiController@index')->name('settings.api');

    Route::get('/settings/layout', 'Settings\LayoutController@index')->name('settings.layout');
    Route::patch('/settings/layout', 'Settings\LayoutController@update')->name('settings.layout');

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');
    Route::get('/helper/dice', 'HelperController@dice')->name('helpers.dice');
    Route::get('/helper/public', 'HelperController@public')->name('helpers.public');
    Route::get('/helper/map', 'HelperController@map')->name('helpers.map');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

    // Slug
    Route::get('/releases/{id}-{slug?}', 'ReleaseController@show');

    Route::resources([
        'releases' => 'ReleaseController',
    ]);

    Route::get('/start', 'StartController@index')->name('start');
    Route::post('/start', 'StartController@store')->name('start');

    // Invitation's campaign comes from the token.
    Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');

    Route::group([
        'prefix' => CampaignLocalization::setCampaign(),
        'middleware' => ['campaign']
    ], function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard/settings', 'DashboardController@edit')->name('dashboard.settings');
        Route::patch('/dashboard/settings', 'DashboardController@update')->name('dashboard.settings.update');

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
        Route::get('/locations/{location}/map-points', 'LocationController@mapPoints')->name('locations.map-points');
        Route::any('/locations/{location}/map/admin', 'LocationController@mapAdmin')->name('locations.map.admin');
        Route::post('/locations/{location}/map_points/{map_point}/move', 'LocationMapPointController@move')->name('locations.map_points.move');

        Route::get('/locations/{location}/events', 'LocationController@events')->name('locations.events');
        Route::get('/locations/{location}/characters', 'LocationController@characters')->name('locations.characters');
        Route::get('/locations/{location}/items', 'LocationController@items')->name('locations.items');
        Route::get('/locations/{location}/locations', 'LocationController@locations')->name('locations.locations');
        Route::get('/locations/{location}/organisations', 'LocationController@organisations')->name('locations.organisations');
        Route::get('/locations/{location}/quests', 'LocationController@quests')->name('locations.quests');
        Route::get('/locations/{location}/journals', 'LocationController@journals')->name('locations.journals');

        // Organisation menu
        Route::get('/organisations/{organisation}/members', 'OrganisationController@members')->name('organisations.members');
        Route::get('/organisations/{organisation}/all-members', 'OrganisationController@allMembers')->name('organisations.all-members');
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

        // Tag menus
        Route::get('/tags/tree', 'TagController@tree')->name('tags.tree');
        Route::get('/tags/{tag}/tags', 'TagController@tags')->name('tags.tags');
        Route::get('/tags/{tag}/children', 'TagController@children')->name('tags.children');
        Route::get('/tags/{tag}/map-points', 'TagController@mapPoints')->name('tags.map-points');

        // Multi-delete for cruds
        Route::post('/bulk/process', 'BulkController@process')->name('bulk.process');

        // Attribute Templates Menu
        Route::get('/attribute_templates/{attribute_template}/attribute_templates', 'AttributeTemplateController@attributeTemplates')->name('attribute_templates.attribute_templates');

        // Notes
        Route::get('/notes/{note}/map-points', 'NoteController@mapPoints')->name('notes.map-points');

        // Events
        Route::get('/events/{event}/map-points', 'EventController@mapPoints')->name('events.map-points');

        // Calendar
        Route::get('/calendars/{calendar}/event', 'CalendarController@event')->name('calendars.event.create');
        Route::post('/calendars/{calendar}/event', 'CalendarController@eventStore')->name('calendars.event.store');
        Route::get('/calendars/{calendar}/month-list', 'CalendarController@monthList')->name('calendars.month-list');
        Route::get('/calendars/{calendar}/events', 'CalendarController@events')->name('calendars.events');
        Route::get('/calendars/{calendar}/today', 'CalendarController@today')->name('calendars.today');
        Route::get('/calendars/{calendar}/map-points', 'CalendarController@mapPoints')->name('calendars.map-points');

        // Conversations
        Route::get('/conversations/{conversation}/map-points', 'ConversationController@mapPoints')->name('conversations.map-points');

        // Attribute multi-save
        Route::post('/entities/{entity}/attributes/saveMany', [\App\Http\Controllers\AttributeController::class, 'saveMany'])->name('entities.attributes.saveMany');

        // Permission save
        Route::post('/campaign_roles/{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaign_roles.savePermissions');

        // Campaign Export
        Route::post('/campaigns/{campaign}/export', 'CampaignController@export')->name('campaigns.export');

        // Impersonator
        Route::get('/members/switch/{campaign_user}', 'Campaign\MemberController@switch')->name('identity.switch');
        Route::get('/members/back', 'Campaign\MemberController@back')->name('identity.back');

        //Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
        Route::resources([
            'calendars' => 'CalendarController',
            'calendar_event' => 'CalendarEventController',
            'calendars.relations' => 'CalendarRelationController',
            'campaigns' => 'CampaignController',
            'campaign_users' => 'CampaignUserController',
            'characters' => 'CharacterController',
            'characters.character_organisations' => 'CharacterOrganisationController',
            'characters.relations' => 'CharacterRelationController',
            'conversations' => 'ConversationController',
            'conversations.conversation_participants' => 'ConversationParticipantController',
            'conversations.conversation_messages' => 'ConversationMessageController',
            'dice_rolls' => 'DiceRollController',
            'dice_rolls.relations' => 'DiceRollRelationController',
            'dice_roll_results' => 'DiceRollResultController',
            'events' => 'EventController',
            'events.relations' => 'EventRelationController',
            'locations' => 'LocationController',
            'locations.relations' => 'LocationRelationController',
            'locations.map_points' => 'LocationMapPointController',
            'families' => 'FamilyController',
            'families.relations' => 'FamilyRelationController',
            'items' => 'ItemController',
            'items.relations' => 'ItemRelationController',
            'journals' => 'JournalController',
            'menu_links' => 'MenuLinkController',
            'organisations' => 'OrganisationController',
            'organisations.relations' => 'OrganisationRelationController',
            //'organisation_member' => 'OrganisationMemberController',
            'organisations.organisation_members' => 'OrganisationMemberController',
            'notes' => 'NoteController',
            'notes.relations' => 'NoteRelationController',
            'quests' => 'QuestController',
            'quests.quest_locations' => 'QuestLocationController',
            'quests.quest_characters' => 'QuestCharacterController',
            'quests.quest_items' => 'QuestItemController',
            'quests.quest_organisations' => 'QuestOrganisationController',
            'quests.relations' => 'QuestRelationController',
            'tags' => 'TagController',
            'sections' => 'SectionController',
            'tags.relations' => 'TagRelationController',
            'campaign_invites' => 'CampaignInviteController',
            'races' => 'RaceController',
            'races.relations' => 'RaceRelationController',

            // Entities
            'entities.attributes' => 'AttributeController',
            'entities.entity_notes' => 'EntityNoteController',
            'entities.entity_events' => 'EntityEventController',
            'entities.entity_files' => 'EntityFileController',
            'entities.inventories' => 'Entity\InventoryController',

            'attribute_templates' => 'AttributeTemplateController',

            // Permission manager
            'campaign_roles' => 'CampaignRoleController',
            'campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
            //'campaigns.campaign_roles.campaign_permissions' => 'CampaignPermissions',

            'campaign_dashboard_widgets' => 'CampaignDashboardWidgetController',
        ]);
        Route::get('/campaigns/{campaign}/leave', 'CampaignController@leave')->name('campaigns.leave');
        Route::post('/campaigns/{campaign}/campaign_settings', 'CampaignSettingController@save')->name('campaigns.settings.save');

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
        Route::get('/search/organisations', 'Search\MiscController@organisations')->name('organisations.find');
        Route::get('/search/tags', 'Search\MiscController@tags')->name('tags.find');
        Route::get('/search/dice-rolls', 'Search\MiscController@diceRolls')->name('dice_rolls.find');
        Route::get('/search/quests', 'Search\MiscController@quests')->name('quests.find');
        Route::get('/search/conversations', 'Search\MiscController@conversations')->name('conversations.find');
        Route::get('/search/races', 'Search\MiscController@races')->name('races.find');
        Route::get('/search/attribute-templates', 'Search\MiscController@attributeTemplates')->name('attribute_templates.find');

        // Entity Search
        Route::get('/search/entity-calendars', 'Search\CalendarController@index')->name('search.calendars');

        // Global Entity Search
        Route::get('/search/reminder-entities', 'Search\LiveController@reminderEntities')->name('search.entities-with-reminders');
        Route::get('/search/relation-entities', 'Search\LiveController@relationEntities')->name('search.entities-with-relations');
        Route::get('/search/months', 'Search\CalendarController@months')->name('search.calendar-months');
        Route::get('/search/live', 'Search\LiveController@index')->name('search.live');

        Route::get('/redirect', 'RedirectController@index')->name('redirect');

        // Campaign Dashboard Widgets
        Route::get('/dashboard-setup', 'DashboardSetupController@index')->name('dashboard.setup');
        Route::post('/dashboard-setup', 'DashboardSetupController@save')->name('dashboard.setup');
        Route::post('/dashboard-setup/reorder', [\App\Http\Controllers\DashboardSetupController::class, 'reorder'])->name('dashboard.reorder');
        Route::get('/dashboard/widgets/recent/{id}', 'DashboardController@recent')->name('dashboard.recent');
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

        // Entity files
        Route::get('/entities/{entity}/files', 'EntityController@files')->name('entities.files');
        Route::get('/entities/{entity}/logs', 'Entity\LogController@index')->name('entities.logs');
        Route::get('/entities/{entity}/mentions', 'Entity\MentionController@index')->name('entities.mentions');
        //Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

        // Inventory
        Route::get('/entities/{entity}/inventory', 'Entity\InventoryController@index')->name('entities.inventory');
        /*Route::get('/entities/{entity}/inventory/create', 'Entity\InventoryController@create')->name('entities.inventory.create');
        Route::post('/entities/{entity}/inventory/store', 'Entity\InventoryController@store')->name('entities.inventory.store');
        Route::get('/entities/{entity}/inventory/update', 'Entity\InventoryController@edit')->name('entities.inventory.edit');
        Route::post('/entities/{entity}/inventory/update', 'Entity\InventoryController@update')->name('entities.inventory.update');
        Route::delete('/entities/{entity}/inventory/delete', 'Entity\InventoryController@delete')->name('entities.inventory.destroy');
        */

        // Export
        Route::get('/entities/export/{entity}', 'EntityController@export')->name('entities.export');

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

        // Entity quick creator
        Route::get('/entity-creator', [\App\Http\Controllers\EntityCreatorController::class, 'selection'])->name('entity-creator.selection');
        Route::get('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'form'])->name('entity-creator.form');
        Route::post('/entity-creator/{type}', [\App\Http\Controllers\EntityCreatorController::class, 'store'])->name('entity-creator.store');
    });

    // Notification
    Route::get('/notifications/delete/{id}', 'NotificationController@delete')->name('notifications.delete');
    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    Route::get('/notifications/refresh', 'NotificationController@refresh')->name('notifications.refresh');

    // 3rd party
    Route::group(['middleware' => ['auth', 'translator'], 'prefix' => 'translations'], function () {
        Translator::routes();
    });

    // Admin/Moderation tools
    Route::group(['prefix' => 'admin', ['middleware' => ['moderator']]], function () {
        Route::get('/home', 'Admin\HomeController@index')->name('admin.home');
        Route::get('/campaigns', 'Admin\CampaignController@index')->name('admin.campaigns.index');
        //Route::resourc('/faqs', 'Admin\FaqController@index')->name('admin.faqs.index');

        Route::resources([
            'faqs' => 'Admin\FaqController',
        ]);
    });

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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
