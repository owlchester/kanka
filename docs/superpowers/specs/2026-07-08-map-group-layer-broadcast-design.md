# Map Group/Layer Change Broadcasting Design

## Goal

When a `MapGroup` or `MapLayer` is created, edited, or deleted — from any save path (legacy Blade CRUD, the REST API, or bulk edit/delete) — broadcast that change over the same `map.{id}` presence channel used by [[2026-07-08-map-metadata-broadcast-design]], so everyone with the v4 map explorer open sees the group/layer tree and layer list update live, without reloading. The v4 explorer currently has no UI of its own for creating/editing/deleting groups or layers — it only *displays* them (via `LegendPanel.vue` for groups, `LeafletCanvas.vue` for layer tiles) — so this is purely about syncing external changes into that read-only view.

## Out of Scope

- No new Vue UI for creating/editing/deleting groups or layers in the v4 explorer — group/layer management stays on the legacy Blade pages and the REST API; this only makes their effects visible live to anyone with the explorer open.
- Drag-and-drop reordering does not broadcast (confirmed with user). Both `Reorders\GroupController`/`Reorders\LayerController` and `ReorderTrait`'s sibling-cascade already call `updateQuietly()`, which suppresses Eloquent model events entirely — reordering was already invisible to observers before this feature, and stays that way. A viewer won't see reordered position live; they will on next reload, exactly as today.
- Cascading deletes are not individually broadcast. If deleting a parent `MapGroup` removes child groups via a DB-level cascade (foreign key) rather than each child's own `->delete()` call, those children's observers never fire and no broadcast is sent for them — only the directly-deleted record produces an event. Same "direct actions only" boundary as the reorder exclusion above.
- No `->toOthers()` exclusion, matching [[2026-07-08-map-metadata-broadcast-design]] — none of the mutation paths here run inside the v4 explorer's own Echo connection anyway (they're all legacy Blade pages or API calls), so there's no self-echo case to even consider.

## Background

- `MapGroup` and `MapLayer` both use the `HasVisibility` trait, which adds a global Eloquent scope (`VisibilityIDScope`) filtering query results by the *currently authenticated user's* permission relative to each record's `visibility_id` (`All`, `Member`, `Admin`, `Self`, `AdminSelf`). This is how the initial explorer page load already hides e.g. a GM-only group from players (`app/Services/Maps/ExploreApiService.php:40`: `GroupResource::collection($this->map->groups)` — the `groups` relation query is scoped per the loading user).
- A websocket broadcast has no per-subscriber payload — Reverb/Pusher sends one payload to every subscriber of `PresenceChannel("map.{id}")`. The channel's own join authorization (`routes/channels.php`) only requires "is a campaign member AND can view this map entity" — which is *broader* than what `Admin`/`Self`/`AdminSelf`-visibility records allow. Broadcasting those indiscriminately would leak their name/existence to viewers who are correctly denied them on page load. `All` and `Member` visibility are safe to broadcast unfiltered, since everyone subscribed to the channel already passed the "campaign member" check the join itself requires.
- The explorer additionally filters *which* layers even appear at all: `ExploreApiService::load()` (line 37) only includes layers where `$layer->typeName() === 'overlay_shown' && $layer->hasImage()` — base layers, unshown overlays, and imageless layers never appear in the v4 explorer regardless of visibility. An edit can flip a layer across this line (e.g. removing its image, or changing its type), so "was this layer explorer-eligible" has to be re-checked on every save, not just at creation.
- Both `MapGroupObserver` and `MapLayerObserver` already exist and are registered (`AppServiceProvider.php:219-220`) with `saving()` (auto-position), `saved()` (reorder cascade + `$map->touchSilently()`), and `deleted()` (cleanup + `$map->touchSilently()`) hooks. `saved()` fires after both creation and update; `$model->wasRecentlyCreated` distinguishes which. This mirrors exactly how [[2026-07-08-map-metadata-broadcast-design]] used `MapObserver` as the single trigger point regardless of caller — the same reasoning applies here, and no new observer registration is needed.
- `App\Events\Maps\Updated` (from the prior design) is the direct template: `ShouldBroadcastNow` + `ShouldRescue`, `PresenceChannel('map.' . $map->id)`, explicit `broadcastVia('reverb')`. The precedent for a single event class covering multiple actions (rather than one class per action) is `App\Events\Whiteboards\Updated`, which already carries an `action` string alongside its payload.
- `App\Http\Resources\Maps\Explore\GroupResource` (`id`, `name`, `parent_id`, `position`, `colour`) and `LayerResource` (`id`, `name`, `type_id`, `image`, `position`) are the exact shapes already sent in the initial explorer payload — reusing them keeps the broadcast payload identical to what a fresh page load would show.
- `LegendPanel.vue` builds its group tree reactively from the flat `props.groups` array (no separate tree state to invalidate) — a plain mutation of the underlying `data.groups` array is sufficient for it to re-render correctly.

