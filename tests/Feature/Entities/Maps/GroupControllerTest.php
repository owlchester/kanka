<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;

it('creates a top-level group and returns it in GroupResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
        'colour' => '#93c5fd',
        'visibility_id' => Visibility::All->value,
        'is_shown' => true,
    ])->assertStatus(201);

    $group = MapGroup::where('name', 'Continent')->firstOrFail();

    expect($response->json())->toBe([
        'id' => $group->id,
        'name' => 'Continent',
        'parent_id' => null,
        'position' => 1,
        'colour' => '#93c5fd',
    ]);
    expect($group->map_id)->toBe($map->id);
    expect($group->visibility_id)->toBe(Visibility::All);
    // MapGroup doesn't cast is_shown to boolean on the model (the existing convention,
    // e.g. MapGroupResource::toArray(), casts at the usage site instead), so a fresh read
    // from SQLite comes back as int(1) rather than a strict bool.
    expect((bool) $group->is_shown)->toBeTrue();
});

it('creates a nested group under an existing parent', function () {
    // This test ends up with 2 groups on one map; MapPolicy::addGroup's pre-existing,
    // out-of-scope count limit defaults standard (non-boosted) campaigns to 1 group per
    // map (config/limits.php), so raise it here purely to keep that unrelated policy from
    // interfering with what this test actually exercises.
    config(['limits.campaigns.maps.groups.standard' => 10]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $parent = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Continent']);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Region',
        'parent_id' => $parent->id,
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('parent_id'))->toBe($parent->id);
});

it('inserts a new group first and shifts the existing group back', function () {
    // See the comment in the "creates a nested group" test above: raise the unrelated
    // MapPolicy::addGroup count limit so it doesn't interfere with this test's 2 groups.
    config(['limits.campaigns.maps.groups.standard' => 10]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $existing = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);
    // Sanity check on the pre-existing MapGroupObserver's own auto-append behavior: the
    // first group ever created on a map gets position 1 with no explicit value needed.
    expect($existing->fresh()->position)->toBe(1);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Regions',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('position'))->toBe(1);
    expect($existing->fresh()->position)->toBe(2);
});

it('inserts a new group after a chosen sibling and shifts the following one back', function () {
    // See the comment in the "creates a nested group" test above: raise the unrelated
    // MapPolicy::addGroup count limit so it doesn't interfere with this test's 3 groups.
    config(['limits.campaigns.maps.groups.standard' => 10]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $first = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'A']);
    $second = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'B']);
    expect($first->fresh()->position)->toBe(1);
    expect($second->fresh()->position)->toBe(2);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'A.5',
        'after_id' => $first->id,
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('position'))->toBe(2);
    expect($first->fresh()->position)->toBe(1);
    expect($second->fresh()->position)->toBe(3);
});

it('shifts every later group on the map, including nested ones, when inserting first', function () {
    // See the comment in the "creates a nested group" test above: raise the unrelated
    // MapPolicy::addGroup count limit so it doesn't interfere with this test's 3 groups.
    config(['limits.campaigns.maps.groups.standard' => 10]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $parent = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Continent']);
    $child = MapGroup::factory()->create(['map_id' => $map->id, 'parent_id' => $parent->id, 'name' => 'Region']);
    expect($parent->fresh()->position)->toBe(1);
    expect($child->fresh()->position)->toBe(2);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'New root',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    // position is a single flat sequence across the whole map (matching the pre-existing
    // MapGroupObserver/ReorderTrait convention) — inserting "first" shifts every later
    // group regardless of nesting depth. This doesn't affect the legend's rendered order:
    // the frontend only ever compares position within one parent's children, and a
    // uniform shift preserves relative order within any such subset.
    expect($parent->fresh()->position)->toBe(2);
    expect($child->fresh()->position)->toBe(3);
});

it('makes newly created groups immediately available, in position order, from the map explore API', function () {
    // See the comment in the "creates a nested group" test above: raise the unrelated
    // MapPolicy::addGroup count limit so it doesn't interfere with this test's 2 groups.
    config(['limits.campaigns.maps.groups.standard' => 10]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $first = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'First',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201)->json();

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Second',
        'after_id' => $first['id'],
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect(collect($response->json('groups'))->pluck('name')->all())->toBe(['First', 'Second']);
});

it('403s group creation for a player without edit permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(403);

    expect(MapGroup::where('name', 'Continent')->exists())->toBeFalse();
});

it('403s group creation past the standard plan group limit', function () {
    config(['limits.campaigns.maps.groups.standard' => 1]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Existing']);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'One too many',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(403);

    expect(MapGroup::where('name', 'One too many')->exists())->toBeFalse();
});

it('404s group creation for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->postJson(route('entities.map-groups.store', [1, $entity]), [
        'name' => 'Continent',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(404);
});

it('422s group creation when name is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(422);
});

it('422s group creation when visibility_id is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
    ])->assertStatus(422);
});
