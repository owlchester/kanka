<?php

use App\Models\Map;
use App\Models\MapMarker;

it('renders a path marker as an L.polyline, not a generic pin', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 6,
        'custom_shape' => '10.000,20.000 11.000,21.000',
        'colour' => '#f2c14e',
    ]);

    expect($marker->marker())->toContain('L.polyline([[10.000, 20.000], [11.000, 21.000]]');
});

it('falls back to a generic pin when a path marker has no custom_shape yet', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 6,
    ]);

    expect($marker->marker())->toContain('L.marker([');
});
