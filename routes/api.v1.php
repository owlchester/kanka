<?php

use App\Http\Controllers\Api\v1\ApplicationApiController;
use App\Http\Controllers\Api\v1\CalendarEventApiController;
use App\Http\Controllers\Api\v1\Calendars\AdvancerApiController;
use App\Http\Controllers\Api\v1\Campaigns\UserApiController;
use App\Http\Controllers\Api\v1\DefaultThumbnailApiController;
use App\Http\Controllers\Api\v1\Entities\Attributes\PatchController;
use App\Http\Controllers\Api\v1\Entities\Attributes\PutController;
use App\Http\Controllers\Api\v1\EntityApiController;
use App\Http\Controllers\Api\v1\EntityArchiveApiController;
use App\Http\Controllers\Api\v1\EntityImageApiController;
use App\Http\Controllers\Api\v1\EntityMentionApiController;
use App\Http\Controllers\Api\v1\EntityMoveApiController;
use App\Http\Controllers\Api\v1\EntityPermissionApiController;
use App\Http\Controllers\Api\v1\EntityRecoveryApiController;
use App\Http\Controllers\Api\v1\EntityTemplateApiController;
use App\Http\Controllers\Api\v1\EntityTransformApiController;
use App\Http\Controllers\Api\v1\EntityTypeApiController;
use App\Http\Controllers\Api\v1\FamilyTreeApiController;
use App\Http\Controllers\Api\v1\FilterApiController;
use App\Http\Controllers\Api\v1\FullTextSearchApiController;
use App\Http\Controllers\Api\v1\HealthController;
use App\Http\Controllers\Api\v1\PostLayoutApiController;
use App\Http\Controllers\Api\v1\PostRecoveryApiController;
use App\Http\Controllers\Api\v1\ProfileApiController;
use App\Http\Controllers\Api\v1\RecentEntityApiController;
use App\Http\Controllers\Api\v1\RelationApiController;
use App\Http\Controllers\Api\v1\SearchApiController;
use App\Http\Controllers\Api\v1\VisibilityController;

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
    'campaigns.calendars.calendar_eras' => 'CalendarEraApiController',
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
    'campaigns.entities.reminders' => 'ReminderApiController',
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

Route::get('campaigns/{campaign}/entities/{entity}/image', [EntityImageApiController::class, 'show']);
Route::post('campaigns/{campaign}/entities/{entity}/image', [EntityImageApiController::class, 'put']);
Route::delete('campaigns/{campaign}/entities/{entity}/image', [EntityImageApiController::class, 'destroy']);
Route::get('campaigns/{campaign}/roles', 'CampaignRoleApiController@index');

Route::get('campaigns/{campaign}/relations', [RelationApiController::class, 'index']);
Route::get('campaigns/{campaign}/search/{query}', [SearchApiController::class, 'index']);

Route::get('campaigns/{campaign}/entities/templates', [EntityTemplateApiController::class, 'index']);
Route::post('campaigns/{campaign}/entities/templates/{entity}/switch', [EntityTemplateApiController::class, 'switch']);

Route::get('campaigns/{campaign}/entities/archived', [EntityArchiveApiController::class, 'index']);
Route::post('campaigns/{campaign}/entities/{entity}/archive', [EntityArchiveApiController::class, 'switch']);

Route::get('campaigns/{campaign}/entities', [EntityApiController::class, 'index']);
Route::get('campaigns/{campaign}/entities/recent', [RecentEntityApiController::class, 'index']);
Route::post('campaigns/{campaign}/entities/{entity_type}', [EntityApiController::class, 'put']);
Route::get('campaigns/{campaign}/entities/{entity}', [EntityApiController::class, 'show']);
Route::put('campaigns/{campaign}/entities/{entity}', [EntityApiController::class, 'edit']);
Route::patch('campaigns/{campaign}/entities/{entity}', [EntityApiController::class, 'patch']);
Route::delete('campaigns/{campaign}/entities/{entity}', [EntityApiController::class, 'destroy']);
Route::get('campaigns/{campaign}/entities/{entity}/mentions', [EntityMentionApiController::class, 'index']);

