# Polygon (Area) Drawing in MapExplorer v4

## Goal

Add polygon drawing/editing to the new map explorer (`resources/js/components/maps/MapExplorer.vue`), reusing the polygon leaflet tools already used by the legacy map page (`resources/js/location/map-v3.js`, Leaflet.Editable via `map.editTools`). Scope: the Toolbar's existing "area" mode only. "circle" and "path" modes stay unwired stubs, same as today.

## Out of scope

- Circle and path drawing modes.
- Re-editing an already-saved pin/polygon after creation (there is currently no update/PATCH route for map markers in the new explorer — only store/preview/destroy). Editing only applies to the in-progress draft, before save.
- A separate stroke-opacity control (stroke always renders at 100% opacity regardless of fill opacity).

## Flow

1. User clicks the "area" toolbar button → `activeMode = 'area'`.
2. `LeafletCanvas.vue` starts a Leaflet.Editable polygon draw session (`leafletMap.editTools.startPolygon()`), matching the legacy page's approach.
3. Each map click adds a vertex (native Leaflet.Editable behavior).
4. Clicking the first vertex again, or double-clicking, finishes the polygon (native `editable:drawing:end` event — no custom close-detection needed).
5. On finish, `MapExplorer.vue` builds a `draftPin` (shape `poly`) from the vertex list and opens `MarkerPanel.vue`, same as the existing pin/text draft flow.
6. While `MarkerPanel` is open, the polygon stays in Leaflet.Editable edit mode (`enableEdit()`) — dragging a vertex live-updates `draftPin`'s shape via a `polygon-change` emit.
7. `latitude`/`longitude` on the marker (required fields) are set to the centroid of the vertices.
8. Closing the panel or saving removes the draft polygon layer and resets `activeMode`/`draftPin` (existing pattern in `handleModeChange`/`onPinCreated`).

## Data model

No new columns needed. `MapMarker` already has:
- `custom_shape` (text): space-separated `"lat,lng lat,lng ..."` vertex string.
- `polygon_style` (text, cast to `array`): keys `stroke` (hex colour), `stroke-width` (int px). No `stroke-opacity` key is set by this feature.
- `shape_id` = `MapMarkerShape::poly` (5).

Draft pin shape while drawing:

```js
{
  name: "",
  colour: defaultColour(),       // fill
  shape: "poly",
  shapeId: 5,
  customShape: "lat,lng lat,lng ...",
  polygonStyle: { stroke: "#...", "stroke-width": 1 | 3 | 6 },
  groupId: null,
  entityId: null,
  entityName: null,
  visibilityId: <default>,
  opacity: 100,                  // fill opacity
  latitude: <centroid lat>,
  longitude: <centroid lng>,
}
```

## Backend changes

- `app/Http/Resources/Maps/Explore/PinResource.php`: add `custom_shape` (parsed into `[[lat, lng], ...]` from the raw string) and `polygon_style` to the returned array.
- `app/Http/Requests/StoreMapMarker.php`: add validation rules:
  - `polygon_style` => `nullable|array`
  - `polygon_style.stroke` => `nullable|string|max:7`
  - `polygon_style.stroke-width` => `nullable|integer|min:1|max:20`
  - (`custom_shape` rule already exists: `nullable|string`)
- No changes to `app/Models/MapMarker.php` — the vertex-string parse for `PinResource` is small enough to live in the resource, no shared helper needed.

## Frontend changes

- **`LeafletCanvas.vue`**
  - Remove the `pin.shape !== 'poly'` filter in `buildPins()`.
  - `buildPin()`: add a `poly` branch — parse `pin.customShape`/`custom_shape` into latlngs, return `L.polygon(latlngs, { color: stroke, weight: strokeWidth, fillColor: colour, fillOpacity: opacity/100, opacity: 1 })`.
  - Watch `activeMode`: entering `'area'` starts the Leaflet.Editable polygon session; leaving it (mode change/cancel) tears it down.
  - New emits: `polygon-change` (vertex list, fired on vertex add/drag while drafting), `polygon-finish` (final vertex list, fired once on `editable:drawing:end`).

- **`MapExplorer.vue`**
  - `handlePolygonFinish(vertices)`: compute centroid, serialize vertices to the wire-format string, build `draftPin` as above, open `MarkerPanel`.
  - `handlePolygonChange(vertices)`: update `draftPin.customShape` (and recentroid) live while editing.
  - `handleBorderColourChange(colour)` / `handleStrokeWidthChange(width)`: update `draftPin.polygonStyle`.
  - Small helpers: centroid calculation, vertex array ↔ `"lat,lng lat,lng"` string serialize/parse.

- **`MarkerPanel.vue`**
  - When `pin.shape === 'poly'`, render a border-colour picker and a stroke-width picker (in addition to existing fields).
  - `save()` payload gains `custom_shape: pin.customShape` and `polygon_style: pin.polygonStyle`.

- **New `StrokeWidthPicker.vue`**
  - Same preset+custom UI pattern as `OpacityPicker.vue`. Presets: 1px (thin), 3px (normal), 6px (bold), plus a custom numeric entry.

- **`ColourPicker.vue`**
  - Generalize from being hardcoded to `pin.colour` to accepting a label + colour value prop and emitting a change, so it can be reused for both fill colour and border colour without duplicating the Coloris/recent-colours wiring.

## Testing

- Pest feature test on `MarkerController::store` (`app/Http/Controllers/Entity/Maps/MarkerController.php`) with a `custom_shape` + `polygon_style` payload — assert the marker is persisted with those values and that `PinResource` returns them on the explore API response.
- Extract the centroid-calculation and vertex-string serialize/parse logic into a plain JS module (mirroring `resources/js/maps/groupTree.js`) and unit-test it with `node:test`, matching `resources/js/maps/groupTree.test.js`'s existing convention. This repo has no Vue component test harness, so Leaflet/Vue interaction itself is verified manually (per the `verify` skill) rather than via automated component tests.
