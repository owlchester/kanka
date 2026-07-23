# Map Polygon (Area) Drawing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let users draw, style, and save polygon ("area") map markers in the new v4 map explorer (`resources/js/components/maps/MapExplorer.vue`), reusing the Leaflet.Editable tooling the legacy map page already depends on.

**Architecture:** The Toolbar's existing but unwired "area" mode drives `LeafletCanvas.vue` to start a Leaflet.Editable polygon draw session. Finishing the draw (click on the first vertex, or double-click — both native Leaflet.Editable behaviors) hands a vertex list up to `MapExplorer.vue`, which builds a `draftPin` and opens the existing `MarkerPanel.vue` draft-editing flow, extended with border-colour and stroke-width controls. The polygon stays live-editable while the panel is open. On save, the vertex list is serialized to the legacy `"lat,lng lat,lng"` wire format and posted to the existing (now extended) marker-create endpoint.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API, `<script setup>`), Leaflet 1.9 + `leaflet-editable` (already a dependency), Tailwind v4. No Vue component test harness exists in this repo — pure JS logic is unit tested with Node's built-in `node:test` (see `resources/js/maps/groupTree.js`/`.test.js`), interactive Leaflet/Vue behavior is verified manually.

## Global Constraints

- Scope is the "area" (polygon) toolbar mode only. "circle" and "path" stay unwired stubs, unchanged.
- Editing only applies to the in-progress draft (vertices draggable while `MarkerPanel` is open, before save). No update/PATCH route exists or is added for re-editing an already-saved pin.
- No separate stroke-opacity control — the polygon border always renders fully opaque, independent of fill opacity.
- Stroke-width presets: 1px ("thin"), 3px ("normal"), 6px ("bold"), plus a custom numeric entry (validated 1–20px).
- All new PHP: curly braces on every control structure, explicit return types/param type hints, PHPDoc over inline comments.
- All new UI copy goes through `__()` on the backend (`lang/en/...`) and is threaded through `ExploreApiService::translations()` into the `i18n` prop — never hardcode strings in `.vue` files.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change in a task, before that task's commit.
- All artisan/composer/node(PHP-side)/yarn commands go through `vendor/bin/sail`.

---

### Task 1: Backend — expose and validate polygon geometry/style

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Modify: `app/Http/Requests/StoreMapMarker.php`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`

**Interfaces:**
- Consumes: `App\Models\MapMarker` properties `custom_shape` (string, space-separated `"lat,lng lat,lng ..."`) and `polygon_style` (array, cast on the model already), both already fillable/cast — no model changes.
- Produces: `PinResource::toArray()` now includes `'custom_shape' => array<int, array{0: float, 1: float}>` and `'polygon_style' => array` (defaults to `[]`) in the JSON returned by both `store` and any future `index`/`preview` use of `PinResource`. `StoreMapMarker` now accepts and validates a `polygon_style` array on create.

- [ ] **Step 1: Write the failing feature tests**

Append to `tests/Feature/Entities/Maps/MarkerControllerTest.php` (before the final closing of the file, after the existing `it('422s create when both name and entity_id are missing', ...)` block):

```php
it('creates a polygon marker with custom_shape and polygon_style and returns them in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New area',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 60,
        'shape_id' => 5,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke' => '#123456', 'stroke-width' => 3],
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New area')->firstOrFail();

    expect($response->json('shape'))->toBe('poly');
    expect($response->json('custom_shape'))->toBe([
        [10.5, 20.25],
        [11.75, 21.1],
        [12.25, 19.75],
    ]);
    expect($response->json('polygon_style'))->toBe(['stroke' => '#123456', 'stroke-width' => 3]);
    expect($marker->custom_shape)->toBe('10.500,20.250 11.750,21.100 12.250,19.750');
});

it('422s create when polygon_style has an out-of-range stroke-width', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New area',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 5,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke' => '#123456', 'stroke-width' => 999],
    ])->assertStatus(422);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: FAIL — `custom_shape`/`polygon_style` missing from the JSON response on the first new test; the second new test gets 201 instead of 422 (no rule rejects `stroke-width: 999` yet).

- [ ] **Step 3: Add polygon_style validation to StoreMapMarker**

In `app/Http/Requests/StoreMapMarker.php`, in the `rules()` method, change:

