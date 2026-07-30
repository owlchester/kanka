# Path Distance & Polygon Surface Area Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** In the v4 map explorer's `DetailPanel`, automatically show a path marker's real-world length or a polygon marker's surface area, converted using the map's configured distance unit.

**Architecture:** Two new pure geometry helpers (`pathLength`, `polygonArea`) in `resources/js/maps/polygon.js` reuse the exact CRS-projection formula the existing ruler tool (`resources/js/leaflet/ruler.js`) already uses, so numbers stay consistent with it. `MapExplorer.vue` passes the map object into `DetailPanel.vue`, which computes and renders one new line under the existing Type - Group line. Two new i18n keys (`distance`, `surface`) flow from `lang/en/maps/explorer.php` through `ExploreApiService::translations()`.

**Tech Stack:** Vue 3 `<script setup>`, Leaflet (`L.CRS.Simple` / `L.CRS.EPSG3857`), Laravel 11 / Pest.

## Global Constraints

- Never hardcode translations; use `__()` (project-wide i18n convention).
- PHP: curly braces always, explicit return types/param type hints, PHPDoc over inline comments.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP file changes.
- Run tests with `vendor/bin/sail artisan test --compact --filter=<Name>`, only the affected test(s).
- No JS test framework exists in this repo (checked: no vitest/jest config, no test script in `package.json`) — the geometry helpers are verified via a one-off Node sanity script (Task 1) plus manual browser verification (Task 4), not an automated JS test suite. This matches existing precedent for this app's Vue/Leaflet features (no automated frontend test coverage anywhere in `resources/js/`).
- Out of scope (per design doc `docs/superpowers/specs/2026-07-11-map-path-distance-polygon-area-design.md`): `MarkerPanel.vue` draft-pin live preview, circle marker area, any change to `ruler.js` itself.

---

### Task 1: Geometry helpers in `polygon.js`

**Files:**
- Modify: `resources/js/maps/polygon.js`

**Interfaces:**
- Produces: `pathLength(vertices: [number, number][], map: { is_real: boolean, max_zoom: number, distance_measure: number|null }): number` — total real-world length of a polyline.
- Produces: `polygonArea(vertices: [number, number][], map: { is_real: boolean, max_zoom: number, distance_measure: number|null }): number` — real-world surface area of a closed polygon (shoelace formula).
- Consumes: `L` from the `leaflet` package (already a project dependency, imported the same way in `LeafletCanvas.vue` and `ruler.js`).

- [ ] **Step 1: Add the helpers**

Replace the full contents of `resources/js/maps/polygon.js` with:

```js
import L from 'leaflet'

export function centroid(vertices) {
    const count = vertices.length
    const totals = vertices.reduce(
        ([totalLat, totalLng], [lat, lng]) => [totalLat + lat, totalLng + lng],
        [0, 0]
    )

    return [totals[0] / count, totals[1] / count]
}

export function serializeVertices(vertices) {
    return vertices.map(([lat, lng]) => `${lat.toFixed(3)},${lng.toFixed(3)}`).join(' ')
}

function crsFor(map) {
    return map.is_real ? L.CRS.EPSG3857 : L.CRS.Simple
}

function toPoint(crs, maxZoom, [lat, lng]) {
    return crs.latLngToPoint(L.latLng(lat, lng), maxZoom)
}

// Mirrors the ruler tool's own formula (resources/js/leaflet/ruler.js) so the
// numbers shown here always agree with what the ruler measures on the same map.
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

// Shoelace formula on projected pixel coordinates. Length scales linearly by
// k = factor / maxZoom (see pathLength), so area scales by k^2.
export function polygonArea(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const k = (map.distance_measure || 1) / maxZoom
    const points = vertices.map((vertex) => toPoint(crs, maxZoom, vertex))

    let sum = 0
    for (let i = 0; i < points.length; i++) {
        const p1 = points[i]
        const p2 = points[(i + 1) % points.length]
        sum += p1.x * p2.y - p2.x * p1.y
    }

    return Math.abs(sum) / 2 * k * k
}
```

- [ ] **Step 2: Sanity-check the math with a throwaway Node script**

No JS test runner exists in this repo, so verify the formulas once, manually, before wiring them into the UI. Create a scratch file (outside the repo, e.g. `/tmp/verify-geometry.mjs`) so nothing needs to be cleaned up from the repo itself:

```js
import L from '/Users/jay/Documents/GitHub/kanka/node_modules/leaflet/dist/leaflet-src.esm.js'

function crsFor(map) {
    return map.is_real ? L.CRS.EPSG3857 : L.CRS.Simple
}

function toPoint(crs, maxZoom, [lat, lng]) {
    return crs.latLngToPoint(L.latLng(lat, lng), maxZoom)
}

function pathLength(vertices, map) {
    const crs = crsFor(map)
    const maxZoom = map.max_zoom
    const factor = map.distance_measure || 1
    let total = 0
    for (let i = 1; i < vertices.length; i++) {
        total += toPoint(crs, maxZoom, vertices[i - 1]).distanceTo(toPoint(crs, maxZoom, vertices[i]))
    }
    return total * factor / maxZoom
}

function polygonArea(vertices, map) {
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

// CRS.Simple map, maxZoom 5, distance_measure 1 -> pixel units are untouched
// except for the /maxZoom division baked into pathLength/polygonArea.
const map = { is_real: false, max_zoom: 5, distance_measure: 1 }

// Straight horizontal line, 100 "pixel" units long.
const line = [[0, 0], [0, 100]]
console.log('expected path length:', 100 / 5, 'got:', pathLength(line, map))

// 10x10 square (corners in [lat, lng] = [y, x] order) -> area 100.
const square = [[0, 0], [0, 10], [10, 10], [10, 0]]
console.log('expected area:', 100 / 25, 'got:', polygonArea(square, map))
```

Run: `node /tmp/verify-geometry.mjs`
Expected output:
```
expected path length: 20 got: 20
expected area: 4 got: 4
```
If the numbers don't match, fix `pathLength`/`polygonArea` in `resources/js/maps/polygon.js` before continuing — do not proceed to Task 2 with unverified math. Delete `/tmp/verify-geometry.mjs` once it passes; it isn't part of the codebase.

- [ ] **Step 3: Commit**

```bash
git add resources/js/maps/polygon.js
git commit -m "feat: add path length and polygon area geometry helpers"
```

---

### Task 2: i18n keys for "Distance" / "Surface"

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Produces: `data.i18n.distance` (string, "Distance"), `data.i18n.surface` (string, "Surface") — consumed by Task 3.

- [ ] **Step 1: Add the language keys**

In `lang/en/maps/explorer.php`, inside the `'marker'` array, add two new entries. Find this block (currently ends with `'stroke_bold'`):

```php
        'stroke_thin'       => 'Thin',
        'stroke_normal'     => 'Normal',
        'stroke_bold'       => 'Bold',
    ],
```

Replace with:

```php
        'stroke_thin'       => 'Thin',
        'stroke_normal'     => 'Normal',
        'stroke_bold'       => 'Bold',
        'distance'          => 'Distance',
        'surface'           => 'Surface',
    ],
```

- [ ] **Step 2: Expose the keys from `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, find this line (around line 152):

```php
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
```

Add immediately after it:

```php
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
            'distance' => __('maps/explorer.marker.distance'),
            'surface' => __('maps/explorer.marker.surface'),
```

- [ ] **Step 3: Update the existing JSON-structure test**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, find this line (line 44):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

Replace with (adds `'distance', 'surface'` right after `'less'`):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'distance', 'surface', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

- [ ] **Step 4: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`
Expected: reports the modified PHP files formatted (or already clean); no errors.

- [ ] **Step 5: Run the test**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add distance and surface translation keys to map explorer"
```

---

### Task 3: Wire `map` prop and render the stat line in `DetailPanel.vue`

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue:141-147`
- Modify: `resources/js/components/maps/DetailPanel.vue`

