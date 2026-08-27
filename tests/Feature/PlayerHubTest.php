<?php

use App\Enums\CampaignFlags;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Entity;
use App\Models\EntityClaim;
use App\Models\InteractionLog;
use App\Models\PlayerSession;
use App\Services\Campaign\ModuleService;
use App\Services\PlayerHub\PlayerHubContextService;

function enablePlayerHubFor(Campaign $campaign): void
{
    $campaign->flags()->create(['flag' => CampaignFlags::PlayerHub]);
    CampaignCache::campaign($campaign)->clear();
}

it('lists visible claimable entities from all enabled member campaigns', function () {
    $this->asUser()->withCampaign()->withCharacters()->withCreatures();
    $user = auth()->user();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);

    $character = Character::findOrFail(1)->entity;
    $character->update(['is_claimable' => true]);
    $claimed = Character::findOrFail(2)->entity;
    EntityClaim::create([
        'entity_id' => $claimed->id,
        'user_id' => $user->id,
        'claimed_at' => now(),
    ]);
    $claim = EntityClaim::where('entity_id', $claimed->id)->firstOrFail();
    $session = new PlayerSession([
        'entity_claim_id' => $claim->id,
        'created_by' => $user->id,
        'name' => 'Session 1',
        'started_at' => now(),
    ]);
    $session->number = 1;
    $session->save();
    InteractionLog::create([
        'player_session_id' => $session->id,
        'entity_id' => $character->id,
        'entity_claim_id' => $claim->id,
        'created_by' => $user->id,
        'note' => 'First note',
    ]);
    InteractionLog::create([
        'player_session_id' => $session->id,
        'entity_id' => $character->id,
        'entity_claim_id' => $claim->id,
        'created_by' => $user->id,
        'note' => 'Second note',
    ]);
    InteractionLog::create([
        'player_session_id' => $session->id,
        'entity_id' => $claimed->id,
        'entity_claim_id' => $claim->id,
        'created_by' => $user->id,
        'note' => 'Third note',
    ]);
    Creature::findOrFail(1)->entity->update(['is_claimable' => true]);

    $response = $this->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonStructure([
            'claimed' => [['id', 'campaign', 'is_claimed', 'claim']],
            'claimable' => [['id', 'campaign', 'is_claimable', 'is_claimed', 'claim']],
            'sync',
        ]);

    expect($response->json('claimed'))->toHaveCount(1)
        ->and($response->json('claimed.0.id'))->toBe($claimed->id)
        ->and($response->json('claimed.0.claim.id'))->toBe($claim->id)
        ->and($response->json('claimed.0.claim.player_sessions_count'))->toBe(1)
        ->and($response->json('claimed.0.claim.interaction_entities_count'))->toBe(2)
        ->and($response->json('claimed.0.claim.last_played_at'))->toBe($session->started_at->toJSON())
        ->and($response->json('claimable'))->toHaveCount(1)
        ->and($response->json('claimable.0.id'))->toBe($character->id)
        ->and($response->json('claimable.0.urls.claim'))->toBeString();
});

it('lists claimable entities without a localized campaign service', function () {
    $this->asUser()->withCampaign()->withCharacters();
    Module::swap(new ModuleService);
    enablePlayerHubFor(Campaign::findOrFail(1));
    Character::findOrFail(1)->entity->update(['is_claimable' => true]);

    $this->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonCount(1, 'claimable');
});

it('includes claimable entities from a second enabled member campaign', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $user = auth()->user();
    $secondCampaign = Campaign::factory()->create(['slug' => 'second-campaign']);
    CampaignUser::create([
        'campaign_id' => $secondCampaign->id,
        'user_id' => $user->id,
    ]);
    $role = CampaignRole::create([
        'campaign_id' => $secondCampaign->id,
        'name' => 'Owner',
        'is_admin' => true,
    ]);
    CampaignRoleUser::create([
        'campaign_role_id' => $role->id,
        'user_id' => $user->id,
    ]);
    enablePlayerHubFor(Campaign::findOrFail(1));
    enablePlayerHubFor($secondCampaign);

    $secondCharacter = Character::factory()->create(['campaign_id' => $secondCampaign->id]);
    $secondEntity = Entity::withoutGlobalScopes()->where('entity_id', $secondCharacter->id)->firstOrFail();
    $secondEntity->update(['is_claimable' => true]);

    $this->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonFragment(['id' => $secondEntity->id]);
});

