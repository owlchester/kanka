<?php

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\Module;
use App\Facades\UserCache;
use App\Mcp\Servers\KankaServer;
use App\Mcp\Tools\GetEntityRelationsTool;
use App\Mcp\Tools\GetEntityTool;
use App\Mcp\Tools\ListCampaignsTool;
use App\Mcp\Tools\ListEntityAttributesTool;
use App\Mcp\Tools\ListEntityPostsTool;
use App\Mcp\Tools\SearchEntitiesTool;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Family;
use App\Models\Location;
use App\Models\Post;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
use App\Models\User;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\EntityCacheService;
use App\Services\Caches\UserCacheService;
use App\Services\Campaign\ModuleService;
use App\Services\Permissions\EntityPermission as EntityPermissionService;
use Laravel\Passport\Passport;

beforeEach(function () {
    config(['mcp.enabled' => true]);
});

it('lists only campaigns the connected user is a member of', function () {
    $this->asUser()->withCampaign();

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(ListCampaignsTool::class)
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->has('campaigns', 1)
            ->where('campaigns.0.id', 1)
            ->has('campaigns.0.name')
            ->where('pagination.page', 1));
});

it('searches and retrieves visible campaign entities', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Elara of the Vale',
    ]);
    $entity = $character->entity;
    $target = Character::factory()->create(['campaign_id' => 1, 'name' => 'Silverkeep']);
    Relation::factory()->create([
        'campaign_id' => 1,
        'owner_id' => $entity->id,
        'target_id' => $target->entity->id,
        'relation' => 'owes gold to',
    ]);

    // MCP requests don't get the campaign route binding that normally primes this singleton.
    CampaignLocalization::clearCampaign();
    app()->forgetInstance('module');
    app()->forgetInstance(ModuleService::class);
    Module::clearResolvedInstance('module');
    app(ModuleService::class);
    app()->forgetInstance('usercache');
    app()->forgetInstance(UserCacheService::class);
    UserCache::clearResolvedInstance('usercache');
    app(UserCacheService::class);
    app()->forgetInstance('campaigncache');
    app()->forgetInstance(CampaignCacheService::class);
    CampaignCache::clearResolvedInstance('campaigncache');
    app(CampaignCacheService::class);
    app()->forgetInstance('entitycache');
    app()->forgetInstance(EntityCacheService::class);
    EntityCache::clearResolvedInstance('entitycache');
    app(EntityCacheService::class);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(SearchEntitiesTool::class, ['campaign_id' => 1, 'query' => 'Elara'])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('results.0.id', $entity->id)
            ->where('results.0.name', 'Elara of the Vale')
            ->where('pagination.page', 1));

    CampaignLocalization::clearCampaign();
    app()->forgetInstance('entitypermission');
    app()->forgetInstance(EntityPermissionService::class);
    EntityPermission::clearResolvedInstance('entitypermission');
    app(EntityPermissionService::class);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('id', $entity->id)
            ->where('name', 'Elara of the Vale')
            ->etc());

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityRelationsTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('results.0.label', 'owes gold to')
            ->where('results.0.target.name', 'Silverkeep')
            ->etc());
});

it('returns character fields, attributes, and visible posts in an entity dossier', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Adam Morley',
        'age' => 'approximately 40',
    ]);
    $entity = $character->entity;
    Attribute::factory()->create(['entity_id' => $entity->id, 'name' => 'Class', 'value' => 'Wizard']);
    Post::factory()->create(['entity_id' => $entity->id, 'name' => 'History', 'entry' => 'A long history.']);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('character.age', 'approximately 40')
            ->where('properties.items.0.name', 'Class')
            ->where('properties.items.0.value', 'Wizard')
            ->where('articles.items.0.name', 'History')
            ->where('articles.items.0.entry', '<p>A long history.</p>')
            ->etc());

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(ListEntityAttributesTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json->where('items.0.value', 'Wizard')->etc());

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(ListEntityPostsTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json->where('items.0.name', 'History')->etc());
});

