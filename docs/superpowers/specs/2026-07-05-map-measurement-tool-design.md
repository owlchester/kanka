# Map Measurement Tool for v4 Explorer Design

## Goal

Port the legacy map's distance-measurement ("ruler") tool to the new v4 map explorer (`resources/js/components/maps/MapExplorer.vue` and siblings), so anyone viewing a v4 map can measure distances the same way they can on the legacy map.

## Out of Scope

- No new UI for configuring a map's distance unit (factor/name) — v4 only *reads* the existing `config.distance_measure`/`config.distance_name` settings, which remain configurable only via the legacy map settings form (`resources/views/maps/form/_settings.blade.php`).
- No change to the legacy map's ruler tool itself.
- No angle/bearing display beyond what the ported plugin already shows (the vendor plugin computes both distance and angle; whichever it already surfaces is kept as-is).
- No changes to `Toolbar.vue`'s existing pin/text/circle/area/path modes beyond the minimal conflict-resolution hook described below.

## Background

Legacy's measurement tool is `L.Control.Ruler`, a self-contained Leaflet control loaded via `<script src>` from `public/vendor/leaflet/`. There are two near-identical vendor files:
- `leaflet.ruler.js` — used for real (`is_real`) maps, computes distance via `L.CRS.EPSG3857.latLngToPoint(...)` (standard Web Mercator projection).
- `leaflet.ruler-kanka.js` — used for fantasy/custom-image maps, computes distance via `L.CRS.Simple.latLngToPoint(...)` (flat pixel-based projection, correct for non-geographic maps).

`resources/views/layouts/map.blade.php` loads whichever file matches `$map->isReal()`. `resources/views/maps/explore.blade.php` only adds the control when `$map->hasDistanceUnit()` (`App\Models\Map::hasDistanceUnit()`, true when `config.distance_measure` is set), passing:
```js
var rulerOptions = {
    lengthUnit: {
        factor: {{ $map->config['distance_measure'] }},
        display: '{{ $map->config['distance_name'] ?? 'Km' }}',
        decimal: 2
    },
};
L.control.ruler(rulerOptions).addTo(window.map);
```
The control is a toggle button (`onAdd`/`_toggleMeasure`): clicking it enters "measuring" mode (disables double-click-zoom, captures map clicks to lay down ruler points, shows a live tooltip with running distance, finishes on double-click or Escape), clicking again exits it. It is always present for any viewer — unrelated to the legacy edit form's marker-creation tools.

v4's map data currently comes from `app/Http/Resources/Maps/Explore/MapResource.php`, which exposes `is_real` but nothing about distance units. v4's map rendering (`resources/js/components/maps/LeafletCanvas.vue`) imports Leaflet plugins as ES modules (`leaflet-editable`, `leaflet.markercluster`) rather than `<script src>` tags. v4's edit toolbar (`resources/js/components/maps/Toolbar.vue`) only renders `v-if="canEdit"` — unlike legacy's ruler, which is available to any viewer — so the ruler must NOT be added to this toolbar; it needs its own always-present control, independent of edit permission.

v4's drawing modes (pin/text/area/circle/path, in `MapExplorer.vue`'s `activeMode` state) already capture map clicks and disable double-click-zoom while active, via `LeafletCanvas.vue`'s per-mode draft lifecycles. Measuring needs equivalent click/zoom capture, so it must be mutually exclusive with any active drawing mode to avoid both systems reacting to the same click.

## Architecture

**1. Ported ruler module** — `resources/js/leaflet/ruler.js` (new). A single ES module adapting the vendor plugin's logic (UI, click-to-measure toggle, live tooltip, distance/angle calculation), parameterized by projection instead of vendored as two files:
```js
L.control.ruler({
    lengthUnit: { factor, display, decimal: 2 },
    crs: L.CRS.EPSG3857, // or L.CRS.Simple for fantasy maps
})
```
Adds two small public methods beyond the vendor original (which only toggles via its own internal click handler): `enable()` and `disable()`, so `LeafletCanvas.vue` can force it off programmatically (see Wiring). Visual behavior (colors, dash style, tooltip format) matches the vendor original unchanged.

**2. Backend — expose distance unit config** — `app/Http/Resources/Maps/Explore/MapResource.php` gains:
```php
'has_distance_unit' => $map->hasDistanceUnit(),
'distance_measure' => $map->config['distance_measure'] ?? null,
'distance_name' => $map->config['distance_name'] ?? 'Km',
```
matching `hasDistanceUnit()`'s existing gating and `explore.blade.php`'s existing `?? 'Km'` default.

**3. Wiring in `LeafletCanvas.vue`** — when `props.map.has_distance_unit` is true, instantiate the ruler control directly on `leafletMap` (not through `Toolbar.vue`, so it's visible regardless of edit permission), choosing `L.CRS.EPSG3857` when `props.map.is_real` else `L.CRS.Simple`, with `factor`/`display` from `props.map.distance_measure`/`distance_name`.

**4. Two-way mode conflict** — clicking the ruler's toggle button emits a new `measure-change` event (boolean) up to `MapExplorer.vue`, which sets `activeMode.value = null` when measuring turns on (cancelling any in-progress pin/circle/area/path draft, mirroring how selecting a new drawing mode already clears the previous one). Conversely, `LeafletCanvas.vue` watches `props.activeMode` and calls the ruler control's `disable()` whenever a drawing mode becomes active while measuring is on.

## Testing

Backend: a Pest test asserting `MapResource`'s `has_distance_unit`/`distance_measure`/`distance_name` fields reflect a map's `config` correctly (present when configured, sensible defaults when not).

Frontend/JS: no automated test coverage exists for Leaflet canvas interactions in this app (matching the established pattern for polygon/circle/path drawing) — verification is live/manual, covering: the ruler control appears only when the map has a distance unit configured; clicking it enters measuring mode, clicking two points shows a running distance in the configured unit; double-click/Escape finishes measuring; starting a pin/circle/area/path draft while measuring is active turns the ruler off; turning measuring on while mid-draft cancels the draft; real maps compute geographic distance, fantasy maps compute flat-pixel distance (spot-check against a known distance_measure factor).