it('lists claims only for the authenticated user and current memberships', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $user = auth()->user();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $entity->update(['is_claimable' => false]);
    EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => $user->id,
        'claimed_at' => now(),
    ]);

    EntityClaim::create([
        'entity_id' => Character::findOrFail(2)->entity->id,
        'user_id' => $user->id,
        'claimed_at' => now()->subDay(),
        'unclaimed_at' => now(),
    ]);

    $this->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonCount(1, 'claimed')
        ->assertJsonPath('claimed.0.id', $entity->id)
        ->assertJsonPath('claimed.0.is_claimed', true)
        ->assertJsonPath('claimed.0.claim.claimed_at', fn ($value): bool => $value !== null);
});

it('does not expose private entities to a player', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $private = Character::findOrFail(1)->entity;
    $private->update(['is_private' => true, 'is_claimable' => true]);

    $this->asPlayer()
        ->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonCount(0, 'claimable');
});

it('does not expose entities denied directly to a player', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $entity->update(['is_claimable' => true]);

    $this->asPlayer();
    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'user_id' => auth()->id(),
        'entity_id' => $entity->id,
        'action' => CampaignPermission::ACTION_READ,
        'access' => false,
    ]);

    $this->getJson('/api/1.0/player-hub/setup')
        ->assertSuccessful()
        ->assertJsonCount(0, 'claimable');
});

it('creates and manages sessions for an active claimed character', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);

    $first = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])
        ->assertCreated()
        ->assertJsonPath('data.name', 'Session 1');
    $firstId = $first->json('data.id');

    $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
        'name' => 'Opening Session',
    ])->assertCreated()->assertJsonPath('data.name', 'Opening Session');

    InteractionLog::create([
        'player_session_id' => $firstId,
        'entity_id' => $entity->id,
        'note' => 'First interaction',
        'visibility' => 'shared',
    ]);

    $sessions = $this->getJson('/api/1.0/player-hub/player-sessions')
        ->assertSuccessful()
        ->assertJsonCount(2, 'data');
    $firstSession = collect($sessions->json('data'))->firstWhere('id', $firstId);

    expect($firstSession['interactions'])->toHaveCount(1)
        ->and($firstSession['interactions'][0]['note'])->toBe('First interaction');

    $this->getJson("/api/1.0/player-hub/player-sessions/{$firstId}")
        ->assertSuccessful()
        ->assertJsonPath('data.interactions.0.note', 'First interaction');

    $this->patchJson("/api/1.0/player-hub/player-sessions/{$firstId}", [
        'summary' => 'Updated summary',
    ])
        ->assertSuccessful()
        ->assertJsonPath('data.summary', 'Updated summary');

    $this->deleteJson("/api/1.0/player-hub/player-sessions/{$firstId}")
        ->assertNoContent();

    $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated()->assertJsonPath('data.name', 'Session 3');
});

it('activates the campaign context for a player hub claim', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $contextService = app(PlayerHubContextService::class);
    $context = $contextService->forClaim(auth()->user(), $claim->id);

    $contextService->activate($context);

    expect($context->campaign->id)->toBe($campaign->id)
        ->and($context->claim->id)->toBe($claim->id)
        ->and(CampaignLocalization::getCampaign()->id)->toBe($campaign->id)
        ->and(Entity::findOrFail($entity->id)->id)->toBe($entity->id);
});

it('creates and manages interactions for a player session', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $claim = EntityClaim::create([
        'entity_id' => Character::findOrFail(1)->entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $sessionId = $session->json('data.id');
    $target = Character::findOrFail(2)->entity;
    $url = "/api/1.0/player-hub/player-sessions/{$sessionId}/interactions";

    $interaction = $this->postJson($url, [
        'entity_id' => $target->id,
        'note' => 'Met at the tavern',
        'visibility' => 'gm',
    ])
        ->assertCreated()
        ->assertJsonStructure(['data' => [
            'id',
            'player_session_id',
            'entity_id',
            'entity_claim_id',
            'note',
            'visibility',
            'created_by',
            'entity' => ['name', 'image', 'urls'],
        ]])
        ->assertJsonPath('data.player_session_id', $sessionId)
        ->assertJsonPath('data.entity_id', $target->id)
        ->assertJsonPath('data.entity_claim_id', $claim->id)
        ->assertJsonPath('data.created_by', auth()->id())
        ->assertJsonPath('data.entity.name', $target->name)
        ->assertJsonPath('data.entity.image', fn ($value): bool => is_string($value))
        ->assertJsonPath('data.visibility', 'gm');
    $interactionId = $interaction->json('data.id');

    $this->getJson($url . '?per_page=1')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $interactionId);

    $this->getJson("{$url}/{$interactionId}")
        ->assertSuccessful()
        ->assertJsonPath('data.note', 'Met at the tavern');

    $this->patchJson("{$url}/{$interactionId}", [
        'note' => 'Met at the busy tavern',
        'visibility' => 'shared',
    ])
        ->assertSuccessful()
        ->assertJsonPath('data.note', 'Met at the busy tavern')
        ->assertJsonPath('data.visibility', 'shared');

    $this->deleteJson("{$url}/{$interactionId}")->assertNoContent();

    $this->getJson("{$url}/{$interactionId}")->assertNotFound();
    expect(InteractionLog::find($interactionId))->toBeNull();
});

