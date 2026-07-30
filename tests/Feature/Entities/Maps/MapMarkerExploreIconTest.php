<?php

use App\Facades\Avatar;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

it('resolves the default pin icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
});

it('resolves the question mark icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 2]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-question']);
});

it('resolves the exclamation icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 3]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-exclamation']);
});

it('resolves the entity avatar icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 4, 'entity_id' => $entity->id]);

    $icon = $marker->exploreIcon();

    expect($icon['type'])->toBe('avatar');
    expect($icon['value'])->toBe(Avatar::entity($entity)->fallback()->size(276)->thumbnail());
});

it('resolves a custom fontawesome icon only when the campaign is boosted', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1, 'custom_icon' => 'fa-solid fa-skull']);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-skull']);
});

it('resolves a sanitized custom svg icon as an image data uri', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'icon' => 1,
        'custom_icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>',
    ]);

    $icon = $marker->exploreIcon();

    expect($icon['type'])->toBe('svg')
        ->and($icon['value'])->toStartWith('data:image/svg+xml;base64,')
        ->and(base64_decode(substr($icon['value'], strlen('data:image/svg+xml;base64,'))))->toContain('<svg');
});

it('ignores a custom icon when the campaign is not boosted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1, 'custom_icon' => 'fa-solid fa-skull']);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
});

it('resolves the square icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 6]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-square']);
});

it('resolves the circle icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 7]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-circle']);
});

it('resolves the diamond icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 8]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-diamond']);
});

it('resolves the triangle icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 9]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-caret-up']);
});

it('returns none for non-marker shapes', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 3]); // circle

    expect($marker->exploreIcon())->toBe(['type' => 'none', 'value' => null]);
});
