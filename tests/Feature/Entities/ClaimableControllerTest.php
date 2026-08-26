<?php

use App\Enums\CampaignFlags;
use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Entity;

function enablePlayerHub(): Campaign
{
    $campaign = Campaign::findOrFail(1);
    $campaign->flags()->create(['flag' => CampaignFlags::PlayerHub]);
    CampaignCache::campaign($campaign)->clear();

    return $campaign;
}

it('sets a character as claimable when player hub is enabled', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = enablePlayerHub();
    $entity = Character::findOrFail(1)->entity;

    $this->get(route('entities.claimable', [$campaign, $entity]))
        ->assertRedirect();

    expect($entity->refresh()->is_claimable)->toBeTrue();
});

it('removes claimable status from a character', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = enablePlayerHub();
    $entity = Character::findOrFail(1)->entity;
    $entity->update(['is_claimable' => true]);

    $this->get(route('entities.claimable', [$campaign, $entity]))
        ->assertRedirect();

    expect($entity->refresh()->is_claimable)->toBeFalse();
});

it('does not allow claimable status without the player hub flag', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;

    $this->get(route('entities.claimable', [$campaign, $entity]))
        ->assertNotFound();

    expect($entity->refresh()->is_claimable)->toBeFalse();
});

it('only allows campaign admins to change claimable status', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = enablePlayerHub();
    $entity = Character::findOrFail(1)->entity;

    $this->asPlayer();

    $this->get(route('entities.claimable', [$campaign, $entity]))
        ->assertForbidden();

    expect($entity->refresh()->is_claimable)->toBeFalse();
});

it('only allows characters to be claimable', function () {
    $this->asUser()->withCampaign()->withCreatures();
    $campaign = enablePlayerHub();
    $entity = Creature::findOrFail(1)->entity;

    $this->get(route('entities.claimable', [$campaign, $entity]))
        ->assertNotFound();

    expect($entity->refresh()->is_claimable)->toBeFalse();
});

it('shows the claimable action on character entities', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = enablePlayerHub();
    $entity = Entity::findOrFail(1);

    $this->get(route('entities.show', [$campaign, $entity]))
        ->assertSuccessful()
        ->assertSee(__('entities/actions.claimable.set'));
});
