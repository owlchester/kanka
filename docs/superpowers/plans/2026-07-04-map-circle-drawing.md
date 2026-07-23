# Map Circle Drawing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Wire up the Toolbar's existing but unwired "circle" mode in the new map explorer (`resources/js/components/maps/MapExplorer.vue`) so users can draw a circle by clicking and dragging, keep resizing it by dragging the resize handle right up until Save, style its fill colour/opacity, and see it persist and re-render correctly on reload.

**Architecture:** Leaflet.Editable (already a dependency, already used for polygon drawing) has native circle-drawing support — `editTools.startCircle()` sets the center on mousedown and live-updates the radius as the user drags, committing in the same mousedown→drag→mouseup gesture (firing the same `editable:drawing:commit` event polygon drawing already uses). This plan adds a circle draft lifecycle to `LeafletCanvas.vue` that mirrors the existing polygon draft lifecycle, wires two new events up into `MapExplorer.vue`'s existing draft-pin flow, and adds `circle_radius` to `MarkerPanel.vue`'s save payload. No new Vue component and no new pure-JS helper module are needed — this reuses the already-shipped `ColourPicker`/`OpacityPicker` fields and the already-exposed `circle_radius` field end to end.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API, `<script setup>`), Leaflet 1.9 + `leaflet-editable`.

## Global Constraints

- No size picker (tiny/small/standard/large/huge/custom) — dropped in favor of relying entirely on click-and-drag plus a live-draggable resize handle before Save.
- No border colour / stroke width for circles — they always render with `stroke: false` (existing, unmodified rendering code).
- No Escape-to-reset / Ctrl+Z for circles — circle drawing is a single continuous gesture with no multi-step vertex history, unlike polygon.
- No whole-circle dragging (repositioning the center after initial placement) — only the resize handle (radius) stays interactive.
- Do not modify `app/Models/MapMarker.php`'s legacy rendering methods (`circleRadius()`, `circleMarker()`) or the old map page. A circle created via the new explorer storing a "final" `circle_radius` value (not run through the legacy real-map 50× multiplier) is a known, accepted, non-blocking cross-path edge case — same class as the already-accepted `custom_shape` parser drift from the polygon plan.
- `LeafletCanvas.vue`'s existing `defaultPolygonStyle` prop is intentionally reused as-is for the circle draft's default fill colour/opacity (its `colour`/`opacity` fields) — this is not a naming oversight, it's a deliberate reuse to avoid introducing a second, near-identical prop.
- All new PHP: curly braces on every control structure, explicit return types/param type hints, PHPDoc over inline comments.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change in a task, before that task's commit.
- All artisan/composer/node(PHP-side)/yarn commands go through `vendor/bin/sail`.

---

### Task 1: Backend — tighten circle_radius validation and prove the round-trip

**Files:**
- Modify: `app/Http/Requests/StoreMapMarker.php:52`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`

**Interfaces:**
- Consumes: nothing new — `circle_radius` and `size_id` are already fillable/cast on `App\Models\MapMarker` and already exposed by `PinResource` (`app/Http/Resources/Maps/Explore/PinResource.php:43`, `:41`). No resource changes needed.
- Produces: `StoreMapMarker` now rejects a zero/negative `circle_radius` (previously only `nullable|integer`, allowing `0` or negative values through).

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/MarkerControllerTest.php` (after the existing polygon tests, before the final closing of the file):

```php
it('creates a circle marker with a positive circle_radius and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New circle',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 50,
        'shape_id' => 3,
        'icon' => 1,
        'circle_radius' => 750,
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New circle')->firstOrFail();

    expect($response->json('shape'))->toBe('circle');
    expect($response->json('circle_radius'))->toBe(750);
    expect($marker->circle_radius)->toBe(750);
});

it('422s create when circle_radius is zero or negative', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New circle',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 3,
        'icon' => 1,
        'circle_radius' => 0,
    ])->assertStatus(422);
});
```

