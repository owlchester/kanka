# Map Explorer: Legend Search, Pin Detail Actions, Map Header (v1.1)

**Date:** 2026-07-03
**Branch:** `feature/map4`

Builds on `docs/superpowers/specs/2026-07-03-entity-map-vue-explorer-design.md` (the base v1 map explorer: `MapExplorer.vue` / `LeafletCanvas.vue` / `LegendPanel.vue` / `DetailPanel.vue`, fed by `entities/{entity}/map-api`). This spec covers the next round of interactions on top of that base, found/requested during live browser testing of the first pass.

## Goal

- Legend: a search box that filters pins by name, showing only the groups/subgroups needed to reach a match; the "Uncategorised" bucket is always expanded (no collapse toggle).
- Detail panel: the pin's name links to its entity when linked; shows the marker's own entry and/or the linked entity's entry (mirroring the legacy marker preview panel), the entity's header image, its group name (or "Uncategorised"), and its type (Marker/Label/Circle/Polygon); a bottom actions row (Center always, Edit/Duplicate/Delete gated by permission) with two-click delete confirmation.
- Main view: map name + visible pin count next to the legend toggle button; Leaflet's zoom control moves to bottom-left so it doesn't collide with that toggle button.

## Backend: marker preview + delete endpoints

Two new routes under the existing `App\Http\Controllers\Entity\Maps` namespace — session-authed (cookie + CSRF), matching everything else built for this page. Explicitly **not** reusing `api.v1`'s `MapMarkerApiController`, which requires a Passport OAuth bearer token our browser session doesn't have.

```php
Route::get('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [MarkerController::class, 'preview'])->name('entities.map-markers.preview');
Route::delete('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [MarkerController::class, 'destroy'])->name('entities.map-markers.destroy');
```

`App\Http\Controllers\Entity\Maps\MarkerController` (new):
- Both actions: `authEntityView($entity)`, then `abort(404)` if `! $entity->isMap()`, then `abort(404)` if `$mapMarker->map_id !== $entity->child->id` (cross-map tamper guard, mirrors legacy `Maps\MarkerController::destroy`).
- `preview()`: returns `new PinPreviewResource($mapMarker)` as JSON.
- `destroy()`: authorizes `$user->can('update', $entity)` (the map's own entity — this is exactly `MapMarkerPolicy::update`/`::delete`'s check, since both just delegate to `$mapMarker->map->entity`), then `$mapMarker->delete()`, returns `response()->json(null, 204)`.

### `PinPreviewResource` (new, `App\Http\Resources\Maps\Explore\PinPreviewResource`)

```json
{
  "id": 100,
  "name": "Waterdeep",
  "entity_url": "https://.../w/1/entities/42",
  "entity_image": "https://.../avatar-400x200.jpg",
  "marker_entry": "<p>Custom marker note...</p>",
  "entity_entry": "<p>The entity's own description...</p>",
  "type": "Marker",
  "group_name": "Towns",
  "can_edit": true
}
```

- `entity_url`: `$marker->entity->url()`, null if no linked entity.
- `entity_image`: `Avatar::entity($marker->entity)->size(400, 200)->thumbnail()` if `$marker->entity->hasImage()`, else null. Mirrors `resources/views/maps/markers/details.blade.php`'s header image.
- `marker_entry`: `Mentions::mapAny($marker)` if `$marker->hasEntry()`, else null.
- `entity_entry`: `$marker->entity->parsedEntry()` if `$marker->entity && $marker->entity->hasEntry()`, else null.
- `type`: `$marker->typeLabel()` — reuses the existing method (already returns translated "Marker"/"Label"/"Circle"/"Polygon").
- `group_name`: `$marker->group->name` if `$marker->group`, else null (frontend renders "Uncategorised").
- `can_edit`: `$user && $user->can('update', $marker->map->entity)` — one flag gates Edit, Duplicate, and Delete, since `MapMarkerPolicy` makes all three the same check in practice.

## Frontend: `DetailPanel.vue`

