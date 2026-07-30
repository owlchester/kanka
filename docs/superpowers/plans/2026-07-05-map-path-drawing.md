# Map Path Drawing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Wire up the Toolbar's existing but unwired "path" mode in the new map explorer, fix the legacy map page so path markers actually render (they currently fall through to a generic pin — paths have never worked there), and let an existing path be edited (not created) on the legacy marker edit form.

**Architecture:** A path is architecturally "a polygon that isn't closed" — Leaflet.Editable's `startPolyline()` is a real, separate method from `startPolygon()`, inheriting `CLOSED: false, MIN_VERTEX: 2` instead of polygon's `CLOSED: true, MIN_VERTEX: 3`, but firing the exact same `editable:vertex:new`/`editable:vertex:dragend`/`editable:drawing:commit` events. `custom_shape`, `PinResource`, and `StoreMapMarker`'s validation are already fully shape-agnostic, so no backend schema changes are needed — a path reuses all three unchanged. This plan adds: (1) a `marker()` render branch on the backend model so paths finally render (as `L.polyline`) everywhere the legacy page already embeds marker JS; (2) a v4 draft lifecycle in `LeafletCanvas.vue`/`MapExplorer.vue`/`MarkerPanel.vue` mirroring the existing polygon/circle ones; (3) a path tab on the legacy edit form (shown only when editing an existing path marker, never on create) reusing the same Leaflet.Editable wiring the polygon tab already has.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API, `<script setup>`), Leaflet 1.9 + `leaflet-editable`, vanilla JS (`resources/js/location/map-v3.js`) for the legacy page.

## Global Constraints

- No path creation entry point anywhere on the legacy map page — paths can only be created via the new v4 explorer.
- A path has exactly one colour (the line itself) — no separate "border colour" field. Reuses the existing `StrokeWidthPicker` component for line thickness and the existing plain `colour` field for the line's colour.
- No changes to `custom_shape`'s wire format, `PinResource`, or `StoreMapMarker` validation — already fully shape-agnostic, reused unchanged.
- No changes to `app/Models/MapMarker.php`'s `circleRadius()` or any circle/polygon-specific rendering method other than adding the new `isPath()` branch to `marker()`.
- No new premium/boost gating for paths — the existing polygon tab in the legacy form is gated behind `$campaign->boosted()`; paths are not (this is a deliberate scope decision for this plan, not an oversight — flag if you believe path markers should be premium-gated too, but do not add it silently).
- `L.Polyline.getLatLngs()` returns a **flat** array of points; `L.Polygon.getLatLngs()` returns a **nested** array (`[[point, point, ...]]`, one ring). Any code reused between the two shapes must account for this difference explicitly — do not assume they share the same vertex-extraction logic.
- All new PHP: curly braces on every control structure, explicit return types/param type hints, PHPDoc over inline comments.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change in a task, before that task's commit.
- All artisan/composer/node(PHP-side)/yarn commands go through `vendor/bin/sail`.

---

### Task 1: Backend — render paths as L.polyline and prove it

**Files:**
- Modify: `app/Models/MapMarker.php`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`
- Create: `tests/Feature/Entities/Maps/MapMarkerPathRenderTest.php`

**Interfaces:**
- Consumes: nothing new — `custom_shape`, `polygon_style`, `colour`, `opacity` are all already fillable/cast on `MapMarker` and already validated/exposed by `StoreMapMarker`/`PinResource`.
- Produces: `MapMarker::marker()` now returns an `L.polyline(...)` JS string for a path-shaped marker with a non-empty `custom_shape`, instead of falling through to the generic `L.marker(...)` pin. `MapMarker::isPath()` now also requires a non-empty `custom_shape`, matching `isPolygon()`'s existing pattern — a path with no shape data yet still renders as a plain pin (this affects `exploreIcon()` and `typeLabel()` too, which already call `isPath()`, but only changes their behavior for the edge case of a path with no `custom_shape`, which previously couldn't happen in practice since paths never rendered at all).

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/MapMarkerPathRenderTest.php`:

