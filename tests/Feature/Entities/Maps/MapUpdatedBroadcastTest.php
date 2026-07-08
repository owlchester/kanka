<?php

use App\Events\Maps\Updated;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Map;
use Illuminate\Broadcasting\PresenceChannel;

it('broadcasts on the map presence channel under the MapUpdated name', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $event = new Updated($map);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapUpdated');
});

it('broadcasts a MapResource for the map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'name' => 'Broadcast Map']);

    $payload = new Updated($map)->broadcastWith();

    expect($payload)->toHaveKey('map');
    expect($payload['map'])->toBeInstanceOf(MapResource::class);
    expect($payload['map']->resource->is($map))->toBeTrue();
});
