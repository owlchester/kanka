# Map Contents (Group/Layer) Change Broadcasting Design

## Goal

When a `MapGroup` or `MapLayer` is created, edited, or deleted — from any save path, including bulk edit — broadcast a fresh snapshot of the map's groups and layers over websockets, so everyone with the v4 map explorer open sees the group tree / layer list update live. Editors additionally get live sync of visibility-restricted (GM-only) groups/layers via a second, admin-only channel, without exposing that content to players' browsers at all.

## Supersedes

This design replaces the group/layer broadcasting mechanism from [[2026-07-08-map-group-layer-broadcast-design]] (the per-item `App\Events\Maps\GroupChanged`/`LayerChanged` events with `action` semantics, already implemented and shipped on this branch as of commit `c5a71cdb3`). That design worked and was fully reviewed, but three things argued for a different approach once implemented:

1. **Scale made the complexity not worth it.** Free campaigns cap at 2 groups/layers per map, premium at 10 — small enough that resending the whole list costs nothing meaningfully more than a per-item diff, while eliminating an entire class of bugs the per-item approach produced during implementation: `Eloquent::$wasRecentlyCreated` never resetting (mislabeled create-vs-update), a stale relation-cache read across a same-instance create-then-update, and the create-vs-update asymmetry needed for layer eligibility flips.
2. **Bulk edit was a real gap.** The per-item design's observers depended on real (non-quiet) Eloquent events firing; `MapGroup::patch()`/`MapLayer::patch()` (used by bulk edit) call `updateQuietly()`, which fires none — so bulk-edited groups/layers silently never broadcast. Fixing this within the old design meant reasoning carefully about `reorder()`'s cascade cost on every save; the new design fixes the underlying `reorder()` cost directly, which makes switching `patch()` to a real `update()` safe.
3. **The visibility gate had no path to let editors see their own restricted content live.** The old design simply never broadcast `Admin`/`Self`/`AdminSelf`-visibility items to anyone, including their own creator/GM, across their own multiple open tabs/sessions. A second, access-controlled channel closes that gap properly (server-enforced, not a client-side "hide it" trust boundary) rather than compromising the security model to get it.

The prior design's `App\Events\Maps\GroupChanged`/`LayerChanged` classes, their `MapGroupObserver`/`MapLayerObserver` wiring, and the corresponding frontend per-item upsert/delete-by-id handlers are removed as part of implementing this one. `MapLayer::isExplorable()` (extracted in that design's Task 1) is kept — it's still needed here, unrelated to the mechanism being replaced.

## Out of Scope

- No change to `App\Events\Maps\Updated` (map name/grid/zoom/config metadata) — already shipped, already reviewed, a different trigger condition, no reason to touch it. It stays on its own event, own channel subscription, own frontend handler.
- No per-recipient filtering of `Self`/`AdminSelf` items for non-editor campaign members (e.g., "let a regular member see the `Self`-visibility item they personally created, live"). The `VisibilityIDScope` global scope supports this nuance for page loads (it's per-viewer), but a broadcast payload is shared across every subscriber of a channel and can't replicate that without per-user channels — out of proportion to the value here. The public channel's payload is simply `visibility_id IN [All, Member]`; anything narrower (including a member's own `Self` items) only appears live via the admin channel (if the viewer is an editor) or on next reload.
- No change to how `is_shown` factors into rendering — unrelated to this feature, unchanged from today.

## Background