```php
<?php

use App\Models\Map;
use App\Models\MapMarker;

it('renders a path marker as an L.polyline, not a generic pin', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 6,
        'custom_shape' => '10.000,20.000 11.000,21.000',
        'colour' => '#f2c14e',
    ]);

    expect($marker->marker())->toContain('L.polyline([[10.000, 20.000], [11.000, 21.000]]');
});

it('falls back to a generic pin when a path marker has no custom_shape yet', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 6,
    ]);

    expect($marker->marker())->toContain('L.marker([');
});
```

Append to `tests/Feature/Entities/Maps/MarkerControllerTest.php` (after the existing polygon/circle tests, before the final closing of the file):

```php
it('creates a path marker with custom_shape and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New path',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 75,
        'shape_id' => 6,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke-width' => 4],
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New path')->firstOrFail();

    expect($response->json('shape'))->toBe('path');
    expect($response->json('custom_shape'))->toBe([
        [10.5, 20.25],
        [11.75, 21.1],
        [12.25, 19.75],
    ]);
    expect($marker->custom_shape)->toBe('10.500,20.250 11.750,21.100 12.250,19.750');
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="renders a path marker|falls back to a generic pin|creates a path marker"`
Expected: FAIL — `marker()` has no `isPath()` branch yet, so a path marker's JS string starts with `L.marker(` even when `custom_shape` is set; the `MarkerControllerTest` case should already pass (nothing backend-specific is missing for the store/PinResource round-trip), but run it alongside the other two to confirm the render test fails first given `phpunit.xml`'s `stopOnFailure=true`.

- [ ] **Step 3: Tighten isPath() to match isPolygon()'s pattern**

In `app/Models/MapMarker.php`, change:

```php
    /**
     * Determine if the marker is of the path type
     */
    public function isPath(): bool
    {
        return $this->shape_id === MapMarkerShape::path;
    }
```

to:

```php
    /**
     * Determine if the marker is of the path type and has a custom shape
     */
    public function isPath(): bool
    {
        return $this->shape_id === MapMarkerShape::path && ! empty($this->custom_shape);
    }
```

- [ ] **Step 4: Add the isPath() render branch to marker()**

In `app/Models/MapMarker.php`, change `marker()` from:

```php
    public function marker(): string
    {
        if ($this->isCircle()) {
            return $this->circleMarker();
        } elseif ($this->isLabel()) {
            return $this->labelMarker();
        } elseif ($this->isPolygon()) {
            $coords = [];
            $segments = explode(' ', str_replace("\r\n", ' ', $this->custom_shape));
            foreach ($segments as $segment) {
                $coord = explode(',', $segment);
                if (! empty($coord[0]) && ! empty($coord[1])) {
                    $coords[] = '[' . $coord[0] . ', ' . Str::before($coord[1], ' ') . ']';
                }
            }

            return 'L.polygon([' . implode(', ', $coords) . '], {
                color: \'' . Arr::get($this->polygon_style, 'stroke', $this->colour) . '\',
                weight: ' . max(1, Arr::get($this->polygon_style, 'stroke-width', 1)) . ',
                opacity: ' . $this->strokeOpacity() . ',
                fillOpacity: ' . $this->floatOpacity() . ',
                fillColor: \'' . e($this->colour) . '\',
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\',
            })' . $this->popup();
            // ' . ($this->editing ? 'draggable: true,' : null) . '
        }

        return 'L.marker([' . $this->latitude . ', ' . $this->longitude . '], {
            title: \'' . $this->markerTitle() . '\',
            opacity: ' . $this->floatOpacity() . ','
            . ($this->isDraggable() ? 'draggable: true,' : null) . '
            ' . $this->markerIcon() . '
        })' . $this->popup() . $this->draggable();
    }
```

to:

