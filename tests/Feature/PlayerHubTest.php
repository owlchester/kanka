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
    $this->postJson('/api/1.0/player-hub/1/claim')->assertUnauthorized();
});
