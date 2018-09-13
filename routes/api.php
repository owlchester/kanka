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

Route::group([
    'middleware' => ['auth:api', 'throttle:60,1']
], function() {
    Route::resources([
        'campaigns' => 'Api\CampaignApiController',
        //'campaigns.campaign_users' => 'Api\CampaignUserApiController',
        'campaigns.calendars' => 'Api\CalendarApiController',
        'campaigns.characters' => 'Api\CharacterApiController',
        'campaigns.dice_rolls' => 'Api\DiceRollApiController',
        'campaigns.events' => 'Api\EventApiController',
        'campaigns.families' => 'Api\FamilyApiController',
        'campaigns.items' => 'Api\ItemApiController',
        'campaigns.journals' => 'Api\JournalApiController',
        'campaigns.locations' => 'Api\LocationApiController',
        'campaigns.organisations' => 'Api\OrganisationApiController',
        'campaigns.organisations.organisation_members' => 'Api\OrganisationMemberApiController',
        'campaigns.quests' => 'Api\QuestApiController',
        'campaigns.quests.quest_characters' => 'Api\QuestCharacterApiController',
        'campaigns.quests.quest_locations' => 'Api\QuestLocationApiController',
        'campaigns.section' => 'Api\SectionApiController',
        //'campaigns.' => 'Api\ApiController',
    ]);

    Route::get('campaigns/{campaign}/users', 'Api\CampaignUserApiController@index');
    //Route::get('campaigns/{campaign}/settings', 'Api\CampaignSettingApiController@index');
});
