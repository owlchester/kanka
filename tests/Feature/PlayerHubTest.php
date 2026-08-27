<?php

use App\Enums\CampaignFlags;
use App\Facades\CampaignCache;
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
    $this->postJson('/api/1.0/player-hub/1/claim')->assertUnauthorized();
});
