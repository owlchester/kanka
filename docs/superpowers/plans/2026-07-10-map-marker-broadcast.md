# Map Marker Change Broadcasting Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When a `MapMarker` (pin) is created, moved (dragged), edited, or deleted — from any save path including bulk edit — broadcast that change over the `map.{id}` presence channel and `map.{id}.admin` private channel, so everyone with the v4 map explorer open sees pins appear, move, update, and disappear live, with visibility changes propagating correctly in both directions.

**Architecture:** A per-item event, `App\Events\Maps\MarkerChanged(MapMarker $marker, string $action, bool $includeRestricted = false)` (markers aren't capped like groups/layers, so a full resync doesn't fit — this mirrors the shape of the earlier, per-item group/layer design). `MapMarker::isPubliclyVisible()` replicates the relevant parts of the existing `visible()` method (own visibility, parent group's visibility, linked entity's `is_private`) as a broadcast-time gate. `MapMarkerObserver` dispatches both channel variants from `created()`/`updated()`/`deleted()`. The public variant downgrades its action to `'deleted'` whenever the marker isn't currently publicly visible, regardless of the real Eloquent action — this is what makes a visibility flip correct in both directions.

**Tech Stack:** Laravel 13 (PHP 8.4), Reverb broadcasting, Pest 3, Vue 3, laravel-echo.

## Global Constraints

- `MapMarker::isPubliclyVisible()` checks, in order: own `visibility_id ∈ [Visibility::All, Visibility::Member]`; if grouped, the parent group's `visibility_id` via `MapGroup::withPrivate()->find($this->group_id)` (bypasses the group's own visibility scope — must be actor-independent, not reliant on whether the acting user happens to be able to see that group); if entity-linked, the entity's `is_private` flag via `Entity::withInvisible()->find($this->entity_id)` (same actor-independence reasoning). No deeper entity permission replication — see the spec's Out of Scope.
- The admin channel (`$includeRestricted = true`) never downgrades the action — editors always see the real action, unfiltered.
- No `wasChanged()` field filtering in the observer — every real save is display-relevant for a marker.
- `MoveController`, the v4 explorer's create/delete endpoints, the legacy Blade marker CRUD, and the API v1 controller are NOT modified — hooking into `MapMarkerObserver` covers all of them.
- No `->toOthers()` exclusion anywhere in this feature (matches prior designs on this branch).
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change, before committing.
- Run tests via `vendor/bin/sail artisan test --compact --filter=...` (minimum filter needed), not the full suite, per task.

---

### Task 1: `MapMarker::isPubliclyVisible()`

**Files:**
- Modify: `app/Models/MapMarker.php`
- Test: `tests/Feature/Entities/Maps/MapMarkerVisibilityTest.php`

**Interfaces:**
- Produces: `MapMarker::isPubliclyVisible(): bool` — used by Task 2's event.

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/MapMarkerVisibilityTest.php`:

```php
<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapMarker;

it('is publicly visible when its own visibility is All or Member and it has no group/entity', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => $visibility]);

    expect($marker->isPubliclyVisible())->toBeTrue();
})->with([
    'all' => [Visibility::All],
    'member' => [Visibility::Member],
]);

it('is not publicly visible when its own visibility is restricted', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'visibility_id' => $visibility]);

    expect($marker->isPubliclyVisible())->toBeFalse();
})->with([
    'admin' => [Visibility::Admin],
    'self' => [Visibility::Self],
    'admin-self' => [Visibility::AdminSelf],
]);

it('is not publicly visible when its parent group is restricted, even if its own visibility is All', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'group_id' => $group->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeFalse();
});

it('is publicly visible when its parent group is also public', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'group_id' => $group->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeTrue();
});

it('is not publicly visible when its linked entity is private', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_private' => true]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'entity_id' => $entity->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeFalse();
});

