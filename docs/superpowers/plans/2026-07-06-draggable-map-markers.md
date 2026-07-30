# Draggable Map Markers for v4 Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let a map editor drag an `is_draggable` marker (`marker`/pin or `circle` shape only) to a new position in the v4 explorer, persisting the new coordinates via the existing legacy `maps.markers.move` endpoint.

**Architecture:** Expose `is_draggable` and a per-pin `move_url` on `PinResource`. On the frontend, `LeafletCanvas.vue` sets Leaflet's native `draggable` option for eligible pins (gated on `canEdit`, a prop this component doesn't have yet) and posts the new position on `dragend`, reverting the visual position if the save fails. Circle dragging needs `leaflet.path.drag` — a plugin already in `package.json`/`node_modules` (legacy loads it as a vendored `<script>` tag) but not yet imported anywhere in the v4 JS bundle; only `L.Marker` drags natively in core Leaflet, so this import is required for the `circle` shape to actually work, not optional.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API), Leaflet 1.9, `leaflet.path.drag` (existing dependency, newly imported).

## Global Constraints

- Only `marker` (plain pin) and `circle` shapes are ever draggable — matches legacy exactly. `label`, `poly`, and `path` never drag, regardless of the `is_draggable` flag's value.
- Dragging is gated to `canEdit` at the frontend level — a deliberate deviation from legacy (which lets any viewer attempt to drag, only enforcing permission server-side). No non-editor should be able to move a marker at all in v4.
- No changes to `App\Http\Controllers\Maps\Markers\MoveController` or the `maps.markers.move` route — reused as-is (already authorizes via `$this->authorize('update', $map->entity)`, accepts `latitude`/`longitude`, persists, returns `{success, marker_id}`).
- `leaflet.path.drag` is NOT a new dependency (already in `package.json`) — it just needs an `import` statement in `resources/js/components/maps/LeafletCanvas.vue`, which doesn't currently import it.
- No automated test coverage exists for Leaflet canvas interactions in this app (matching the established pattern for every other v4 map explorer change on this branch) — frontend verification is live/manual.

---

### Task 1: Expose is_draggable and move_url on PinResource

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: `App\Models\MapMarker::is_draggable` (existing column), `$marker->map_id` (existing column), the existing `maps.markers.move` route.
- Produces: each pin in the v4 map API's `pins` array gains `is_draggable` (bool) and `move_url` (string) — consumed by Task 2's frontend drag wiring.

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the existing `assertJsonStructure` call's `pins` line (currently):

```php
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url']],
```

to:

```php
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url']],
```

Then append two new tests to the end of the same file:

```php
it('exposes is_draggable and move_url for a draggable pin', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'is_draggable' => true]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['is_draggable'])->toBeTrue();
    expect($pin['move_url'])->toBe(route('maps.markers.move', [1, $map->id, $marker->id]));
});

it('reports is_draggable false for a marker without the flag', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'is_draggable' => false]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['is_draggable'])->toBeFalse();
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="exposes is_draggable and move_url|reports is_draggable false|returns the full explore payload"`
Expected: FAIL — `is_draggable`/`move_url` don't exist on the response yet.

- [ ] **Step 3: Add the fields to `PinResource`**

In `app/Http/Resources/Maps/Explore/PinResource.php`, change:

```php
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
        ];
```

to:

```php
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'is_draggable' => (bool) $marker->is_draggable,
            'move_url' => route('maps.markers.move', [$this->campaign->id, $marker->map_id, $marker->id]),
        ];
```

- [ ] **Step 4: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="exposes is_draggable and move_url|reports is_draggable false|returns the full explore payload"`
Expected: all passing.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Resources/Maps/Explore/PinResource.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: expose is_draggable and move_url on the v4 map API's pins"
```

---

### Task 2: Drag-to-move for marker and circle pins

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `pin.is_draggable`/`pin.move_url` (Task 1), existing `props.canEdit` on `MapExplorer.vue` (not yet on `LeafletCanvas.vue` — this task adds it there).
- Produces: a new `pin-moved` emit from `LeafletCanvas.vue`, payload `{ id: Number, latitude: Number, longitude: Number }` — consumed by `MapExplorer.vue`'s new `handlePinMoved` function, which updates the matching entry in `data.value.pins`. Nothing later in this plan consumes this further.

- [ ] **Step 1: Import `leaflet.path.drag` and add the `canEdit` prop**

In `resources/js/components/maps/LeafletCanvas.vue`, change:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
import '../../leaflet/ruler.js'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change'])
```

to:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'
import 'leaflet-editable'
import 'leaflet.path.drag'
import '../../leaflet/ruler.js'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved'])
```

