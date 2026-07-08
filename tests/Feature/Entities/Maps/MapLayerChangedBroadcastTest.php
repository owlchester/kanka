<?php

use App\Events\Maps\LayerChanged;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;

it('broadcasts on the map presence channel under the MapLayerChanged name', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    $event = new LayerChanged($layer, 'created');

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapLayerChanged');
});

it('broadcasts a LayerResource for created/updated actions', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Cave Overlay']);

    $payload = new LayerChanged($layer, 'updated')->broadcastWith();

    expect($payload['action'])->toBe('updated');
    expect($payload['id'])->toBe($layer->id);
    expect($payload['layer'])->toBeInstanceOf(LayerResource::class);
    expect($payload['layer']->resource->is($layer))->toBeTrue();
});

it('broadcasts a null layer for the deleted action', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    $payload = new LayerChanged($layer, 'deleted')->broadcastWith();

    expect($payload['action'])->toBe('deleted');
    expect($payload['id'])->toBe($layer->id);
    expect($payload['layer'])->toBeNull();
});
