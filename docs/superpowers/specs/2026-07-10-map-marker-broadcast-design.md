# Map Marker Change Broadcasting Design

## Goal

When a `MapMarker` (pin) is created, moved (dragged), edited, or deleted — from any save path — broadcast that change over the existing `map.{id}` presence channel and `map.{id}.admin` private channel, so everyone with the v4 map explorer open sees pins appear, move, update, and disappear live. Visibility changes must propagate correctly in both directions: an admin switching a marker from `Admin`-only to `All`/`Member` during play must make it appear live for players; switching it back must make it disappear live for them too.

## Out of Scope

- No live streaming of in-progress drag movement (i.e., other viewers seeing a pin visibly slide across the map while someone is still dragging it, before they release). The existing drag implementation only persists and emits once, on drop (`LeafletCanvas.vue`'s `dragend` handler → `MoveController`) — this design broadcasts that single, authoritative post-drop position, matching what already happens today for the dragging user's own view. True in-flight streaming would need a new whisper-style event (like the existing cursor-position whisper) and is a separate, bigger feature not requested here.
- No changes to `MoveController`, the v4 explorer's create/delete endpoints, the legacy Blade marker CRUD, or the API v1 `MapMarkerApiController` — all of these already perform real (non-quiet) `MapMarker::update()`/`create()`/`delete()` calls, so hooking broadcasting into `MapMarkerObserver` covers every one of them without per-controller changes.
- No full replication of Entity's per-user/per-role permission grant system for the broadcast visibility gate. Only the entity's `is_private` flag is checked (see Architecture). A marker linked to a non-private entity with finer-grained role restrictions may occasionally over- or under-broadcast relative to a specific viewer's exact entity permissions — this is an accepted, pragmatic limit, not a full solve. It self-heals on reload, matching the precedent already set for `Self`/`AdminSelf`-visibility items across this branch's other real-time features.
- No dragging permission changes — `is_draggable` is a static per-marker flag that is already included in the existing `PinResource` shape reused here; this design doesn't add any new draggability logic, it just ensures the flag reaches every viewer's client the same way any other marker field does.

## Background

- `MapMarker` can be numerous per map (no cap like groups/layers, which are limited to 2/10 for free/premium campaigns) — a full-resync broadcast (the approach just built for `ContentsChanged`) would not scale here. This design uses per-item events instead, closer to the very first (later reverted, for a different reason — scale, not correctness) group/layer design.
- `MapMarker::visible()` (`app/Models/MapMarker.php`) is the existing method that decides whether a marker appears in a given viewer's initial page load. It layers three checks on top of the DB-level `VisibilityIDScope` (from `HasVisibility`, same trait `MapGroup`/`MapLayer` use): the marker's own `visibility_id`, whether its parent group (if any) is itself visible (`! empty($this->group_id) && ! $this->group` — the group relation resolves to null when the querying user can't see it, due to the SAME scope applying to `MapGroup`), and whether its linked entity (if any) is visible (via `Entity`'s own, richer permission system).
- The broadcast gate needs to replicate the visibility_id and group-inheritance checks precisely (both expressible via the same `Visibility` enum used by `ContentsChanged`), but only checks the entity's `is_private` flag for the entity-linked case — see Out of Scope.
- Because a broadcast is built once (within whichever request triggered the save) and delivered to every channel subscriber, it cannot rely on `$marker->group`/`$marker->entity`'s own scoped relation resolution (which reflects the ACTING user's permissions, not a fixed truth) — the same reasoning already applied to `ContentsChanged`'s `withPrivate()` usage. This design queries the group and entity fresh, explicitly bypassing their own visibility scopes (`MapGroup::withPrivate()->find(...)`, `Entity::withInvisible()->find(...)` — both existing scope-bypass macros already used elsewhere in this codebase, e.g. `routes/channels.php`'s `Map::withInvisible()`), rather than reading the marker's own `group`/`entity` relation properties.
- `App\Observers\MapMarkerObserver` already exists and is registered, with `saving()` (opacity rounding, custom icon sanitization, circle radius nulling) and `saved()`/`deleted()` that only call `$mapMarker->map->touchSilently()` — no broadcasting today.
- `MapMarker::patch()` (used by the datagrid bulk-edit UI) calls `updateQuietly()`, the same gap already fixed for `MapGroup`/`MapLayer` in the prior design.
- The dedicated move endpoint, `App\Http\Controllers\Maps\Markers\MoveController::index`, already calls `$mapMarker->update($request->only('latitude', 'longitude'))` — a real, non-quiet, partial update. Hooking into the observer's `updated()` hook picks this up automatically; this is exactly the "some markers have an is_draggable property that just moves them around which needs to be propagated" requirement, satisfied with no special-casing.
- `App\Http\Resources\Maps\Explore\PinResource` (`app/Http/Resources/Maps/Explore/PinResource.php`) is the existing resource used for the initial pins payload — it already includes `is_draggable`, and needs both `->campaign(Campaign $campaign)` and `->mapEntity(Entity $mapEntity)` context (the MAP's own entity, for building `destroy_url`/`preview_url`/`move_url` — not the marker's linked entity). Reused as-is for the broadcast payload.
- `App\Events\Maps\ContentsChanged` (groups/layers) is the direct template for the event shape (`ShouldBroadcastNow`, `ShouldRescue`, public/admin channel selection via a boolean flag, `PresenceChannel`/`PrivateChannel` on `map.{id}` / `map.{id}.admin`).

