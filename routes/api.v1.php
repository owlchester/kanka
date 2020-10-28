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
    'campaigns.abilities' => 'AbilityApiController',
    //'campaigns.campaign_users' => 'CampaignUserApiController',
    'campaigns.calendars' => 'CalendarApiController',
    'campaigns.calendars.calendar_weather' => 'CalendarWeatherApiController',
    'campaigns.characters' => 'CharacterApiController',
    'campaigns.dice_rolls' => 'DiceRollApiController',
    'campaigns.events' => 'EventApiController',
    'campaigns.families' => 'FamilyApiController',
    'campaigns.items' => 'ItemApiController',
    'campaigns.journals' => 'JournalApiController',
    'campaigns.locations' => 'LocationApiController',
    'campaigns.locations.map_points' => 'LocationMapPointApiController',
    'campaigns.maps' => 'MapApiController',
    'campaigns.maps.map_layers' => 'MapLayerApiController',
    'campaigns.maps.map_groups' => 'MapGroupApiController',
    'campaigns.maps.map_markers' => 'MapMarkerApiController',
    'campaigns.notes' => 'NoteApiController',
    'campaigns.organisations' => 'OrganisationApiController',
    'campaigns.organisations.organisation_members' => 'OrganisationMemberApiController',
    'campaigns.quests' => 'QuestApiController',
    'campaigns.quests.quest_characters' => 'QuestCharacterApiController',
    'campaigns.quests.quest_locations' => 'QuestLocationApiController',
    'campaigns.quests.quest_items' => 'QuestItemApiController',
    'campaigns.quests.quest_organisations' => 'QuestOrganisationApiController',
    'campaigns.races' => 'RaceApiController',
    'campaigns.tags' => 'TagApiController',
    'campaigns.timelines' => 'TimelineApiController',
    'campaigns.timelines.timeline_eras' => 'TimelineEraApiController',
    'campaigns.timelines.timeline_elements' => 'TimelineElementApiController',
    'campaigns.conversations' => 'ConversationApiController',
    'campaigns.conversations.conversation_participants' => 'ConversationParticipantApiController',
    'campaigns.conversations.conversation_messages' => 'ConversationMessageApiController',
    //'campaigns.' => 'ApiController',

    // Entity elements
    'campaigns.entities.attributes' => 'EntityAttributeApiController',
    'campaigns.entities.entity_notes' => 'EntityNoteApiController',
    'campaigns.entities.entity_events' => 'EntityEventApiController',
    'campaigns.entities.entity_files' => 'EntityFileApiController',
    'campaigns.entities.relations' => 'EntityRelationApiController',
    'campaigns.entities.entity_tags' => 'EntityTagApiController',
    'campaigns.entities.inventory' => 'EntityInventoryApiController',
    'campaigns.entities.entity_abilities' => 'EntityAbilityApiController',

    'campaigns.campaign_dashboard_widgets' => 'CampaignDashboardWidgetApiController'
]);

Route::get('campaigns/{campaign}/users', 'CampaignUserApiController@index');
Route::get('campaigns/{campaign}/relations', 'RelationApiController@index');
Route::get('campaigns/{campaign}/search/{query}', 'SearchApiController@index');
Route::get('profile', 'ProfileApiController@index');

Route::get('campaigns/{campaign}/entities', 'EntityApiController@index');
Route::get('campaigns/{campaign}/entities/{entity}', 'EntityApiController@show');

//Route::get('campaigns/{campaign}/settings', 'CampaignSettingApiController@index');