```php
    public function marker(): string
    {
        if ($this->isCircle()) {
            return $this->circleMarker();
        } elseif ($this->isLabel()) {
            return $this->labelMarker();
        } elseif ($this->isPolygon()) {
            return 'L.polygon([' . implode(', ', $this->parsedShapeCoordinates()) . '], {
                color: \'' . Arr::get($this->polygon_style, 'stroke', $this->colour) . '\',
                weight: ' . max(1, Arr::get($this->polygon_style, 'stroke-width', 1)) . ',
                opacity: ' . $this->strokeOpacity() . ',
                fillOpacity: ' . $this->floatOpacity() . ',
                fillColor: \'' . e($this->colour) . '\',
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\',
            })' . $this->popup();
            // ' . ($this->editing ? 'draggable: true,' : null) . '
        } elseif ($this->isPath()) {
            return 'L.polyline([' . implode(', ', $this->parsedShapeCoordinates()) . '], {
                color: \'' . e($this->colour) . '\',
                weight: ' . max(1, Arr::get($this->polygon_style, 'stroke-width', 1)) . ',
                opacity: ' . $this->floatOpacity() . ',
                smoothFactor: 1,
                linecap: \'round\',
                linejoin: \'round\',
            })' . $this->popup();
        }

        return 'L.marker([' . $this->latitude . ', ' . $this->longitude . '], {
            title: \'' . $this->markerTitle() . '\',
            opacity: ' . $this->floatOpacity() . ','
            . ($this->isDraggable() ? 'draggable: true,' : null) . '
            ' . $this->markerIcon() . '
        })' . $this->popup() . $this->draggable();
    }

    /**
     * Parse the raw "lat,lng lat,lng ..." custom_shape string (shared by polygon and path
     * markers) into an array of "[lat, lng]" JS coordinate literals.
     *
     * @return array<int, string>
     */
    private function parsedShapeCoordinates(): array
    {
        $coords = [];
        $segments = explode(' ', str_replace("\r\n", ' ', $this->custom_shape));
        foreach ($segments as $segment) {
            $coord = explode(',', $segment);
            if (! empty($coord[0]) && ! empty($coord[1])) {
                $coords[] = '[' . $coord[0] . ', ' . Str::before($coord[1], ' ') . ']';
            }
        }

        return $coords;
    }
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="renders a path marker|falls back to a generic pin|creates a path marker"`
Expected: all 3 PASS.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapMarker.php tests/Feature/Entities/Maps/MarkerControllerTest.php tests/Feature/Entities/Maps/MapMarkerPathRenderTest.php
git commit -m "feat: render path markers as L.polyline instead of a generic pin"
```

---

### Task 2: Wire the path draw/edit lifecycle in LeafletCanvas

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `props.activeMode === 'path'`, `props.draftPin`, `props.defaultPolygonStyle` (existing prop, reused for the path draft's default colour/opacity — its `stroke`/`stroke-width` fields double as the path's line colour/width defaults).
- Produces: two new emits — `path-change(vertices: Array<[number, number]>)` fired on vertex add/drag, and `path-finish(vertices: Array<[number, number]>)` fired once when the draw commits. Also renders saved path pins (`pin.shape === 'path'`) via `buildPin()`.

- [ ] **Step 1: Render saved path pins**

In `resources/js/components/maps/LeafletCanvas.vue`, change `buildPin()` from:

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

    if (pin.shape === 'path') {
        const latlngs = pin.custom_shape || pin.customShape || []
        const style = pin.polygon_style || pin.polygonStyle || {}

        return L.polyline(latlngs, {
            color: pin.colour || '#ccc',
            weight: style['stroke-width'] || 1,
            opacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'circle') {
```

- [ ] **Step 2: Add path-change/path-finish to the emits list and new state**

Change:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish'])
```

to:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish'])
```

Add new state alongside the existing `let draftCircle = null` / `let circleEditing = false`:

```js
let draftPath = null
let pathEditing = false
```

- [ ] **Step 3: Skip the draft-marker path for path drafts too**

Change `buildDraftMarker` from:

```js
    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle') {
        return
    }
```

to:

```js
    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle' || props.draftPin.shape === 'path') {
        return
    }
```

- [ ] **Step 4: Add the path draft lifecycle functions**

