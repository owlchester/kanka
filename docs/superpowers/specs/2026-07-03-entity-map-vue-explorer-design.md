# Entity Map Page: Vue + Leaflet Explorer (v1)

**Date:** 2026-07-03
**Branch:** `feature/map4`

## Problem

The current map viewing experience (`/w/{campaign}/maps/{map}/explore`) is built as server-rendered Blade generating raw inline `<script>` strings (`maps/_setup.blade.php`, `App\Models\MapMarker::marker()`/`popup()`), mixing PHP and JS in a way that's hard to extend or reason about. We want to start replacing this with a proper Vue component on top of Leaflet, built incrementally, without disturbing the existing explore page.

## Goal

A new, separate, read-only map viewing page at `entities/{entity}/map` that renders a map entity's groups, layers, and pins using a Vue root component and Leaflet, fed by a dedicated JSON API endpoint (`entities/{entity}/map-api`). This is the first slice of the new engine — editing, the ruler tool, layer-visibility toggling, and polygon pins are explicitly deferred.

The old `/maps/{map}/explore` page is untouched and keeps working as-is. This is a parallel, experimental page.

## Routing & Controllers

New entity-scoped routes in `routes/campaigns/entities.php`, alongside the other `entities.*` routes:

```php
Route::get('/w/{campaign}/entities/{entity}/map', [Entity\Maps\ShowController::class, 'index'])->name('entities.map');
Route::get('/w/{campaign}/entities/{entity}/map-api', [Entity\Maps\ApiController::class, 'index'])->name('entities.map-api');
```

### `App\Http\Controllers\Entity\Maps\ShowController`

- `index(Campaign $campaign, Entity $entity)`
- Auths view access (`authEntityView`, matching other entity controllers)
- Guards: `$entity->isType(config('entities.ids.map'))` and `$entity->hasChild()` — 404 otherwise
- Renders `entities.pages.map.index` with just `$campaign`/`$entity` in scope — no map data prep server-side (mirrors `Whiteboards\DrawController::show()`, which defers all data loading to the client via the API route).

### `App\Http\Controllers\Entity\Maps\ApiController`

- `index(Campaign $campaign, Entity $entity)`
- Same guards as above
- Delegates to `App\Services\Maps\ExploreApiService` and returns its array as JSON

## View & Layout

`resources/views/entities/pages/map/index.blade.php` — Blade (the convention for every file under `entities/pages`, despite the informal "index.php" name used when this was scoped). Extends `layouts.rich` (the minimal layout — no header/sidebar chrome), the same way `resources/views/whiteboards/draw.blade.php` extends it:

```blade
@extends('layouts.rich', [
    'title' => $entity->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'map-page',
])

@section('content')
    <div id="map-explorer">
        <map-explorer api="{{ route('entities.map-api', [$campaign, $entity]) }}"></map-explorer>
    </div>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/maps/explore.js')
@endsection
```

## Dependencies

Today Leaflet core is loaded globally via CDN (`config('app.leaflet_source')`); only its plugins are npm packages, vendored as plain scripts rather than bundled. For this Vue integration we add real npm dependencies and import them directly instead of relying on the global `L`:

- `leaflet` (core — not currently an npm dependency; approved as part of this design)
- `leaflet.markercluster` (already a dependency, now actually imported/bundled instead of only vendored)

No other existing dependencies change. The old explore page's CDN-loaded Leaflet and vendored plugin scripts (`leaflet.ruler.js`, `leaflet.layerstree.js`, `leaflet.editable.js`, etc.) are untouched.

## Vue Architecture

New Vite entry `resources/js/maps/explore.js`, added to `vite.config.js`'s `input` array, following the existing minimal-mount convention (`resources/js/whiteboards.js`, `resources/js/entities/explore.js`):

```js
import { createApp } from 'vue'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
```

Components under `resources/js/components/maps/`:

- **`MapExplorer.vue`** (root, `<map-explorer :api>`)
  - Fetches `api` via axios on mount, holds `loading`/`error`/`data`/`selectedPin` state
  - Loading state matches `Whiteboard.vue`'s pattern: `fa-solid fa-spinner fa-spin` + "loading...." text, full-screen centered
  - Renders `LeafletCanvas`, `LegendPanel` (left, toggle button top-left), `DetailPanel` (right)
- **`LeafletCanvas.vue`**
  - Props: the fetched `map`/`layers`/`groups`/`pins` data
  - Builds the `L.map(...)` instance, base layer, layer image overlays, and pins/clustering (see Rendering Logic)
  - Emits `pin-click(pin)`
- **`LegendPanel.vue`**
  - Props: `groups`, `pins`, `open` (toggled from `MapExplorer`)
  - Uses `groupTree.js` to build a nested group→pins structure plus a trailing "Uncategorised" bucket
  - Each group row toggles collapse/expand of its pin list (UI-only, does not affect map layer visibility)
  - Clicking a pin emits selection, same as clicking a map pin
