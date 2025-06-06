<?php

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
    'campaigns.attribute_templates' => 'AttributeTemplateApiController',
    'campaigns.bookmarks' => 'BookmarkApiController',
    // 'campaigns.campaign_users' => 'CampaignUserApiController',
    'campaigns.calendars' => 'CalendarApiController',
    'campaigns.calendars.calendar_weather' => 'CalendarWeatherApiController',
    'campaigns.characters' => 'CharacterApiController',
    'campaigns.creatures' => 'CreatureApiController',
    'campaigns.dice_rolls' => 'DiceRollApiController',
    'campaigns.events' => 'EventApiController',
    'campaigns.families' => 'FamilyApiController',
    'campaigns.items' => 'ItemApiController',
    'campaigns.journals' => 'JournalApiController',
    'campaigns.locations' => 'LocationApiController',
    'campaigns.maps' => 'MapApiController',
    'campaigns.maps.map_layers' => 'MapLayerApiController',
    'campaigns.maps.map_groups' => 'MapGroupApiController',
    'campaigns.maps.map_markers' => 'MapMarkerApiController',
    'campaigns.notes' => 'NoteApiController',
    'campaigns.organisations' => 'OrganisationApiController',
    'campaigns.organisations.organisation_members' => 'OrganisationMemberApiController',
    'campaigns.quests' => 'QuestApiController',
    'campaigns.quests.quest_elements' => 'QuestElementApiController',
    'campaigns.races' => 'RaceApiController',
    'campaigns.tags' => 'TagApiController',
    'campaigns.timelines' => 'TimelineApiController',
    'campaigns.timelines.timeline_eras' => 'TimelineEraApiController',
    'campaigns.timelines.timeline_elements' => 'TimelineElementApiController',
    'campaigns.conversations' => 'ConversationApiController',
    'campaigns.conversations.conversation_participants' => 'ConversationParticipantApiController',
    'campaigns.conversations.conversation_messages' => 'ConversationMessageApiController',
    // 'campaigns.' => 'ApiController',

    // Entity elements
    'campaigns.entities.attributes' => 'EntityAttributeApiController',
    'campaigns.entities.posts' => 'PostApiController',
    'campaigns.reminders' => 'Entities\ReminderApiController',
    'campaigns.entities.relations' => 'EntityRelationApiController',
    'campaigns.entities.entity_tags' => 'EntityTagApiController',
    'campaigns.entities.inventory' => 'EntityInventoryApiController',
    'campaigns.entities.entity_abilities' => 'EntityAbilityApiController',
    'campaigns.entities.entity_assets' => 'EntityAssetApiController',
    'campaigns.entities.entity_permissions' => 'EntityPermissionApiController',

    'campaigns.campaign_dashboard_widgets' => 'CampaignDashboardWidgetApiController',
    'campaigns.campaign_styles' => 'CampaignStyleApiController',

    'campaigns.images' => 'CampaignImageApiController',
    'campaigns.entity_types' => 'Campaigns\EntityTypeApiController',
]);

Route::get('campaigns/{campaign}/entities/{entity}/image', [App\Http\Controllers\Api\v1\EntityImageApiController::class, 'show']);
Route::post('campaigns/{campaign}/entities/{entity}/image', [App\Http\Controllers\Api\v1\EntityImageApiController::class, 'put']);
Route::delete('campaigns/{campaign}/entities/{entity}/image', [App\Http\Controllers\Api\v1\EntityImageApiController::class, 'destroy']);
Route::get('campaigns/{campaign}/roles', 'CampaignRoleApiController@index');

Route::get('campaigns/{campaign}/relations', [App\Http\Controllers\Api\v1\RelationApiController::class, 'index']);
Route::get('campaigns/{campaign}/search/{query}', [App\Http\Controllers\Api\v1\SearchApiController::class, 'index']);

Route::get('campaigns/{campaign}/entities/templates', [App\Http\Controllers\Api\v1\EntityTemplateApiController::class, 'index']);
Route::post('campaigns/{campaign}/entities/templates/{entity}/switch', [App\Http\Controllers\Api\v1\EntityTemplateApiController::class, 'switch']);

Route::get('campaigns/{campaign}/entities', [App\Http\Controllers\Api\v1\EntityApiController::class, 'index']);
Route::get('campaigns/{campaign}/entities/recent', [App\Http\Controllers\Api\v1\RecentEntityApiController::class, 'index']);
Route::post('campaigns/{campaign}/entities/{entity_type}', [App\Http\Controllers\Api\v1\EntityApiController::class, 'put']);
Route::get('campaigns/{campaign}/entities/{entity}', [App\Http\Controllers\Api\v1\EntityApiController::class, 'show']);
Route::put('campaigns/{campaign}/entities/{entity}', [App\Http\Controllers\Api\v1\EntityApiController::class, 'edit']);
Route::patch('campaigns/{campaign}/entities/{entity}', [App\Http\Controllers\Api\v1\EntityApiController::class, 'patch']);
Route::delete('campaigns/{campaign}/entities/{entity}', [App\Http\Controllers\Api\v1\EntityApiController::class, 'destroy']);
Route::get('campaigns/{campaign}/entities/{entity}/mentions', [App\Http\Controllers\Api\v1\EntityMentionApiController::class, 'index']);

