# Path Drawing in MapExplorer v4 (and Legacy Rendering/Editing)

## Goal

Wire up the Toolbar's existing but unwired "path" mode in the new map explorer (`resources/js/components/maps/MapExplorer.vue`), letting users draw an open, multi-point connected line, style its colour/stroke-width/opacity, and see it persist and re-render correctly on reload. Unlike polygon and circle (which already existed on the legacy map page before this branch touched them), paths are a brand-new shape that has never rendered correctly on the legacy page — this plan also fixes that, and adds path *editing* (not creation) to the legacy marker edit form.

## Out of scope

- Adding a path creation entry point to the legacy map page's create form. Paths can only be created via the new v4 explorer.
- A discrete size/width picker beyond the existing Stroke Width picker (thin/normal/bold/custom) already built for polygons — reused as-is.
- A separate "border colour" field — a path has only one colour (the line itself), unlike a polygon's fill+border.
- Any change to `app/Models/MapMarker.php`'s `circleRadius()`/polygon-specific rendering, or to `custom_shape`'s wire format (space-separated `"lat,lng lat,lng ..."` pairs) — already fully shape-agnostic and reused unchanged.
- Escape-to-reset / Ctrl+Z for path drawing — out of scope for this pass; can be added later by generalizing the existing polygon keydown handler if wanted, but not part of this plan.

## Background: what already exists