it('validates interaction fields and prevents cross-session access', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $claim = EntityClaim::create([
        'entity_id' => Character::findOrFail(1)->entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $sessionId = $session->json('data.id');
    $url = "/api/1.0/player-hub/player-sessions/{$sessionId}/interactions";

    $this->postJson($url, [])->assertUnprocessable();

    $interaction = $this->postJson($url, [
        'entity_id' => Character::findOrFail(2)->entity->id,
        'note' => 'Note',
    ])->assertCreated();
    $interactionId = $interaction->json('data.id');

    $secondSession = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $secondUrl = '/api/1.0/player-hub/player-sessions/' . $secondSession->json('data.id') . '/interactions';

    $this->getJson("{$secondUrl}/{$interactionId}")->assertNotFound();
    $this->asPlayer()->getJson($url)->assertNotFound();
});

it('filters sessions by entity claim id', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);

    $firstClaim = EntityClaim::create([
        'entity_id' => Character::findOrFail(1)->entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $secondClaim = EntityClaim::create([
        'entity_id' => Character::findOrFail(2)->entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);

    $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $firstClaim->id,
    ])->assertCreated();
    $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $secondClaim->id,
    ])->assertCreated();

    $this->getJson('/api/1.0/player-hub/player-sessions?entity_claim_id=' . $firstClaim->id)
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.entity_claim_id', $firstClaim->id);
});

it('derives interaction log claim ownership and cascades logs', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = new PlayerSession([
        'entity_claim_id' => $claim->id,
        'created_by' => auth()->id(),
        'name' => 'Session 1',
        'started_at' => now(),
    ]);
    $session->number = 1;
    $session->save();

    $log = InteractionLog::create([
        'player_session_id' => $session->id,
        'entity_id' => $entity->id,
        'entity_claim_id' => 999999,
        'created_by' => auth()->id(),
        'note' => 'Note',
        'visibility' => 'gm',
    ]);

    expect($log->refresh()->entity_claim_id)->toBe($claim->id)
        ->and($log->visibility->value)->toBe('gm')
        ->and($log->effectiveVisibility()->value)->toBe('gm');

    $inherited = InteractionLog::create([
        'player_session_id' => $session->id,
        'entity_id' => $entity->id,
        'created_by' => auth()->id(),
        'note' => 'Inherited note',
    ]);

    expect($inherited->effectiveVisibility()->value)->toBe('shared');

    $session->delete();

    expect(InteractionLog::find($log->id))->toBeNull();
});

it('recovers a deleted session and its interaction logs', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $sessionId = $session->json('data.id');
    $interaction = $this->postJson("/api/1.0/player-hub/player-sessions/{$sessionId}/interactions", [
        'entity_id' => $entity->id,
        'note' => 'Recovered note',
    ])->assertCreated();
    $interactionId = $interaction->json('data.id');

    $this->deleteJson("/api/1.0/player-hub/player-sessions/{$sessionId}")->assertNoContent();

    expect(PlayerSession::find($sessionId))->toBeNull()
        ->and(PlayerSession::withTrashed()->find($sessionId)->trashed())->toBeTrue()
        ->and(InteractionLog::find($interactionId))->toBeNull()
        ->and(InteractionLog::withTrashed()->find($interactionId)->trashed())->toBeTrue();

    $this->getJson("/api/1.0/player-hub/player-sessions/{$sessionId}")->assertNotFound();

    $this->postJson("/api/1.0/player-hub/player-sessions/{$sessionId}/recover")
        ->assertSuccessful()
        ->assertJsonPath('data.id', $sessionId)
        ->assertJsonPath('data.interactions.0.id', $interactionId);

    expect(PlayerSession::find($sessionId)->trashed())->toBeFalse()
        ->and(InteractionLog::find($interactionId)->trashed())->toBeFalse();
});