Add these new functions right after `stopCircleDraft()` (before `function handlePolygonKeydown(e) {`):

```js
function pathLatLngs() {
    if (! draftPath) {
        return []
    }

    return draftPath.getLatLngs().map((point) => [point.lat, point.lng])
}

function styleDraftPath() {
    if (! draftPath || ! props.draftPin) {
        return
    }

    const style = props.draftPin.polygonStyle || {}

    draftPath.setStyle({
        color: props.draftPin.colour || '#ccc',
        weight: style['stroke-width'] || 1,
        opacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startPathDraft() {
    const style = props.defaultPolygonStyle

    draftPath = leafletMap.editTools.startPolyline(undefined, {
        color: style.stroke,
        weight: style['stroke-width'],
        opacity: style.opacity / 100,
    })
    pathEditing = false

    leafletMap.doubleClickZoom.disable()

    draftPath.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
        emit('path-change', pathLatLngs())
    })

    draftPath.on('editable:drawing:commit', () => {
        pathEditing = true
        emit('path-finish', pathLatLngs())
    })
}

function stopPathDraft() {
    if (! draftPath) {
        return
    }

    draftPath.disableEdit()
    leafletMap.removeLayer(draftPath)
    draftPath = null
    pathEditing = false
    leafletMap.doubleClickZoom.enable()
}
```

Note: `draftPath.getLatLngs()` returns a **flat** array of points for a polyline (unlike `draftPolygon.getLatLngs()`, which returns a nested array of rings) — `pathLatLngs()` above must NOT index into `[0]` the way `polygonLatLngs()` does.

- [ ] **Step 5: Style the draft path when colour/opacity change, and drive the path draft lifecycle**

Change the existing `watch(() => props.draftPin, ...)` block from:

```js
watch(() => props.draftPin, (pin) => {
    if (! leafletMap) {
        return
    }

    buildDraftMarker()

    if (pin?.shape === 'poly') {
        styleDraftPolygon()
    }

    if (pin?.shape === 'circle') {
        styleDraftCircle()
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

    if (pin?.shape === 'circle') {
        styleDraftCircle()
    }

    if (pin?.shape === 'path') {
        styleDraftPath()
    }
})
```

Then add a new watcher right after the existing circle `watch(() => [props.activeMode, props.draftPin], ...)` block (the one that drives `startCircleDraft`/`stopCircleDraft`) — do not modify the polygon or circle watchers, add this as a separate new block:

```js
watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'path') {
        stopPathDraft()

        return
    }

    if (! props.draftPin && pathEditing) {
        stopPathDraft()
        startPathDraft()

        return
    }

    if (! draftPath) {
        startPathDraft()
    }
})
```

- [ ] **Step 6: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors. Full interactive verification happens in Task 5.

- [ ] **Step 7: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: wire Leaflet.Editable path draw/edit lifecycle into map canvas"
```

---

### Task 3: Wire the path draft flow into MapExplorer and save it from MarkerPanel

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`

**Interfaces:**
- Consumes: `path-change`/`path-finish` events from `LeafletCanvas.vue` (Task 2), the existing `defaultPolygonStyle()` helper and `centroid()` import already in `MapExplorer.vue`.
- Produces: a `draftPin` with `shape: 'path'`, `shapeId: 6`, `customShape: Array<[number, number]>`, `polygonStyle: {'stroke-width': number}` (no `stroke` key — a path has no separate border colour).

- [ ] **Step 1: Wire the new LeafletCanvas events and add the path handlers**

In `resources/js/components/maps/MapExplorer.vue`, change the `<LeafletCanvas>` tag from:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
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
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
        />
```

In the script, change:

```js
function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}

function onPinCreated(pin) {
```

to:

```js
function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}

function handlePathFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "path",
        shapeId: 6,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        customShape: vertices,
        polygonStyle: { "stroke-width": style["stroke-width"] },
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}

function handlePathChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function onPinCreated(pin) {
```

- [ ] **Step 2: Show the Stroke Width picker for paths too, and send custom_shape/polygon_style for paths in save()**

In `resources/js/components/maps/MarkerPanel.vue`, change:

```html
            <StrokeWidthPicker
                v-if="mode === 'full' && pin.shape === 'poly'"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />
```

to:

```html
            <StrokeWidthPicker
                v-if="mode === 'full' && (pin.shape === 'poly' || pin.shape === 'path')"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />
```

(Leave the border-colour `ColourPicker` above it unchanged — it stays gated to `pin.shape === 'poly'` only, per the plan's styling decision.)

Change `save()` from:

```js
    try {
        const isPolygon = props.pin.shape === "poly";
        const isCircle = props.pin.shape === "circle";
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
            circle_radius: isCircle ? Math.round(props.pin.circleRadius) : undefined,
        });
        emit("created", res.data);
```

to:

```js
    try {
        const isPolygon = props.pin.shape === "poly";
        const isPath = props.pin.shape === "path";
        const isCircle = props.pin.shape === "circle";
        const hasCustomShape = isPolygon || isPath;
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
            custom_shape: hasCustomShape ? serializeVertices(props.pin.customShape) : undefined,
            polygon_style: hasCustomShape ? props.pin.polygonStyle : undefined,
            circle_radius: isCircle ? Math.round(props.pin.circleRadius) : undefined,
        });
        emit("created", res.data);
```

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue resources/js/components/maps/MarkerPanel.vue
git commit -m "feat: wire path draw/edit events into the map explorer draft flow"
```

---

### Task 4: Legacy — add a path tab to the marker edit form (edit-only, never create)

**Files:**
- Modify: `resources/views/maps/markers/_form.blade.php`
- Modify: `resources/js/location/map-v3.js`
- Modify: `lang/en/maps/markers.php`

**Interfaces:**
- Consumes: `MapMarker::isPath()` (Task 1, tightened to require non-empty `custom_shape`), the `$model`/`$activeTab` variables already available in `_form.blade.php` (set by `app/Http/Controllers/Maps/MarkerController.php` — `$activeTab = $mapMarker->shape_id` on edit, defaults to 1 on create).
- Produces: nothing consumed by other tasks — this is legacy-page-only, does not affect the v4 explorer or the API.

**Important:** `resources/views/maps/markers/edit.blade.php` needs **no changes**. Its existing block:
```php
var marker{{ $model->id }} = {!! $model->editing()->multiplier($map->isReal())->marker() !!}.addTo(map{{ $map->id }});
@if (!$model->isCircle())
window.polygon = marker{{ $model->id }};
window.polygon.enableEdit();
window.polygon.on('editable:dragend', markerUpdateHandler);
window.polygon.on('editable:vertex:dragend', markerUpdateHandler);
window.polygon.on('editable:vertex:dragend', markerUpdateHandler);
@endif
```
already runs `enableEdit()` and wires drag events for **any** non-circle marker — including a path, once Task 1 makes `marker()` return a real `L.polyline` for it. `Leaflet.Editable`'s `EditableMixin` (which `enableEdit()` comes from) is included on `L.Polyline`/`L.Polygon`/`L.Rectangle`/`L.Circle`/`L.Marker` alike, so this generic code already works for paths with zero changes. Do not modify `edit.blade.php` or `create.blade.php` as part of this task.

- [ ] **Step 1: Add the path tab list item**

In `resources/views/maps/markers/_form.blade.php`, change:

```blade
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.area') }}">
                <x-icon class="fa-regular fa-2x fa-draw-polygon" />
                <br />
                {{ __('maps/markers.tabs.area') }}
            </a>
        </li>
        <li role="presentation">
            <a href="#presets" data-nohash="true" class="text-center" data-presets="{{ route('preset_types.presets.index', [$campaign, 'preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}">
```

to:

```blade
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.area') }}">
                <x-icon class="fa-regular fa-2x fa-draw-polygon" />
                <br />
                {{ __('maps/markers.tabs.area') }}
            </a>
        </li>
        @if (isset($model) && $model->isPath())
        <li role="presentation" @if($activeTab == 6) class="active" @endif>
            <a href="#marker-path" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.path') }}">
                <x-icon class="fa-regular fa-2x fa-route" />
                <br />
                {{ __('maps/markers.tabs.path') }}
            </a>
        </li>
        @endif
        <li role="presentation">
            <a href="#presets" data-nohash="true" class="text-center" data-presets="{{ route('preset_types.presets.index', [$campaign, 'preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}">
```

- [ ] **Step 2: Add the path tab pane**

In `resources/views/maps/markers/_form.blade.php`, find the closing of the poly tab-pane and the start of the presets tab-pane:

```blade
                <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                    <input type="number" name="polygon_style[stroke-opacity]" value="{{ $source->polygon_style['stroke-opacity'] ?? old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
                </x-forms.field>
            </x-grid>
        </div>

        <div class="tab-pane pane-presets" id="presets">
```

Change it to:

```blade
                <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                    <input type="number" name="polygon_style[stroke-opacity]" value="{{ $source->polygon_style['stroke-opacity'] ?? old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
                </x-forms.field>
            </x-grid>
        </div>

        @if (isset($model) && $model->isPath())
        <div class="tab-pane @if($activeTab == 6) active @endif" id="marker-path">
            <x-grid>
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                    <x-helper>
                        <p>{{ __('maps/markers.helpers.path.edit') }}</p>
                    </x-helper>
                    <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{!! \App\Facades\FormCopy::field('custom_shape')->string() ?: old('custom_shape', $model->custom_shape ?? null) !!}</textarea>
                </div>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    <input type="number" name="polygon_style[stroke-width]" value="{{ $model->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]') }}" id="path-stroke-width" step="1" min="1" max="99" maxlength="2" />
                </x-forms.field>
            </x-grid>
        </div>
        @endif

        <div class="tab-pane pane-presets" id="presets">
```

