<?php

use App\Enums\Visibility;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Facades\UserCache;
use App\Mcp\Servers\KankaServer;
use App\Mcp\Tools\AddEntityPostTool;
use App\Mcp\Tools\CreateEntityTool;
use App\Mcp\Tools\CreateRelationTool;
use App\Mcp\Tools\GetEntityRelationsTool;
use App\Mcp\Tools\GetEntityTool;
use App\Mcp\Tools\ListCampaignsTool;
use App\Mcp\Tools\ListEntityAttributesTool;
use App\Mcp\Tools\ListEntityPostsTool;
use App\Mcp\Tools\SearchContentTool;
use App\Mcp\Tools\SearchEntitiesTool;
use App\Models\Attribute;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Location;
use App\Models\Pledge;
use App\Models\Post;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
use App\Models\User;
use App\Services\Caches\CampaignCacheService;
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

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(SearchEntitiesTool::class, ['campaign_id' => 1, 'query' => 'Elara'])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('results.0.id', $entity->id)
            ->where('results.0.name', 'Elara of the Vale')
            ->where('pagination.page', 1));

    CampaignLocalization::clearCampaign();
    app()->forgetInstance(EntityPermissionService::class);
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

it('does not attach character details to another child type with the same numeric id', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1, 'age' => 'Private character age']);
    $location = Location::factory()->create(['campaign_id' => 1]);
    expect($character->id)->toBe($location->id);

    KankaServer::actingAs(auth()->user(), 'api')
        ->tool(GetEntityTool::class, ['campaign_id' => 1, 'entity_id' => $location->entity->id])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('id', $location->entity->id)
            ->where('character', null)
            ->etc());
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
        ->assertSee('Claude')
        ->assertSee('ChatGPT')
        ->assertSee('Wyvern and Elemental')
        ->assertSee('full-text');
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

it('gates the MCP endpoint to Wyvern and Elemental subscribers', function () {
    $initPayload = [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'initialize',
        'params' => [
            'protocolVersion' => '2025-03-26',
            'capabilities' => [],
            'clientInfo' => ['name' => 'TestClient', 'version' => '1.0.0'],
        ],
    ];

    $freeUser = User::factory()->create();
    Passport::actingAs($freeUser, ['mcp:use']);
    $this->postJson('/mcp', $initPayload)->assertForbidden();

    $owlbearUser = User::factory()->create(['pledge' => Pledge::OWLBEAR]);
    Passport::actingAs($owlbearUser, ['mcp:use']);
    $this->postJson('/mcp', $initPayload)->assertForbidden();

    $wyvernUser = User::factory()->create(['pledge' => Pledge::WYVERN]);
    Passport::actingAs($wyvernUser, ['mcp:use']);
    $this->postJson('/mcp', $initPayload)->assertOk();

    $elementalUser = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Passport::actingAs($elementalUser, ['mcp:use']);
    $this->postJson('/mcp', $initPayload)->assertOk();
});

it('searches full-text entity and post content while respecting ACL', function () {
    $this->asUser()->withCampaign();
    $admin = auth()->user();

    $publicChar = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Brother Aldric',
        'is_private' => false,
    ]);
    $publicEntity = $publicChar->entity;
    $publicEntity->entry = '<p>Keeper of the Obsidian Pact archive.</p>';
    $publicEntity->save();

    $privateChar = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Secret Agent',
        'is_private' => true,
    ]);
    $privateEntity = $privateChar->entity;
    $privateEntity->entry = '<p>Secretly leads the Obsidian Pact.</p>';
    $privateEntity->save();

    Post::factory()->create([
        'entity_id' => $publicEntity->id,
        'name' => 'Hidden Ledger',
        'entry' => '<p>Obsidian Pact treasury details.</p>',
        'visibility_id' => Visibility::Admin,
    ]);

    KankaServer::actingAs($admin, 'api')
        ->tool(SearchContentTool::class, ['campaign_id' => 1, 'query' => 'Obsidian Pact'])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('search_engine', 'database')
            ->has('results', 3));

    // Non-admin member should only see the public entity, not private entity or admin-only post
    $member = User::factory()->create(['pledge' => Pledge::WYVERN]);
    CampaignUser::create(['campaign_id' => 1, 'user_id' => $member->id]);

    CampaignLocalization::clearCampaign();
    app()->forgetInstance(EntityPermissionService::class);
    app(EntityPermissionService::class);

    KankaServer::actingAs($member, 'api')
        ->tool(SearchContentTool::class, ['campaign_id' => 1, 'query' => 'Obsidian Pact'])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->has('results', 1)
            ->where('results.0.entity_id', $publicEntity->id)
            ->etc());
});

