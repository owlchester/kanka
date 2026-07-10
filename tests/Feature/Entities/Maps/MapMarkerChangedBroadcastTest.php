<?php

use App\Enums\Visibility;
use App\Events\Maps\MarkerChanged;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;

it('broadcasts on the public presence channel by default', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $event = new MarkerChanged($marker, 'created');

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapMarkerChanged');
});

it('broadcasts on the private admin channel when includeRestricted is true', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $event = new MarkerChanged($marker, 'created', true);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PrivateChannel::class);
    expect($channels[0]->name)->toBe('private-map.' . $map->id . '.admin');
});

it('broadcasts a PinResource for created/updated actions on a publicly visible marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All, 'name' => 'Camp']);

    $payload = new MarkerChanged($marker, 'updated')->broadcastWith();

    expect($payload['action'])->toBe('updated');
    expect($payload['id'])->toBe($marker->id);
    expect($payload['pin'])->toBeInstanceOf(PinResource::class);
    expect($payload['pin']->resource->is($marker))->toBeTrue();
});

it('broadcasts a null pin for the deleted action', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $payload = new MarkerChanged($marker, 'deleted')->broadcastWith();

    expect($payload['action'])->toBe('deleted');
    expect($payload['id'])->toBe($marker->id);
    expect($payload['pin'])->toBeNull();
});

it('downgrades the public action to deleted when the marker is not publicly visible', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);

    $payload = new MarkerChanged($marker, 'updated')->broadcastWith();

    expect($payload['action'])->toBe('deleted');
    expect($payload['pin'])->toBeNull();
});

it('does not downgrade the action on the admin channel even when restricted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);

    $payload = new MarkerChanged($marker, 'updated', true)->broadcastWith();

    expect($payload['action'])->toBe('updated');
    expect($payload['pin'])->toBeInstanceOf(PinResource::class);
});
