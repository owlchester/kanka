# Draggable Map Markers for v4 Explorer Design

## Goal

Port legacy's draggable-marker feature to the v4 (Vue/Leaflet) map explorer: a marker with `is_draggable` set can be dragged to a new position by a map editor, persisting the new coordinates to the backend on drop.

## Out of Scope

- No changes to `App\Http\Controllers\Maps\Markers\MoveController` or the `maps.markers.move` route — both already do exactly what's needed (authorize via the map entity's update permission, accept `latitude`/`longitude`, persist, return `{success, marker_id}`).
- No changes to how `is_draggable` is set (the existing pin-shape-only checkbox in the legacy marker edit form, `resources/views/maps/markers/_form.blade.php`) — this only ports the *rendering/interaction* side to v4.
- No dragging for `label`, `poly` (polygon), or `path` shapes — matches legacy exactly, where only plain `marker` (pin) and `circle` shapes ever implement dragging, regardless of the `is_draggable` flag's value on other shapes.
- No circle-radius resizing via drag — only position (`latitude`/`longitude`) changes; radius editing is unrelated existing draft-shape tooling, untouched here.
- **Deviation from legacy, decided during brainstorming:** legacy lets any authenticated viewer attempt to drag an `is_draggable` pin while exploring (only the backend enforces edit permission, so a non-editor's drag visually moves the pin then silently fails to persist). v4 instead gates dragging to editors only at the frontend level (`canEdit`), avoiding that confusing dead-end interaction.

## Background

`App\Models\MapMarker::is_draggable` (`database/migrations/2020_06_06_084917_create_maps_table.php:104`, boolean, default false) is a per-marker flag set via a checkbox that only appears in the legacy marker edit form's "pin" shape tab. Legacy's `MapMarker::marker()`/`circleMarker()` (`app/Models/MapMarker.php:300-371`) set `draggable: true` on the Leaflet marker options and bind `dragstart`/`dragend` handlers only for those two shapes; `dragend` fires an immediate AJAX POST to `maps.markers.move` with the new `latitude`/`longitude` (`.toFixed(3)`), no separate save step. `polygon()` has dragging explicitly commented out; `path()`/`labelMarker()` never wire it up at all.

The backend endpoint (`App\Http\Controllers\Maps\Markers\MoveController::index`, route `POST /w/{campaign}/maps/{map}/{map_marker}/move` named `maps.markers.move`) already authorizes via `$this->authorize('update', $map->entity)`, reads `$request->only('latitude', 'longitude')`, calls `$mapMarker->update(...)`, and returns `{success: true, marker_id: $mapMarker->id}` — this is reused as-is.

v4 has no equivalent today: `App\Http\Resources\Maps\Explore\PinResource` doesn't expose `is_draggable`, and `resources/js/components/maps/LeafletCanvas.vue`'s `buildPin()` sets no `draggable` option and binds no drag-to-move handlers on any rendered shape (the file's only `dragend`-adjacent handlers are `editable:vertex:dragend`/`editable:dragend`, which belong to the unrelated Leaflet.Editable draft-shape-drawing tooling). `PinResource::toArray()`'s existing `'shape' => $marker->shape_id?->name ?? 'marker'` (confirmed against `App\Enums\MapMarkerShape`: `marker=1, label=2, circle=3, poly=5, path=6`) already produces the exact string values (`'marker'`, `'circle'`) `LeafletCanvas.vue`'s `buildPin()` needs to match against for shape-scoping.

## Architecture

**1. `PinResource` gains two fields** — `'is_draggable' => (bool) $marker->is_draggable` and `'move_url' => route('maps.markers.move', [$this->campaign->id, $marker->map_id, $marker->id])`, built from data the resource already has access to (`$this->campaign`, already used for other route-building fields on this same resource; `$marker->map_id`, a plain column).

**2. `LeafletCanvas.vue` gains a `canEdit` prop** (currently absent from this component — `MapExplorer.vue` already has `canEdit` for `Toolbar`/`SettingsPanel` and just passes the same value down one more level). In `buildPin()`, for the `marker` (default) and `circle` shape branches only, the built Leaflet object's options gain `draggable: props.canEdit && pin.is_draggable`, and (only when that's true) a `dragend` listener:
- Reads the marker's new position via `e.target.getLatLng()`.
- POSTs `{latitude, longitude}` to `pin.move_url` via axios.
- On success: emits a new `pin-moved` event, `{id: pin.id, latitude, longitude}`.
- On failure: calls `e.target.setLatLng([pin.latitude, pin.longitude])` to snap the marker back to its pre-drag position (the `pin` object's original, not-yet-updated coordinates), so a failed save doesn't leave the UI showing a position that was never actually persisted.

**3. `MapExplorer.vue`** passes `:can-edit="canEdit"` to `<LeafletCanvas>` and adds `@pin-moved="handlePinMoved"`, where `handlePinMoved({id, latitude, longitude})` updates the matching entry in `data.value.pins` (replacing that one pin's `latitude`/`longitude`, leaving everything else in the array untouched). This keeps the reactive `pins` array in sync with the persisted position, so a later full-pins rebuild (triggered by `LeafletCanvas.vue`'s existing `watch(() => props.pins, ...)` — e.g. after a different marker is created elsewhere) doesn't revert the dragged marker to a stale position.

## Testing

Backend: a Pest test on the existing `entities.map-api` endpoint confirming a pin's `is_draggable` and `move_url` fields are present and correct in `PinResource`'s output (both when the flag is true and false), and that `move_url` resolves to the exact same URL the existing `maps.markers.move` route produces for that marker.

Frontend: no automated test coverage exists for Leaflet canvas interactions in this app (matching the established pattern for every other v4 map explorer change on this branch) — verification is manual/live: drag an `is_draggable` pin/circle as an editor, confirm the position persists (reload the page, confirm it stuck); confirm a non-`is_draggable` marker, or any `label`/`poly`/`path` marker, cannot be dragged regardless of the flag; confirm a non-editor (viewer) cannot drag any marker at all; confirm a failed move (e.g. simulate a network error) snaps the marker back to its original position rather than leaving it in an unpersisted spot.