- [ ] **Step 2: Run tests to verify the second one fails**

Run: `vendor/bin/sail artisan test --compact --filter="creates a circle marker with a positive circle_radius|422s create when circle_radius"`
Expected: the first test PASSES already (circle_radius/PinResource support pre-exists); the second FAILS (currently returns 201, not 422) since `circle_radius` has no lower bound yet.

- [ ] **Step 3: Tighten the validation rule**

In `app/Http/Requests/StoreMapMarker.php`, change:

```php
            'circle_radius' => 'nullable|integer',
```

to:

```php
            'circle_radius' => 'nullable|integer|min:1',
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="creates a circle marker with a positive circle_radius|422s create when circle_radius"`
Expected: both PASS.

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Requests/StoreMapMarker.php tests/Feature/Entities/Maps/MarkerControllerTest.php
git commit -m "feat: require a positive circle_radius when creating a circle map marker"
```

---

### Task 2: Wire the circle draw/edit lifecycle in LeafletCanvas

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `props.activeMode === 'circle'` (set by the existing Toolbar/`handleModeChange`, no change needed there), `props.draftPin` (existing prop), `props.defaultPolygonStyle` (existing prop — reused for circle's default fill colour/opacity, per Global Constraints).
- Produces: two new emits — `circle-change({ lat, lng, radius })` fired whenever the resize handle is dragged, and `circle-finish({ lat, lng, radius })` fired once when the initial click-and-drag gesture completes (`editable:drawing:commit`). Consumed by `MapExplorer.vue` in Task 3.

- [ ] **Step 1: Add circle-change/circle-finish to the emits list**

In `resources/js/components/maps/LeafletCanvas.vue`, change:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish'])
```

to:

```js
const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish'])
```

Add new state alongside the existing `let draftPolygon = null` / `let polygonEditing = false`:

```js
let draftCircle = null
let circleEditing = false
```

- [ ] **Step 2: Skip the draft-marker path for circle drafts too**

Change `buildDraftMarker` from:

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
```

to:

```js
function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)
}
```

- [ ] **Step 3: Add the circle draft lifecycle functions**

Add these new functions right after `stopPolygonDraft()` (before `function handlePolygonKeydown(e) {`):

```js
function circleLatLngRadius() {
    if (! draftCircle) {
        return null
    }

    const center = draftCircle.getLatLng()

    return { lat: center.lat, lng: center.lng, radius: draftCircle.getRadius() }
}

function styleDraftCircle() {
    if (! draftCircle || ! props.draftPin) {
        return
    }

    draftCircle.setStyle({
        fillColor: props.draftPin.colour || '#ccc',
        fillOpacity: (props.draftPin.opacity ?? 100) / 100,
    })
}

function startCircleDraft() {
    const style = props.defaultPolygonStyle

    draftCircle = leafletMap.editTools.startCircle(undefined, {
        fillColor: style.colour,
        fillOpacity: style.opacity / 100,
        stroke: false,
    })
    circleEditing = false

    draftCircle.on('editable:vertex:dragend', () => {
        emit('circle-change', circleLatLngRadius())
    })

    draftCircle.on('editable:drawing:commit', () => {
        circleEditing = true
        emit('circle-finish', circleLatLngRadius())
    })
}

function stopCircleDraft() {
    if (! draftCircle) {
        return
    }

    draftCircle.disableEdit()
    leafletMap.removeLayer(draftCircle)
    draftCircle = null
    circleEditing = false
}
```

- [ ] **Step 4: Style the draft circle when colour/opacity change, and drive the circle draft lifecycle**

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
})
```

Then add a new watcher right after the existing `watch(() => [props.activeMode, props.draftPin], ...)` block (the one that drives `startPolygonDraft`/`stopPolygonDraft`) — do not modify that existing block, add this as a separate watcher immediately following it:

```js
watch(() => [props.activeMode, props.draftPin], () => {
    if (! leafletMap) {
        return
    }

    if (props.activeMode !== 'circle') {
        stopCircleDraft()

        return
    }

    if (! props.draftPin && circleEditing) {
        stopCircleDraft()
        startCircleDraft()

        return
    }

    if (! draftCircle) {
        startCircleDraft()
    }
})
```

- [ ] **Step 5: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors. Full interactive verification happens in Task 4.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: wire Leaflet.Editable circle draw/edit lifecycle into map canvas"
```

---

### Task 3: Wire the circle draft flow into MapExplorer and save it from MarkerPanel

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`

**Interfaces:**
- Consumes: `circle-change`/`circle-finish` events from `LeafletCanvas.vue` (Task 2), the existing `defaultPolygonStyle()` helper in `MapExplorer.vue` (reused for circle's default colour/opacity).
- Produces: a `draftPin` with `shape: 'circle'`, `shapeId: 3`, `circleRadius: <number>` — consumed by `LeafletCanvas.vue`'s `styleDraftCircle`/rendering (Task 2, already handles `pin.circleRadius` via the existing `buildPin` circle branch reading `pin.circle_radius` for saved pins — the draft path only needs the camelCase field for the live in-progress circle, which is why `MarkerPanel.vue`'s `save()` must translate it to `circle_radius` on the wire).

- [ ] **Step 1: Wire the new LeafletCanvas events and add the circle handlers**

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
        />
```

In the script, change:

```js
function handleStrokeWidthChange(width) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, "stroke-width": width } };
}