it('creates standard and custom entities defaulting to private for admins', function () {
    $this->asUser()->withCampaign();
    $admin = auth()->user();

    KankaServer::actingAs($admin, 'api')
        ->tool(CreateEntityTool::class, [
            'campaign_id' => 1,
            'module' => 'character',
            'name' => 'Captain Vane',
            'type' => 'NPC',
            'entry' => 'Commander of the **Silver Guard**.',
        ])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('name', 'Captain Vane')
            ->where('module.code', 'character')
            ->where('is_private', true)
            ->etc());

    $created = Entity::where('campaign_id', 1)->where('name', 'Captain Vane')->firstOrFail();
    expect((bool) $created->is_private)->toBeTrue();
    expect($created->entry)->toContain('<strong>Silver Guard</strong>');

    KankaServer::actingAs($admin, 'api')
        ->tool(CreateEntityTool::class, [
            'campaign_id' => 1,
            'module' => 'note',
            'name' => 'Session 14 Prep',
            'is_private' => false,
        ])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('name', 'Session 14 Prep')
            ->where('module.code', 'note')
            ->where('is_private', false)
            ->etc());

    // Non-member user is denied access to create entities in the campaign
    $outsider = User::factory()->create(['pledge' => Pledge::WYVERN]);

    KankaServer::actingAs($outsider, 'api')
        ->tool(CreateEntityTool::class, [
            'campaign_id' => 1,
            'module' => 'character',
            'name' => 'Unauthorized NPC',
        ])
        ->assertHasErrors();
});

it('adds an article post and creates a relation defaulting to admin-only visibility', function () {
    $this->asUser()->withCampaign();
    $admin = auth()->user();

    $c1 = Character::factory()->create(['campaign_id' => 1, 'name' => 'Silverkeep']);
    $c2 = Character::factory()->create(['campaign_id' => 1, 'name' => 'Lord Vance']);

    KankaServer::actingAs($admin, 'api')
        ->tool(AddEntityPostTool::class, [
            'campaign_id' => 1,
            'entity_id' => $c1->entity->id,
            'name' => 'Session 14 Recap',
            'entry' => 'The party met *Lord Vance* at the gate.',
        ])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('entity_id', $c1->entity->id)
            ->where('name', 'Session 14 Recap')
            ->where('visibility', Visibility::Admin->value)
            ->etc());

    $post = Post::where('entity_id', $c1->entity->id)->where('name', 'Session 14 Recap')->firstOrFail();
    expect($post->entry)->toContain('<em>Lord Vance</em>');

    KankaServer::actingAs($admin, 'api')
        ->tool(CreateRelationTool::class, [
            'campaign_id' => 1,
            'owner_entity_id' => $c1->entity->id,
            'target_entity_id' => $c2->entity->id,
            'relation' => 'governed by',
            'attitude' => 25,
        ])
        ->assertHasNoErrors()
        ->assertStructuredContent(fn ($json) => $json
            ->where('owner_entity_id', $c1->entity->id)
            ->where('target_entity_id', $c2->entity->id)
            ->where('relation', 'governed by')
            ->where('attitude', 25)
            ->where('visibility', Visibility::Admin->value)
            ->etc());
});