(The path tab reuses the main form's already-visible `colour` field — `background_colour.blade.php` renders `name="colour"` unconditionally for any non-label shape, path included — so no duplicate colour field is added here. There is deliberately no "start drawing"/"reset" button, unlike the poly tab: paths are edit-only, so the tab always has an existing shape to display and drag.)

- [ ] **Step 3: Add the path helper translation string**

In `lang/en/maps/markers.php`, change:

```php
        'polygon'                   => [
            'edit'  => 'Edit the polygon by dragging its edges and nodes.',
        ],
    ],
```

to:

```php
        'polygon'                   => [
            'edit'  => 'Edit the polygon by dragging its edges and nodes.',
        ],
        'path'                      => [
            'edit'  => 'Edit the path by dragging its points.',
        ],
    ],
```

- [ ] **Step 4: Wire the path tab's shape_id and generalize the vertex-update handler in map-v3.js**

In `resources/js/location/map-v3.js`, change `initTabs()` from:

```js
    document.querySelector('a[href="#marker-poly"]').addEventListener('click', function () {
        shapeField.value = 5;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#presets"]')?.addEventListener('click', function (e) {
```

to:

```js
    document.querySelector('a[href="#marker-poly"]').addEventListener('click', function () {
        shapeField.value = 5;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#marker-path"]')?.addEventListener('click', function () {
        shapeField.value = 6;
        document.querySelector('#map-marker-bg-colour').classList.remove('hidden');
        showMainFields();
    });
    document.querySelector('a[href="#presets"]')?.addEventListener('click', function (e) {
```

Change:

```js
const isPolygon = () => {
    return Number(shapeField.value) === 5;
};
const isLabel = () => {
    return Number(shapeField.value) === 2;
};
```

to:

```js
const isPolygon = () => {
    return Number(shapeField.value) === 5;
};
const isPath = () => {
    return Number(shapeField.value) === 6;
};
const isLabel = () => {
    return Number(shapeField.value) === 2;
};
```

Change:

```js
window.markerUpdateHandler = function (data) {
    if (isPolygon()) {
        updatePolygon(data);
    }
    else if (isLabel()) {
        updateLabel(data);
    }
};
```

to:

```js
window.markerUpdateHandler = function (data) {
    if (isPolygon() || isPath()) {
        updatePolygon(data);
    }
    else if (isLabel()) {
        updateLabel(data);
    }
};
```

Change `updatePolygon` from:

```js
const updatePolygon = (data) => {
    //console.log('polygon updated', data);
    let points = data.target.getLatLngs();
    if (points.length === 0) {
        return;
    }

    let coords = [];
    points[0].forEach((i) => {
        coords.push(i.lat.toFixed(3) + ',' + i.lng.toFixed(3));
    });
    window.setPolygonPosition(coords.join(' '));
};
```

to:

```js
const updatePolygon = (data) => {
    // A polygon's getLatLngs() returns a nested array of rings ([[point, ...]]);
    // a path's getLatLngs() returns a flat array of points ([point, ...]) — both are
    // handled here since this function now serializes both shapes' vertices.
    let points = isPath() ? data.target.getLatLngs() : (data.target.getLatLngs()[0] || []);
    if (points.length === 0) {
        return;
    }

    let coords = [];
    points.forEach((i) => {
        coords.push(i.lat.toFixed(3) + ',' + i.lng.toFixed(3));
    });
    window.setPolygonPosition(coords.join(' '));
};
```

- [ ] **Step 5: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors (this repo has no automated test coverage for Blade rendering or this vanilla-JS file — full interactive verification, including confirming the existing polygon tab still works, happens in Task 5).

- [ ] **Step 6: Commit**

```bash
git add resources/views/maps/markers/_form.blade.php resources/js/location/map-v3.js lang/en/maps/markers.php
git commit -m "feat: add an edit-only path tab to the legacy marker form"
```

---

### Task 5: End-to-end verification

**Files:** none (verification only).

**Interfaces:** none — this task exercises the full stack built in Tasks 1-4.

- [ ] **Step 1: Run the backend tests for touched areas**

```bash
vendor/bin/sail artisan test --compact --filter="MapMarkerPathRenderTest|creates a path marker"
```

Expected: all pass.

- [ ] **Step 2: Build and manually exercise the v4 explorer**

```bash
vendor/bin/sail yarn run build
```

Then, using a boosted-campaign admin account:

1. Open a map's v4 explore page. Click the "Path" toolbar button.
2. Click several points on the map — confirm the line grows live as points are added.
3. Double-click, or click the last placed point again, to finish — confirm the `MarkerPanel` opens with the path still visible.
4. Confirm the panel (in Details/full mode) shows Colour, Stroke Width (Thin/Normal/Bold/Custom), Opacity, Group, Linked Entry, Visibility — and does **not** show a border-colour field.
5. Drag one of the path's points while the panel is open — confirm the line updates live.
6. Name it, pick a colour and a stroke width preset, Save — confirm it persists with the correct colour/width, and the marker count increments.
7. Refresh the page — confirm the path reloads and renders identically.
8. With Rapid mode on, confirm you can draw a second path immediately without reselecting "Path" from the toolbar.

- [ ] **Step 3: Manually verify the legacy map page**

1. On the **legacy** map explore page for the same map, confirm the path marker created in Step 2 now renders as a line (not a generic pin).
2. Open that marker's legacy **edit** form — confirm a "Path" tab is present and active, showing the custom_shape textarea and a stroke-width field, and that dragging one of the line's points on the map updates the textarea and the marker preview live.
3. Save the edit form — confirm the change persists (reload the legacy explore page and confirm the path's new shape/style shows).
4. Open the legacy **create** form for a brand-new marker — confirm there is **no** "Path" tab option anywhere (only Pin/Text/Circle/Area/Preset).
5. **Regression check:** open the legacy edit form for an *existing polygon* marker (created before this plan) — confirm its "Area" tab still works exactly as before (drag vertices, save) — this shares the same `_form.blade.php`/`map-v3.js` files this plan modified.

- [ ] **Step 4: Fix forward if any manual check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 4)**

```bash
git add -A
git commit -m "fix: address issues found in path drawing end-to-end verification"
```
