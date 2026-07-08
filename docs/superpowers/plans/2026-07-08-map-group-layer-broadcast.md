# Map Group/Layer Change Broadcasting Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When a `MapGroup` or `MapLayer` is created, edited, or deleted — from any save path — broadcast that change over the existing `map.{id}` presence channel so everyone with the v4 map explorer open sees the group tree / layer list update live, without reloading.

**Architecture:** Two new events, `App\Events\Maps\GroupChanged` and `App\Events\Maps\LayerChanged` (mirroring `App\Events\Maps\Updated`), each carrying an `action` (`created`/`updated`/`deleted`) plus the resource (or `null` for deletes). Dispatched from the *existing*, already-registered `MapGroupObserver`/`MapLayerObserver` `saved()`/`deleted()` methods — one trigger point regardless of caller. A visibility gate (only `All`/`Member` broadcast) and, for layers, an explorer-eligibility re-check (`overlay_shown` type + has an image) decide whether/what to send. The frontend's `useMapPresence.js` composable gains two more listeners and `MapExplorer.vue` upserts/removes from `data.groups`/`data.layers` by id.

**Tech Stack:** Laravel 13 (PHP 8.4), Reverb broadcasting, Pest 3, Vue 3, laravel-echo.

## Global Constraints

- Only `visibility_id` of `All` or `Member` may broadcast. `Admin`, `Self`, `AdminSelf` never broadcast, on create, update, or delete (confirmed with user — presence-channel membership alone isn't enough authorization for those).
- A `MapLayer` only broadcasts as present (`created`/`updated`) when `$layer->isExplorable()` is true (`typeName() === 'overlay_shown' && hasImage()`). If a save leaves it ineligible (or it's genuinely deleted), the event's `action` is `'deleted'` regardless of the real Eloquent lifecycle event.
- Drag-and-drop reordering does not broadcast (confirmed with user, out of scope) — both `Reorders\*Controller` and `ReorderTrait`'s sibling cascade already use `updateQuietly()`, which fires no model events; nothing in this plan changes that.
- No `->toOthers()` exclusion (matches the prior `Maps\Updated` plan).
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change, before committing.
- Run tests via `vendor/bin/sail artisan test --compact --filter=...` (minimum filter needed), not the full suite, per task.

---

### Task 1: Extract `MapLayer::isExplorable()`

**Files:**
- Modify: `app/Models/MapLayer.php`
- Modify: `app/Services/Maps/ExploreApiService.php:37`
- Test: `tests/Feature/Entities/MapLayerTest.php`

**Interfaces:**
- Produces: `MapLayer::isExplorable(): bool` — used by Task 5's observer wiring and by the refactored `ExploreApiService::load()`.

- [ ] **Step 1: Write the failing test**

Append to `tests/Feature/Entities/MapLayerTest.php`:

```php
it('is explorable only when overlay_shown and has an image', function () {
    $this->asUser()->withCampaign()->withMaps();

    $layer = App\Models\MapLayer::factory()->create(['map_id' => 1, 'type_id' => 2, 'image_uuid' => null]);
    expect($layer->isExplorable())->toBeFalse();

    $layer->update(['image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeFalse(); // image row doesn't exist yet

    App\Models\Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeTrue();

    $layer->update(['type_id' => null]);
    expect($layer->fresh()->isExplorable())->toBeFalse();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: FAIL — `Call to undefined method App\Models\MapLayer::isExplorable()`.

- [ ] **Step 3: Add the method and refactor its one caller**

In `app/Models/MapLayer.php`, add right after the existing `hasImage()` method (around line 143):

```php
    public function hasImage(): bool
    {
        return $this->image || ! empty($this->image_path);
    }

    public function isExplorable(): bool
    {
        return $this->typeName() === 'overlay_shown' && $this->hasImage();
    }
```

In `app/Services/Maps/ExploreApiService.php`, replace line 37:

```php
                    ->filter(fn ($layer) => $layer->typeName() === 'overlay_shown' && $layer->hasImage())
```

with:

```php
                    ->filter(fn ($layer) => $layer->isExplorable())
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: PASS (all tests in the file, including the new one)

Also run the explorer's own test to confirm the refactor didn't change its behavior:

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (unchanged — this is a pure extraction, same logic)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapLayer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/MapLayerTest.php
git commit -m "refactor: extract MapLayer::isExplorable() from ExploreApiService's inline filter"
```

---

### Task 2: `App\Events\Maps\GroupChanged` broadcast event

**Files:**
- Create: `app/Events/Maps/GroupChanged.php`
- Test: `tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php`

**Interfaces:**
- Produces: `App\Events\Maps\GroupChanged`, constructed as `new GroupChanged(MapGroup $group, string $action)` (also `GroupChanged::dispatch($group, $action)` via `Dispatchable`). Public properties `$group`, `$action`. `broadcastOn(): array` (one `PresenceChannel` named `"presence-map.{$group->map_id}"`), `broadcastAs(): string` (`'MapGroupChanged'`), `broadcastWith(): array` (`['action' => ..., 'id' => ..., 'group' => GroupResource|null]` — `null` when `$action === 'deleted'`).

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupChangedBroadcastTest`
Expected: FAIL — `Class "App\Events\Maps\GroupChanged" not found`.

- [ ] **Step 3: Write the event class**

Create `app/Events/Maps/GroupChanged.php`:

```php
<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\MapGroup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapGroup $group,
        public string $action,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('map.' . $this->group->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapGroupChanged';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'id' => $this->group->id,
            'group' => $this->action === 'deleted' ? null : new GroupResource($this->group),
        ];
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupChangedBroadcastTest`
Expected: PASS (3 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/GroupChanged.php tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php
git commit -m "feat: add Maps\GroupChanged broadcast event"
```

---

### Task 3: `MapGroupObserver` dispatches on save/delete, gated by visibility

**Files:**
- Modify: `app/Observers/MapGroupObserver.php`
- Test: `tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\GroupChanged::dispatch(MapGroup $group, string $action)` from Task 2.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php` (add `use App\Enums\Visibility;` and `use Illuminate\Support\Facades\Event;` to the top imports):

```php
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
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupChangedBroadcastTest`
Expected: the 4 new "dispatches" tests FAIL (nothing dispatches yet); the "does not dispatch" dataset test passes trivially (nothing dispatches either way, for now).

- [ ] **Step 3: Wire the observer**

Modify `app/Observers/MapGroupObserver.php`:

```php
<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Events\Maps\GroupChanged;
use App\Models\MapGroup;

class MapGroupObserver
{
    use ReorderTrait;

    public function saving(MapGroup $mapGroup)
    {
        if (! empty($mapGroup->position)) {
            $mapGroup->position = (int) $mapGroup->position;
        } else {
            $lastGroup = $mapGroup->map->groups()->max('position');
            if ($lastGroup) {
                $mapGroup->position = (int) $lastGroup + 1;
            } else {
                $mapGroup->position = 1;
            }
        }
    }

    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
        $this->broadcastChange($mapGroup, 'deleted');
    }

    public function saved(MapGroup $mapGroup)
    {
        $this->reorder($mapGroup);
        $mapGroup->map->touchSilently();
        $this->broadcastChange($mapGroup, $mapGroup->wasRecentlyCreated ? 'created' : 'updated');
    }

    protected function broadcastChange(MapGroup $mapGroup, string $action): void
    {
        if (! in_array($mapGroup->visibility_id, [Visibility::All, Visibility::Member], true)) {
            return;
        }

        GroupChanged::dispatch($mapGroup, $action);
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupChangedBroadcastTest`
Expected: PASS (10 tests total: 3 from Task 2, 4 dispatch tests, 3 dataset cases for the restricted-visibility test)

Also confirm no regression in the model's own existing tests:

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupTest`
Expected: PASS (unchanged)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapGroupObserver.php tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php
git commit -m "feat: broadcast MapGroupChanged when a visible group is saved or deleted"
```

---

### Task 4: `App\Events\Maps\LayerChanged` broadcast event

**Files:**
- Create: `app/Events/Maps/LayerChanged.php`
- Test: `tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php`

**Interfaces:**
- Produces: `App\Events\Maps\LayerChanged`, constructed as `new LayerChanged(MapLayer $layer, string $action)` / `LayerChanged::dispatch($layer, $action)`. Same shape as `GroupChanged` (Task 2), substituting `MapLayer`/`LayerResource`/`'MapLayerChanged'`/`layer`.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerChangedBroadcastTest`
Expected: FAIL — `Class "App\Events\Maps\LayerChanged" not found`.

- [ ] **Step 3: Write the event class**

Create `app/Events/Maps/LayerChanged.php`:

```php
<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\MapLayer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LayerChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapLayer $layer,
        public string $action,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('map.' . $this->layer->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapLayerChanged';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'id' => $this->layer->id,
            'layer' => $this->action === 'deleted' ? null : new LayerResource($this->layer),
        ];
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerChangedBroadcastTest`
Expected: PASS (3 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/LayerChanged.php tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php
git commit -m "feat: add Maps\LayerChanged broadcast event"
```

---

### Task 5: `MapLayerObserver` dispatches on save/delete, gated by visibility and explorer-eligibility

**Files:**
- Modify: `app/Observers/MapLayerObserver.php`
- Test: `tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\LayerChanged::dispatch(MapLayer $layer, string $action)` from Task 4; `MapLayer::isExplorable(): bool` from Task 1.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php` (add `use App\Enums\Visibility; use App\Models\Image; use Illuminate\Support\Facades\Event;` to the top imports):

```php
it('dispatches LayerChanged with action created when a visible, explorable layer is created', function () {
    Event::fake([LayerChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'created');
});

it('does not dispatch LayerChanged when a layer is created but not explorable', function () {
    Event::fake([LayerChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapLayer::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All, 'type_id' => null]);

    Event::assertNotDispatched(LayerChanged::class);
});

it('dispatches LayerChanged with action deleted when an explorable layer loses its image on update', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->update(['image_uuid' => null]);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'deleted' && $event->layer->id === $layer->id);
});

it('dispatches LayerChanged with action updated when a layer becomes explorable on update', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All, 'type_id' => null]);

    Event::fake([LayerChanged::class]);
    $layer->update(['type_id' => 2, 'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'updated' && $event->layer->is($layer));
});

it('dispatches LayerChanged with action deleted when a visible, explorable layer is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->delete();

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'deleted' && $event->layer->id === $layer->id);
});

