<?php

use App\Models\Map;
use App\Models\MapMarker;

it('suppresses the datagrid icon for label markers', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 2]);

    expect($marker->datagridMarkerIcon())->toBe('');
});

it('suppresses the datagrid icon for circle markers', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 3]);

    expect($marker->datagridMarkerIcon())->toBe('');
});

it('suppresses the datagrid icon for polygon markers', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 5]);

    expect($marker->datagridMarkerIcon())->toBe('');
});

it('still shows an icon for regular marker-shaped markers', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 1, 'icon' => 1]);

    expect($marker->datagridMarkerIcon())->not->toBe('');
});
