<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'campaigns' => 'CampaignApiController',
    //'campaigns.campaign_users' => 'CampaignUserApiController',
    'campaigns.calendars' => 'CalendarApiController',
    'campaigns.characters' => 'CharacterApiController',
    'campaigns.dice_rolls' => 'DiceRollApiController',
    'campaigns.events' => 'EventApiController',
    'campaigns.families' => 'FamilyApiController',
    'campaigns.items' => 'ItemApiController',
    'campaigns.journals' => 'JournalApiController',
    'campaigns.locations' => 'LocationApiController',
    'campaigns.locations.map_points' => 'LocationMapPointApiController',
    'campaigns.organisations' => 'OrganisationApiController',
    'campaigns.organisations.organisation_members' => 'OrganisationMemberApiController',
    'campaigns.quests' => 'QuestApiController',
    'campaigns.quests.quest_characters' => 'QuestCharacterApiController',
    'campaigns.quests.quest_locations' => 'QuestLocationApiController',
    'campaigns.races' => 'RaceApiController',
    'campaigns.tags' => 'TagApiController',
    //'campaigns.' => 'ApiController',

    // Entity elements
    'campaigns.entities.attributes' => 'EntityAttributeApiController',
    'campaigns.entities.entity_notes' => 'EntityNoteApiController',
    'campaigns.entities.entity_events' => 'EntityEventApiController',
    'campaigns.entities.relations' => 'EntityRelationApiController',
    'campaigns.entities.tags' => 'EntityTagApiController',

]);

Route::get('campaigns/{campaign}/users', 'CampaignUserApiController@index');
Route::get('campaigns/{campaign}/search/{query}', 'SearchApiController@index');
Route::get('profile', 'ProfileApiController@index');
//Route::get('campaigns/{campaign}/settings', 'CampaignSettingApiController@index');