it('does not dispatch LayerChanged for restricted-visibility layers', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => $visibility,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->update(['name' => 'Still restricted']);
    $layer->delete();

    Event::assertNotDispatched(LayerChanged::class);
})->with([
    'admin' => [Visibility::Admin],
    'self' => [Visibility::Self],
    'admin-self' => [Visibility::AdminSelf],
]);
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerChangedBroadcastTest`
Expected: the 5 new "dispatches"/"does not dispatch...not explorable" tests FAIL; the restricted-visibility dataset test passes trivially for now.

- [ ] **Step 3: Wire the observer**

Modify `app/Observers/MapLayerObserver.php`:

```php
<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Events\Maps\LayerChanged;
use App\Facades\Images;
use App\Models\MapLayer;

class MapLayerObserver
{
    use ReorderTrait;

    public function saving(MapLayer $mapLayer)
    {
        if (! empty($mapLayer->position)) {
            $mapLayer->position = (int) $mapLayer->position;
        } else {
            /** @var ?MapLayer $lastLayer */
            $lastLayer = $mapLayer->map->layers()->orderByDesc('position')->first();
            if ($lastLayer) {
                $mapLayer->position = (int) $lastLayer->position + 1;
            } else {
                $mapLayer->position = 1;
            }
        }

        // Trying to cheat the options
        if ($mapLayer->type_id > 2) {
            $mapLayer->type_id = null;
        }
    }

