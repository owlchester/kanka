<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapMarker;

it('is publicly visible when its own visibility is All or Member and it has no group/entity', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => $visibility]);

    expect($marker->isPubliclyVisible())->toBeTrue();
})->with([
    'all' => [Visibility::All],
    'member' => [Visibility::Member],
]);

it('is not publicly visible when its own visibility is restricted', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => $visibility]);

    expect($marker->isPubliclyVisible())->toBeFalse();
})->with([
    'admin' => [Visibility::Admin],
    'self' => [Visibility::Self],
    'admin-self' => [Visibility::AdminSelf],
]);

it('is not publicly visible when its parent group is restricted, even if its own visibility is All', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'group_id' => $group->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeFalse();
});

it('is publicly visible when its parent group is also public', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'group_id' => $group->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeTrue();
});

it('is not publicly visible when its linked entity is private', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_private' => true]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'entity_id' => $entity->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeFalse();
});

it('is publicly visible when its linked entity is not private', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_private' => false]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'entity_id' => $entity->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeTrue();
});