it('recovers a deleted interaction without exposing it across sessions', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $firstSession = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $firstSessionId = $firstSession->json('data.id');
    $secondSession = $this->postJson('/api/1.0/player-hub/player-sessions', [
        'entity_claim_id' => $claim->id,
    ])->assertCreated();
    $secondSessionId = $secondSession->json('data.id');
    $interaction = $this->postJson("/api/1.0/player-hub/player-sessions/{$firstSessionId}/interactions", [
        'entity_id' => $entity->id,
        'note' => 'Recover me',
    ])->assertCreated();
    $interactionId = $interaction->json('data.id');

    $this->deleteJson("/api/1.0/player-hub/player-sessions/{$firstSessionId}/interactions/{$interactionId}")
        ->assertNoContent();
    $this->postJson("/api/1.0/player-hub/player-sessions/{$secondSessionId}/interactions/{$interactionId}/recover")
        ->assertNotFound();

    $this->postJson("/api/1.0/player-hub/player-sessions/{$firstSessionId}/interactions/{$interactionId}/recover")
        ->assertSuccessful()
        ->assertJsonPath('data.id', $interactionId)
        ->assertJsonPath('data.note', 'Recover me');

    expect(InteractionLog::find($interactionId)->trashed())->toBeFalse();
});

it('does not allow another player to recover a deleted session', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = new PlayerSession([
        'entity_claim_id' => $claim->id,
        'created_by' => auth()->id(),
        'name' => 'Deleted session',
        'started_at' => now(),
    ]);
    $session->number = 1;
    $session->save();
    $session->delete();

    $this->asPlayer()
        ->postJson("/api/1.0/player-hub/player-sessions/{$session->id}/recover")
        ->assertNotFound();
});

it('does not expose a player session to another player', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $claim = EntityClaim::create([
        'entity_id' => $entity->id,
        'user_id' => auth()->id(),
        'claimed_at' => now(),
    ]);
    $session = new PlayerSession([
        'entity_claim_id' => $claim->id,
        'created_by' => auth()->id(),
        'name' => 'Session 1',
        'started_at' => now(),
    ]);
    $session->number = 1;
    $session->save();

    $this->asPlayer()
        ->getJson("/api/1.0/player-hub/player-sessions/{$session->id}")
        ->assertNotFound();
});

it('claims an entity atomically and removes its claimable status', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;
    $entity->update(['is_claimable' => true]);

    $this->asPlayer()
        ->postJson("/api/1.0/player-hub/{$entity->id}/claim")
        ->assertCreated()
        ->assertJsonPath('data.id', $entity->id)
        ->assertJsonPath('data.is_claimed', true);
    $player = auth()->user();

    expect($entity->refresh()->is_claimable)->toBeFalse()
        ->and(EntityClaim::where('entity_id', $entity->id)->where('user_id', $player->id)->count())->toBe(1);
});

it('returns conflict when an entity is no longer claimable', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    enablePlayerHubFor($campaign);
    $entity = Character::findOrFail(1)->entity;

    $this->asPlayer()
        ->postJson("/api/1.0/player-hub/{$entity->id}/claim")
        ->assertStatus(409);
});

it('requires authentication for player hub endpoints', function () {
    $this->getJson('/api/1.0/player-hub/setup')->assertUnauthorized();
    $this->getJson('/api/1.0/player-hub/player-sessions')->assertUnauthorized();
    $this->postJson('/api/1.0/player-hub/player-sessions')->assertUnauthorized();
    $this->getJson('/api/1.0/player-hub/player-sessions/1/interactions')->assertUnauthorized();
    $this->postJson('/api/1.0/player-hub/player-sessions/1/interactions')->assertUnauthorized();
    $this->postJson('/api/1.0/player-hub/player-sessions/1/recover')->assertUnauthorized();
    $this->postJson('/api/1.0/player-hub/player-sessions/1/interactions/1/recover')->assertUnauthorized();
    $this->postJson('/api/1.0/player-hub/1/claim')->assertUnauthorized();
});