Route::get('campaigns/{campaign}/users', 'Campaigns\UserApiController@index');
Route::get('campaigns/{campaign}/users/{user}', 'Campaigns\UserApiController@show');
Route::post('campaigns/{campaign}/users', 'Campaigns\UserApiController@add');
Route::delete('campaigns/{campaign}/users', 'Campaigns\UserApiController@remove');

Route::get('campaigns/{campaign}/users', [App\Http\Controllers\Api\v1\Campaigns\UserApiController::class, 'index']);
Route::get('campaigns/{campaign}/users/{user}', [App\Http\Controllers\Api\v1\Campaigns\UserApiController::class, 'show']);
Route::post('campaigns/{campaign}/users', [App\Http\Controllers\Api\v1\Campaigns\UserApiController::class, 'add']);
Route::delete('campaigns/{campaign}/users', [App\Http\Controllers\Api\v1\Campaigns\UserApiController::class, 'remove']);

Route::post('campaigns/{campaign}/permissions/test', [App\Http\Controllers\Api\v1\EntityPermissionApiController::class, 'test']);

Route::get('campaigns/{campaign}/calendars/{calendar}/reminders', [App\Http\Controllers\Api\v1\CalendarEventApiController::class, 'index']);
Route::post('campaigns/{campaign}/calendars/{calendar}/advance', [App\Http\Controllers\Api\v1\Calendars\AdvancerApiController::class, 'advance']);
Route::post('campaigns/{campaign}/calendars/{calendar}/retreat', [App\Http\Controllers\Api\v1\Calendars\AdvancerApiController::class, 'retreat']);

Route::get('visibilities', [App\Http\Controllers\Api\v1\VisibilityController::class, 'index']);
Route::get('post-layouts', [App\Http\Controllers\Api\v1\PostLayoutApiController::class, 'index']);

Route::get('campaigns/{campaign}/recovery', [App\Http\Controllers\Api\v1\EntityRecoveryApiController::class, 'index']);
Route::post('campaigns/{campaign}/recover', [App\Http\Controllers\Api\v1\EntityRecoveryApiController::class, 'recover']);

Route::get('campaigns/{campaign}/recovery/posts', [App\Http\Controllers\Api\v1\PostRecoveryApiController::class, 'index']);
Route::post('campaigns/{campaign}/recover/posts', [App\Http\Controllers\Api\v1\PostRecoveryApiController::class, 'recover']);

Route::post('campaigns/{campaign}/transform', [App\Http\Controllers\Api\v1\EntityTransformApiController::class, 'transform']);

Route::post('campaigns/{campaign}/transfer', [App\Http\Controllers\Api\v1\EntityMoveApiController::class, 'transfer']);

Route::get('campaigns/{campaign}/default-thumbnails', [App\Http\Controllers\Api\v1\DefaultThumbnailApiController::class, 'index']);
Route::post('campaigns/{campaign}/default-thumbnails', [App\Http\Controllers\Api\v1\DefaultThumbnailApiController::class, 'upload']);
Route::delete('campaigns/{campaign}/default-thumbnails', [App\Http\Controllers\Api\v1\DefaultThumbnailApiController::class, 'delete']);

Route::get('campaigns/{campaign}/fulltext-search', [App\Http\Controllers\Api\v1\FullTextSearchApiController::class, 'index']);

Route::get('campaigns/{campaign}/families/{family}/tree', [App\Http\Controllers\Api\v1\FamilyTreeApiController::class, 'show']);
Route::post('campaigns/{campaign}/families/{family}/tree', [App\Http\Controllers\Api\v1\FamilyTreeApiController::class, 'store']);
Route::put('campaigns/{campaign}/families/{family}/tree', [App\Http\Controllers\Api\v1\FamilyTreeApiController::class, 'store']);
Route::delete('campaigns/{campaign}/families/{family}/tree', [App\Http\Controllers\Api\v1\FamilyTreeApiController::class, 'destroy']);

Route::get('profile', [App\Http\Controllers\Api\v1\ProfileApiController::class, 'index']);
Route::get('version', function () {
    return config('app.version');
});

Route::get('health', [\App\Http\Controllers\Api\v1\HealthController::class, 'index']);
Route::get('entity-types', [App\Http\Controllers\Api\v1\EntityTypeApiController::class, 'index']);
Route::get('filters', [App\Http\Controllers\Api\v1\FilterApiController::class, 'index']);
Route::get('filters/{entityType}', [App\Http\Controllers\Api\v1\FilterApiController::class, 'show']);