`leaflet.path.drag` is what makes the `draggable` option work on `L.Circle` (core Leaflet only wires native drag support for `L.Marker` — this plugin adds the equivalent for `L.Path`-based shapes via `L.Path.addInitHook`, exactly what legacy relies on via its vendored copy of the same plugin, `public/vendor/leaflet/leaflet.path.drag.js`, loaded in `resources/views/layouts/map.blade.php`).

- [ ] **Step 2: Add a shared drag-persist helper**

In `resources/js/components/maps/LeafletCanvas.vue`, add this function next to `pinIcon()` (just above `buildPin()`):

```js
function movePinTo(pin, layer) {
    const { lat, lng } = layer.getLatLng()

    axios.post(pin.move_url, { latitude: lat, longitude: lng })
        .then(() => {
            emit('pin-moved', { id: pin.id, latitude: lat, longitude: lng })
        })
        .catch(() => {
            layer.setLatLng([pin.latitude, pin.longitude])
        })
}
```

`layer.getLatLng()`/`layer.setLatLng()` work identically for both `L.Marker` and `L.Circle`, so this one helper covers both draggable shapes.

- [ ] **Step 3: Wire dragging into the `circle` and default `marker` branches of `buildPin()`**

Change:

```js
    if (pin.shape === 'circle') {
        return L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
        })
    }
```

to:

```js
    if (pin.shape === 'circle') {
        const draggable = props.canEdit && pin.is_draggable
        const circle = L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
            draggable,
        })

        if (draggable) {
            circle.on('dragend', (e) => movePinTo(pin, e.target))
        }

        return circle
    }
```

Change:

```js
    return L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
    })
}
```

to:

```js
    const draggable = props.canEdit && pin.is_draggable
    const marker = L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
        draggable,
    })

    if (draggable) {
        marker.on('dragend', (e) => movePinTo(pin, e.target))
    }

    return marker
}
```

(This last change is `buildPin()`'s final fallback branch — the plain pin/marker shape. `label`/`poly`/`path` branches above it are untouched, so they're never draggable regardless of `pin.is_draggable`, per the plan's scope. This branch is also reached by `buildDraftMarker()` for an in-progress pin/text draft — but a draft pin object never has `is_draggable`/`move_url` set, so `draggable` naturally evaluates to `false` there; no special-casing needed.)

- [ ] **Step 4: Wire `canEdit` and the `pin-moved` handler in `MapExplorer.vue`**

Change:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :preview-center="previewCenter"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
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
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
            @pin-moved="handlePinMoved"
        />
```

Add the handler function next to `removePin` — change:

```js
function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}
```

to:

```js
function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handlePinMoved({ id, latitude, longitude }) {
    data.value.pins = data.value.pins.map((pin) =>
        pin.id === id ? { ...pin, latitude, longitude } : pin
    );
}
```

- [ ] **Step 5: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 6: Manually verify**

Using `vendor/bin/sail artisan tinker` to set `is_draggable => true` on an existing plain-pin marker and a circle marker (or via the legacy marker edit form's pin-shape tab, which already exposes this checkbox):
1. As an editor, open the v4 explorer, drag the draggable pin marker to a new spot — confirm it visually follows the cursor, and after reloading the page, the new position stuck.
2. Do the same for the draggable circle marker — confirm it drags too (this is the step that would silently fail without the `leaflet.path.drag` import from Step 1).
3. Confirm a marker with `is_draggable = false` cannot be dragged at all.
4. Confirm a `label`, `poly`, or `path` marker cannot be dragged even if `is_draggable` were somehow set on it.
5. As a non-editor (viewer without update permission), confirm no marker can be dragged, even an `is_draggable` one.
6. To check the failure-revert path: temporarily break `pin.move_url` (e.g. via browser devtools, edit the pin's `move_url` in Vue devtools before dragging, or simulate by dragging a marker whose id has since been deleted server-side) and confirm a failed save snaps the marker back to its original position rather than leaving it in the dropped spot.

- [ ] **Step 7: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: support dragging is_draggable map markers in the v4 explorer"
```

---

### Task 3: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the full backend test suite for maps**

```bash
vendor/bin/sail artisan test --compact --filter=Maps
```

Expected: all passing.

- [ ] **Step 2: Run Pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Expected: no remaining style issues.

- [ ] **Step 3: Full manual walkthrough**

Repeat Task 2's Step 6 checks in one consolidated pass, plus: confirm dragging a marker doesn't interfere with clicking it (a plain click, without dragging, should still open `DetailPanel` as before — Leaflet distinguishes a click from a drag natively, but confirm it in practice), and confirm dragging one marker doesn't affect any other marker's position or the map's own pan/zoom state.

- [ ] **Step 4: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own verification, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in draggable-marker end-to-end verification"
```