    public function deleted(MapLayer $mapLayer)
    {
        Images::model($mapLayer)->cleanup();
        $mapLayer->map->touchSilently();
        $this->broadcastChange($mapLayer, 'deleted');
    }

    public function saved(MapLayer $mapLayer)
    {
        $this->reorder($mapLayer);
        $mapLayer->map->touchSilently();
        $this->broadcastChange($mapLayer, $mapLayer->isExplorable()
            ? ($mapLayer->wasRecentlyCreated ? 'created' : 'updated')
            : 'deleted');
    }

    protected function broadcastChange(MapLayer $mapLayer, string $action): void
    {
        if (! in_array($mapLayer->visibility_id, [Visibility::All, Visibility::Member], true)) {
            return;
        }

        LayerChanged::dispatch($mapLayer, $action);
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerChangedBroadcastTest`
Expected: PASS (11 tests total: 3 from Task 4, 5 dispatch/eligibility tests, 3 dataset cases)

Also confirm no regression in the model's own existing tests:

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: PASS (unchanged, including Task 1's new `isExplorable` test)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapLayerObserver.php tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php
git commit -m "feat: broadcast MapLayerChanged when a visible, explorable layer is saved or deleted"
```

---

### Task 6: Frontend — apply group/layer broadcasts to the live map explorer

**Files:**
- Modify: `resources/js/composables/useMapPresence.js`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: the `MapGroupChanged`/`MapLayerChanged` broadcast events (Tasks 2-5), payload shapes `{ action, id, group }` / `{ action, id, layer }`.
- Produces: `useMapPresence(getInteractive, getI18n, { onMapUpdated, onGroupChanged, onLayerChanged } = {})` — the composable's third parameter changes from a single callback to an options object (it currently only takes `onMapUpdated` as a bare third argument).

- [ ] **Step 1: Change the composable's third parameter to an options object and add the two new listeners**

Modify `resources/js/composables/useMapPresence.js` — change the function signature:

```js
export function useMapPresence(getInteractive, getI18n, { onMapUpdated, onGroupChanged, onLayerChanged } = {}) {
```

And extend the existing listener block (where `.MapUpdated` is currently registered) to:

```js
        channel.listen('.MapUpdated', (payload) => {
            onMapUpdated?.(payload.map)
        })

        channel.listen('.MapGroupChanged', (payload) => {
            onGroupChanged?.(payload)
        })

        channel.listen('.MapLayerChanged', (payload) => {
            onLayerChanged?.(payload)
        })

        channel.error(() => {
            error.value = i18n.error_disconnected
        })
```

- [ ] **Step 2: Update the call site and add the two handlers in MapExplorer.vue**

Modify `resources/js/components/maps/MapExplorer.vue` — change the `useMapPresence` call (currently passing `handleRemoteMapUpdate` as a bare third argument) to pass the options object:

```js
const {
    activeUsers,
    remoteCursors,
    error: presenceError,
    sendCursor,
} = useMapPresence(
    () => data.value.interactive,
    () => data.value.i18n?.presence,
    {
        onMapUpdated: handleRemoteMapUpdate,
        onGroupChanged: handleRemoteGroupChanged,
        onLayerChanged: handleRemoteLayerChanged,
    },
);
```

Add the two new handlers next to `handleRemoteMapUpdate`:

```js
function handleRemoteMapUpdate(map) {
    data.value.map = map;
}

function handleRemoteGroupChanged({ action, group, id }) {
    if (action === 'deleted') {
        data.value.groups = data.value.groups.filter((g) => g.id !== id);
        return;
    }

    const index = data.value.groups.findIndex((g) => g.id === id);
    if (index === -1) {
        data.value.groups = [...data.value.groups, group];
    } else {
        data.value.groups = data.value.groups.map((g) => (g.id === id ? group : g));
    }
}

function handleRemoteLayerChanged({ action, layer, id }) {
    if (action === 'deleted') {
        data.value.layers = data.value.layers.filter((l) => l.id !== id);
        return;
    }

    const index = data.value.layers.findIndex((l) => l.id === id);
    if (index === -1) {
        data.value.layers = [...data.value.layers, layer];
    } else {
        data.value.layers = data.value.layers.map((l) => (l.id === id ? layer : l));
    }
}
```

- [ ] **Step 3: Build assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify**

No automated frontend test coverage exists for Vue/Leaflet interaction in this app (consistent with the rest of the v4 map explorer's real-time features). Verify manually with two authenticated browser sessions viewing the same map:
1. In session A, create a new map group via the legacy Blade UI (or the REST API) with default (All) visibility. Confirm it appears live in session B's legend panel without a reload.
2. Rename that group in session A. Confirm session B's legend updates live.
3. Delete that group in session A. Confirm it disappears live from session B's legend.
4. Repeat 1-3 for a map layer (create one as `overlay_shown` with an image attached, rename it, delete it) and confirm session B's layer list updates live each time.
5. Create a group/layer with `Admin` visibility. Confirm session B (a non-admin player) sees no live update at all — no flicker, no entry appearing.
6. Edit an existing `overlay_shown` layer with an image to remove its image. Confirm it disappears live from session B even though it wasn't deleted, only updated.

- [ ] **Step 5: Commit**

```bash
git add resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue public/build/manifest.json
git commit -m "feat: apply live map group/layer updates from broadcast events"
```