- **`DetailPanel.vue`**
  - Props: `pin` (nullable)
  - v1: shows the pin's name only
- `resources/js/maps/groupTree.js` — pure helper `buildGroupTree(groups, pins)` returning `{ groups: [{...group, children: [...], pins: [...]}], uncategorised: [...pins] }`. Shared by `LeafletCanvas` (for cluster/group layer assignment) and `LegendPanel` (for the list), so the grouping logic isn't duplicated.

## API Data Contract (`entities.map-api`)

`App\Services\Maps\ExploreApiService::campaign($campaign)->entity($entity)->load(): array`, modeled on `Whiteboards\ApiService`'s "one service assembles the whole payload" convention rather than a single Eloquent API Resource:

```json
{
  "map": {
    "id": 1,
    "name": "...",
    "is_real": false,
    "is_chunked": false,
    "has_clustering": true,
    "image": "https://.../map.png",
    "width": 2000,
    "height": 1500,
    "min_zoom": -2,
    "max_zoom": 4,
    "initial_zoom": 0,
    "center": [750, 1000],
    "tile_url": null,
    "chunks_url": null
  },
  "layers": [
    { "id": 10, "name": "Winter", "type_id": 2, "image": "https://.../layer.png", "position": 1 }
  ],
  "groups": [
    { "id": 5, "name": "Towns", "parent_id": null, "position": 1 }
  ],
  "pins": [
    {
      "id": 100,
      "name": "Waterdeep",
      "group_id": 5,
      "latitude": 12.3,
      "longitude": 45.6,
      "shape_id": 1,
      "colour": "#ff0000",
      "font_colour": "#ffffff",
      "icon": "fa-solid fa-city",
      "custom_icon": null,
      "size_id": 2,
      "pin_size": null,
      "circle_radius": null,
      "opacity": 1
    }
  ]
}
```

- `tile_url` is populated (OpenStreetMap template) when `is_real`; `chunks_url` (pointing at the existing `maps.chunks` route) when `is_chunked`.
- Groups/pins are flat, not pre-nested — `groupTree.js` on the frontend builds the tree + uncategorised bucket. This avoids reimplementing `Map::buildGroupTree()`/`legendMarkers()` server-side for a shape only the frontend needs.
- Visibility/permission filtering (private groups, pins pointing at entities the viewer can't see) is applied server-side in `ExploreApiService`, matching `MapMarker::visible()`'s existing rules.

## Rendering Logic

- **Base layer**:
  - `is_real` → Leaflet tile layer from OpenStreetMap
  - `is_chunked` → tile layer from `chunks_url` (existing `maps.chunks` route), `CRS.Simple`, `maxBounds`
  - simple (neither) → `L.imageOverlay(map.image, bounds)`, `CRS.Simple`, bounds computed from `width`/`height` (mirrors current `Map::bounds()`)
- **Layers**: each layer's image added as a stacked `L.imageOverlay`. **v1 scope cut:** only layers with `type_id = overlay_shown` (shown-by-default overlays) are rendered, stacked above the base image. Layers of type `standard` (alternate base image) or `overlay` (hidden-by-default) are skipped — there is no layer-visibility toggle UI in this design. Adding one is a follow-up.
- **Pins**: v1 supports `shape_id` values `marker`, `label`, `circle` (colour, icon/custom icon, size, opacity, radius as applicable). `poly` (freeform drawn polygon areas) is out of scope — it's an area-annotation/editing feature, not a pin.
- **Clustering**: when `map.has_clustering` is true, all pins are added to a single `L.markerClusterGroup()`. Otherwise pins are added directly to the map. No per-group layer-control checkin/checkout (that machinery in the old page exists only to support the native Leaflet layers-tree control, which this design replaces with the Vue `LegendPanel`).
- **Pin click**: no `bindPopup`. Click sets `selectedPin` on `MapExplorer`, opening `DetailPanel`.

## Out of Scope (v1)

- Editing: adding/moving/deleting pins, layers, groups
- Ruler/measuring tool
- Layer visibility toggle UI (only shown-by-default overlays render)
- Polygon-shaped pins/areas
- Live position ticker (other users moving pins in real time)
- Feature parity with `/maps/{map}/explore` — this is a separate, additive page

## Testing

- Pest feature test for `entities.map`: 404 for a non-map entity, 200 + correct view/data for a map entity
- Pest feature test for `entities.map-api`: asserts JSON shape (`map`/`layers`/`groups`/`pins` keys present) and correct values for a seeded map with groups, layers, and pins of each supported shape
- No JS/Vue automated test harness exists in this repo; Vue components are verified manually in-browser (loading state, legend collapse/expand, pin click → detail panel, clustering on/off) per project convention.