it('includes visible linked locations, tags, races, and families in the dossier', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1, 'name' => 'Adam Morley']);
    $entity = $character->entity;
    $family = Family::factory()->create(['campaign_id' => 1, 'name' => 'Morley Family']);
    $race = Race::factory()->create(['campaign_id' => 1, 'name' => 'Human']);
    $location = Location::factory()->create(['campaign_id' => 1, 'name' => 'Rivermoor']);
    $tag = Tag::factory()->create(['campaign_id' => 1, 'name' => 'Royal Guard']);
    $character->characterFamilies()->create(['family_id' => $family->id, 'is_private' => false]);
    $character->characterRaces()->create(['race_id' => $race->id, 'is_private' => false]);
    $entity->entityLocations()->create(['location_id' => $location->id]);
    $entity->entityTags()->create(['tag_id' => $tag->id]);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('locations.0.name', 'Rivermoor')
            ->where('tags.0.name', 'Royal Guard')
            ->where('character.races.0.name', 'Human')
            ->where('character.families.0.name', 'Morley Family')
            ->etc());
});

it('includes visible appearance and personality traits in the character dossier', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Adam Morley',
        'is_personality_visible' => true,
    ]);
    $entity = $character->entity;
    CharacterTrait::query()->create([
        'character_id' => $character->id,
        'name' => 'Hair',
        'entry' => 'Dark and curly',
        'section_id' => CharacterTrait::SECTION_APPEARANCE,
        'is_private' => false,
        'default_order' => 1,
    ]);
    CharacterTrait::query()->create([
        'character_id' => $character->id,
        'name' => 'Temperament',
        'entry' => 'Patient',
        'section_id' => CharacterTrait::SECTION_PERSONALITY,
        'is_private' => false,
        'default_order' => 1,
    ]);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityTool::class, ['campaign_id' => 1, 'entity_id' => $entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('character.traits.appearance.0.name', 'Hair')
            ->where('character.traits.appearance.0.entry', 'Dark and curly')
            ->where('character.traits.personality.0.name', 'Temperament')
            ->etc());
});

it('publishes protected resource metadata for the MCP endpoint', function () {
    $this->getJson('/.well-known/oauth-protected-resource/mcp')
        ->assertOk()
        ->assertJsonPath('resource', url('/mcp'))
        ->assertJsonPath('scopes_supported.0', 'mcp:use');
});

it('shows a browser help page on the MCP URL', function () {
    $this->get('/mcp')
        ->assertOk()
        ->assertViewIs('mcp.help')
        ->assertSee('Kanka MCP')
        ->assertSee('OpenCode')
        ->assertSee('Codex')
        ->assertSee('Claude')
        ->assertSee('read-only');
});

it('keeps the MCP endpoint disabled unless explicitly enabled', function () {
    config(['mcp.enabled' => false]);

    $this->postJson('/mcp', [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'initialize',
        'params' => [],
    ])->assertNotFound();
});

it('requires an authorized MCP credential and advertises the protected-resource URL', function () {
    $this->postJson('/mcp', [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'initialize',
        'params' => [],
    ])
        ->assertUnauthorized()
        ->assertHeader('WWW-Authenticate');
});

it('requires the MCP scope on authenticated server requests', function () {
    Passport::actingAs(User::factory()->create(), ['read']);

    $this->postJson('/mcp', [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'initialize',
        'params' => [],
    ])->assertForbidden();
});

it('does not allow MCP-scoped tokens to use the authenticated REST API', function () {
    $user = User::factory()->create();
    Passport::actingAs($user, ['mcp:use']);

    $this->getJson('/api/1.0/profile')->assertForbidden();
});

it('allows ordinary OAuth API tokens to continue using the REST API', function () {
    $user = User::factory()->create();
    Passport::actingAs($user, ['read']);

    $this->getJson('/api/1.0/profile')->assertOk();
});
