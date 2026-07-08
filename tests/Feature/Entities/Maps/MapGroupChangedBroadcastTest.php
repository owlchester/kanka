<?php

use App\Events\Maps\GroupChanged;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\Map;
use App\Models\MapGroup;
use Illuminate\Broadcasting\PresenceChannel;

it('broadcasts on the map presence channel under the MapGroupChanged name', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);

    $event = new GroupChanged($group, 'created');

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapGroupChanged');
});

it('broadcasts a GroupResource for created/updated actions', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Dungeon Levels']);

    $payload = new GroupChanged($group, 'updated')->broadcastWith();

    expect($payload['action'])->toBe('updated');
    expect($payload['id'])->toBe($group->id);
    expect($payload['group'])->toBeInstanceOf(GroupResource::class);
    expect($payload['group']->resource->is($group))->toBeTrue();
});

it('broadcasts a null group for the deleted action', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);

    $payload = new GroupChanged($group, 'deleted')->broadcastWith();

    expect($payload['action'])->toBe('deleted');
    expect($payload['id'])->toBe($group->id);
    expect($payload['group'])->toBeNull();
});