Fetches `entities.map-markers.preview` via axios as soon as a pin is selected (own local `loading`/`preview` state, independent of `MapExplorer`'s page-level loading state). Layout, top to bottom:

1. **Header**: `entity_image` as a cover-background banner if present (plain header otherwise), with the pin's name overlaid — linked (`<a :href="entity_url">`) if `entity_url` is set, plain text otherwise. Name renders immediately from the `pin` prop (no need to wait on the fetch); the rest of the panel waits for `preview` to load.
2. **Subtitle**: `{{ preview.type }} - {{ preview.group_name || 'Uncategorised' }}`.
3. **Body**: `marker_entry` (if present, `v-html`), then — only if `marker_entry` was also present — a "From entry" label, followed by `entity_entry` (if present, `v-html`); if there's no `marker_entry`, `entity_entry` renders alone with no label. Exactly mirrors the legacy panel's nesting.
4. **Actions** (flex column at the bottom):
   - If `can_edit`: **Edit details** (`btn2 btn-primary btn-block`, full width) — `<a target="_blank">` to `maps.map_markers.edit` (new tab, so the legacy form's save-redirect back to the old explore page doesn't disrupt this session).
   - Next row: **Center** (`btn2 btn-default`, always visible, no permission gate) + if `can_edit`: **Duplicate** (`btn2`, no-op click handler for now).
   - If `can_edit`: **Delete marker** (`btn2 btn-danger`), two-click confirm as local component state (`confirming` ref): first click flips text to a confirm label; second click calls `axios.delete(entities.map-markers.destroy route)`; on the resulting 204, emits `deleted` (parent closes the panel and removes the pin from `data.pins`, so it disappears from both the map and the legend without a refetch).

**Center**: clicking emits `center`. `MapExplorer` holds `centerNonce = ref(0)`; the handler increments it and passes both `:center-pin="selectedPin"` and `:center-nonce="centerNonce"` down to `LeafletCanvas`. `LeafletCanvas` watches `centerNonce` (not `centerPin` — a plain reference-equality watch wouldn't fire on a second click on the same already-selected pin) and, whenever it changes, calls `leafletMap.setView([centerPin.latitude, centerPin.longitude])`. This is necessary because clicking Center twice in a row on the same pin must still re-trigger centering after the user has panned away.

No existing "parent calls an exposed child method via template ref" convention exists in this codebase (`Whiteboard.vue` and siblings use props-down/events-up exclusively) — this design follows that same convention rather than introducing `defineExpose`.

## Frontend: `LegendPanel.vue` search + uncategorised

- New `<input placeholder="Search markers">` above the group list, bound to a local `query` ref.
- A `computed` filters `props.pins` by case-insensitive substring match on `pin.name` before passing to `buildGroupTree` — so the tree structure (all groups, correctly nested) is always built from `props.groups`, but only matching pins populate any group's `.pins`/`.uncategorised`.
- `LegendGroupNode` gains a `hasMatches` check (a group renders if it has any own pins after filtering, or any descendant group does, recursively) and skips rendering entirely when search is active and it has none.
- While `query` is non-empty, groups with matches are force-expanded (a computed override, not a change to the manually-toggled `openIds` state) — so results are visible without the user also having to expand every matching group. Clearing the search reverts to whatever was manually toggled before.
- "Uncategorised" section loses its collapse toggle: always rendered (no chevron button, no `isOpen('uncategorised')` gate) when non-empty, same visibility condition as today (`tree.uncategorised.length`), just without the ability to collapse it.

## Frontend: `MapExplorer.vue` header + `LeafletCanvas.vue` zoom control

- Next to the existing legend toggle button: an `<h1>` with `data.map.name`, and beneath it `{{ data.pins.length }} markers` (count of pins visible to the current user — already server-filtered by `ExploreApiService`, no extra work needed).
- `LeafletCanvas`: `L.map(..., { zoomControl: false, ... })`, then `L.control.zoom({ position: 'bottomleft' }).addTo(leafletMap)` in `onMounted`. Nothing in this codebase repositions the zoom control today, so this doesn't conflict with an existing convention.

## Testing

- Pest feature tests for `entities.map-markers.preview` (200 + correct JSON shape/values for a marker with/without an entity, with/without its own entry, with/without a group) and `entities.map-markers.destroy` (204 + row actually gone; 403 for a user without update permission on the map's entity; 404 for a marker belonging to a different map).
- No JS/Vue automated tests (same constraint as the base spec) — legend search, detail panel actions, centering, and zoom control position are verified manually in-browser.