Route::get('campaigns/{campaign}/users', 'Campaigns\UserApiController@index');
Route::get('campaigns/{campaign}/users/{user}', 'Campaigns\UserApiController@show');
Route::post('campaigns/{campaign}/users', 'Campaigns\UserApiController@add');
Route::delete('campaigns/{campaign}/users', 'Campaigns\UserApiController@remove');

Route::get('campaigns/{campaign}/users', [UserApiController::class, 'index']);
Route::get('campaigns/{campaign}/users/{user}', [UserApiController::class, 'show']);
Route::post('campaigns/{campaign}/users', [UserApiController::class, 'add']);
Route::delete('campaigns/{campaign}/users', [UserApiController::class, 'remove']);

Route::post('campaigns/{campaign}/permissions/test', [EntityPermissionApiController::class, 'test']);

Route::get('campaigns/{campaign}/calendars/{calendar}/reminders', [CalendarEventApiController::class, 'index']);
Route::post('campaigns/{campaign}/calendars/{calendar}/advance', [AdvancerApiController::class, 'advance']);
Route::post('campaigns/{campaign}/calendars/{calendar}/retreat', [AdvancerApiController::class, 'retreat']);

Route::get('visibilities', [VisibilityController::class, 'index']);
Route::get('post-layouts', [PostLayoutApiController::class, 'index']);

Route::get('campaigns/{campaign}/recovery', [EntityRecoveryApiController::class, 'index']);
Route::post('campaigns/{campaign}/recover', [EntityRecoveryApiController::class, 'recover']);

Route::get('campaigns/{campaign}/recovery/posts', [PostRecoveryApiController::class, 'index']);
Route::post('campaigns/{campaign}/recover/posts', [PostRecoveryApiController::class, 'recover']);

Route::post('campaigns/{campaign}/transform', [EntityTransformApiController::class, 'transform']);

Route::post('campaigns/{campaign}/transfer', [EntityMoveApiController::class, 'transfer']);

Route::get('campaigns/{campaign}/default-thumbnails', [DefaultThumbnailApiController::class, 'index']);
Route::post('campaigns/{campaign}/default-thumbnails', [DefaultThumbnailApiController::class, 'upload']);
Route::delete('campaigns/{campaign}/default-thumbnails', [DefaultThumbnailApiController::class, 'delete']);

Route::get('campaigns/{campaign}/fulltext-search', [FullTextSearchApiController::class, 'index']);

Route::get('campaigns/{campaign}/families/{family}/tree', [FamilyTreeApiController::class, 'show']);
Route::post('campaigns/{campaign}/families/{family}/tree', [FamilyTreeApiController::class, 'store']);
Route::put('campaigns/{campaign}/families/{family}/tree', [FamilyTreeApiController::class, 'store']);
Route::delete('campaigns/{campaign}/families/{family}/tree', [FamilyTreeApiController::class, 'destroy']);

Route::get('profile', [ProfileApiController::class, 'index']);
Route::get('version', function () {
    return config('app.version');
});

Route::get('health', [HealthController::class, 'index']);
Route::get('entity-types', [EntityTypeApiController::class, 'index']);
Route::get('filters', [FilterApiController::class, 'index']);
Route::get('filters/{entityType}', [FilterApiController::class, 'show']);

Route::get('campaigns/{campaign}/applications', [ApplicationApiController::class, 'index']);
Route::get('campaigns/{campaign}/applications/{application}', [ApplicationApiController::class, 'show']);
Route::post('campaigns/{campaign}/applications/{application}/approve', [ApplicationApiController::class, 'approve']);
Route::post('campaigns/{campaign}/applications/{application}/reject', [ApplicationApiController::class, 'reject']);

// Bulk entity attributes
Route::put('campaigns/{campaign}/entities/{entity}/attributes', [PutController::class, 'put']);
Route::patch('campaigns/{campaign}/entities/{entity}/attributes', [PatchController::class, 'patch']);