## Architecture

**1. `MapMarker::isPubliclyVisible(): bool`** (new model method, mirrors `MapLayer::isExplorable()`):
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

**2. `App\Events\Maps\MarkerChanged`** (`ShouldBroadcastNow`, `ShouldRescue`):
```php
public function __construct(
    public MapMarker $marker,
    public string $action, // 'created' | 'updated' | 'deleted'
    public bool $includeRestricted = false,
) {
    $this->broadcastVia('reverb');
}

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
```
The admin variant (`$includeRestricted = true`) always uses the real action, unfiltered — editors see everything regardless of visibility. The public variant downgrades to `'deleted'` whenever the marker isn't currently publicly visible, regardless of the real Eloquent action — this is what makes an admin's visibility flip (either direction) correct: a marker moving from restricted to public broadcasts as its real action (`created` on first save, `updated` thereafter) the moment it becomes eligible; one moving from public to restricted broadcasts `'deleted'` even though it was really an update, so players' clients remove it. A marker that was already ineligible and stays ineligible harmlessly re-broadcasts `'deleted'` on every change — the frontend's filter-by-id is a no-op for an id that was never present.

**3. `MapMarkerObserver`** — adds dispatch, `saving()` untouched:
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
No `wasChanged()` field filtering — every real save is display-relevant for a marker (position, name, colour, icon, opacity, visibility, etc.), matching the same reasoning already applied to groups/layers.

**4. `MapMarker::patch()`** — switches `updateQuietly($data)` to `update($data)`, same fix as `MapGroup`/`MapLayer`, so bulk-edited markers broadcast too. The existing `group_id == -1` → `null` sentinel handling is untouched.

**5. Frontend — `useMapPresence.js`** gains one more callback, `onMarkerChanged`, added into the *existing* editor/non-editor either-or channel split (not a new branch):
```js
if (canEdit) {
    adminChannelName = interactive.channel + '.admin'
    const adminChannel = echo.private(adminChannelName)
    adminChannel.listen('.MapContentsChanged', (payload) => { onContentsChanged?.(payload) })
    adminChannel.listen('.MapMarkerChanged', (payload) => { onMarkerChanged?.(payload) })
} else {
    channel.listen('.MapContentsChanged', (payload) => { onContentsChanged?.(payload) })
    channel.listen('.MapMarkerChanged', (payload) => { onMarkerChanged?.(payload) })
}
```

**6. `MapExplorer.vue`** — a new handler, wired as `onMarkerChanged`, same upsert-or-remove shape as the original (reverted) group/layer handlers:
```js
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
No `->toOthers()` — the acting user's own broadcast re-applying an equivalent pin to their own already-updated local state is harmless (same reasoning as every other real-time feature on this branch).

## Testing

Backend: Pest feature tests for `MapMarker::isPubliclyVisible()` (own visibility All/Member → true, Admin/Self/AdminSelf → false; grouped marker with a restricted-visibility group → false even if the marker's own visibility is All; entity-linked marker with `is_private` entity → false; entity-linked marker with a public entity → true; ungrouped/unlinked marker → governed by its own visibility only). Tests for `App\Events\Maps\MarkerChanged` (channel/name per `includeRestricted`, payload null-on-delete, the public-variant action-downgrade-to-`deleted` when the marker isn't publicly visible, the admin variant always using the real action). Tests for `MapMarkerObserver` (dispatches both variants exactly once on create/update/delete; a visibility flip from `All` to `Admin` on update causes the public variant to carry `action: 'deleted'`; a flip from `Admin` to `All` causes it to carry the real action; a move via `MoveController`-style partial `update(['latitude' => ..., 'longitude' => ...])` dispatches like any other update, proving drag-move needs no special casing). A regression test proving `MapMarker::patch()` now dispatches (bulk edit fix).

Frontend: no automated test coverage exists for this app's Vue/Leaflet real-time features (established precedent). Manual verification: with two sessions (editor + player) viewing the same map — creating/moving/editing/deleting a public-visibility marker updates both live; creating an `Admin`-visibility marker updates only the editor's session; flipping an existing public marker to `Admin`-only visibility makes it disappear live from the player's session; flipping it back makes it reappear live; dragging a draggable marker to a new position updates both sessions live at the drop point (not mid-drag); a marker in a group whose visibility is `Admin`-only never appears in the player's session even if the marker's own visibility is `All`; bulk-editing several markers via the datagrid updates both sessions live in one shot.