- `App\Enums\MapMarkerShape::path` = 6 already exists.
- `App\Models\MapMarker::isPath()` already exists (`$this->shape_id === MapMarkerShape::path`) and is already wired into `typeLabel()` and `exploreIcon()` (returns `type: none` for paths, matching polygon/circle/label).
- `MapMarker::marker()` (the method that generates the legacy Leaflet JS string embedded inline via Blade on every legacy page) has **no `isPath()` branch** — a path-shaped marker currently falls through to the generic `L.marker(...)` pin branch. This is the actual bug: paths are invisible/wrong on the legacy map today. Every legacy page (`explore.blade.php`, `_preview.blade.php`, `form/_markers.blade.php`, `markers/create.blade.php`, `markers/edit.blade.php`) just echoes `$marker->marker()`'s returned JS string inline — so adding one branch to `marker()` fixes rendering everywhere with no other plumbing changes.
- `custom_shape`, `PinResource`, and `StoreMapMarker`'s validation are already fully shape-agnostic (no polygon-specific logic baked in) — a path reuses all three completely unchanged.
- Leaflet.Editable (already a dependency) has a real, distinct `startPolyline()` method (not an alias for `startPolygon()`). `PolylineEditor` inherits `CLOSED: false, MIN_VERTEX: 2` from the base `PathEditor` (vs. `PolygonEditor`'s explicit `CLOSED: true, MIN_VERTEX: 3`). This means "click the first vertex to close" — polygon's finish gesture — does not apply to a polyline; finishing happens via double-click or clicking the last placed vertex again, both native gestures requiring no custom code. Both editors fire the same `editable:vertex:new`/`editable:vertex:dragend`/`editable:drawing:commit` events already used for polygon drawing.
- `resources/js/components/maps/Toolbar.vue` already has a "path" mode button (icon `fa-regular fa-route`) and `lang/en/maps/explorer.php` already has its helper text ("Click to add points along the path") — both unwired, same state circle was in before that plan.
- The legacy marker create/edit forms share one partial (`resources/views/maps/markers/_form.blade.php`) with tabs for pin/label/circle/poly. There is no path tab. The partial already distinguishes create vs. edit via `isset($model)` (`create.blade.php` passes `'model' => null`; `edit.blade.php` passes the real model).

## Data model

No new columns, no changes to `custom_shape`'s format, `PinResource`, or `StoreMapMarker`. A path marker is just `shape_id = MapMarkerShape::path` (6) with `custom_shape` (vertex string) and `polygon_style['stroke-width']` populated (the existing `polygon_style.stroke` key is left unused for paths — the line's colour comes from the marker's plain `colour` field, matching the "one colour" decision below).

Draft pin shape while drawing (v4):

```js
{
  name: "",
  colour: defaultColour(),        // the line's colour (not a "fill")
  shape: "path",
  shapeId: 6,
  icon: { type: "fa", value: "fa-solid fa-map-pin" },
  iconId: 1,
  customIcon: null,
  customShape: vertices,          // same [[lat,lng], ...] shape as polygon drafts
  polygonStyle: { "stroke-width": DEFAULT_STROKE_WIDTH },  // no `stroke` key needed
  groupId: null,
  entityId: null,
  entityName: null,
  visibilityId: <default>,
  opacity: <default>,
  latitude: <centroid lat>,
  longitude: <centroid lng>,
}
```

## Flow (v4 explorer)

1. User clicks the "path" toolbar button → `activeMode = 'path'`.
2. Click to place each point; Leaflet.Editable's native polyline gesture live-updates the line as points are added, matching the existing helper text.
3. Double-click, or click the last placed vertex again, finishes the line (native `editable:drawing:commit`, same event polygon drawing already uses — verify this is the correct finish event for `PolylineEditor` too, not `editable:drawing:end`, per the lesson learned from polygon's Task 4 bug).
4. On finish, `MapExplorer.vue` builds a `draftPin` (shape `path`) and opens `MarkerPanel.vue`, same as the existing draft flow.
5. The path's vertices stay draggable while the panel is open (commit doesn't disable editing), matching polygon's live-edit behavior.
6. `MarkerPanel.vue` shows Colour (as the line colour), Stroke Width (reused component), Opacity, Group, Linked Entity, Visibility — no border-colour field.
7. Save persists `custom_shape` (serialized the same way as polygon) and `polygon_style['stroke-width']`.

## Frontend changes (v4)

- **`LeafletCanvas.vue`**
  - `buildPin()`: add a `path` branch rendering `L.polyline(latlngs, { color, weight, opacity })` — reading `pin.custom_shape`/`pin.customShape` the same way polygon's branch does. Verify `L.Polyline.getLatLngs()` returns a flat array of points (not nested rings like `L.Polygon.getLatLngs()` does) before reusing any shared vertex-extraction helper — this is a real, easy-to-miss difference between the two Leaflet classes.
  - Add a parallel path draft lifecycle (`startPathDraft()`/`stopPathDraft()`), mirroring the polygon lifecycle but calling `editTools.startPolyline()`, with its own state (`draftPath`, `pathEditing`) and its own `watch(() => [props.activeMode, props.draftPin], ...)` block, keyed on `'path'` — added as new code, not merged into the existing polygon/circle watchers.
  - New emits: `path-change`, `path-finish`.
  - No doubleClickZoom handling needed to add here *if* finishing is confirmed to work via "click the last vertex again" as the primary gesture — but double-click is also a valid finish gesture per Leaflet.Editable's generic drawing-click handling, so this needs the same doubleClickZoom suppression treatment polygon got, scoped to path mode.

- **`MapExplorer.vue`**
  - `handlePathFinish(vertices)` / `handlePathChange(vertices)`, mirroring `handlePolygonFinish`/`handlePolygonChange` — including the icon/iconId/customIcon defaults (learned the hard way twice now on this branch).
  - Wire the two new `LeafletCanvas` events in the template.

- **`MarkerPanel.vue`**
  - Show the existing `StrokeWidthPicker` for `pin.shape === 'path'` too (currently gated to `'poly'` only) — no new component.
  - Do **not** show the border-colour `ColourPicker` for path (stays poly-only).
  - `save()` payload: reuse the same `custom_shape`/`polygon_style` construction already used for polygon, gated on `pin.shape === 'poly' || pin.shape === 'path'` rather than `'poly'` alone, since the wire format is identical.

## Backend changes

- **`app/Models/MapMarker.php`**: add an `isPath()` branch to `marker()`, following the same `custom_shape` parsing already used in the `isPolygon()` branch, returning:
  ```php
  'L.polyline([' . implode(', ', $coords) . '], {
      color: \'' . e($this->colour) . '\',
      weight: ' . max(1, Arr::get($this->polygon_style, 'stroke-width', 1)) . ',
      opacity: ' . $this->floatOpacity() . ',
  })' . $this->popup();
  ```
  (No `fillColor`/`fillOpacity` — a polyline has no fill.)

## Legacy edit form

- **`resources/views/maps/markers/_form.blade.php`**: add a `#marker-path` tab, rendered only when `isset($model) && $model->isPath()` — never present on create, never reachable by switching from another shape's tab. Reuses the poly tab's colour + `polygon_style[stroke-width]` fields (no fill-colour field), plus the same live-editable Leaflet.Editable preview.
- **`resources/js/location/map-v3.js`**: extend the existing `isPolygon()`-gated `markerUpdateHandler`/`updatePolygon()` logic to also handle `isPath()` (`shapeField.value === '6'`), since the vertex-string serialization is identical between the two shapes — this is a small conditional broadening, not new logic.
- **`resources/views/maps/markers/edit.blade.php`**: extend the existing `window.polygon = marker{id}; window.polygon.enableEdit(); ...` block (currently gated to editing a poly marker) to also cover editing a path marker, using `startPolyline`'s equivalent live-editing setup (`enableEdit()` on the already-rendered `L.polyline` instance, same drag-vertex event wiring). No `startNewPolygon()`-equivalent "start fresh" button is added for paths, matching the "no create" constraint.

## Testing

- Pest feature test on `MarkerController::store` with a path payload (`shape_id: 6`, `custom_shape`, `polygon_style: {'stroke-width': N}`) — mirrors the existing polygon test, asserting the round-trip through `PinResource`.
- A small PHP-level assertion (or extend the existing model test conventions) that `MapMarker::marker()` returns an `L.polyline(...)` string for a path-shaped marker, not the generic `L.marker(...)` fallback — this is the actual bug being fixed, so it needs direct coverage.
- No new pure-JS helper module needed (reuses `centroid`/`serializeVertices` from the polygon plan) — no new `node:test` additions.
- Manual/live verification (per the `verify` skill, as done for polygon and circle): draw a path in v4, confirm it persists/re-renders; separately confirm on the **legacy** map explore page that an existing path marker now renders as a line (not a pin); confirm the legacy edit form's path tab lets you drag a vertex and save the change; confirm there is no way to create a new path from the legacy create form.