it('is publicly visible when its linked entity is not private', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_private' => false]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'entity_id' => $entity->id,
    ]);

    expect($marker->isPubliclyVisible())->toBeTrue();
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerVisibilityTest`
Expected: FAIL — `Call to undefined method App\Models\MapMarker::isPubliclyVisible()`.

- [ ] **Step 3: Add the method**

In `app/Models/MapMarker.php`, add near the existing `visible()` method:

```php
    public function isPubliclyVisible(): bool
    {
        if (! self::isVisibleToPublic($this->visibility_id)) {
            return false;
        }

        if ($this->group_id) {
            $group = MapGroup::withPrivate()->find($this->group_id);
            if (! $group || ! self::isVisibleToPublic($group->visibility_id)) {
                return false;
            }
        }

        if ($this->entity_id) {
            $entity = Entity::withInvisible()->find($this->entity_id);
            if (! $entity || $entity->is_private) {
                return false;
            }
        }

        return true;
    }

    protected static function isVisibleToPublic($visibilityId): bool
    {
        return in_array($visibilityId, [Visibility::All, Visibility::Member], true);
    }
```

No new imports needed: `MapMarker.php` is in the `App\Models` namespace, same as `MapGroup` and `Entity`, so both are referenceable without a `use` statement. `Visibility` is already imported (line 6 of the file).

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerVisibilityTest`
Expected: PASS (9 tests: 2+3 dataset cases, 4 single tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapMarker.php tests/Feature/Entities/Maps/MapMarkerVisibilityTest.php
git commit -m "feat: add MapMarker::isPubliclyVisible() for broadcast visibility gating"
```

---

### Task 2: `App\Events\Maps\MarkerChanged` broadcast event

**Files:**
- Create: `app/Events/Maps/MarkerChanged.php`
- Test: `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php`

**Interfaces:**
- Consumes: `MapMarker::isPubliclyVisible(): bool` from Task 1.
- Produces: `App\Events\Maps\MarkerChanged`, constructed as `new MarkerChanged(MapMarker $marker, string $action, bool $includeRestricted = false)` (also `MarkerChanged::dispatch($marker, $action)` / `::dispatch($marker, $action, true)` via `Dispatchable`). `broadcastOn(): array` (`PresenceChannel("map.{id}")` or `PrivateChannel("map.{id}.admin")`). `broadcastAs(): string` (always `'MapMarkerChanged'`). `broadcastWith(): array` (`['action' => ..., 'id' => ..., 'pin' => PinResource|null]`).

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php`:

```php
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
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: FAIL — `Class "App\Events\Maps\MarkerChanged" not found`.

- [ ] **Step 3: Write the event class**

Create `app/Events/Maps/MarkerChanged.php`:

```php
<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\MapMarker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarkerChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapMarker $marker,
        public string $action,
        public bool $includeRestricted = false,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            $this->includeRestricted
                ? new PrivateChannel('map.' . $this->marker->map_id . '.admin')
                : new PresenceChannel('map.' . $this->marker->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapMarkerChanged';
    }

    public function broadcastWith(): array
    {
        $action = $this->action;

        if (! $this->includeRestricted && $action !== 'deleted' && ! $this->marker->isPubliclyVisible()) {
            $action = 'deleted';
        }

        $map = $this->marker->map;

        return [
            'action' => $action,
            'id' => $this->marker->id,
            'pin' => $action === 'deleted'
                ? null
                : new PinResource($this->marker)->campaign($map->campaign)->mapEntity($map->entity),
        ];
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: PASS (6 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/MarkerChanged.php tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php
git commit -m "feat: add Maps\MarkerChanged broadcast event"
```

---

### Task 3: `MapMarkerObserver` dispatches on save/delete

**Files:**
- Modify: `app/Observers/MapMarkerObserver.php`
- Test: `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\MarkerChanged::dispatch(MapMarker $marker, string $action)` / `::dispatch($marker, $action, true)` from Task 2.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php` (add `use App\Models\Map;` if not already imported by earlier tests in this file — it is; add `use Illuminate\Support\Facades\Event;`):

```php
it('dispatches both MarkerChanged variants when a marker is created', function () {
    Event::fake([MarkerChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapMarker::factory()->create(['map_id' => $map->id]);

    Event::assertDispatched(MarkerChanged::class, fn ($event) => $event->action === 'created' && ! $event->includeRestricted);
    Event::assertDispatched(MarkerChanged::class, fn ($event) => $event->action === 'created' && $event->includeRestricted);
});

it('dispatches both MarkerChanged variants when a marker is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    Event::fake([MarkerChanged::class]);
    $marker->update(['name' => 'Renamed']);

    Event::assertDispatchedTimes(MarkerChanged::class, 2);
});

it('dispatches both MarkerChanged variants when a marker is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    Event::fake([MarkerChanged::class]);
    $marker->delete();

    Event::assertDispatchedTimes(MarkerChanged::class, 2);
});

it('dispatches on a partial move-style update, matching the dedicated move endpoint', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'latitude' => 1, 'longitude' => 1]);

    Event::fake([MarkerChanged::class]);
    $marker->update(['latitude' => 42, 'longitude' => 42]);

    Event::assertDispatched(MarkerChanged::class, fn ($event) => $event->action === 'updated' && $event->marker->id === $marker->id);
    Event::assertDispatchedTimes(MarkerChanged::class, 2);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: the 4 new tests FAIL (nothing dispatches yet — the observer's `saved()`/`deleted()` only touch the map silently today).

- [ ] **Step 3: Wire the observer**

Modify `app/Observers/MapMarkerObserver.php`. Keep the existing `saving()` and `sanitizeCustomIcon()` methods completely untouched; replace only `saved()`/`deleted()` and add the new hooks:

```php
    public function saved(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
    }

    public function created(MapMarker $mapMarker): void
    {
        $this->broadcastChange($mapMarker, 'created');
    }

    public function updated(MapMarker $mapMarker): void
    {
        $this->broadcastChange($mapMarker, 'updated');
    }

    public function deleted(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
        $this->broadcastChange($mapMarker, 'deleted');
    }

    protected function broadcastChange(MapMarker $mapMarker, string $action): void
    {
        MarkerChanged::dispatch($mapMarker, $action);
        MarkerChanged::dispatch($mapMarker, $action, true);
    }
```

Add `use App\Events\Maps\MarkerChanged;` to the file's imports.

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: PASS (10 tests total: 6 from Task 2, 4 new)

Also confirm no regression:

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerTest`
Expected: PASS (unchanged)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapMarkerObserver.php tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php
git commit -m "feat: broadcast MarkerChanged from MapMarkerObserver on save/delete"
```

---

### Task 4: Bulk edit now broadcasts — `MapMarker::patch()` uses a real update

**Files:**
- Modify: `app/Models/MapMarker.php`
- Test: `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `MapMarkerObserver`'s `updated()` hook from Task 3 — this task relies on it already dispatching `MarkerChanged` on any real update.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php` (add `use App\Models\MapGroup;` if not already imported):

```php
it('dispatches MarkerChanged when a marker is bulk-patched', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    Event::fake([MarkerChanged::class]);
    $marker->patch(['name' => 'Bulk Renamed']);

    Event::assertDispatchedTimes(MarkerChanged::class, 2);
    expect($marker->fresh()->name)->toBe('Bulk Renamed');
});

it('still converts a group_id of -1 to null when bulk-patched', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'group_id' => $group->id]);

    $marker->patch(['group_id' => -1]);

    expect($marker->fresh()->group_id)->toBeNull();
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: the "dispatches MarkerChanged when a marker is bulk-patched" test FAILS (`patch()` currently calls `updateQuietly()`, firing no events); the `group_id = -1` test PASSES already (that sentinel logic is untouched either way).

- [ ] **Step 3: Switch `patch()` to a real update**

In `app/Models/MapMarker.php`, find the `patch()` method and change:

```php
    public function patch(array $data): bool
    {
        if (isset($data['group_id']) && $data['group_id'] == -1) {
            $data['group_id'] = null;
        }

        return $this->updateQuietly($data);
    }
```

to:

```php
    public function patch(array $data): bool
    {
        if (isset($data['group_id']) && $data['group_id'] == -1) {
            $data['group_id'] = null;
        }

        return $this->update($data);
    }
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerChangedBroadcastTest`
Expected: PASS (12 tests total: 10 from Tasks 2-3, 2 new)

Also confirm no regression:

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerTest`
Expected: PASS

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapMarker.php tests/Feature/Entities/Maps/MapMarkerChangedBroadcastTest.php
git commit -m "fix: bulk-edited markers now broadcast, via a real update() in patch()"
```

---

### Task 5: Frontend — apply the marker broadcast to the live map explorer

**Files:**
- Modify: `resources/js/composables/useMapPresence.js`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: the `MapMarkerChanged` broadcast event (Tasks 2-4), payload shape `{ action, id, pin }` — `pin` matches the same `PinResource` shape already used throughout `data.pins`.
- Produces: `useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged, onMarkerChanged } = {})` — one more optional callback added to the existing options object.

- [ ] **Step 1: Add the `.MapMarkerChanged` listener to both branches of the existing channel split**

Modify `resources/js/composables/useMapPresence.js` — change the function signature:

```js
export function useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged, onMarkerChanged } = {}) {
```

Extend the existing `if (canEdit) { ... } else { ... }` block (added by an earlier task on this branch) to also listen for `.MapMarkerChanged` on whichever channel is already selected:

```js
        if (canEdit) {
            adminChannelName = interactive.channel + '.admin'
            const adminChannel = echo.private(adminChannelName)
            adminChannel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
            adminChannel.listen('.MapMarkerChanged', (payload) => {
                onMarkerChanged?.(payload)
            })
        } else {
            channel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
            channel.listen('.MapMarkerChanged', (payload) => {
                onMarkerChanged?.(payload)
            })
        }
```

- [ ] **Step 2: Wire the callback and add the handler in MapExplorer.vue**

Modify `resources/js/components/maps/MapExplorer.vue` — update the `useMapPresence(...)` call to add the new callback to the existing options object:

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
        canEdit: props.canEdit,
        onMapUpdated: handleRemoteMapUpdate,
        onContentsChanged: handleContentsChanged,
        onMarkerChanged: handleMarkerChanged,
    },
);
```

Add the new handler next to `handleContentsChanged`:

```js
function handleContentsChanged({ groups, layers }) {
    data.value.groups = groups;
    data.value.layers = layers;
}

function handleMarkerChanged({ action, pin, id }) {
    if (action === 'deleted') {
        data.value.pins = data.value.pins.filter((p) => p.id !== id);
        return;
    }

    const index = data.value.pins.findIndex((p) => p.id === id);
    if (index === -1) {
        data.value.pins = [...data.value.pins, pin];
    } else {
        data.value.pins = data.value.pins.map((p) => (p.id === id ? pin : p));
    }
}
```

- [ ] **Step 3: Build assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify**

No automated frontend test coverage exists for Vue/Leaflet interaction in this app (consistent with the rest of the v4 map explorer's real-time features). Verify manually with two authenticated browser sessions viewing the same map — one as an editor (GM), one as a player:
1. As the editor, create a new public-visibility (`All`) marker via the explorer's own marker-creation flow. Confirm it appears live in the PLAYER's session too, without a reload.
2. Drag that marker to a new position and drop it. Confirm it moves live in the player's session at the drop point (not mid-drag).
3. Edit the marker's name via the legacy Blade edit form. Confirm it updates live in the player's session.
4. Delete it. Confirm it disappears live from the player's session.
5. Create a marker with `Admin`-only visibility. Confirm it appears live in the editor's OWN other session/tab (via the admin channel) but never appears at all in the player's session.
6. Take an existing `All`-visibility marker and edit its visibility to `Admin`-only. Confirm it disappears live from the player's session even though it wasn't deleted, only updated.
7. Take that same now-restricted marker and flip its visibility back to `All`. Confirm it reappears live in the player's session.
8. Put a marker in a map group whose own visibility is `Admin`-only, with the marker's own visibility left at `All`. Confirm the marker never appears in the player's session (group-inheritance gate).
9. Bulk-edit several markers at once via the datagrid batch-edit UI. Confirm all changes appear live in both sessions in one shot.

- [ ] **Step 5: Commit**

```bash
git add resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue public/build/manifest.json
git commit -m "feat: apply live map marker updates from Maps\MarkerChanged broadcast"
```
