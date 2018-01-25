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
], function() {

    Route::get('/', 'HomeController@index')->name('home');


    Auth::routes();

    Route::get('/profile', 'ProfileController@edit')->name('profile');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/dashboard/settings', 'DashboardController@edit')->name('dashboard.settings');
    Route::patch('/dashboard/settings', 'DashboardController@update')->name('dashboard.settings.update');

    Route::get('/helper/link', 'HelperController@link')->name('helpers.link');

    // OAuth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

    // Password
    Route::patch('/profile/password', 'ProfileController@password')->name('profile.password');
    Route::patch('/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');

    // Random character
    Route::get('/characters/random', 'CharacterController@random')->name('characters.random');

    // Slug
    Route::get('/releases/{id}-{slug?}', 'ReleaseController@show');

    //Route::get('/my-campaigns', 'CampaignController@index')->name('campaign');
    Route::resources([
        'campaigns' => 'CampaignController',
        'campaign_user' => 'CampaignUserController',
        'characters' => 'CharacterController',
        'characters.character_organisations' => 'CharacterOrganisationController',
        'characters.attributes' => 'CharacterAttributeController',
        'characters.relations' => 'CharacterRelationController',
        'events' => 'EventController',
        'events.relations' => 'EventRelationController',
        'locations' => 'LocationController',
        'locations.location_attributes' => 'LocationAttributeController',
        'locations.relations' => 'LocationRelationController',
        //'location_attribute' => 'LocationAttributeController',
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
    ]);
    Route::get('/campaigns/{campaign}/leave', 'CampaignController@leave')->name('campaigns.leave');
    Route::post('/campaigns/{campaign}/campaign_settings', 'CampaignSettingController@save')->name('campaigns.settings.save');


    // Search
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

    Route::get('/invitation/join/{token}', 'InvitationController@join')->name('campaigns.join');

    Route::get('/redirect', 'RedirectController@index')->name('redirect');

    // Move
    Route::get('/entities/move/{entity}', 'EntityController@move')->name('entities.move');
    Route::post('/entities/move/{entity}', 'EntityController@post')->name('entities.move');

    Route::post('/entities/create', 'EntityController@create')->name('entities.create');

});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// 3rd party
Route::group(['middleware' => ['web', 'auth', 'translator'], 'prefix' => 'translations'], function () {
    Translator::routes();
});
