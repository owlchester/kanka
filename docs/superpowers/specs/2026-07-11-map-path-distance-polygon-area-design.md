# Path Distance & Polygon Surface Area Design

## Goal

When viewing an existing `path`-shaped or `poly`-shaped marker in the v4 map explorer's `DetailPanel`, automatically display its real-world length (path) or surface area (polygon), converted using the map's configured distance unit (`distance_measure` / `distance_name`). Only shown for maps that have a distance unit configured.

## Out of Scope

- `MarkerPanel.vue` (the draft-pin creation panel) — no live length/area while drawing, per decision; only the saved-marker detail view shows this.
- Circle markers — not requested; circle radius/area could reuse the same helpers later but isn't part of this change.
- Any change to the existing ruler/measure tool (`resources/js/leaflet/ruler.js`) — reused as the reference formula only, not modified.

## Background

- `Map.config` (JSON) holds `distance_measure` (float scale factor) and `distance_name` (unit label, default `'Km'`). `MapResource` exposes these plus `has_distance_unit` (bool) and `is_real`/`max_zoom` to the frontend as part of `data.map`.
- The existing ruler tool (`ruler.js:172-174`) computes real-world distance between two points as:
  ```js
  const crs = map.options.crs || L.CRS.EPSG3857
  const pt1 = crs.latLngToPoint(latlng1, maxZoom)
  const pt2 = crs.latLngToPoint(latlng2, maxZoom)
  const distance = pt1.distanceTo(pt2) * factor / maxZoom
  ```
  `crs` is `L.CRS.Simple` for custom/fantasy maps (`! map.is_real`) or `L.CRS.EPSG3857` for real-world maps — same convention used when the Leaflet map itself is constructed in `LeafletCanvas.vue`. Reusing this exact formula keeps path-length numbers consistent with whatever the user sees from the ruler tool.
- `path` and `poly` pins store their vertices in `pin.customShape`, an array of `[lat, lng]` pairs (already present client-side in the `pins` array — no extra fetch needed).
- `DetailPanel.vue` currently receives only `pin` and `i18n` props; it does not have access to `data.map`.
- `resources/js/maps/polygon.js` already holds small pure geometry helpers (`centroid`, `serializeVertices`) — the natural home for two more.

## Architecture

**1. `resources/js/maps/polygon.js`** — two new pure exports:
```js
import L from 'leaflet'

function crsFor(map) {
    return map.is_real ? L.CRS.EPSG3857 : L.CRS.Simple
}

function toPoint(crs, maxZoom, [lat, lng]) {
    return crs.latLngToPoint(L.latLng(lat, lng), maxZoom)
}

export function pathLength(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const factor = map.distance_measure || 1
    let total = 0

    for (let i = 1; i < vertices.length; i++) {
        total += toPoint(crs, maxZoom, vertices[i - 1]).distanceTo(toPoint(crs, maxZoom, vertices[i]))
    }

    return total * factor / maxZoom
}

export function polygonArea(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const k = (map.distance_measure || 1) / maxZoom
    const points = vertices.map((v) => toPoint(crs, maxZoom, v))

    let sum = 0
    for (let i = 0; i < points.length; i++) {
        const p1 = points[i]
        const p2 = points[(i + 1) % points.length]
        sum += p1.x * p2.y - p2.x * p1.y
    }

    return Math.abs(sum) / 2 * k * k
}
```
`polygonArea` is the shoelace formula on projected pixel coordinates. Since length scales linearly by `k = factor / maxZoom`, area scales by `k²` — derived directly from the ruler's own distance formula, not a separate assumption.

**2. `MapExplorer.vue`** — pass `:map="data.map"` into `DetailPanel` (currently only `:pin` and `:i18n`).

**3. `DetailPanel.vue`** — new `map` prop, plus two computed properties:
```js
const distanceText = computed(() => {
    if (props.pin?.shape !== 'path' || ! props.map?.has_distance_unit || ! props.pin.customShape?.length) {
        return null
    }

    return `${props.i18n.distance} ${pathLength(props.pin.customShape, props.map).toFixed(2)} ${props.map.distance_name}`
})

const surfaceText = computed(() => {
    if (props.pin?.shape !== 'poly' || ! props.map?.has_distance_unit || ! props.pin.customShape?.length) {
        return null
    }

    return `${props.i18n.surface} ${polygonArea(props.pin.customShape, props.map).toFixed(2)} ${props.map.distance_name}²`
})
```
Rendered as a new `<p class="text-xs text-neutral-content ...">` line directly under the existing Type - Group line (`DetailPanel.vue:78-95`), shown only when `distanceText || surfaceText` is truthy — same text size/color as the line above it, values separated by ` | ` if a marker somehow qualifies for both (never happens in practice since shape is either `path` or `poly`, but keeps the template simple: just render whichever of the two computed values is non-null).

**4. i18n** — two new keys under `marker` in `lang/en/maps/explorer.php` (`distance` → `'Distance'`, `surface` → `'Surface'`), plus matching entries in `ExploreApiService::translations()` (`'distance' => __('maps/explorer.marker.distance')`, `'surface' => __('maps/explorer.marker.surface')`).

## Testing

Frontend-only change with no existing JS unit test harness in this codebase (checked: no `vitest`/`jest` config present) — verified manually instead:
- Open a map with a distance unit configured, view an existing path marker → "Distance X.XX <unit>" line appears under Type - Group.
- Same map, view an existing polygon marker → "Surface X.XX <unit>²" line appears.
- Map with no distance unit configured (`has_distance_unit: false`) → no line appears for either shape.
- Marker/pin/label/circle shapes → no line appears.
- Sanity-check the numbers against the existing ruler tool on the same map for a path with 2 points (ruler distance should match `pathLength` exactly) and against a manually-computed rectangle area for a 4-point polygon.