## Architecture

**1. `MapLayer::isExplorable(): bool`** (new method, `app/Models/MapLayer.php`) — extracts the existing inline filter from `ExploreApiService::load()`:
```php
public function isExplorable(): bool
{
    return $this->typeName() === 'overlay_shown' && $this->hasImage();
}
```
`ExploreApiService::load()`'s filter closure (line 37) is updated to `fn ($layer) => $layer->isExplorable()` — a targeted dedup, not a behavior change.

**2. Two new events**, both following `App\Events\Maps\Updated`'s exact shape (`ShouldBroadcastNow`, `ShouldRescue`, `InteractsWithBroadcasting`/`InteractsWithSockets`, `broadcastVia('reverb')` in the constructor, `PresenceChannel('map.' . $map->id)`):

- `App\Events\Maps\GroupChanged`:
  ```php
  public function __construct(
      public MapGroup $group,
      public string $action, // 'created' | 'updated' | 'deleted'
  ) {
      $this->broadcastVia('reverb');
  }

  public function broadcastOn(): array
  {
      return [new PresenceChannel('map.' . $this->group->map_id)];
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
  ```
- `App\Events\Maps\LayerChanged` — identical shape, substituting `MapLayer`/`LayerResource`/`'MapLayerChanged'`/`layer` for the group equivalents.

**3. `MapGroupObserver`** — add the visibility gate and dispatch inside the existing `saved()`/`deleted()` methods (no new lifecycle methods):
```php
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
```

**4. `MapLayerObserver`** — same pattern, plus the eligibility re-check on save (not on delete — a deleted layer is unconditionally a removal regardless of its last-known eligibility):
```php
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
```
A layer that was never explorable and is edited while still not explorable correctly still dispatches `'deleted'` every save — harmless, since the frontend's delete-handling is an idempotent filter-by-id (removing an id that was never present is a no-op).

**5. Frontend — `useMapPresence.js`** — the third parameter (currently a single `onMapUpdated` callback, added by the prior design) becomes an options object to avoid a growing positional-parameter list:
```js
export function useMapPresence(getInteractive, getI18n, { onMapUpdated, onGroupChanged, onLayerChanged } = {}) {
```
Two more listeners are added alongside the existing `.MapUpdated` one:
```js
channel.listen('.MapGroupChanged', (payload) => {
    onGroupChanged?.(payload)
})

channel.listen('.MapLayerChanged', (payload) => {
    onLayerChanged?.(payload)
})
```

**6. `MapExplorer.vue`** — updates its `useMapPresence(...)` call to pass the object form, and adds two handlers following the same upsert-or-remove shape:
```js
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

## Testing

Backend: Pest feature tests on `MapGroupObserver`/`MapLayerObserver` (mirroring the structure of [[2026-07-08-map-metadata-broadcast-design]]'s `MapObserver` tests):
- Creating a group/layer with `visibility_id` of `All` or `Member` dispatches `GroupChanged`/`LayerChanged` with `action: 'created'` and a non-null resource matching the record.
- Updating one dispatches `action: 'updated'`.
- Deleting one dispatches `action: 'deleted'` with a null resource and the correct `id`.
- A group/layer with `visibility_id` of `Admin`, `Self`, or `AdminSelf` never dispatches, on create, update, or delete.
- A layer created as `overlay_shown` with an image dispatches `'created'`; a layer created as `standard` type, or `overlay_shown` with no image, does not dispatch at all on create.
- Updating a layer to remove its image (or change its type away from `overlay_shown`) while it was previously explorable dispatches `action: 'deleted'`. Updating a layer *into* eligibility (adding an image, or changing type to `overlay_shown`) dispatches `action: 'updated'` (or `'created'` if this is also its first save) with the resource.
- Regression coverage that the existing `saving()` position-assignment and `reorder()`/`touchSilently()` behavior in both observers is unchanged.

Frontend: no automated test coverage exists for this app's Vue/Leaflet real-time features (established precedent). Manual verification: with two authenticated sessions viewing the same map, creating/editing/deleting a group or layer via the legacy Blade pages (or the REST API) in one session should update the other session's legend tree / layer list live; a GM-only (`Admin`-visibility) group's changes should produce no visible update for a player session; editing an existing "base" layer's type to `overlay_shown` and attaching an image should make it appear live; removing that image should make it disappear live.