```php
            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',
            'is_draggable' => 'boolean',
```

to:

```php
            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',
            'polygon_style' => 'nullable|array',
            'polygon_style.stroke' => 'nullable|string|max:7',
            'polygon_style.stroke-width' => 'nullable|integer|min:1|max:20',
            'is_draggable' => 'boolean',
```

- [ ] **Step 4: Expose custom_shape/polygon_style from PinResource**

In `app/Http/Resources/Maps/Explore/PinResource.php`, change the `toArray()` method from:

```php
    public function toArray(Request $request): array
    {
        $marker = $this->resource;

        return [
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'group_id' => $marker->group_id,
            'latitude' => (float) $marker->latitude,
            'longitude' => (float) $marker->longitude,
            'shape' => $marker->shape_id?->name ?? 'marker',
            'colour' => $marker->colour,
            'font_colour' => $marker->font_colour,
            'icon' => $marker->exploreIcon(),
            'size_id' => $marker->size_id,
            'pin_size' => $marker->pin_size,
            'circle_radius' => $marker->circle_radius,
            'opacity' => (float) ($marker->opacity ?: 100),
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
        ];
    }
```

to:

```php
    public function toArray(Request $request): array
    {
        $marker = $this->resource;

        return [
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'group_id' => $marker->group_id,
            'latitude' => (float) $marker->latitude,
            'longitude' => (float) $marker->longitude,
            'shape' => $marker->shape_id?->name ?? 'marker',
            'colour' => $marker->colour,
            'font_colour' => $marker->font_colour,
            'icon' => $marker->exploreIcon(),
            'size_id' => $marker->size_id,
            'pin_size' => $marker->pin_size,
            'circle_radius' => $marker->circle_radius,
            'opacity' => (float) ($marker->opacity ?: 100),
            'custom_shape' => $this->polygonPoints($marker->custom_shape),
            'polygon_style' => $marker->polygon_style ?? [],
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
        ];
    }

    /**
     * Parse the raw "lat,lng lat,lng ..." custom_shape string (see MapMarker::marker()) into
     * an array of [lat, lng] float pairs for the Vue map explorer.
     *
     * @return array<int, array{0: float, 1: float}>
     */
    private function polygonPoints(?string $customShape): array
    {
        if (empty($customShape)) {
            return [];
        }

        $points = [];
        $segments = explode(' ', str_replace("\r\n", ' ', trim($customShape)));
        foreach ($segments as $segment) {
            $coords = explode(',', $segment);
            if (isset($coords[0], $coords[1]) && $coords[0] !== '' && $coords[1] !== '') {
                $points[] = [(float) $coords[0], (float) $coords[1]];
            }
        }

        return $points;
    }
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: PASS (all tests in the file, including the two new ones and the pre-existing ones).

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps/Explore/PinResource.php app/Http/Requests/StoreMapMarker.php tests/Feature/Entities/Maps/MarkerControllerTest.php
git commit -m "feat: expose and validate polygon geometry/style for map markers"
```

---

### Task 2: Frontend — polygon math helpers

**Files:**
- Create: `resources/js/maps/polygon.js`
- Create: `resources/js/maps/polygon.test.js`

**Interfaces:**
- Consumes: nothing (pure functions).
- Produces: `centroid(vertices: Array<[number, number]>): [number, number]` and `serializeVertices(vertices: Array<[number, number]>): string`, both imported later by `MapExplorer.vue` (Task 7) and `MarkerPanel.vue` (Task 6). `vertices` is always an array of `[lat, lng]` number pairs — this is the same shape `PinResource` returns for `custom_shape` (Task 1) and the shape `LeafletCanvas.vue` emits from its polygon events (Task 4).

- [ ] **Step 1: Write the failing tests**

Create `resources/js/maps/polygon.test.js`:

```js
import { test } from 'node:test'
import assert from 'node:assert/strict'
import { centroid, serializeVertices } from './polygon.js'

test('centroid averages the vertex coordinates', () => {
    const result = centroid([
        [0, 0],
        [10, 0],
        [10, 10],
        [0, 10],
    ])

    assert.deepEqual(result, [5, 5])
})

test('centroid handles a single vertex', () => {
    assert.deepEqual(centroid([[3, 4]]), [3, 4])
})

test('serializeVertices formats pairs to 3 decimals and joins with spaces', () => {
    const result = serializeVertices([
        [10, 20],
        [11.2, 21.7],
    ])

    assert.equal(result, '10.000,20.000 11.200,21.700')
})
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `node --test resources/js/maps/polygon.test.js`
Expected: FAIL — `polygon.js` does not exist yet (module not found).

- [ ] **Step 3: Implement the helpers**

Create `resources/js/maps/polygon.js`:

```js
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
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `node --test resources/js/maps/polygon.test.js`
Expected: PASS (3 tests).

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/polygon.js resources/js/maps/polygon.test.js
git commit -m "feat: add polygon centroid and vertex-serialization helpers"
```

---

### Task 3: Render saved polygon pins in LeafletCanvas

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue:92-147`

**Interfaces:**
- Consumes: `pin.shape === 'poly'` pins from `props.pins`, with `pin.custom_shape: Array<[number, number]>` and `pin.polygon_style: {stroke?: string, 'stroke-width'?: number}` (both now present per Task 1's `PinResource`).
- Produces: `buildPin(pin)` now returns an `L.polygon` layer for `shape === 'poly'` pins instead of being filtered out. No new exports — internal to the file.

- [ ] **Step 1: Remove the poly filter and add polygon rendering**

In `resources/js/components/maps/LeafletCanvas.vue`, change `buildPin` from:

```js
function buildPin(pin) {
    if (pin.shape === 'circle') {
```

to:

```js
function buildPin(pin) {
    if (pin.shape === 'poly') {
        const latlngs = pin.custom_shape || pin.customShape || []
        const style = pin.polygon_style || pin.polygonStyle || {}

        return L.polygon(latlngs, {
            color: style.stroke || pin.colour || '#ccc',
            weight: style['stroke-width'] || 1,
            fillColor: pin.colour || '#ccc',
            fillOpacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'circle') {
```

Then change `buildPins` from:

```js
    // Polygon pins are out of scope for v1 (see design doc) — skip rather than mis-render at the wrong spot
    props.pins.filter((pin) => pin.shape !== 'poly').forEach((pin) => {
```

to:

```js
    props.pins.forEach((pin) => {
```

- [ ] **Step 2: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors (this file has no automated test harness — full behavioral verification happens in Task 8's manual pass, once a polygon can actually be drawn/saved).

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: render saved polygon pins on the map explorer canvas"
```

---

### Task 4: Wire polygon drawing/editing lifecycle in LeafletCanvas

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `props.activeMode === 'area'` (set by the existing Toolbar/`handleModeChange` in `MapExplorer.vue` — no change needed there), `props.draftPin` (existing prop).
- Produces: two new emits — `polygon-change(vertices: Array<[number, number]>)` fired continuously while a vertex is added or dragged, and `polygon-finish(vertices: Array<[number, number]>)` fired once when the draw is finished (click on first vertex, double-click, or other native Leaflet.Editable finish gesture). Consumed by `MapExplorer.vue` in Task 7.

- [ ] **Step 1: Import leaflet-editable and enable it on the map**

Change the imports at the top of `resources/js/components/maps/LeafletCanvas.vue` from:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
```

to:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
```

Change the `defineEmits` line from:

```js
const emit = defineEmits(['pin-click', 'map-click'])
```

to:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish'])
```

Add a new local variable alongside the existing `let pinLayer = null` / `let draftMarker = null`:

```js
let draftPolygon = null
let polygonEditing = false
```

In `onMounted`, change the map options object from:

```js
    const options = {
        zoom: props.map.initial_zoom,
        minZoom: props.map.min_zoom,
        maxZoom: props.map.max_zoom,
        center: props.map.center,
        attributionControl: false,
        zoomControl: false,
    }
```

to:

```js
    const options = {
        zoom: props.map.initial_zoom,
        minZoom: props.map.min_zoom,
        maxZoom: props.map.max_zoom,
        center: props.map.center,
        attributionControl: false,
        zoomControl: false,
        editable: true,
    }
```

- [ ] **Step 2: Skip the draft-marker path for polygon drafts, add polygon draft functions**

Change `buildDraftMarker` (added in Task 3's file, unmodified otherwise) from:

```js
function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin) {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)
}
```

to:

```js
function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin || props.draftPin.shape === 'poly') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)
}

function polygonLatLngs() {
    if (! draftPolygon) {
        return []
    }

    const rings = draftPolygon.getLatLngs()

    return (rings[0] || []).map((point) => [point.lat, point.lng])
}

function styleDraftPolygon() {
    if (! draftPolygon || ! props.draftPin) {
        return
    }

    const style = props.draftPin.polygonStyle || {}

    draftPolygon.setStyle({
        color: style.stroke || props.draftPin.colour || '#ccc',
        weight: style['stroke-width'] || 1,
        fillColor: props.draftPin.colour || '#ccc',
        fillOpacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startPolygonDraft() {
    draftPolygon = leafletMap.editTools.startPolygon()
    polygonEditing = false

    draftPolygon.on('editable:vertex:new editable:vertex:dragend editable:dragend', () => {
        emit('polygon-change', polygonLatLngs())
    })

    draftPolygon.on('editable:drawing:end', () => {
        polygonEditing = true
        emit('polygon-finish', polygonLatLngs())
    })
}

function stopPolygonDraft() {
    if (! draftPolygon) {
        return
    }

    draftPolygon.disableEdit()
    leafletMap.removeLayer(draftPolygon)
    draftPolygon = null
    polygonEditing = false
}
```

- [ ] **Step 3: React to activeMode/draftPin changes**

Change the existing `watch(() => props.draftPin, ...)` block from:

```js
watch(() => props.draftPin, () => {
    if (leafletMap) {
        buildDraftMarker()
    }
})
```

to:

```js
watch(() => props.draftPin, (pin) => {
    if (! leafletMap) {
        return
    }

    buildDraftMarker()

    if (pin?.shape === 'poly') {
        styleDraftPolygon()
    }
})

watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'area') {
        stopPolygonDraft()

        return
    }

    if (! props.draftPin && polygonEditing) {
        stopPolygonDraft()
        startPolygonDraft()

        return
    }

    if (! draftPolygon) {
        startPolygonDraft()
    }
})
```

(Leave the `watch(() => props.centerNonce, ...)` and `watch(() => props.pins, ...)` blocks untouched.)

- [ ] **Step 4: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors. Full interactive verification happens in Task 8.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: wire Leaflet.Editable polygon draw/edit lifecycle into map canvas"
```

---

### Task 5: Generalize ColourPicker for reuse (fill + border)

**Files:**
- Modify: `resources/js/components/maps/ColourPicker.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue` (update its one existing `<ColourPicker>` usage)

**Interfaces:**
- Consumes: nothing new.
- Produces: `ColourPicker.vue` props change from `{pin: Object, i18n: Object}` to `{colour: String|null, label: String}`, emit unchanged (`change`, payload is the hex string). Task 6 adds a second `<ColourPicker>` instance (border colour) using these same props.

- [ ] **Step 1: Change ColourPicker's props and internal references**

In `resources/js/components/maps/ColourPicker.vue`, change the props block from:

```js
const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
});
```

to:

```js
const props = defineProps({
    colour: { type: String, default: null },
    label: { type: String, required: true },
});
```

Change every other reference to `props.pin.colour` to `props.colour`:

- `isSelected(swatch)`: `return props.pin.colour?.toLowerCase() === swatch.toLowerCase();` → `return props.colour?.toLowerCase() === swatch.toLowerCase();`
- `onMounted`: `colorisInput.value.value = props.pin.colour || "";` → `colorisInput.value.value = props.colour || "";`
- `watch(() => props.pin.colour, (colour) => {` → `watch(() => props.colour, (colour) => {`

Change the template label from:

```html
<label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.colour }}</label>
```

to:

```html
<label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ label }}</label>
```

- [ ] **Step 2: Update MarkerPanel's existing usage**

In `resources/js/components/maps/MarkerPanel.vue`, change:

```html
            <ColourPicker
                v-if="mode === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('colour-change', $event)"
            />
```

to:

```html
            <ColourPicker
                v-if="mode === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />
```

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/ColourPicker.vue resources/js/components/maps/MarkerPanel.vue
git commit -m "refactor: generalize ColourPicker so it can be reused for border colour"
```

---

### Task 6: Border colour + stroke width fields in MarkerPanel

**Files:**
- Create: `resources/js/components/maps/StrokeWidthPicker.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`

**Interfaces:**
- Consumes: `pin.polygonStyle: {stroke?: string, 'stroke-width'?: number}` (set by `MapExplorer.vue` in Task 7), `serializeVertices` from `resources/js/maps/polygon.js` (Task 2).
- Produces: `MarkerPanel.vue` emits two new events — `border-colour-change(hex: string)` and `stroke-width-change(px: number)` — consumed by `MapExplorer.vue` in Task 7. `save()`'s POST payload gains `custom_shape` (string) and `polygon_style` (object) when `pin.shape === 'poly'`.

- [ ] **Step 1: Add new i18n keys**

In `lang/en/maps/explorer.php`, change the `'marker'` array from:

```php
    'marker'    => [
        'center'            => 'Center',
        'delete'            => 'Delete marker',
        'delete_confirm'    => 'Click again to confirm',
        'duplicate'         => 'Duplicate',
        'edit'              => 'Edit details',
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'new_pin'           => 'New pin',
        'name_placeholder'  => 'Name this pin...',
        'save'              => 'Save',
        'details'           => 'Details',
        'less'              => 'Less',
        'shape'             => 'Shape',
        'group'             => 'Group',
        'none'              => 'None',
        'visibility'        => 'Visibility',
        'colour'            => 'Colour',
        'opacity'           => 'Opacity',
        'custom'            => 'Custom',
        'premium_custom_icon' => 'Unlock custom pins with a premium campaign',
    ],
```

to:

```php
    'marker'    => [
        'center'            => 'Center',
        'delete'            => 'Delete marker',
        'delete_confirm'    => 'Click again to confirm',
        'duplicate'         => 'Duplicate',
        'edit'              => 'Edit details',
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'new_pin'           => 'New pin',
        'name_placeholder'  => 'Name this pin...',
        'save'              => 'Save',
        'details'           => 'Details',
        'less'              => 'Less',
        'shape'             => 'Shape',
        'group'             => 'Group',
        'none'              => 'None',
        'visibility'        => 'Visibility',
        'colour'            => 'Colour',
        'opacity'           => 'Opacity',
        'custom'            => 'Custom',
        'premium_custom_icon' => 'Unlock custom pins with a premium campaign',
        'border_colour'     => 'Border colour',
        'stroke_width'      => 'Border width',
        'stroke_thin'       => 'Thin',
        'stroke_normal'     => 'Normal',
        'stroke_bold'       => 'Bold',
    ],
```

- [ ] **Step 2: Thread the new keys through ExploreApiService**

In `app/Services/Maps/ExploreApiService.php`, in `translations()`, change:

```php
            'colour' => __('maps/explorer.marker.colour'),
            'opacity' => __('maps/explorer.marker.opacity'),
```

to:

```php
            'colour' => __('maps/explorer.marker.colour'),
            'border_colour' => __('maps/explorer.marker.border_colour'),
            'stroke_width' => __('maps/explorer.marker.stroke_width'),
            'stroke_thin' => __('maps/explorer.marker.stroke_thin'),
            'stroke_normal' => __('maps/explorer.marker.stroke_normal'),
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
            'opacity' => __('maps/explorer.marker.opacity'),
```

- [ ] **Step 3: Create StrokeWidthPicker.vue**

Create `resources/js/components/maps/StrokeWidthPicker.vue`:

```vue
<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.stroke_width }}</label>

        <input
            v-if="customMode"
            v-model="customText"
            type="number"
            min="1"
            max="20"
            class="input input-bordered w-full"
            autofocus
            @keydown.tab="commitCustom"
            @keydown.enter="commitCustom"
            @blur="commitCustom"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="preset in presets"
                :key="preset.value"
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="width === preset.value ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="selectPreset(preset.value)"
            >
                {{ preset.label }}
            </button>

            <button
                type="button"
                class="rounded-lg px-2 h-9 cursor-pointer border-2 text-xs"
                :class="isCustom ? 'bg-accent text-accent-content border-accent' : 'bg-base-200 border-transparent'"
                @click="clickCustom"
            >
                {{ isCustom ? `${width}px` : i18n.custom }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    width: { type: Number, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const PRESET_VALUES = [1, 3, 6];

const presets = computed(() => [
    { value: 1, label: props.i18n.stroke_thin },
    { value: 3, label: props.i18n.stroke_normal },
    { value: 6, label: props.i18n.stroke_bold },
]);

const customMode = ref(false);
const customText = ref("");

const isCustom = computed(() => !PRESET_VALUES.includes(props.width));

function selectPreset(value) {
    emit("change", value);
}

function clickCustom() {
    customText.value = String(props.width ?? 1);
    customMode.value = true;
}

function commitCustom() {
    if (!customMode.value) {
        return;
    }

    customMode.value = false;

    const trimmed = customText.value.trim();
    const parsed = Math.round(Number(trimmed));
    const value = trimmed === "" || Number.isNaN(parsed) ? 1 : Math.min(20, Math.max(1, parsed));

    emit("change", value);
}
</script>
```

- [ ] **Step 4: Wire the new fields and save() payload into MarkerPanel.vue**

In `resources/js/components/maps/MarkerPanel.vue`, change the imports from:

```js
import { ref, watch } from "vue";
import ColourPicker from "./ColourPicker.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
import ShapePicker from "./ShapePicker.vue";
import VisibilitySelect from "./VisibilitySelect.vue";
```

to:

```js
import { ref, watch } from "vue";
import { serializeVertices } from "../../maps/polygon.js";
import ColourPicker from "./ColourPicker.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
import GroupPicker from "./GroupPicker.vue";
import OpacityPicker from "./OpacityPicker.vue";
import ShapePicker from "./ShapePicker.vue";
import StrokeWidthPicker from "./StrokeWidthPicker.vue";
import VisibilitySelect from "./VisibilitySelect.vue";
```

Change the `defineEmits` list from:

```js
const emit = defineEmits([
    "close",
    "created",
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
]);
```

to:

```js
const emit = defineEmits([
    "close",
    "created",
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
    "border-colour-change",
    "stroke-width-change",
]);
```

In the template, change:

```html
            <ColourPicker
                v-if="mode === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />
```

to:

```html
            <ColourPicker
                v-if="mode === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />

            <ColourPicker
                v-if="mode === 'full' && pin.shape === 'poly'"
                :colour="pin.polygonStyle?.stroke"
                :label="i18n.border_colour"
                @change="$emit('border-colour-change', $event)"
            />

            <StrokeWidthPicker
                v-if="mode === 'full' && pin.shape === 'poly'"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />
```

Change `save()` from:

```js
async function save() {
    saving.value = true;
    error.value = null;

    try {
        const res = await axios.post(props.createUrl, {
            name: name.value,
            latitude: props.pin.latitude,
            longitude: props.pin.longitude,
            colour: props.pin.colour,
            shape_id: props.pin.shapeId,
            icon: props.pin.iconId,
            custom_icon: props.pin.customIcon,
            group_id: props.pin.groupId,
            entity_id: props.pin.entityId,
            visibility_id: props.pin.visibilityId,
            opacity: props.pin.opacity,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
```

to:

```js
async function save() {
    saving.value = true;
    error.value = null;

    try {
        const isPolygon = props.pin.shape === "poly";
        const res = await axios.post(props.createUrl, {
            name: name.value,
            latitude: props.pin.latitude,
            longitude: props.pin.longitude,
            colour: props.pin.colour,
            shape_id: props.pin.shapeId,
            icon: props.pin.iconId,
            custom_icon: props.pin.customIcon,
            group_id: props.pin.groupId,
            entity_id: props.pin.entityId,
            visibility_id: props.pin.visibilityId,
            opacity: props.pin.opacity,
            custom_shape: isPolygon ? serializeVertices(props.pin.customShape) : undefined,
            polygon_style: isPolygon ? props.pin.polygonStyle : undefined,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
```

- [ ] **Step 5: Verify PHP formatting and frontend build**

```bash
vendor/bin/sail bin pint --dirty --format agent
vendor/bin/sail yarn run build
```

Expected: no formatting changes needed beyond what Pint applies automatically; build succeeds.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/StrokeWidthPicker.vue resources/js/components/maps/MarkerPanel.vue lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php
git commit -m "feat: add border colour and stroke width fields to the marker panel"
```

---

### Task 7: Wire the draw flow into MapExplorer

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `polygon-change`/`polygon-finish` events from `LeafletCanvas.vue` (Task 4), `border-colour-change`/`stroke-width-change` events from `MarkerPanel.vue` (Task 6), `centroid` from `resources/js/maps/polygon.js` (Task 2).
- Produces: a `draftPin` with `shape: 'poly'`, `shapeId: 5`, `customShape: Array<[number, number]>`, `polygonStyle: {stroke, 'stroke-width'}` — matching what `LeafletCanvas.vue` (Task 3/4) and `MarkerPanel.vue` (Task 6) expect.

- [ ] **Step 1: Import centroid and wire new template events**

Change the imports from:

```js
import { ref, computed, onMounted } from "vue";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";
```

to:

```js
import { ref, computed, onMounted } from "vue";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";
```

In the template, change the `<LeafletCanvas>` tag from:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            @pin-click="selectPin"
            @map-click="handleMapClick"
        />
```

to:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
        />
```

Change the `<MarkerPanel>` tag from:

```html
        <MarkerPanel
            :pin="draftPin"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :visibilities="data.visibilities"
            @close="draftPin = null"
            @created="onPinCreated"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
            @name-change="handleNameChange"
        />
```

to:

```html
        <MarkerPanel
            :pin="draftPin"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :visibilities="data.visibilities"
            @close="draftPin = null"
            @created="onPinCreated"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
            @name-change="handleNameChange"
            @border-colour-change="handleBorderColourChange"
            @stroke-width-change="handleStrokeWidthChange"
        />
```

- [ ] **Step 2: Add the new handlers**

In `resources/js/components/maps/MapExplorer.vue`, change:

```js
function handleOpacityChange(opacity) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, opacity };
}

