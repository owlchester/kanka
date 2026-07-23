<?php

use App\Events\Maps\Updated;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Map;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Event;

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

it('dispatches Maps\Updated when a watched field changes', function (array $changes) {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'name' => 'Original', 'grid' => 10]);

    $map->update($changes);

    Event::assertDispatched(Updated::class, fn ($event) => $event->map->is($map));
})->with([
    'name' => [['name' => 'Renamed']],
    'grid' => [['grid' => 42]],
    'min_zoom' => [['min_zoom' => -3]],
    'max_zoom' => [['max_zoom' => 6]],
    'config distance_measure' => [['config' => ['distance_measure' => 2.5]]],
    'config distance_name' => [['config' => ['distance_name' => 'Leagues']]],
    'config legacy_pins' => [['config' => ['legacy_pins' => true]]],
]);

it('does not dispatch Maps\Updated when only an unwatched field changes', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $map->update(['height' => 500, 'width' => 500]);

    Event::assertNotDispatched(Updated::class);
});

it('does not dispatch Maps\Updated when a watched field is set to its current value', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'grid' => 40]);

    $map->update(['grid' => 40]);

    Event::assertNotDispatched(Updated::class);
});