function onPinCreated(pin) {
```

to:

```js
function handleStrokeWidthChange(width) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, "stroke-width": width } };
}

function handleCircleFinish({ lat, lng, radius }) {
    const style = defaultPolygonStyle();

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "circle",
        shapeId: 3,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        circleRadius: radius,
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}

function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}

function onPinCreated(pin) {
```

- [ ] **Step 2: Send circle_radius in MarkerPanel's save() payload**

In `resources/js/components/maps/MarkerPanel.vue`, change `save()` from:

```js
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
```

to:

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

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue resources/js/components/maps/MarkerPanel.vue
git commit -m "feat: wire circle draw/edit events into the map explorer draft flow"
```

---

### Task 4: End-to-end verification

**Files:** none (verification only).

**Interfaces:** none — this task exercises the full stack built in Tasks 1-3.

- [ ] **Step 1: Run the backend tests for touched areas**

```bash
vendor/bin/sail artisan test --compact --filter=MarkerControllerTest
```

Expected: the circle tests from Task 1 pass. (This repo's `phpunit.xml` has `stopOnFailure=true`, and a pre-existing, unrelated failure already exists earlier in this same file — confirmed in the polygon plan's own Task 8 to predate that plan's start commit. If the run stops there, re-run with a narrower `--filter` targeting just the two circle tests by name to confirm they pass in isolation, the same way the polygon plan's Task 8 verified its own new tests.)

- [ ] **Step 2: Build and manually exercise the feature**

```bash
vendor/bin/sail yarn run build
```

Then, using a boosted-campaign admin account:

1. Open a map's v4 explore page.
2. Click the "Circle" toolbar button.
3. Click and drag on the map — confirm a circle appears and grows/shrinks live as you drag.
4. Release the mouse — confirm the `MarkerPanel` opens immediately with the drawn circle still visible.
5. Drag the circle's resize handle again while the panel is open — confirm the circle's radius updates live.
6. Name the pin, pick a fill colour and an opacity value, and confirm the on-map circle updates to match live.
7. Click Save — confirm the circle persists with the chosen fill/opacity, and the marker count in the header increments.
8. Refresh the page — confirm the circle reloads and renders identically (round-trips through `PinResource`/`StoreMapMarker` from Task 1).
9. With Rapid mode on (see the already-shipped rapid-mode feature), draw and save a circle, then confirm you can immediately draw another one without reselecting "Circle" from the toolbar.

- [ ] **Step 3: Fix forward if any manual check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 4: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in circle drawing end-to-end verification"
```
