# Map Measurement Tool for v4 Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Port the legacy map's distance-measurement ("ruler") tool to the v4 map explorer, so anyone viewing a v4 map can measure distances the same way they can on the legacy map.

**Architecture:** Expose the map's existing `distance_measure`/`distance_name` config through the v4 map API, port the legacy `L.Control.Ruler` Leaflet plugin into a single local ES module (parameterized by whatever CRS the map itself already uses, instead of legacy's two near-duplicate vendor files), and wire it into `LeafletCanvas.vue` as an always-visible control (independent of the edit-only toolbar), with two-way conflict resolution against the existing drawing modes.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API), Leaflet 1.9 (npm package, not vendor `<script>` tags).

## Global Constraints

- The ruler control must be visible to ANY viewer of a v4 map, not gated behind edit permission — it must NOT be added to `Toolbar.vue` (which only renders `v-if="canEdit"`).
- The ruler's distance calculation must use whatever CRS the map's own `L.map(...)` instance is configured with (`L.CRS.Simple` for fantasy/image maps, Leaflet's default `L.CRS.EPSG3857` for real maps) — read from `this._map.options.crs` at calculation time, not passed in as a separate option that could drift out of sync.
- No new UI for configuring a map's distance unit — v4 only reads the existing `config.distance_measure`/`config.distance_name` settings (configured via the legacy map settings form, unchanged by this plan).
- Visual behavior (colors, dash style, tooltip text/format) must match the legacy plugin unchanged.
- Activating the ruler cancels any in-progress pin/circle/area/path draft; selecting a drawing mode while the ruler is active turns the ruler off. Both directions must work.
- No automated test coverage exists for Leaflet canvas interactions in this app — frontend/JS verification is live/manual, matching the established pattern from the polygon/circle/path drawing plans.

---

### Task 1: Expose the map's distance-unit config on the v4 map API

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: `App\Models\Map::hasDistanceUnit(): bool` (existing), `$map->config` (existing, cast to array, keys `distance_measure`/`distance_name`).
- Produces: the v4 map API's `map` object gains `has_distance_unit` (bool), `distance_measure` (float|null), `distance_name` (string) — consumed by Task 3's frontend wiring.

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the existing `assertJsonStructure` call (currently):

```php
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url'],
```

to:

```php
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url', 'has_distance_unit', 'distance_measure', 'distance_name'],
```

Then append two new tests to the end of the same file:

```php
it('exposes the configured distance unit for a map with one set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'config' => ['distance_measure' => 0.5, 'distance_name' => 'Leagues'],
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200);

    expect($response->json('map.has_distance_unit'))->toBeTrue();
    expect($response->json('map.distance_measure'))->toBe(0.5);
    expect($response->json('map.distance_name'))->toBe('Leagues');
});

it('defaults the distance unit name to Km and omits distance_measure for a map with none set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => []]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200);

    expect($response->json('map.has_distance_unit'))->toBeFalse();
    expect($response->json('map.distance_measure'))->toBeNull();
    expect($response->json('map.distance_name'))->toBe('Km');
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="exposes the configured distance unit|defaults the distance unit name|returns the full explore payload"`
Expected: the two new tests FAIL (fields don't exist yet); the existing structure test also FAILS (new keys missing from the actual response).

- [ ] **Step 3: Add the fields to MapResource**

In `app/Http/Resources/Maps/Explore/MapResource.php`, change:

```php
            'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
            'search_url' => route('search.entities-with-relations', $this->campaign->id),
        ];
```

to:

```php
            'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
            'search_url' => route('search.entities-with-relations', $this->campaign->id),
            'has_distance_unit' => $map->hasDistanceUnit(),
            'distance_measure' => $map->config['distance_measure'] ?? null,
            'distance_name' => $map->config['distance_name'] ?? 'Km',
        ];
```

- [ ] **Step 4: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="exposes the configured distance unit|defaults the distance unit name|returns the full explore payload"`
Expected: 3 passed.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Resources/Maps/Explore/MapResource.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: expose a map's configured distance unit on the v4 map API"
```

---

### Task 2: Port the ruler plugin into a local ES module

**Files:**
- Create: `resources/js/leaflet/ruler.js`

**Interfaces:**
- Consumes: `leaflet` (npm package, already a project dependency).
- Produces: `L.control.ruler(options)` (a factory function attached to the shared `L` singleton, matching the legacy plugin's own public API), where `options` is `{ lengthUnit: { factor, display, decimal }, onToggle: (active: boolean) => void }`. Also attaches instance methods `enable()`/`disable()` to the returned control (used by Task 3 to resolve mode conflicts).

- [ ] **Step 1: Create the ported module**

Create `resources/js/leaflet/ruler.js` with exactly this content (ported from `public/vendor/leaflet/leaflet.ruler-kanka.js`, unwrapped from its UMD wrapper into an ES module, with the hardcoded `L.CRS.Simple` replaced by reading the map's own configured CRS, an `onToggle` callback option added, and `enable()`/`disable()` public methods added):

```js
import L from 'leaflet'

L.Control.Ruler = L.Control.extend({
    options: {
        position: 'topright',
        circleMarker: {
            color: 'red',
            radius: 2,
        },
        lineStyle: {
            color: 'red',
            dashArray: '1,6',
        },
        lengthUnit: {
            display: 'km',
            decimal: 2,
            factor: null,
        },
        angleUnit: {
            display: '&deg;',
            decimal: 2,
            factor: null,
        },
        onToggle: null,
    },
    onAdd(map) {
        this._map = map
        this._container = L.DomUtil.create('div', 'leaflet-bar')
        this._container.classList.add('leaflet-ruler')
        L.DomEvent.disableClickPropagation(this._container)
        L.DomEvent.on(this._container, 'click', this._toggleMeasure, this)
        this._choice = false
        this._defaultCursor = this._map._container.style.cursor
        this._allLayers = L.layerGroup()
        this._maxZoom = this._map.getMaxZoom()

        return this._container
    },
    onRemove() {
        L.DomEvent.off(this._container, 'click', this._toggleMeasure, this)
    },
    enable() {
        if (! this._choice) {
            this._toggleMeasure()
        }
    },
    disable() {
        if (this._choice) {
            this._toggleMeasure()
        }
    },
    _toggleMeasure() {
        this._choice = ! this._choice
        this._clickedLatLong = null
        this._clickedPoints = []
        this._totalLength = 0

        if (typeof this.options.onToggle === 'function') {
            this.options.onToggle(this._choice)
        }

        if (this._choice) {
            this._map.doubleClickZoom.disable()
            L.DomEvent.on(this._map._container, 'keydown', this._escape, this)
            L.DomEvent.on(this._map._container, 'dblclick', this._closePath, this)
            this._container.classList.add('leaflet-ruler-clicked')
            this._clickCount = 0
            this._tempLine = L.featureGroup().addTo(this._allLayers)
            this._tempPoint = L.featureGroup().addTo(this._allLayers)
            this._pointLayer = L.featureGroup().addTo(this._allLayers)
            this._polylineLayer = L.featureGroup().addTo(this._allLayers)
            this._allLayers.addTo(this._map)
            this._map._container.style.cursor = 'crosshair'
            this._map.on('click', this._clicked, this)
            this._map.on('mousemove', this._moving, this)
        } else {
            this._map.doubleClickZoom.enable()
            L.DomEvent.off(this._map._container, 'keydown', this._escape, this)
            L.DomEvent.off(this._map._container, 'dblclick', this._closePath, this)
            this._container.classList.remove('leaflet-ruler-clicked')
            this._map.removeLayer(this._allLayers)
            this._allLayers = L.layerGroup()
            this._map._container.style.cursor = this._defaultCursor
            this._map.off('click', this._clicked, this)
            this._map.off('mousemove', this._moving, this)
        }
    },
    _clicked(e) {
        this._clickedLatLong = e.latlng
        this._clickedPoints.push(this._clickedLatLong)
        L.circleMarker(this._clickedLatLong, this.options.circleMarker).addTo(this._pointLayer)

        if (this._clickCount > 0 && ! e.latlng.equals(this._clickedPoints[this._clickedPoints.length - 2])) {
            if (this._movingLatLong) {
                L.polyline([this._clickedPoints[this._clickCount - 1], this._movingLatLong], this.options.lineStyle).addTo(this._polylineLayer)
            }

            let text
            this._totalLength += this._result.Distance

            if (this._clickCount > 1) {
                text = '' + this._totalLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
            } else {
                text = '' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
            }

            L.circleMarker(this._clickedLatLong, this.options.circleMarker).bindTooltip(text, { permanent: true, className: 'result-tooltip', direction: 'top' }).addTo(this._pointLayer).openTooltip()
        }

        this._clickCount++
    },
    _moving(e) {
        if (! this._clickedLatLong) {
            return
        }

        L.DomEvent.off(this._container, 'click', this._toggleMeasure, this)
        this._movingLatLong = e.latlng

        if (this._tempLine) {
            this._map.removeLayer(this._tempLine)
            this._map.removeLayer(this._tempPoint)
        }

        let text
        this._addedLength = 0
        this._tempLine = L.featureGroup()
        this._tempPoint = L.featureGroup()
        this._tempLine.addTo(this._map)
        this._tempPoint.addTo(this._map)
        this._calculateBearingAndDistance()
        this._addedLength = this._result.Distance + this._totalLength
        L.polyline([this._clickedLatLong, this._movingLatLong], this.options.lineStyle).addTo(this._tempLine)

        if (this._clickCount > 1) {
            text = '<b>Distance:</b>&nbsp;' + this._addedLength.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display + '<br><div class="plus-length">(+' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display + ')</div>'
        } else {
            text = '<b>Distance:</b>&nbsp;' + this._result.Distance.toFixed(this.options.lengthUnit.decimal) + '&nbsp;' + this.options.lengthUnit.display
        }

        L.circleMarker(this._movingLatLong, this.options.circleMarker).bindTooltip(text, { sticky: true, className: 'moving-tooltip', direction: 'top' }).addTo(this._tempPoint).openTooltip()
    },
    _escape(e) {
        if (e.keyCode !== 27) {
            return
        }

        if (this._clickCount > 0) {
            this._closePath()
        } else {
            this._choice = true
            this._toggleMeasure()
        }
    },
    _calculateBearingAndDistance() {
        const f1 = this._clickedLatLong.lat
        const l1 = this._clickedLatLong.lng
        const f2 = this._movingLatLong.lat
        const l2 = this._movingLatLong.lng
        const toRadian = Math.PI / 180

        // haversine formula - bearing
        const y = Math.sin((l2 - l1) * toRadian) * Math.cos(f2 * toRadian)
        const x = Math.cos(f1 * toRadian) * Math.sin(f2 * toRadian) - Math.sin(f1 * toRadian) * Math.cos(f2 * toRadian) * Math.cos((l2 - l1) * toRadian)
        let brng = Math.atan2(y, x) * ((this.options.angleUnit.factor ? this.options.angleUnit.factor / 2 : 180) / Math.PI)
        brng += brng < 0 ? (this.options.angleUnit.factor ? this.options.angleUnit.factor : 360) : 0

        // Distance is computed in whatever CRS the map itself uses (CRS.Simple for
        // fantasy/image maps, EPSG3857 by default for real-world maps) so it always
        // matches the map's own projection, instead of the two near-duplicate legacy
        // vendor files (one hardcoded to each CRS).
        const crs = this._map.options.crs || L.CRS.EPSG3857
        const pt1 = crs.latLngToPoint(this._clickedLatLong, this._maxZoom)
        const pt2 = crs.latLngToPoint(this._movingLatLong, this._maxZoom)
        const distance = pt1.distanceTo(pt2) * (this.options.lengthUnit.factor ? this.options.lengthUnit.factor : 1) / this._maxZoom

        this._result = {
            Bearing: brng,
            Distance: distance,
        }
    },
    _closePath() {
        this._map.removeLayer(this._tempLine)
        this._map.removeLayer(this._tempPoint)
        this._choice = false
        L.DomEvent.on(this._container, 'click', this._toggleMeasure, this)
        this._toggleMeasure()
    },
})

L.control.ruler = function (options) {
    return new L.Control.Ruler(options)
}
```

- [ ] **Step 2: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors (this file isn't imported by anything yet — Task 3 wires it up — so this only checks the file's own syntax).

- [ ] **Step 3: Commit**

```bash
git add resources/js/leaflet/ruler.js
git commit -m "feat: port the legacy map ruler plugin into a local ES module for v4"
```

---

### Task 3: Wire the ruler into the v4 canvas with two-way mode conflict resolution

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `L.control.ruler(options)` and its `enable()`/`disable()` methods (Task 2); `props.map.has_distance_unit`/`distance_measure`/`distance_name` (Task 1).
- Produces: a new `measure-change` emit from `LeafletCanvas.vue` (boolean), consumed by `MapExplorer.vue` to clear `activeMode` when measuring starts.

- [ ] **Step 1: Import the ruler module and add the CSS it needs**

In `resources/js/components/maps/LeafletCanvas.vue`, change the imports at the top from:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
```

to:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
import '../../leaflet/ruler.js'
```

Add `measure-change` to the emits list — change:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish'])
```

to:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change'])
```

Add a module-level variable for the ruler control alongside the other draft-state variables — change:

```js
let draftPath = null
let pathEditing = false
```

to:

```js
let draftPath = null
let pathEditing = false
let rulerControl = null
```

At the end of the `<style>` block (after the `.marker-draft .marker-pin` rule, before the closing `</style>`), add the ruler's CSS, ported unchanged from `resources/css/maps/maps.css` (using the literal colour value instead of that file's `--map-ruler-color` variable, since this component doesn't load that shared stylesheet):

```css
.leaflet-ruler {
    height: 48px;
    width: 48px;
    background-image: url(/resources/images/leaflet/icon.png);
    background-repeat: no-repeat;
    background-position: center;
}

.leaflet-ruler:hover {
    background-image: url(/resources/images/leaflet/icon-colored.png);
}

.leaflet-ruler-clicked {
    height: 48px;
    width: 48px;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url(/resources/images/leaflet/icon-colored.png);
}

.result-tooltip {
    background-color: white;
    border-width: medium;
    border-color: #de0000;
    font-size: smaller;
}

.moving-tooltip {
    background-color: rgba(255, 255, 255, .7);
    background-clip: padding-box;
    opacity: 0.5;
    border: dotted;
    border-color: #de0000;
    font-size: smaller;
}

.plus-length {
    padding-left: 45px;
}
```

- [ ] **Step 2: Instantiate the ruler control in `onMounted`, and add it to `onBeforeUnmount`**

In `resources/js/components/maps/LeafletCanvas.vue`, change the end of `onMounted` from:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

to:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()

    if (props.map.has_distance_unit) {
        rulerControl = L.control.ruler({
            lengthUnit: {
                factor: props.map.distance_measure,
                display: props.map.distance_name,
                decimal: 2,
            },
            onToggle: (active) => emit('measure-change', active),
        }).addTo(leafletMap)
    }

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

Change `onBeforeUnmount` from:

```js
onBeforeUnmount(() => {
    document.removeEventListener('keydown', handlePolygonKeydown)
    leafletMap?.remove()
})
```

to:

```js
onBeforeUnmount(() => {
    document.removeEventListener('keydown', handlePolygonKeydown)
    rulerControl = null
    leafletMap?.remove()
})
```

- [ ] **Step 3: Turn the ruler off when a drawing mode becomes active**

In `resources/js/components/maps/LeafletCanvas.vue`, add a new watcher alongside the three existing `watch(() => [props.activeMode, props.draftPin], ...)` blocks (after the path one, before `onMounted`):

```js
watch(() => props.activeMode, (mode) => {
    if (mode && rulerControl) {
        rulerControl.disable()
    }
})
```

- [ ] **Step 4: Clear the active drawing mode when measuring starts**

In `resources/js/components/maps/MapExplorer.vue`, add `@measure-change="handleMeasureChange"` to the `<LeafletCanvas>` tag — change:

```html
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
        />
```

to:

```html
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
        />
```

Add the handler function next to `handleModeChange` — change:

```js
function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
}
```

to:

```js
function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
}

function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
    }
}
```

- [ ] **Step 5: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: wire the ruler control into the v4 map explorer"
```

---

### Task 4: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the new backend tests**

```bash
vendor/bin/sail artisan test --compact --filter="exposes the configured distance unit|defaults the distance unit name|returns the full explore payload"
```

Expected: all passing.

- [ ] **Step 2: Manually exercise the v4 explorer**

Using a real-world (`is_real`) map with a distance unit configured (set `config.distance_measure`/`config.distance_name` via the legacy map settings form, or directly via `vendor/bin/sail artisan tinker`), and a fantasy/image map likewise configured:

1. Open the v4 explorer for the real map — confirm the ruler button appears in the map's corner (independent of whether you're logged in as an editor or a plain viewer — check both).
2. Click the ruler button, click two points on the map, confirm a running distance tooltip appears in the configured unit.
3. Double-click (or press Escape) to finish measuring — confirm the tool exits cleanly and the drawn ruler line/points remain visible until toggled off again.
4. Click the ruler button again to toggle it off — confirm the line/points disappear.
5. Repeat on the fantasy/image map — confirm distance is computed sensibly for that map's own coordinate scale (spot-check against the configured `distance_measure` factor: two points N pixels apart at the map's declared factor should report roughly `N * factor` in the display unit).
6. Start a Pin/Circle/Area/Path draft, then click the ruler button — confirm the in-progress draft is cancelled (its panel closes) and measuring mode starts.
7. Start measuring, then click a toolbar mode (e.g. Pin) — confirm measuring turns off (ruler button no longer shows its "active" state) and the new drawing mode starts cleanly.
8. Confirm a map with NO distance unit configured shows no ruler button at all.
9. Confirm a viewer without edit permission still sees the ruler button (unlike the Pin/Circle/Area/Path toolbar, which should NOT show for them).

- [ ] **Step 3: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 4: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in measurement tool end-to-end verification"
```