function onPinCreated(pin) {
```

to:

```js
function handleOpacityChange(opacity) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, opacity };
}

const DEFAULT_STROKE_WIDTH = 1;

function handlePolygonFinish(vertices) {
    const [lat, lng] = centroid(vertices);

    draftPin.value = {
        name: "",
        colour: defaultColour(),
        shape: "poly",
        shapeId: 5,
        customShape: vertices,
        polygonStyle: { stroke: defaultColour(), "stroke-width": DEFAULT_STROKE_WIDTH },
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: 100,
        latitude: lat,
        longitude: lng,
    };
}

function handlePolygonChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function handleBorderColourChange(colour) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, stroke: colour } };
}

function handleStrokeWidthChange(width) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, "stroke-width": width } };
}

function onPinCreated(pin) {
```

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: wire polygon draw/edit events into the map explorer draft flow"
```

---

### Task 8: End-to-end verification

**Files:** none (verification only).

**Interfaces:** none — this task exercises the full stack built in Tasks 1–7.

- [ ] **Step 1: Run the full backend test suite for touched areas**

```bash
vendor/bin/sail artisan test --compact --filter=MarkerControllerTest
```

Expected: all tests pass.

- [ ] **Step 2: Run the frontend unit tests**

```bash
node --test resources/js/maps/polygon.test.js resources/js/maps/groupTree.test.js
```

Expected: all tests pass (both this feature's new tests and the pre-existing suite, to confirm nothing else broke).

- [ ] **Step 3: Build and manually exercise the feature**

```bash
vendor/bin/sail yarn run build
```

Then, using a boosted-campaign admin account (polygon markers are hidden on reload for non-boosted campaigns per `MapMarker::visible()` — pre-existing, unrelated to this feature):

1. Open a map's v4 explore page.
2. Click the "Area" toolbar button.
3. Click 3–4 points on the map, then double-click (or click the first vertex again) to finish the shape.
4. Confirm the `MarkerPanel` opens with the polygon still visible and its vertices draggable — drag one and confirm the shape updates live.
5. Name the pin, click "Details" to expand to full mode, and confirm Colour, Border colour, Border width (Thin/Normal/Bold/custom), Opacity, Group, Visibility all render.
6. Pick a border colour and the "Bold" stroke width preset, then Save.
7. Confirm the polygon renders on the map with the chosen fill and border styling, and the marker count in the header increments.
8. Refresh the page and confirm the polygon reloads identically (round-trips through the backend from Task 1).
9. Click "Area" again, start a polygon, and close the panel without saving (`✕`) — confirm the map is immediately ready to draw a new polygon on the next click.

- [ ] **Step 4: Fix forward if any manual check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 4)**

```bash
git add -A
git commit -m "fix: address issues found in polygon drawing end-to-end verification"
```
