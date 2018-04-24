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
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function () {

    Route::get('/', 'HomeController@index')->name('home');

    // Frontend stuff
    Route::get('/about', 'FrontController@about')->name('about');
    //Route::get('/terms-of-service', 'FrontController@tos')->name('tos');
    Route::get('/privacy-policy', 'FrontController@privacy')->name('privacy');
    Route::get('/help', 'FrontController@help')->name('help');
    Route::get('/faq', 'FrontController@faq')->name('faq');


    Auth::routes();

    Route::get('/profile', 'ProfileController@edit')->name('profile');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/dashboard/settings', 'DashboardController@edit')->name('dashboard.settings');
    Route::patch('/dashboard/settings', 'DashboardController@update')->name('dashboard.settings.update');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

    // Password
    Route::patch('/profile/password', 'ProfileController@password')->name('profile.password');
    Route::patch('/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');

    // Random character
    Route::get('/characters/random', 'CharacterController@random')->name('characters.random');

    // Locations
    Route::get('/locations/tree', 'LocationController@tree')->name('locations.tree');
    Route::any('/locations/{location}/map', 'LocationController@map')->name('locations.map');

    // Slug
    Route::get('/releases/{id}-{slug?}', 'ReleaseController@show');

    // Multi-delete for cruds
    Route::post('/calendars/deleteMany', 'CalendarController@deleteMany')->name('calendars.deleteMany');
    Route::post('/characters/deleteMany', 'CharacterController@deleteMany')->name('characters.deleteMany');
    Route::post('/events/deleteMany', 'EventController@deleteMany')->name('events.deleteMany');
    Route::post('/locations/deleteMany', 'LocationController@deleteMany')->name('locations.deleteMany');
    Route::post('/families/deleteMany', 'FamilyController@deleteMany')->name('families.deleteMany');
    Route::post('/items/deleteMany', 'ItemController@deleteMany')->name('items.deleteMany');
    Route::post('/journals/deleteMany', 'JournalController@deleteMany')->name('journals.deleteMany');
    Route::post('/organisations/deleteMany', 'OrganisationController@deleteMany')->name('organisations.deleteMany');
    Route::post('/notes/deleteMany', 'NoteController@deleteMany')->name('notes.deleteMany');
    Route::post('/quests/deleteMany', 'QuestController@deleteMany')->name('quests.deleteMany');
    Route::post('/attribute_templates/deleteMany', 'AttributeTemplateController@deleteMany')->name('attribute_templates.deleteMany');


    Route::post('/calendars/{calendar}/addEvent', 'CalendarController@addEvent')->name('calendars.event.add');

    // Attribute multi-save
    Route::post('/entities/{entity}/attributes/saveMany', 'AttributeController@saveMany')->name('entities.attributes.saveMany');

    // Permission save
    Route::post('/campaigns/{campaign}/campaign_role{campaign_role}/savePermissions', 'CampaignRoleController@savePermissions')->name('campaigns.campaign_roles.savePermissions');


    //Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
    Route::resources([
        'calendars' => 'CalendarController',
        'calendar_event' => 'CalendarEventController',
        'calendars.relations' => 'CalendarRelationController',
        'campaigns' => 'CampaignController',
        'campaign_user' => 'CampaignUserController',
        'characters' => 'CharacterController',
        'characters.character_organisations' => 'CharacterOrganisationController',
        'characters.relations' => 'CharacterRelationController',
        'events' => 'EventController',
        'events.relations' => 'EventRelationController',
        'locations' => 'LocationController',
        'locations.relations' => 'LocationRelationController',
        'families' => 'FamilyController',
        'families.relations' => 'FamilyRelationController',
        'items' => 'ItemController',
        'items.relations' => 'ItemRelationController',
        'journals' => 'JournalController',
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

        'releases' => 'ReleaseController',
        'campaigns.campaign_invites' => 'CampaignInviteController',
        'entities.attributes' => 'AttributeController',
        'entities.entity_notes' => 'EntityNoteController',

        'attribute_templates' => 'AttributeTemplateController',

        // Permission manager
        'campaigns.campaign_roles' => 'CampaignRoleController',
        'campaigns.campaign_roles.campaign_role_users' => 'CampaignRoleUserController',
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
    Route::get('/search', 'SearchController@search')->name('search');
    Route::get('/search/entities', 'SearchController@entities')->name('search.relations');
    Route::get('/search/mentions', 'SearchController@mentions')->name('search.mentions');
    Route::get('/search/months', 'SearchController@months')->name('search.months');

    Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');

    Route::get('/redirect', 'RedirectController@index')->name('redirect');

    // Move
    Route::get('/entities/move/{entity}', 'EntityController@move')->name('entities.move');
    Route::post('/entities/move/{entity}', 'EntityController@post')->name('entities.move');

    // Attribute template
    Route::get('/entities/{entity}/attribute/template', 'AttributeController@template')->name('entities.attributes.template');
    Route::post('/entities/{entity}/attribute/template', 'AttributeController@applyTemplate')->name('entities.attributes.template');
    Route::post('/entities/{entity}/permissions', 'PermissionController@permissions')->name('entities.permissions');

    Route::post('/entities/create', 'EntityController@create')->name('entities.create');

    // Notification
    Route::get('/notifications/delete/{id}', 'NotificationController@delete')->name('notifications.delete');

    // 3rd party
    Route::group(['middleware' => ['translator'], 'prefix' => 'translations'], function () {
        Translator::routes();
    });
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

