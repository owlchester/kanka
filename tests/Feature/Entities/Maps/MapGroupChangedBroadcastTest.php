<?php

use App\Enums\Visibility;
use App\Events\Maps\GroupChanged;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\Map;
use App\Models\MapGroup;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Event;

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

it('dispatches GroupChanged with action created when a visible group is created', function () {
    Event::fake([GroupChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);

    Event::assertDispatched(GroupChanged::class, fn ($event) => $event->action === 'created');
});

it('dispatches GroupChanged with action updated when a visible group is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);

    Event::fake([GroupChanged::class]);
    $group->update(['name' => 'Renamed']);

    Event::assertDispatched(GroupChanged::class, fn ($event) => $event->action === 'updated' && $event->group->is($group));
});

it('dispatches GroupChanged exactly once when a visible group is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);

    Event::fake([GroupChanged::class]);
    $group->update(['name' => 'Renamed']);

    Event::assertDispatchedTimes(GroupChanged::class, 1);
});

it('dispatches GroupChanged with action deleted when a visible group is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);

    Event::fake([GroupChanged::class]);
    $group->delete();

    Event::assertDispatched(GroupChanged::class, fn ($event) => $event->action === 'deleted' && $event->group->id === $group->id);
});

it('dispatches GroupChanged for Member-visibility groups', function () {
    Event::fake([GroupChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Member]);

    Event::assertDispatched(GroupChanged::class);
});

it('does not dispatch GroupChanged for restricted-visibility groups', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => $visibility]);

    Event::fake([GroupChanged::class]);
    $group->update(['name' => 'Still restricted']);
    $group->delete();

    Event::assertNotDispatched(GroupChanged::class);
})->with([
    'admin' => [Visibility::Admin],
    'self' => [Visibility::Self],
    'admin-self' => [Visibility::AdminSelf],
]);
