# Map Metadata Change Broadcasting Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When a `Map`'s `name`, `grid`, `min_zoom`, `max_zoom`, or `config` (distance measure/name, legacy pin mode) changes — from any save path — broadcast the fresh map data over the existing `map.{id}` presence channel so everyone with that map open in the v4 explorer sees the change live.

**Architecture:** A new `App\Events\Maps\Updated` (`ShouldBroadcastNow`) broadcasts a `MapResource`-shaped payload on `PresenceChannel("map.{id}")`. `App\Observers\MapObserver::updated()` — already registered for `Map` — dispatches it whenever a watched attribute actually changed, so every save path (Vue `SettingsPanel`, classic entity edit form, API v1) triggers it identically without per-controller wiring. The frontend's `useMapPresence.js` composable (already joined to this channel for presence/cursors) listens for the event and hands the payload to `MapExplorer.vue`, which merges it into `data.map` exactly like it already does for its own settings-save response.

**Tech Stack:** Laravel 11 (PHP 8.4), Reverb broadcasting, Pest 3, Vue 3, laravel-echo.

## Global Constraints

- Only `name`, `grid`, `min_zoom`, `max_zoom`, and `config` (covers `distance_measure`, `distance_name`, `legacy_pins`) trigger the broadcast. `center_x`/`center_y`/`center_marker_id`/`initial_zoom` do not (confirmed with user).
- No `->toOthers()` exclusion — the map explorer uses its own ad-hoc `Echo` connection, not `window.Echo`, so there's no correct socket id to exclude. The frontend must tolerate re-receiving its own change.
- No new presence-channel authorization work — reuse `routes/channels.php`'s existing `Broadcast::channel('map.{id}', ...)`.
- No toast/notification UI — apply the update to reactive state silently.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change, before committing.
- Run tests via `vendor/bin/sail artisan test --compact --filter=...` (minimum filter needed), not the full suite, per task.

---

### Task 1: `App\Events\Maps\Updated` broadcast event

**Files:**
- Create: `app/Events/Maps/Updated.php`
- Test: `tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php`

**Interfaces:**
- Produces: `App\Events\Maps\Updated`, constructed as `new Updated(Map $map)` (also usable as `Updated::dispatch($map)` via the `Dispatchable` trait). Public property `$map` (the `Map` instance). Methods: `broadcastOn(): array` (one `PresenceChannel` named `"presence-map.{$map->id}"`), `broadcastAs(): string` (`'MapUpdated'`), `broadcastWith(): array` (`['map' => MapResource]`).
- Consumes: `App\Http\Resources\Maps\Explore\MapResource` (existing), specifically its fluent `->campaign(Campaign $campaign)` setter.

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapUpdatedBroadcastTest`
Expected: FAIL — `Class "App\Events\Maps\Updated" not found`.

- [ ] **Step 3: Write the event class**

Create `app/Events/Maps/Updated.php`:

```php
<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Map;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Map $map,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('map.' . $this->map->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'map' => new MapResource($this->map)->campaign($this->map->campaign),
        ];
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapUpdatedBroadcastTest`
Expected: PASS (2 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/Updated.php tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php
git commit -m "feat: add Maps\Updated broadcast event"
```

---

### Task 2: `MapObserver::updated()` dispatches on watched-field changes

**Files:**
- Modify: `app/Observers/MapObserver.php`
- Test: `tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\Updated::dispatch(Map $map)` from Task 1.
- Produces: `MapObserver::updated(Map $map): void`, registered automatically (the class is already bound via `Map::observe('App\Observers\MapObserver')` in `AppServiceProvider`) — no provider change needed.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php` (add `use Illuminate\Support\Facades\Event;` to the top imports alongside the existing ones):

```php
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
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapUpdatedBroadcastTest`
Expected: the 7-case dataset test and the "unwatched field" test FAIL (event never dispatched because the observer hook doesn't exist yet); the "same value" test passes trivially (nothing dispatches either way).

- [ ] **Step 3: Add the observer hook**

Modify `app/Observers/MapObserver.php`:

```php
<?php

namespace App\Observers;

use App\Events\Maps\Updated;
use App\Models\Map;

class MapObserver
{
    public function saving(Map $map)
    {
        $map->grid = (int) $map->grid;
    }

