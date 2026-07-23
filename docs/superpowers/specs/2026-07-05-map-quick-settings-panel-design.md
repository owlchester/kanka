# Map Quick-Settings Panel for v4 Explorer Design

## Goal

Let map editors change a small, high-value subset of map settings directly from the v4 map explorer (`resources/js/components/maps/MapExplorer.vue` and siblings), without leaving the map to open the legacy full settings form. In scope: zoom bounds (min/max/initial), grid spacing, distance/measurement unit (name + factor), and map centering.

## Out of Scope

- Everything else the legacy settings form exposes stays legacy-only: `is_real`, `has_clustering`, `is_private`, layers/groups CRUD, image, entry, attributes, tags, template. These either require re-provisioning tiles/chunking, live on separate CRUD pages already, or belong to the generic entity form.
- No redesign of the legacy settings form itself (`resources/views/maps/form/_settings.blade.php`) — it remains reachable via "Edit map" for anything outside the quick panel's scope.
- No changes to `Toolbar.vue`'s existing pin/text/area/circle/path modes or the ruler control beyond the minimal `activeMode` integration described below for the new centering mode.

## Background

Map-level config currently flows to v4 read-only through `App\Http\Resources\Maps\Explore\MapResource`, consumed by `LeafletCanvas.vue` to configure the Leaflet instance (bounds, tile vs image vs chunked layer, zoom constraints, initial center, clustering, and the recently-added ruler control). There is no v4 UI to change any of it — editing requires leaving the explorer for `entities.edit` (the generic entity form's "Settings" tab).

Two of the target fields need groundwork before they're editable:
- **Zoom bounds**: `MapResource` currently exposes only `Map::minZoom()`/`maxZoom()`/`initialZoom()` — computed values (clamped against `MIN_ZOOM`/`MAX_ZOOM` constants, which differ for real/chunked maps), not the raw `min_zoom`/`max_zoom`/`initial_zoom` columns. Editing needs the raw values.
- **Grid**: v4 doesn't render the grid overlay at all today. Legacy draws it in `explore.blade.php` via `Map::grids()` — pure math over `grid`/`width`/`height` (no DB round trip needed) producing line coordinate pairs, drawn as grey (`opacity: 0.5`) polylines. This design ports that rendering into `LeafletCanvas.vue`, since editing a setting with no visible effect would be confusing.

The map's name/header (`MapExplorer.vue`, top-left, next to the legend toggle) is currently static text. Elsewhere in the app, contextual menus use a tippy dropdown pattern (`resources/js/entities/EntityRow.vue`'s actions menu: a trigger button/element + hidden content div + `tippy(el, { content, theme: 'kanka-dropdown', ... })`), which this design reuses.

## Architecture

**1. Header dropdown** — the map name in `MapExplorer.vue` becomes a clickable trigger for a tippy dropdown (`theme: 'kanka-dropdown'`, same as `EntityRow.vue`), with up to three items:
- "Go to overview" → `entities.show` for the map entity (always shown)
- "Settings" → opens the new quick-settings panel (only when `canEdit`)
- "Edit map" → `entities.edit` for the map entity, i.e. the legacy full form (only when `canEdit`)

**2. `SettingsPanel.vue`** (new component, sibling to `MarkerPanel.vue`) — a side panel with the quick-editable fields: grid spacing (number), zoom min/max/initial (numbers), distance unit name + factor (text/number, mirroring the existing legacy validation range), and a read-only display of the current center (coordinates or marker name). A single "Save" button batches all changed fields into one request, matching `MarkerPanel.vue`'s save convention (not per-field autosave).

**3. Centering — click-to-set** — a new `activeMode` value (`center-pick`), following the same mutual-exclusion pattern already used for pin/text/area/circle/path and the ruler (`measure-change`):
- Panel has a "Pick center on map" button that sets `activeMode.value = 'center-pick'`
- `LeafletCanvas.vue`'s existing `map-click` emit (already wired to `MapExplorer.vue`'s `handleMapClick`) is extended: when `activeMode === 'center-pick'`, the click coordinate is routed to the panel's pending center state instead of creating a marker draft. Unlike pin/text mode (which stays active across clicks so drafts can be repositioned before saving), `center-pick` only needs one coordinate, so `activeMode` resets to `null` immediately after the first click
- Panel also keeps a "Use marker instead" tab, reusing the existing marker-picker UI pattern (scoped to markers already on the map, as legacy does), setting `center_marker_id` and clearing `center_x`/`center_y`
- Whichever method is used, the result is included in the batched Save

**4. Grid rendering in `LeafletCanvas.vue`** — when `props.map.settings.grid` is set, compute the same horizontal/vertical line pairs as `Map::grids()` (pure arithmetic over `grid`/`width`/`height`, no new endpoint needed) and draw them as `L.polyline` with the same style legacy uses (grey, 0.5 opacity). Prerequisite for the grid field to have any visible effect in the panel.

**5. Backend** — new nested `settings` object on `MapResource`, included alongside the existing computed convenience fields (kept separate to avoid confusion between "raw editable value" and "rendering-ready computed value"):
```php
'settings' => [
    'grid' => $map->grid,
    'min_zoom' => $map->min_zoom,
    'max_zoom' => $map->max_zoom,
    'initial_zoom' => $map->initial_zoom,
    'distance_measure' => $map->config['distance_measure'] ?? null,
    'distance_name' => $map->config['distance_name'] ?? null,
    'center_x' => $map->center_x,
    'center_y' => $map->center_y,
    'center_marker_id' => $map->center_marker_id,
],
```
New route `PATCH /w/{campaign}/maps/{map}/settings` → `Maps\SettingsController@update` (own controller, alongside the existing `Maps\*` controllers for bulk/reorder actions — a scoped partial update, distinct from the generic `Crud\MapController` full-entity update). A dedicated form request validates only these fields, reusing the existing bounds from `StoreMap.php` (e.g. `distance_measure` between 0.001–100.99). Returns the updated `MapResource`; the front end replaces `data.map` in `MapExplorer.vue`, and `LeafletCanvas.vue` reacts to the new `props.map` the same way it already does for every other map-level setting — no page reload.

**6. Permissions** — the "Settings"/"Edit map" dropdown items and the panel itself are gated by the existing `canEdit` prop, same as `Toolbar.vue`'s drawing modes. Read-only viewers see only "Go to overview".

## Testing

Backend: Pest feature tests for `Maps\SettingsController@update` — authorization (rejects non-editors), validation bounds (grid/zoom/distance ranges, center exclusivity between coordinates and marker), and correct persistence of each field. A test asserting `MapResource`'s new `settings` object reflects the map's raw column/config values.

Frontend/JS: no automated test coverage exists for Leaflet canvas interactions in this app (matching the established pattern for polygon/circle/path/ruler work) — verification is live/manual via the `/verify` skill, covering: dropdown shows the right items per permission level; Settings panel opens and saves each field, with the map re-rendering the new zoom bounds/grid/ruler unit without reload; "Pick center on map" enters a crosshair-style single-click mode, sets coordinates, and cancels any in-progress drawing mode (and vice versa); "Use marker instead" correctly sets/clears `center_marker_id` vs `center_x`/`center_y`; grid lines render correctly against a map's actual `width`/`height`/`grid` values.