**Interfaces:**
- Consumes: `pathLength`, `polygonArea` from `resources/js/maps/polygon.js` (Task 1). `data.i18n.distance`, `data.i18n.surface` (Task 2). `pin.shape`, `pin.customShape` (existing `PinResource` shape, already present on every pin object).
- Consumes: `data.map` (existing top-level object in `MapExplorer.vue`'s `data` ref, shape per `MapResource`: `is_real`, `max_zoom`, `has_distance_unit`, `distance_measure`, `distance_name`).

- [ ] **Step 1: Pass `map` into `DetailPanel`**

In `resources/js/components/maps/MapExplorer.vue`, find:

```html
        <DetailPanel
            :pin="selectedPin"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />
```

Replace with:

```html
        <DetailPanel
            :pin="selectedPin"
            :map="data.map"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />
```

- [ ] **Step 2: Add the `map` prop and computed stat text in `DetailPanel.vue`**

In `resources/js/components/maps/DetailPanel.vue`, find the script imports and props (top of `<script setup>`):

```js
import { computed, ref, watch } from "vue";

const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
});
```

Replace with:

```js
import { computed, ref, watch } from "vue";
import { pathLength, polygonArea } from "../../maps/polygon.js";

const props = defineProps({
    pin: { type: Object, default: null },
    map: { type: Object, default: () => ({}) },
    i18n: { type: Object, required: true },
});
```

Then, directly after the existing `markerIcon` computed property (ends at line 219, `});`), add two new computed properties:

```js
const distanceText = computed(() => {
    if (props.pin?.shape !== "path" || !props.map?.has_distance_unit || !props.pin.customShape?.length) {
        return null;
    }

    return `${props.i18n.distance} ${pathLength(props.pin.customShape, props.map).toFixed(2)} ${props.map.distance_name}`;
});

const surfaceText = computed(() => {
    if (props.pin?.shape !== "poly" || !props.map?.has_distance_unit || !props.pin.customShape?.length) {
        return null;
    }

    return `${props.i18n.surface} ${polygonArea(props.pin.customShape, props.map).toFixed(2)} ${props.map.distance_name}²`;
});
```

- [ ] **Step 3: Render the stat line in the template**

In `resources/js/components/maps/DetailPanel.vue`, find the Type - Group paragraph and the element right after it:

```html
                <p class="text-xs text-neutral-content flex items-center gap-1">
                    <span class="marker-type">{{ preview.type }}</span>
                    <span>-</span>
                    <span
                        class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                        :class="
                            !preview.group_colour ? 'bg-neutral-content' : ''
                        "
                        :style="
                            preview.group_colour
                                ? { backgroundColor: preview.group_colour }
                                : {}
                        "
                    />
                    <span class="marker-group">{{
                        preview.group_name || i18n.ungrouped
                    }}</span>
                </p>

                <a
```

Replace with (adds a new `<p>` right after the closing `</p>`, before the `<a`):

```html
                <p class="text-xs text-neutral-content flex items-center gap-1">
                    <span class="marker-type">{{ preview.type }}</span>
                    <span>-</span>
                    <span
                        class="inline-block w-2.5 h-2.5 rounded-full flex-none"
                        :class="
                            !preview.group_colour ? 'bg-neutral-content' : ''
                        "
                        :style="
                            preview.group_colour
                                ? { backgroundColor: preview.group_colour }
                                : {}
                        "
                    />
                    <span class="marker-group">{{
                        preview.group_name || i18n.ungrouped
                    }}</span>
                </p>

                <p
                    v-if="distanceText || surfaceText"
                    class="text-xs text-neutral-content"
                >
                    {{ distanceText || surfaceText }}
                </p>

                <a
```

- [ ] **Step 4: Manual verification (no automated frontend test harness in this repo)**

Run: `vendor/bin/sail yarn run dev` (or `vendor/bin/sail composer run dev` if that's the project's usual combined dev command — check `composer.json`'s `"dev"` script if unsure which one is running already).

In a browser, open a map that has `distance_measure`/`distance_name` configured (or set one via the map's Settings panel first) and that has at least one existing `path` marker and one existing `poly` marker (create them via the toolbar's Path/Area tools and save them if none exist yet).

- Click the path marker → `DetailPanel` opens → confirm a line reading `Distance X.XX <unit>` appears under the Type - Group line.
- Click the polygon marker → confirm a line reading `Surface X.XX <unit>²` appears.
- Open the map's Settings panel and clear the distance unit (or use a map with none configured) → reopen both markers → confirm neither line appears.
- Click a plain pin/label/circle marker → confirm no distance/surface line appears.
- Cross-check the path's displayed distance against the existing ruler tool: enable the ruler (only available when `has_distance_unit` is true), click the same two/more points the path marker uses, and confirm the ruler's total reads the same number (within rounding) as `DetailPanel`'s `Distance` line.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue resources/js/components/maps/DetailPanel.vue
git commit -m "feat: show path distance and polygon surface area in marker detail panel"
```

## Self-Review Notes

- **Spec coverage:** Geometry formulas (Task 1) ✓, i18n keys (Task 2) ✓, prop wiring + display (Task 3) ✓, gating on `has_distance_unit` and shape (Task 3, Step 2) ✓, out-of-scope items (MarkerPanel, circles, ruler.js) untouched ✓.
- **Placeholder scan:** No TBDs; every step has literal code or an exact command with expected output.
- **Type/name consistency:** `pathLength`/`polygonArea` signatures in Task 1 match the call sites in Task 3, Step 2 exactly (same argument order: `(vertices, map)`). `data.i18n.distance`/`data.i18n.surface` (Task 2) match `props.i18n.distance`/`props.i18n.surface` (Task 3).