    public function updated(Map $map): void
    {
        if (! $map->wasChanged(['name', 'grid', 'min_zoom', 'max_zoom', 'config'])) {
            return;
        }

        Updated::dispatch($map);
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapUpdatedBroadcastTest`
Expected: PASS (11 tests total: 2 from Task 1, 7 dataset cases, 2 negative cases)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapObserver.php tests/Feature/Entities/Maps/MapUpdatedBroadcastTest.php
git commit -m "feat: broadcast Maps\Updated when watched map fields change"
```

---

### Task 3: Verify the Vue SettingsPanel save path triggers the broadcast

**Files:**
- Modify: `tests/Feature/Entities/Maps/MapSettingsControllerTest.php`

**Interfaces:**
- Consumes: `App\Events\Maps\Updated` (Task 1), `Entity\Maps\SettingsController::update()` (existing, unmodified).

- [ ] **Step 1: Write the failing test**

Add to the top imports of `tests/Feature/Entities/Maps/MapSettingsControllerTest.php` (currently `use App\Models\Character; use App\Models\Map; use App\Models\MapMarker;`):

```php
use App\Events\Maps\Updated;
use Illuminate\Support\Facades\Event;
```

Append this test to the file:

```php
it('dispatches Maps\Updated when settings are saved', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 77,
    ])->assertStatus(200);

    Event::assertDispatched(Updated::class, fn ($event) => $event->map->id === $map->id);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="MapSettingsControllerTest"`
Expected: this test would actually already PASS once Task 2 is in place, since `SettingsController::update()` calls `$map->update($data)` and the observer already fires — this step confirms that instead of failing. If it does fail, the observer isn't wired correctly; stop and re-check Task 2 before proceeding.

- [ ] **Step 3: (No production code change needed)**

This task only adds regression coverage for the existing path — Task 2's observer already makes it pass.

- [ ] **Step 4: Run the full file to confirm no regressions**

Run: `vendor/bin/sail artisan test --compact --filter="MapSettingsControllerTest"`
Expected: PASS (all tests in the file, including the pre-existing ones)

- [ ] **Step 5: Commit**

```bash
git add tests/Feature/Entities/Maps/MapSettingsControllerTest.php
git commit -m "test: cover Maps\Updated broadcast from the settings save path"
```

---

### Task 4: Verify the API v1 map update path triggers the broadcast

**Files:**
- Modify: `tests/Feature/Entities/MapTest.php`

**Interfaces:**
- Consumes: `App\Events\Maps\Updated` (Task 1), `Api\v1\MapApiController::update()` (existing, unmodified — this stands in for any non-SettingsPanel save path, including the classic entity edit form, since all of them funnel through `Map::update()`).

- [ ] **Step 1: Write the failing test**

Add to the top of `tests/Feature/Entities/MapTest.php` (currently `use App\Models\Map; use Illuminate\Support\Facades\Storage;`):

```php
use App\Events\Maps\Updated;
use Illuminate\Support\Facades\Event;
```

Append this test to the file:

```php
it('dispatches Maps\Updated when the API updates a map\'s name', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign()->withMaps();

    $this->putJson('/api/1.0/campaigns/1/maps/1', ['name' => 'Renamed via API'])
        ->assertStatus(200);

    Event::assertDispatched(Updated::class, fn ($event) => $event->map->id === 1);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapTest`
Expected: this test PASSes once Task 2 is in place (same reasoning as Task 3 — `MapApiController::update()` calls `$map->update(...)` directly). If it fails, the observer isn't catching this path; stop and re-check Task 2.

- [ ] **Step 3: (No production code change needed)**

- [ ] **Step 4: Run the full file to confirm no regressions**

Run: `vendor/bin/sail artisan test --compact --filter=MapTest`
Expected: PASS (all tests in the file)

- [ ] **Step 5: Commit**

```bash
git add tests/Feature/Entities/MapTest.php
git commit -m "test: cover Maps\Updated broadcast from the API map update path"
```

---

### Task 5: Frontend — apply the broadcast to the live map explorer

**Files:**
- Modify: `resources/js/composables/useMapPresence.js`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: the `MapUpdated` broadcast event from Task 1 (`channel.listen('.MapUpdated', ...)`), payload shape `{ map: <MapResource JSON> }` — identical shape to `data.map` already used throughout `MapExplorer.vue`.
- Produces: `useMapPresence(getInteractive, getI18n, onMapUpdated)` — third parameter added, a callback invoked with the raw `map` object whenever the broadcast is received.

- [ ] **Step 1: Add the listener to the composable**

Modify `resources/js/composables/useMapPresence.js` — change the function signature and add the listener inside `connect()`, right after the existing `channel.listenForWhisper(CURSOR_EVENT, ...)` block (before `channel.error(...)`):

```js
export function useMapPresence(getInteractive, getI18n, onMapUpdated) {
```

```js
        channel.listenForWhisper(CURSOR_EVENT, (payload) => {
            remoteCursors.value = {
                ...remoteCursors.value,
                [payload.userId]: {
                    lat: payload.lat,
                    lng: payload.lng,
                    name: payload.name,
                    colour: colourForUser(payload.userId),
                },
            }
        })

        channel.listen('.MapUpdated', (payload) => {
            onMapUpdated?.(payload.map)
        })

        channel.error(() => {
            error.value = i18n.error_disconnected
        })
```

- [ ] **Step 2: Wire the callback in MapExplorer.vue**

Modify `resources/js/components/maps/MapExplorer.vue` — add a handler function near `handleSettingsSaved` (around line 285):

```js
function handleSettingsSaved(map) {
    data.value.map = map;
}

function handleRemoteMapUpdate(map) {
    data.value.map = map;
}
```

Then update the `useMapPresence` call to pass it as the third argument:

```js
const {
    activeUsers,
    remoteCursors,
    error: presenceError,
    sendCursor,
} = useMapPresence(
    () => data.value.interactive,
    () => data.value.i18n?.presence,
    handleRemoteMapUpdate,
);
```

- [ ] **Step 3: Build assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify**

No automated frontend test coverage exists for Vue/Leaflet interaction in this app (consistent with the rest of the v4 map explorer's real-time features). Verify manually with two authenticated browser sessions viewing the same map:
1. In session A, open the map's `SettingsPanel` and change `grid` (or `legacy_pins`, or a unit-measurement field) and save. Confirm session B's map updates live (e.g. the grid overlay changes, or the legend/marker rendering reflects the new `legacy_pins` mode) without a reload.
2. In session A, edit the map's name via the classic entity edit form (`/w/{campaign}/maps/{map}/edit`) and save. Confirm session B's header (`{{ data.map.name }}`) updates live.
3. In session A, change only the map's center via `SettingsPanel`. Confirm session B does *not* receive any update (out of scope per the design).

- [ ] **Step 5: Commit**

```bash
git add resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue public/build/manifest.json
git commit -m "feat: apply live map metadata updates from Maps\Updated broadcast"
```