- Both `MapGroup` and `MapLayer` use `HasVisibility`, whose `VisibilityIDScope` global scope filters query results based on the *querying* user's permission. This scope is why a plain page load already hides GM-only groups from players — but a websocket broadcast is built once (within whichever request triggered the save) and delivered identically to every channel subscriber, so the scope's per-viewer nature doesn't carry over to broadcasting; the filtering has to happen explicitly when building the broadcast payload.
- `Map::groups(): HasMany` and `Map::layers(): HasMany` (`app/Models/Map.php:150,159`) are the relations already used by `ExploreApiService::load()` to build the initial explorer payload via `GroupResource`/`LayerResource` (`app/Http/Resources/Maps/Explore/{Group,Layer}Resource.php`) — reused here unchanged.
- `MapLayer::isExplorable()` (`app/Models/MapLayer.php`) — `typeName() === 'overlay_shown' && hasImage()` — determines whether a layer can render as a map overlay at all, independent of visibility. `ExploreApiService::load()` already filters its initial layer list by this.
- `App\Observers\MapGroupObserver`/`MapLayerObserver` are already registered for their models (`AppServiceProvider.php`). Both currently have a `saved()` that calls `reorder()` (a `ReorderTrait` method that re-numbers every sibling group/layer on the map, via `updateQuietly()` so it doesn't recursively fire events) unconditionally on every save, and a `deleted()` that does model-specific cleanup (image cleanup for layers) plus `$map->touchSilently()`.
- `App\Contracts\Broadcasting\ShouldRescue` (used throughout this branch's broadcasting work) wraps a `ShouldBroadcastNow` event's actual send attempt in Laravel's `rescue()` helper, so a broadcast failure (unreachable Reverb, bad credentials) never fails the triggering save request. Kept here for the same reason as the prior designs.
- `routes/channels.php` already has `Broadcast::channel('map.{id}', ...)` — a presence channel requiring campaign membership + entity view permission. This design adds a second, private (not presence) channel, `map.{id}.admin`, gated additionally on `can('update', $entity)` (the same check the existing presence channel closure already uses to compute each subscriber's `role: 'edit'|'view'`).
- `MapGroup::patch()`/`MapLayer::patch()` (`app/Models/{MapGroup,MapLayer}.php`) exist for the datagrid2 bulk-edit UI (`Maps/Bulks/{Group,Layer}Controller` → `BulkControllerTrait::bulkProcess()` → `$model->patch($data)`) and currently call `updateQuietly()`, matching the same convention used by every other model with a `patch()` method (`MapMarker`, `OrganisationMember`, `Reminder`) — a deliberate, codebase-wide choice to keep bulk operations from firing per-row side effects. This design's `reorder()` fix (only run on create, or on update when `position` itself changed) removes the main cost that made switching `patch()` to a real `update()` risky, so only `MapGroup::patch()`/`MapLayer::patch()` switch — the other three models' `patch()` methods are untouched, since they have no relationship to map-contents broadcasting.

## Architecture

**1. `MapGroupObserver`/`MapLayerObserver` — simplified triggers:**
```php
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

public function saved(MapGroup $mapGroup)
{
    $mapGroup->map->touchSilently();
}

protected function broadcastContents(Map $map): void
{
    ContentsChanged::dispatch($map);
    ContentsChanged::dispatch($map, includeRestricted: true);
}
```
`MapLayerObserver` is the same shape, keeping its existing `Images::model($mapLayer)->cleanup()` call in `deleted()`. Neither observer does any visibility or eligibility filtering itself anymore — that moved entirely into the event's own `broadcastWith()`, since it now queries fresh state rather than reasoning about the specific instance that triggered the save. `created()` always reorders (a new item needs positioning among siblings); `updated()` only reorders when `position` itself changed — the fix that also makes switching `patch()` to a real `update()` cheap for bulk edits.

**2. Single event, `App\Events\Maps\ContentsChanged`** (`ShouldBroadcastNow`, `ShouldRescue`):
```php
public function __construct(
    public Map $map,
    public bool $includeRestricted = false,
) {
    $this->broadcastVia('reverb');
}

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

    if (! $this->includeRestricted) {
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
```
The `isExplorable()` filter always applies to layers regardless of `$includeRestricted` — it's about whether the layer can render as a tile overlay at all, not about who's allowed to see it. Same `broadcastAs()` name on both channels; the channel itself (public vs. admin) is what scopes delivery, so the frontend can use one listener shape for both.

**3. `routes/channels.php`** — new entry:
```php
Broadcast::channel('map.{id}.admin', function (User $user, $id) {
    $map = Map::withInvisible()->findOrFail($id);
    $entity = $map->entity()->withInvisible()->firstOrFail();

    EntityPermission::campaign($entity->campaign);

    return $user->can('member', $entity->campaign) && $user->can('update', $entity);
});
```
A private (not presence) channel — no "who's watching" tracking needed here, purely access-gated delivery. Returning a boolean (not an array) is what makes Echo/Reverb treat it as private rather than presence.

**4. `MapGroup::patch()`/`MapLayer::patch()`** — change `updateQuietly($data)` to `update($data)`, so bulk edits now fire the observer like any other save path. No other model's `patch()` changes.

**5. Frontend — `useMapPresence.js`** gains a `canEdit` boolean parameter (from `MapExplorer.vue`'s existing `canEdit` prop). After the existing presence-channel join:
- If `canEdit` is true: additionally `echo.private(interactive.channel + '.admin')`, and listen for `.MapContentsChanged` *there*, invoking the (single) `onContentsChanged` callback with `{ groups, layers }`.
- If `canEdit` is false: listen for `.MapContentsChanged` on the existing public presence channel instead, same callback.
Only one of the two is ever registered per session — an editor doesn't also listen on the public channel for this event, avoiding a last-write-wins race between the filtered and full payloads (Reverb gives no cross-channel ordering guarantee). Both cases clean up their respective channel on unmount, mirroring the existing presence-channel `echo.leave(...)` pattern.

**6. `MapExplorer.vue`** — a single handler, wired as `onContentsChanged`:
```js
function handleContentsChanged({ groups, layers }) {
    data.value.groups = groups;
    data.value.layers = layers;
}
```
No per-item id tracking, no upsert/delete branching — a full, authoritative replace each time, exactly mirroring what a page reload would show (for whichever channel the viewer is on).

## Testing

Backend: Pest feature tests on `App\Events\Maps\ContentsChanged` (channel/name per `includeRestricted` value, payload shape and visibility/eligibility filtering for both the public and admin variants — a restricted-visibility group appears in the admin payload but not the public one; a non-explorable layer appears in neither) and on `MapGroupObserver`/`MapLayerObserver` (creating/updating/deleting a group or layer dispatches both `ContentsChanged` variants exactly once each; `reorder()` is NOT called on a non-position update; `reorder()` IS called on create and on a position-changing update). A regression test confirming `MapGroup::patch()`/`MapLayer::patch()` now fires the observer (dispatches `ContentsChanged`) where before it silently didn't.

Frontend: no automated test coverage exists for this app's Vue/Leaflet real-time features (established precedent). Manual verification: with two authenticated sessions (one editor, one player) viewing the same map — creating/editing/deleting a visible group or layer updates both sessions live; creating/editing/deleting a GM-only (`Admin`-visibility) group or layer updates only the editor's session live, with no visible change or console error on the player's session; a bulk-edit of several groups/layers via the datagrid updates both sessions live in one shot; dragging to reorder does *not* trigger a live update (still out of scope, unchanged from the prior design).
