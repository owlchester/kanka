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
    Route::get('/faq', 'FrontController@faq')->name('faq');
    Route::get('/features', 'FrontController@features')->name('features');
    Route::get('/public-campaigns', 'FrontController@campaigns')->name('public_campaigns');

    Auth::routes();

    Route::get('/settings/profile', 'Settings\ProfileController@index')->name('settings.profile');
    Route::patch('/settings/profile', 'Settings\ProfileController@update')->name('settings.profile');

    Route::get('/settings/account', 'Settings\AccountController@index')->name('settings.account');
    Route::patch('/settings/account/password', 'Settings\AccountController@password')->name('settings.account.password');
    Route::patch('/settings/account/email', 'Settings\AccountController@email')->name('settings.account.email');
    Route::patch('/settings/account/destroy', 'Settings\AccountController@destroy')->name('settings.account.destroy');

    Route::get('/settings/patreon', 'Settings\PatreonController@index')->name('settings.patreon');
    Route::get('/settings/patreon-callback', 'Settings\PatreonController@callback')->name('settings.patreon.callback');

    Route::get('/settings/api', 'Settings\ApiController@index')->name('settings.api');

    Route::get('/settings/layout', 'Settings\LayoutController@index')->name('settings.layout');
    Route::patch('/settings/layout', 'Settings\LayoutController@update')->name('settings.layout');

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');
    Route::get('/helper/dice', 'HelperController@dice')->name('helpers.dice');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

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

        Route::get('/dice_rolls/{dice_roll}/roll', 'DiceRollController@roll')->name('dice_rolls.roll');
        Route::delete('/dice_rolls/{dice_roll}/roll/{dice_roll_result}/destroy', 'DiceRollController@destroyRoll')->name('dice_rolls.destroy_roll');

        // Locations
        Route::get('/sections/tree', 'SectionController@tree')->name('sections.tree');
        Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
        Route::any('/locations/{location}/map', 'LocationController@map')->name('locations.map');
        Route::any('/locations/{location}/map/admin', 'LocationController@mapAdmin')->name('locations.map.admin');
        Route::get('/locations/{location}/map_points/{map_point}/move', 'LocationMapPointController@move')->name('locations.map_points.move');

        Route::get('/locations/{location}/events', 'LocationController@events')->name('locations.events');
        Route::get('/locations/{location}/characters', 'LocationController@characters')->name('locations.characters');
        Route::get('/locations/{location}/items', 'LocationController@items')->name('locations.items');
        Route::get('/locations/{location}/locations', 'LocationController@locations')->name('locations.locations');


        Route::get('/races/{race}/characters', 'RaceController@characters')->name('races.characters');
        Route::get('/races/{race}/races', 'RaceController@races')->name('races.races');

        // Multi-delete for cruds
        Route::post('/bulk/process', 'BulkController@process')->name('bulk.process');


        Route::post('/calendars/{calendar}/addEvent', 'CalendarController@addEvent')->name('calendars.event.add');
        Route::get('/calendars/{calendar}/month-list', 'CalendarController@monthList')->name('calendars.month-list');

        // Attribute multi-save
        Route::post('/entities/{entity}/attributes/saveMany', 'AttributeController@saveMany')->name('entities.attributes.saveMany');

        // Permission save
        Route::post('/campaign_roles/{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaign_roles.savePermissions');

        // Campaign Export
        Route::post('/campaigns/{campaign}/export', 'CampaignController@export')->name('campaigns.export');

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
            'quests.relations' => 'QuestRelationController',
            'sections' => 'SectionController',
            'sections.relations' => 'SectionRelationController',
            'campaign_invites' => 'CampaignInviteController',
            'races' => 'RaceController',
            'races.relations' => 'RaceRelationController',

            // Entities
            'entities.attributes' => 'AttributeController',
            'entities.entity_notes' => 'EntityNoteController',
            'entities.entity_events' => 'EntityEventController',

            'attribute_templates' => 'AttributeTemplateController',

            // Permission manager
            'campaign_roles' => 'CampaignRoleController',
            'campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
            //'campaigns.campaign_roles.campaign_permissions' => 'CampaignPermissions',

        ]);
        Route::get('/campaigns/{campaign}/leave', 'CampaignController@leave')->name('campaigns.leave');
        Route::post('/campaigns/{campaign}/campaign_settings', 'CampaignSettingController@save')->name('campaigns.settings.save');

        // Search
        Route::get('/search/calendars', 'SearchController@calendars')->name('calendars.find');
        Route::get('/search/characters', 'SearchController@characters')->name('characters.find');
        Route::get('/search/campaigns', 'SearchController@campaigns')->name('campaigns.find');
        Route::get('/search/events', 'SearchController@events')->name('events.find');
        Route::get('/search/families', 'SearchController@families')->name('families.find');
        Route::get('/search/item', 'SearchController@items')->name('items.find');
        Route::get('/search/locations', 'SearchController@locations')->name('locations.find');
        Route::get('/search/notes', 'SearchController@notes')->name('notes.find');
        Route::get('/search/organisations', 'SearchController@organisations')->name('organisations.find');
        Route::get('/search/sections', 'SearchController@sections')->name('sections.find');
        Route::get('/search/dice_rolls', 'SearchController@diceRolls')->name('dice_rolls.find');
        Route::get('/search/quests', 'SearchController@quests')->name('quests.find');
        Route::get('/search/conversations', 'SearchController@conversations')->name('conversations.find');
        Route::get('/search/races', 'SearchController@races')->name('races.find');

        Route::get('/search', 'SearchController@search')->name('search');
        Route::get('/search/entities', 'SearchController@entities')->name('search.relations');
        Route::get('/search/calendar_event', 'SearchController@calendarEvent')->name('search.calendar_event');
        Route::get('/search/mentions', 'SearchController@mentions')->name('search.mentions');
        Route::get('/search/months', 'SearchController@months')->name('search.months');
        Route::get('/search/live', 'SearchController@live')->name('search.live');
        Route::get('/redirect', 'RedirectController@index')->name('redirect');

        // Move
        Route::get('/entities/move/{entity}', 'EntityController@move')->name('entities.move');
        Route::post('/entities/move/{entity}', 'EntityController@post')->name('entities.move');

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
    });

    // Notification
    Route::get('/notifications/delete/{id}', 'NotificationController@delete')->name('notifications.delete');
    Route::get('/notifications', 'NotificationController@index')->name('notifications');

    // 3rd party
    Route::group(['middleware' => ['translator'], 'prefix' => 'translations'], function () {
        Translator::routes();
    });

    // Admin/Moderation tools
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/campaigns', 'Admin\CampaignController@index')->name('admin.campaigns.index');
    });
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
