# Map Contents (Group/Layer) Change Broadcasting Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When a `MapGroup` or `MapLayer` is created, edited, or deleted — from any save path including bulk edit — broadcast a fresh snapshot of the map's groups and layers over websockets, so everyone with the v4 map explorer open sees the group tree / layer list update live. Editors additionally get live sync of visibility-restricted content via a second, admin-only channel.

**Architecture:** A single event, `App\Events\Maps\ContentsChanged(Map $map, bool $includeRestricted = false)`, queries `$map->groups`/`$map->layers` fresh at broadcast time (not the specific instance that triggered the save) and broadcasts on either the existing public presence channel or a new admin-only private channel depending on the flag. `MapGroupObserver`/`MapLayerObserver` dispatch both variants from `created()`/`updated()`/`deleted()`. The frontend listens on exactly one of the two channels per session (editors use the admin channel exclusively, others use the public one) and does a full array replace — no per-item diffing.

**Tech Stack:** Laravel 13 (PHP 8.4), Reverb broadcasting, Pest 3, Vue 3, laravel-echo.

## Global Constraints

- This plan first REVERTS the previously-shipped per-item `App\Events\Maps\GroupChanged`/`LayerChanged` design (commits on this branch through `c5a71cdb3`) — see Task 1. `MapLayer::isExplorable()` (from that same prior work) is kept.
- The public channel's groups/layers payload is filtered to `visibility_id IN [Visibility::All, Visibility::Member]`. The admin channel's payload bypasses visibility filtering entirely via the `withPrivate()` query macro (added by `HasVisibility`'s `VisibilityIDScope`) — this must NOT rely on the acting user's own permission level, since the admin channel must be complete regardless of who triggered the change.
- `MapLayer::isExplorable()` filtering (`typeName() === 'overlay_shown' && hasImage()`) always applies to layers on BOTH channels — it's a rendering constraint, not a permission one.
- `reorder()` (in `ReorderTrait`, used by both observers) must only run on `created()`, or on `updated()` when `wasChanged('position')` — never unconditionally on every save.
- No `->toOthers()` exclusion anywhere in this feature (matches prior designs on this branch).
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change, before committing.
- Run tests via `vendor/bin/sail artisan test --compact --filter=...` (minimum filter needed), not the full suite, per task.

---

### Task 1: Revert the per-item group/layer broadcast implementation

**Files:**
- Restore to commit `e46363d66`'s version: `app/Observers/MapGroupObserver.php`, `app/Observers/MapLayerObserver.php`, `resources/js/composables/useMapPresence.js`, `resources/js/components/maps/MapExplorer.vue`
- Delete: `app/Events/Maps/GroupChanged.php`, `app/Events/Maps/LayerChanged.php`, `tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php`, `tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php`

**Interfaces:**
- Produces: `MapGroupObserver`/`MapLayerObserver` back to their pre-existing shape (`saving()`, unconditional `reorder()` in `saved()`, `deleted()` with no broadcast) — the exact starting point later tasks build on. `useMapPresence(getInteractive, getI18n, onMapUpdated)` back to a single bare third callback. `MapExplorer.vue`'s `handleRemoteMapUpdate` and its bare-callback call site restored.
- Consumes: nothing new — this is a pure revert to a known commit.

- [ ] **Step 1: Confirm working tree is clean**

Run: `git status --porcelain`
Expected: no output (clean tree) — if there's output, stop and report BLOCKED rather than discarding uncommitted work.

- [ ] **Step 2: Restore the four files to their pre-per-item-broadcast state**

```bash
git checkout e46363d66 -- app/Observers/MapGroupObserver.php app/Observers/MapLayerObserver.php resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue
```

- [ ] **Step 3: Delete the superseded event and test files**

```bash
git rm app/Events/Maps/GroupChanged.php app/Events/Maps/LayerChanged.php tests/Feature/Entities/Maps/MapGroupChangedBroadcastTest.php tests/Feature/Entities/Maps/MapLayerChangedBroadcastTest.php
```

- [ ] **Step 4: Run tests to confirm a clean baseline**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Entities/Maps/`
Expected: PASS — this now runs the smaller set of tests that existed before the per-item broadcast work (Task 1 of the prior plan's `isExplorable` test, `MapSettingsControllerTest`, `PresenceChannelTest`, `ExploreApiControllerTest`, etc. — none of the deleted `MapGroupChangedBroadcastTest`/`MapLayerChangedBroadcastTest` files remain to run).

Also run: `vendor/bin/sail artisan test --compact --filter=MapGroupTest` and `vendor/bin/sail artisan test --compact --filter=MapLayerTest` and `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: all PASS (these should be entirely unaffected by the revert).

- [ ] **Step 5: Rebuild frontend assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds — this regenerates `public/build/manifest.json` to match the reverted `.vue`/`.js` source.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapGroupObserver.php app/Observers/MapLayerObserver.php resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue public/build/manifest.json
git commit -m "revert: remove per-item group/layer broadcast in favor of a resync-based design

Free/premium campaigns cap at 2/10 groups+layers per map, making a
full resync on any change cheap and far simpler than per-item CRUD
events. See docs/superpowers/specs/2026-07-08-map-contents-broadcast-design.md."
```

---

### Task 2: `App\Events\Maps\ContentsChanged` broadcast event

**Files:**
- Create: `app/Events/Maps/ContentsChanged.php`
- Test: `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php`

**Interfaces:**
- Produces: `App\Events\Maps\ContentsChanged`, constructed as `new ContentsChanged(Map $map, bool $includeRestricted = false)` (also `ContentsChanged::dispatch($map)` / `ContentsChanged::dispatch($map, true)` via `Dispatchable`). `broadcastOn(): array` (one channel — `PrivateChannel("map.{id}.admin")` when `$includeRestricted` is true, else `PresenceChannel("map.{id}")`). `broadcastAs(): string` (always `'MapContentsChanged'`, regardless of `$includeRestricted` — the channel itself scopes delivery). `broadcastWith(): array` (`['groups' => GroupResource::collection(...), 'layers' => LayerResource::collection(...)]`).

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php`:

```php
<?php

use App\Enums\Visibility;
use App\Events\Maps\ContentsChanged;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;

it('broadcasts on the public presence channel by default', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $event = new ContentsChanged($map);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapContentsChanged');
});

it('broadcasts on the private admin channel when includeRestricted is true', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $event = new ContentsChanged($map, true);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PrivateChannel::class);
    expect($channels[0]->name)->toBe('private-map.' . $map->id . '.admin');
    expect($event->broadcastAs())->toBe('MapContentsChanged');
});

it('includes only All/Member visibility groups and layers by default', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    $visibleGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);
    $memberGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Member]);
    $adminGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);

    $visibleLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);
    $adminLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::Admin,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    $payload = new ContentsChanged($map)->broadcastWith();

    $groupIds = collect($payload['groups'])->map(fn (GroupResource $g) => $g->resource->id)->all();
    $layerIds = collect($payload['layers'])->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($groupIds)->toContain($visibleGroup->id, $memberGroup->id);
    expect($groupIds)->not->toContain($adminGroup->id);
    expect($layerIds)->toContain($visibleLayer->id);
    expect($layerIds)->not->toContain($adminLayer->id);
});

it('includes restricted-visibility groups and layers when includeRestricted is true', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    $adminGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);
    $adminLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::Admin,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    $payload = new ContentsChanged($map, true)->broadcastWith();

    $groupIds = collect($payload['groups'])->map(fn (GroupResource $g) => $g->resource->id)->all();
    $layerIds = collect($payload['layers'])->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($groupIds)->toContain($adminGroup->id);
    expect($layerIds)->toContain($adminLayer->id);
});

it('excludes non-explorable layers on both channels regardless of visibility', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $notExplorable = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => null,
    ]);

    $publicLayerIds = collect(new ContentsChanged($map)->broadcastWith()['layers'])
        ->map(fn (LayerResource $l) => $l->resource->id)->all();
    $adminLayerIds = collect(new ContentsChanged($map, true)->broadcastWith()['layers'])
        ->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($publicLayerIds)->not->toContain($notExplorable->id);
    expect($adminLayerIds)->not->toContain($notExplorable->id);
});
```

Note: the `includeRestricted` test above cannot independently prove the `withPrivate()` call is doing the bypassing (as opposed to visibility filtering just not being applied at all in this environment) — `VisibilityIDScope::apply()` short-circuits entirely when `app()->runningInConsole()` is true, which is the case for the whole Pest test run, so the global scope never actually constrains any query in this suite regardless of `withPrivate()`. The test still correctly proves the code's own explicit behavior (the `whereIn` filter is present/absent as expected), which is what matters for this codebase's test conventions — this is a known, documented environment limitation, not a gap to try to work around.

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: FAIL — `Class "App\Events\Maps\ContentsChanged" not found`.

- [ ] **Step 3: Write the event class**

Create `app/Events/Maps/ContentsChanged.php`:

```php
<?php

namespace App\Events\Maps;

use App\Enums\Visibility;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Map;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentsChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Map $map,
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
                ? new PrivateChannel('map.' . $this->map->id . '.admin')
                : new PresenceChannel('map.' . $this->map->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapContentsChanged';
    }

    public function broadcastWith(): array
    {
        $groups = $this->map->groups();
        $layers = $this->map->layers();

        if ($this->includeRestricted) {
            // The acting user (whoever triggered the save) may not be an
            // admin — this channel must be complete regardless, so the
            // visibility scope is bypassed entirely rather than relied on.
            $groups->withPrivate();
            $layers->withPrivate();
        } else {
            $groups->whereIn('visibility_id', [Visibility::All, Visibility::Member]);
            $layers->whereIn('visibility_id', [Visibility::All, Visibility::Member]);
        }

        return [
            'groups' => GroupResource::collection($groups->get()),
            'layers' => LayerResource::collection(
                $layers->get()->filter(fn ($layer) => $layer->isExplorable())->values()
            ),
        ];
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: PASS (5 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/ContentsChanged.php tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php
git commit -m "feat: add Maps\ContentsChanged broadcast event"
```

---

### Task 3: Admin-only private channel authorization

**Files:**
- Modify: `routes/channels.php`
- Test: `tests/Feature/Entities/Maps/PresenceChannelTest.php` (append)

**Interfaces:**
- Produces: `Broadcast::channel('map.{id}.admin', ...)`, authorizing when the user is a campaign member AND can `update` the map's entity. Consumed by Task 2's `ContentsChanged` event (`broadcastOn()`'s admin branch) and Task 7's frontend (`echo.private(...)`).

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/PresenceChannelTest.php` (the file already has the necessary `beforeEach` pusher-config override and `use App\Models\Map; use App\Models\User;` imports — no new imports needed):

```php
it('authorizes a campaign editor to join the map admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(200);
});

it('denies a player from joining the map admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});

it('denies a user who is not a member of the map\'s campaign from the admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $outsider = User::factory()->create();
    $this->actingAs($outsider);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=PresenceChannelTest`
Expected: the 3 new tests FAIL (404 or unauthorized-for-wrong-reason, since no `map.{id}.admin` channel is registered yet) — the 2 pre-existing tests in the file still PASS.

- [ ] **Step 3: Register the channel**

Add to `routes/channels.php`, after the existing `Broadcast::channel('map.{id}', ...)` block:

```php
Broadcast::channel('map.{id}.admin', function (User $user, $id) {
    $map = Map::withInvisible()->findOrFail($id);
    $entity = $map->entity()->withInvisible()->firstOrFail();

    EntityPermission::campaign($entity->campaign);

    return $user->can('member', $entity->campaign) && $user->can('update', $entity);
});
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=PresenceChannelTest`
Expected: PASS (5 tests total: 2 pre-existing, 3 new)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add routes/channels.php tests/Feature/Entities/Maps/PresenceChannelTest.php
git commit -m "feat: add admin-only private channel for restricted map contents"
```

---

### Task 4: `MapGroupObserver` — reorder fix + ContentsChanged dispatch

**Files:**
- Modify: `app/Observers/MapGroupObserver.php`
- Test: `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\ContentsChanged::dispatch(Map $map)` / `::dispatch(Map $map, true)` from Task 2.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php` (add `use App\Models\Map; use Illuminate\Support\Facades\Event;` — `Map`/`MapGroup` are already imported from Task 2's tests, only add `Event` if not already present):

```php
it('dispatches both ContentsChanged variants when a group is created', function () {
    Event::fake([ContentsChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapGroup::factory()->create(['map_id' => $map->id]);

    Event::assertDispatched(ContentsChanged::class, fn ($event) => $event->map->id === $map->id && ! $event->includeRestricted);
    Event::assertDispatched(ContentsChanged::class, fn ($event) => $event->map->id === $map->id && $event->includeRestricted);
});

it('dispatches both ContentsChanged variants when a group is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $group->update(['name' => 'Renamed']);

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
});

it('dispatches both ContentsChanged variants when a group is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $group->delete();

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
});

it('does not re-run reorder() when a non-position field is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group1 = MapGroup::factory()->create(['map_id' => $map->id]);
    $group2 = MapGroup::factory()->create(['map_id' => $map->id]);

    $group1->updateQuietly(['position' => 99]);

    $group2->update(['name' => 'Renamed']);

    expect($group1->fresh()->position)->toBe(99);
});

it('re-runs reorder() when position is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group1 = MapGroup::factory()->create(['map_id' => $map->id]);
    $group2 = MapGroup::factory()->create(['map_id' => $map->id]);

    $group1->updateQuietly(['position' => 99]);

    $group2->update(['position' => 50]);

    expect($group1->fresh()->position)->not->toBe(99);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: the 5 new tests FAIL (nothing dispatches yet; the reorder tests currently fail because the *old* unconditional `reorder()` in `saved()` — restored by Task 1's revert — always re-normalizes, so `$group1->fresh()->position` would be `1` or `2`, not `99`, in the "does not re-run" test; and the "re-runs" test would coincidentally still pass under the old code, since reorder always runs there too — that's fine, the goal is the *first* test failing under old behavior).

- [ ] **Step 3: Update the observer**

Modify `app/Observers/MapGroupObserver.php`:

```php
<?php

namespace App\Observers;

use App\Events\Maps\ContentsChanged;
use App\Models\Map;
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

    public function saved(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
    }

    public function created(MapGroup $mapGroup): void
    {
        $this->reorder($mapGroup);
        $this->broadcastContents($mapGroup->map);
    }

    public function updated(MapGroup $mapGroup): void
    {
        if ($mapGroup->wasChanged('position')) {
            $this->reorder($mapGroup);
        }
        $this->broadcastContents($mapGroup->map);
    }

    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
        $this->broadcastContents($mapGroup->map);
    }

    protected function broadcastContents(Map $map): void
    {
        ContentsChanged::dispatch($map);
        ContentsChanged::dispatch($map, true);
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: PASS (10 tests total: 5 from Task 2, 5 new)

Also confirm no regression:

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupTest`
Expected: PASS (unchanged)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapGroupObserver.php tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php
git commit -m "feat: broadcast ContentsChanged from MapGroupObserver, reorder only when needed"
```

---

### Task 5: `MapLayerObserver` — reorder fix + ContentsChanged dispatch

**Files:**
- Modify: `app/Observers/MapLayerObserver.php`
- Test: `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `App\Events\Maps\ContentsChanged::dispatch(Map $map)` / `::dispatch(Map $map, true)` from Task 2. Same shape as Task 4, for `MapLayer`.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php` (add `use App\Models\MapLayer;` if not already imported by Task 2's tests — it is, no new import needed):

```php
it('dispatches both ContentsChanged variants when a layer is created', function () {
    Event::fake([ContentsChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapLayer::factory()->create(['map_id' => $map->id]);

    Event::assertDispatched(ContentsChanged::class, fn ($event) => $event->map->id === $map->id && ! $event->includeRestricted);
    Event::assertDispatched(ContentsChanged::class, fn ($event) => $event->map->id === $map->id && $event->includeRestricted);
});

it('dispatches both ContentsChanged variants when a layer is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $layer->update(['name' => 'Renamed']);

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
});

it('dispatches both ContentsChanged variants when a layer is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $layer->delete();

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
});

it('does not re-run reorder() when a non-position layer field is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer1 = MapLayer::factory()->create(['map_id' => $map->id]);
    $layer2 = MapLayer::factory()->create(['map_id' => $map->id]);

    $layer1->updateQuietly(['position' => 99]);

    $layer2->update(['name' => 'Renamed']);

    expect($layer1->fresh()->position)->toBe(99);
});

it('re-runs reorder() when layer position is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer1 = MapLayer::factory()->create(['map_id' => $map->id]);
    $layer2 = MapLayer::factory()->create(['map_id' => $map->id]);

    $layer1->updateQuietly(['position' => 99]);

    $layer2->update(['position' => 50]);

    expect($layer1->fresh()->position)->not->toBe(99);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: the 5 new tests FAIL, for the same reasons as Task 4's Step 2.

- [ ] **Step 3: Update the observer**

Modify `app/Observers/MapLayerObserver.php`:

```php
<?php

namespace App\Observers;

use App\Events\Maps\ContentsChanged;
use App\Facades\Images;
use App\Models\Map;
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

    public function saved(MapLayer $mapLayer)
    {
        $mapLayer->map->touchSilently();
    }

    public function created(MapLayer $mapLayer): void
    {
        $this->reorder($mapLayer);
        $this->broadcastContents($mapLayer->map);
    }

    public function updated(MapLayer $mapLayer): void
    {
        if ($mapLayer->wasChanged('position')) {
            $this->reorder($mapLayer);
        }
        $this->broadcastContents($mapLayer->map);
    }

    public function deleted(MapLayer $mapLayer)
    {
        Images::model($mapLayer)->cleanup();
        $mapLayer->map->touchSilently();
        $this->broadcastContents($mapLayer->map);
    }

    protected function broadcastContents(Map $map): void
    {
        ContentsChanged::dispatch($map);
        ContentsChanged::dispatch($map, true);
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: PASS (15 tests total: 10 from Tasks 2-4, 5 new)

Also confirm no regression:

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: PASS (unchanged, including the pre-existing `isExplorable` test)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/MapLayerObserver.php tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php
git commit -m "feat: broadcast ContentsChanged from MapLayerObserver, reorder only when needed"
```

---

### Task 6: Bulk edit now broadcasts — `patch()` uses a real update

**Files:**
- Modify: `app/Models/MapGroup.php`
- Modify: `app/Models/MapLayer.php`
- Test: `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php` (append)

**Interfaces:**
- Consumes: `MapGroupObserver`/`MapLayerObserver`'s `updated()` hooks from Tasks 4-5 — this task relies on them already dispatching `ContentsChanged` on any real update.

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php`:

```php
it('dispatches ContentsChanged when a group is bulk-patched', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $group->patch(['name' => 'Bulk Renamed']);

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
    expect($group->fresh()->name)->toBe('Bulk Renamed');
});

it('dispatches ContentsChanged when a layer is bulk-patched', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    Event::fake([ContentsChanged::class]);
    $layer->patch(['name' => 'Bulk Renamed']);

    Event::assertDispatchedTimes(ContentsChanged::class, 2);
    expect($layer->fresh()->name)->toBe('Bulk Renamed');
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: the 2 new tests FAIL — `patch()` currently calls `updateQuietly()`, which fires no events, so `Event::assertDispatchedTimes` sees 0, not 2.

- [ ] **Step 3: Switch `patch()` to a real update**

In `app/Models/MapGroup.php`, find the `patch()` method and change:

```php
    public function patch(array $data): bool
    {
        return $this->updateQuietly($data);
    }
```

to:

```php
    public function patch(array $data): bool
    {
        return $this->update($data);
    }
```

In `app/Models/MapLayer.php`, make the identical change to its own `patch()` method.

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MapContentsChangedBroadcastTest`
Expected: PASS (17 tests total: 15 from Tasks 2-5, 2 new)

Also confirm no regression in the models' own tests and in the other models that still use `updateQuietly()` in their own unrelated `patch()` methods (untouched by this task, just confirming nothing else broke):

Run: `vendor/bin/sail artisan test --compact --filter=MapGroupTest` and `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: both PASS

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapGroup.php app/Models/MapLayer.php tests/Feature/Entities/Maps/MapContentsChangedBroadcastTest.php
git commit -m "fix: bulk-edited groups/layers now broadcast, via a real update() in patch()"
```

---

### Task 7: Frontend — apply the resync broadcast to the live map explorer

**Files:**
- Modify: `resources/js/composables/useMapPresence.js`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: the `MapContentsChanged` broadcast event (Tasks 2-6), payload shape `{ groups: [...], layers: [...] }` — identical shape to the initial `data.groups`/`data.layers` arrays already used throughout `MapExplorer.vue`. The admin channel name is `${interactive.channel}.admin` (Task 3's registration, e.g. `map.5.admin` for map id 5).
- Produces: `useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged } = {})` — the composable's third parameter changes from a single bare `onMapUpdated` callback (restored by Task 1's revert) to an options object.

- [ ] **Step 1: Change the composable's third parameter to an options object, add canEdit-based channel selection**

Modify `resources/js/composables/useMapPresence.js` — change the function signature:

```js
export function useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged } = {}) {
```

Add an `adminChannelName` tracking variable alongside the existing ones (near the top of the function body, with `let echo = null` etc.):

```js
    let echo = null
    let channel = null
    let connectedChannelName = null
    let adminChannelName = null
```

Extend the listener block inside `connect()` — right after the existing `channel.listen('.MapUpdated', ...)` block, before `channel.error(...)`:

```js
        channel.listen('.MapUpdated', (payload) => {
            onMapUpdated?.(payload.map)
        })

        if (canEdit) {
            adminChannelName = interactive.channel + '.admin'
            const adminChannel = echo.private(adminChannelName)
            adminChannel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
        } else {
            channel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
        }

        channel.error(() => {
            error.value = i18n.error_disconnected
        })
```

Update the cleanup in `onBeforeUnmount` to also leave the admin channel if one was joined:

```js
    onBeforeUnmount(() => {
        if (echo && connectedChannelName) {
            echo.leave(connectedChannelName)
        }
        if (echo && adminChannelName) {
            echo.leave(adminChannelName)
        }
    })
```

- [ ] **Step 2: Update the call site and add the handler in MapExplorer.vue**

Modify `resources/js/components/maps/MapExplorer.vue` — change the `useMapPresence` call (currently passing `handleRemoteMapUpdate` as a bare third argument, per Task 1's revert) to pass the options object:

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
    },
);
```

Add the new handler next to `handleRemoteMapUpdate`:

```js
function handleRemoteMapUpdate(map) {
    data.value.map = map;
}

function handleContentsChanged({ groups, layers }) {
    data.value.groups = groups;
    data.value.layers = layers;
}
```

- [ ] **Step 3: Build assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify**

No automated frontend test coverage exists for Vue/Leaflet interaction in this app (consistent with the rest of the v4 map explorer's real-time features). Verify manually with two authenticated browser sessions viewing the same map — one as an editor (GM), one as a player:
1. As the editor, create a new map group with default (`All`) visibility via the legacy Blade UI. Confirm it appears live in BOTH sessions' legend panels without a reload.
2. Rename that group. Confirm both sessions update live.
3. Delete it. Confirm it disappears live from both.
4. Repeat 1-3 for a map layer (create as `overlay_shown` with an image attached, rename, delete) — confirm both sessions' layer lists update live.
5. As the editor, create a group with `Admin` visibility. Confirm it appears live in the EDITOR's own session (via the admin channel) but produces no visible change and no console error in the PLAYER's session.
6. Bulk-edit several groups/layers at once via the datagrid batch-edit UI. Confirm both sessions update live in one shot (this is the bulk-edit path fixed in Task 6).
7. Drag-reorder a group or layer. Confirm neither session updates live (still out of scope — unchanged from before this feature existed).

- [ ] **Step 5: Commit**

```bash
git add resources/js/composables/useMapPresence.js resources/js/components/maps/MapExplorer.vue public/build/manifest.json
git commit -m "feat: apply live map contents (group/layer) updates from ContentsChanged broadcast"
```
