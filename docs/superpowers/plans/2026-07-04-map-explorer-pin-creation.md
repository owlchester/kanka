# Map Explorer Pin Creation (v1) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** In the Vue map explorer, clicking a toolbar mode closes the pin detail panel; while in "pin" mode, clicking the map drops a temporary yellow pin at that spot and opens a new `MarkerPanel` (name field + Save) that persists it via a new backend endpoint.

**Architecture:** `Toolbar.vue` becomes a controlled component — `MapExplorer.vue` owns `activeMode` as the single source of truth so it can react to mode changes (close `DetailPanel`, discard any pending draft). `LeafletCanvas.vue` gains a map-wide click listener gated on `activeMode === 'pin'` and renders one optional client-side "draft" pin (never part of the persisted `pins` array). `MarkerPanel.vue` is a new sibling to `DetailPanel.vue` with just a name field and Save; Save POSTs to a new endpoint and the response is pushed straight into `data.pins`.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest 3, Vue 3 (`<script setup>`), Leaflet.

## Global Constraints

- Full design spec: `docs/superpowers/specs/2026-07-04-map-explorer-pin-creation-design.md` — read it if anything below is ambiguous.
- Explicitly out of scope for this plan: Template/preset picker, custom colour picker, shape picker, group picker, entity-link select, "Details"/full-form expansion, Rapid-mode chaining, duplicate. Do not add any of these.
- New backend endpoint is session-authed (cookie + CSRF via the global `axios` instance) under `App\Http\Controllers\Entity\Maps`, matching the existing `preview`/`destroy` pattern — do not reuse the OAuth-gated `App\Http\Controllers\Api\v1\MapMarkerApiController`.
- All UI copy must come from `data.i18n` — no hardcoded strings in `.vue` files.
- Draft (unsaved) pins are entirely client-side — never persisted before Save; closing the panel or switching toolbar modes discards the draft outright.
- No JS/Vue automated test harness exists in this repo — Vue component changes are verified manually in-browser, not via an automated test.
- All PHP changes: run `vendor/bin/sail bin pint --dirty --format agent` before each task's final commit.
- All Artisan/PHP/Composer/Node/Yarn commands go through `vendor/bin/sail`.

---

### Task 1: Backend endpoint for creating a marker

**Files:**
- Modify: `routes/campaigns/entities.php:61`
- Modify: `app/Http/Controllers/Entity/Maps/MarkerController.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify (test): `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`
- Modify (test): `tests/Feature/Entities/Maps/MarkerControllerTest.php`

**Interfaces:**
- Produces: `POST` route `entities.map-markers.store` (params: `campaign`, `entity`); `MapResource` field `map.create_url`; flat i18n keys `i18n.error_save`, `i18n.new_pin`, `i18n.name_placeholder`, `i18n.save`. Task 3's `MarkerPanel.vue` POSTs `{ name, latitude, longitude, colour, shape_id, icon }` to `data.map.create_url` and expects a 201 response shaped like one entry of `data.pins` (a `PinResource`).

- [ ] **Step 1: Write the failing explore-payload test**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, replace the `'returns the full explore payload for a simple map'` test's body from the `assertJsonStructure` call through the `destroy_url` assertion with:

```php
    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url']],
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
        ]);

    $response->assertJsonFragment(['name' => $map->name, 'is_real' => false, 'has_clustering' => true]);
    $response->assertJsonFragment(['name' => 'Waterdeep', 'group_id' => $group->id]);
    expect($response->json('map.create_url'))->toBe(route('entities.map-markers.store', [1, $map->entity->id]));
```

(Leave everything else in the file — including the layers/pins assertions below it — unchanged.)

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: FAIL — `Route [entities.map-markers.store] not defined.`

- [ ] **Step 3: Write the failing store-endpoint tests**

Append to `tests/Feature/Entities/Maps/MarkerControllerTest.php`:

```php
it('creates a marker and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New pin')->firstOrFail();

    expect($response->json('id'))->toBe($marker->id);
    expect($response->json('name'))->toBe('New pin');
    expect($response->json('colour'))->toBe('#f2c14e');
    expect($response->json('shape'))->toBe('marker');
    expect($response->json('icon'))->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
    expect($response->json('preview_url'))->toBe(route('entities.map-markers.preview', [1, $map->entity->id, $marker->id]));
    expect($marker->map_id)->toBe($map->id);
});

it('403s create for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(403);

    expect(MapMarker::where('name', 'New pin')->exists())->toBeFalse();
});

it('404s create for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->postJson(route('entities.map-markers.store', [1, $entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(404);
});

it('422s create when both name and entity_id are missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(422);
});
```

- [ ] **Step 4: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: FAIL — route `entities.map-markers.store` not defined.

- [ ] **Step 5: Add the route**

In `routes/campaigns/entities.php`, insert immediately after the existing line 61 (`Route::delete('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'destroy'])->name('entities.map-markers.destroy');`):

```php
Route::post('/w/{campaign}/entities/{entity}/map/markers', [EntityMapMarkerController::class, 'store'])->name('entities.map-markers.store');
```

- [ ] **Step 6: Add `store()` to the controller**

Replace `app/Http/Controllers/Entity/Maps/MarkerController.php` in full:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapMarker;
use App\Http\Resources\Maps\Explore\PinPreviewResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class MarkerController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function preview(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        // Explicitly scope the shared permission service to this campaign (mirroring
        // GuestAuthTrait/CampaignPolicy/MiscPolicy) so `can('update', ...)` inside
        // PinPreviewResource evaluates the user's actual role rather than falling back to
        // EntityPermission::loadAllPermissions()'s "no campaign set" admin bypass.
        EntityPermission::campaign($campaign);

        return response()->json(new PinPreviewResource($mapMarker));
    }

    public function store(StoreMapMarker $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        // See the comment in preview() above.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $marker = MapMarker::create($request->validated() + ['map_id' => $entity->child->id]);

        return response()->json(new PinResource($marker)->campaign($campaign)->mapEntity($entity), 201);
    }

    public function destroy(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        // See the comment in preview() above.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $mapMarker->delete();

        return response()->json(null, 204);
    }

    protected function guardMarker(Entity $entity, MapMarker $mapMarker): void
    {
        if (! $entity->isMap() || $mapMarker->map_id !== $entity->child->id) {
            abort(404);
        }
    }
}
```

- [ ] **Step 7: Add `create_url` to `MapResource`**

Replace `app/Http/Resources/Maps/Explore/MapResource.php` in full:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\Map;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Map $resource
 */
class MapResource extends JsonResource
{
    use CampaignAware;

    public function toArray(Request $request): array
    {
        $map = $this->resource;
        $isChunked = $map->isChunked() && $map->chunkingReady();

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_chunked' => $isChunked,
            'has_clustering' => (bool) $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => array_map('floatval', explode(', ', $map->centerFocus())),
            'tile_url' => $map->isReal() ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : null,
            'chunks_url' => $isChunked
                ? route('maps.chunks', [$this->campaign->id, $map->id]) . '/?z={z}&x={x}&y={y}'
                : null,
            'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
        ];
    }
}
```

- [ ] **Step 8: Add the translation strings**

In `lang/en/maps/explorer.php`, update the `errors` and `marker` arrays:

```php
    'errors'    => [
        'delete'    => 'Unable to delete this marker.',
        'load'      => 'Unable to load this map.',
        'save'      => 'Unable to save this marker.',
    ],
```

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
    ],
```

- [ ] **Step 9: Expose the new strings from `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, replace the `translations()` method in full:

```php
    protected function translations(): array
    {
        return [
            'legend_title' => __('maps.panels.legend'),
            'legend_search' => __('maps/explorer.legend.search'),
            'ungrouped' => __('maps/explorer.ungrouped'),
            'loading' => __('maps/explorer.loading'),
            'error_load' => __('maps/explorer.errors.load'),
            'error_delete' => __('maps/explorer.errors.delete'),
            'error_save' => __('maps/explorer.errors.save'),
            'from_entry' => __('maps/explorer.marker.from_entry'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'edit_details' => __('maps/explorer.marker.edit'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('maps/explorer.marker.save'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'toolbar' => [
                'rapid' => __('maps/explorer.toolbar.rapid'),
                'pin' => __('maps/explorer.toolbar.pin'),
                'text' => __('maps/explorer.toolbar.text'),
                'area' => __('maps/explorer.toolbar.area'),
                'circle' => __('maps/explorer.toolbar.circle'),
                'path' => __('maps/explorer.toolbar.path'),
                'helper' => [
                    'pin' => __('maps/explorer.toolbar.helper.pin'),
                    'text' => __('maps/explorer.toolbar.helper.text'),
                    'area' => __('maps/explorer.toolbar.helper.area'),
                    'circle' => __('maps/explorer.toolbar.helper.circle'),
                    'path' => __('maps/explorer.toolbar.helper.path'),
                ],
            ],
        ];
    }
```

- [ ] **Step 10: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: PASS (12 tests — 8 existing + 4 new)

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (4 tests)

- [ ] **Step 11: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add routes/campaigns/entities.php app/Http/Controllers/Entity/Maps/MarkerController.php app/Http/Resources/Maps/Explore/MapResource.php lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php tests/Feature/Entities/Maps/MarkerControllerTest.php
git commit -m "feat: add marker creation endpoint for the map explorer"
```

---

### Task 2: Toolbar mode selection closes the detail panel

**Files:**
- Modify: `resources/js/components/maps/Toolbar.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: nothing new from Task 1.
- Produces: `Toolbar.vue` is now a controlled component — its highlighted mode comes from the new `active-mode` prop, and clicking a mode button emits `mode-change` (new value or `null`) instead of mutating local state. `MapExplorer.vue` gains `activeMode` (single source of truth) and `handleModeChange(mode)`. Task 3 extends `handleModeChange` further (to also discard a pending draft pin) and adds the map-click wiring; Task 4 adds `MarkerPanel`.

No automated test (DOM-only change). Verify manually per Step 3.

- [ ] **Step 1: Make `Toolbar.vue` a controlled component**

Replace `resources/js/components/maps/Toolbar.vue` in full:

```vue
<template>
    <div
        v-if="canEdit"
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[1200] flex flex-col items-center gap-2"
    >
        <div
            v-if="props.activeMode"
            class="bg-accent opacity-60 text-accent-content rounded-full px-3 py-1.5 text-xs whitespace-nowrap"
        >
            {{ helperText }}
        </div>

        <div
            class="bg-base-100 rounded-2xl shadow-lg flex items-center gap-1 px-2 py-2"
        >
            <button
                type="button"
                class="flex items-center gap-2 rounded-full px-3 py-1.5 cursor-pointer"
                :class="rapid ? 'bg-accent text-accent-content' : ''"
                @click="rapid = !rapid"
            >
                <span
                    class="inline-block w-2 h-2 rounded-full bg-current"
                    aria-hidden="true"
                />
                <span>{{ i18n.toolbar.rapid }}</span>
            </button>

            <div
                class="w-px self-stretch bg-base-content/20 mx-1"
                aria-hidden="true"
            />

            <button
                v-for="mode in modes"
                :key="mode.key"
                type="button"
                class="flex flex-col items-center gap-1 rounded-xl px-3 py-1.5 cursor-pointer"
                :class="
                    props.activeMode === mode.key
                        ? 'bg-accent text-accent-content'
                        : ''
                "
                @click="selectMode(mode.key)"
            >
                <i :class="mode.icon" aria-hidden="true" />
                <span class="text-xs">{{ mode.label }}</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    i18n: { type: Object, required: true },
    canEdit: { type: Boolean, default: false },
    activeMode: { type: String, default: null },
});

const emit = defineEmits(["mode-change"]);

const rapid = ref(false);

const modes = computed(() => [
    {
        key: "pin",
        icon: "fa-regular fa-location-dot",
        label: props.i18n.toolbar.pin,
    },
    { key: "text", icon: "fa-regular fa-font", label: props.i18n.toolbar.text },
    {
        key: "area",
        icon: "fa-regular fa-draw-polygon",
        label: props.i18n.toolbar.area,
    },
    {
        key: "circle",
        icon: "fa-regular fa-circle",
        label: props.i18n.toolbar.circle,
    },
    {
        key: "path",
        icon: "fa-regular fa-route",
        label: props.i18n.toolbar.path,
    },
]);

const helperText = computed(() => {
    if (!props.activeMode) {
        return "";
    }

    return props.i18n.toolbar.helper[props.activeMode];
});

function selectMode(key) {
    emit("mode-change", props.activeMode === key ? null : key);
}
</script>
```

- [ ] **Step 2: Wire `activeMode`/`handleModeChange` into `MapExplorer.vue`**

Replace `resources/js/components/maps/MapExplorer.vue` in full:

```vue
<template>
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error"
    >
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
    </div>

    <template v-else>
        <div class="fixed top-4 left-4 z-[1200] flex items-center gap-4">
            <button
                class="legend-toggle btn2 btn-default"
                @click="legendOpen = !legendOpen"
            >
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <h1 class="text-lg font-semibold leading-tight">
                    {{ data.map.name }}
                </h1>
                <p class="text-sm opacity-75">{{ markersCountText }}</p>
            </div>
        </div>

        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :i18n="data.i18n"
            @select="selectPin"
        />

        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            @pin-click="selectPin"
        />

        <DetailPanel
            :pin="selectedPin"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            @mode-change="handleModeChange"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import Toolbar from "./Toolbar.vue";

const props = defineProps({
    api: { type: String, required: true },
    loadingText: { type: String, required: true },
    errorText: { type: String, required: true },
    canEdit: { type: Boolean, default: false },
});

const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function selectPin(pin) {
    selectedPin.value = pin;
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
</script>
```

- [ ] **Step 3: Verify the build and manually check**

Run: `vendor/bin/sail yarn run build`
Expected: no errors. Revert the incidentally-regenerated manifest: `git checkout -- public/build/manifest.json`, then confirm `git status` shows only the intended files before committing.

In a browser, as a user who can edit the map:
1. Click a pin to open the detail panel.
2. Click any toolbar mode button (Pin/Text/Area/Circle/Path) — the detail panel closes and the clicked button highlights (the helper-text pill above the toolbar appears with its copy).
3. Click the same button again — it un-highlights and the helper pill disappears.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/Toolbar.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: close the detail panel when a toolbar mode is selected"
```

---

### Task 3: Pin mode + map click drops a temporary yellow pin

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `activeMode`/`handleModeChange` from Task 2.
- Produces: `LeafletCanvas.vue` gains props `activeMode`/`draftPin` and emits `map-click({ lat, lng })` whenever the map itself (not an existing pin) is clicked while `activeMode === 'pin'`. `MapExplorer.vue` gains `draftPin` (shape: `{ name, colour, shape: 'marker', icon: {type:'fa', value:'fa-solid fa-map-pin'}, latitude, longitude }`) and `handleMapClick`. Task 4's `MarkerPanel.vue` consumes `draftPin` directly and reads `latitude`/`longitude`/`colour` off it when saving.

No automated test (Leaflet/DOM-only change). Verify manually per Step 3.

- [ ] **Step 1: Add click handling and draft-pin rendering to `LeafletCanvas.vue`**

Replace `resources/js/components/maps/LeafletCanvas.vue` in full:

```vue
<template>
    <div ref="mapEl" class="w-full h-screen"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
})

const emit = defineEmits(['pin-click', 'map-click'])

const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null

function bounds() {
    return [[0, 0], [props.map.height, props.map.width]]
}

function buildBaseLayer() {
    if (props.map.is_real) {
        L.tileLayer(props.map.tile_url, {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(leafletMap)

        return
    }

    if (props.map.is_chunked) {
        L.tileLayer(props.map.chunks_url, { attribution: '&copy; Kanka' }).addTo(leafletMap)

        return
    }

    L.imageOverlay(props.map.image, bounds()).addTo(leafletMap)
}

function buildLayers() {
    props.layers.forEach((layer) => {
        L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
    })
}

function pinIcon(pin) {
    const size = pin.pin_size || 40
    let inner = '<i class="fa-solid fa-map-pin"></i>'
    let style = `--pin-size: ${size}px; background-color: ${pin.colour || '#ccc'};`

    if (pin.icon?.type === 'fa') {
        inner = `<i class="${pin.icon.value}" aria-hidden="true"></i>`
    } else if (pin.icon?.type === 'html' || pin.icon?.type === 'svg') {
        inner = pin.icon.value
    } else if (pin.icon?.type === 'avatar') {
        inner = ''
        // The avatar image is painted on ::after (counter-rotated), not this div (rotated -45deg),
        // so the image itself renders upright instead of tilted.
        style = `--pin-size: ${size}px; --pin-avatar: url('${pin.icon.value}');`
    }

    return L.divIcon({
        html: `<div class="marker-pin" style="${style}"></div>${inner}`,
        iconSize: [size, size],
        iconAnchor: [size / 2, size + size / 4],
        popupAnchor: [0, -(size + size / 4)],
        className: `marker marker-${pin.id}`,
    })
}

function buildPin(pin) {
    if (pin.shape === 'circle') {
        return L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'label') {
        return L.marker([pin.latitude, pin.longitude], { opacity: 0 })
            .bindTooltip(pin.name, { permanent: true, direction: 'center', className: 'map-label' })
    }

    return L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
    })
}

function buildPins() {
    if (pinLayer) {
        leafletMap.removeLayer(pinLayer)
    }

    pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    // Polygon pins are out of scope for v1 (see design doc) — skip rather than mis-render at the wrong spot
    props.pins.filter((pin) => pin.shape !== 'poly').forEach((pin) => {
        const marker = buildPin(pin)
        marker.on('click', () => emit('pin-click', pin))
        pinLayer.addLayer(marker)
    })

    pinLayer.addTo(leafletMap)
}

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

watch(() => props.centerNonce, () => {
    if (props.centerPin && leafletMap) {
        leafletMap.setView([props.centerPin.latitude, props.centerPin.longitude])
    }
})

watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.draftPin, () => {
    if (leafletMap) {
        buildDraftMarker()
    }
})

onMounted(() => {
    const options = {
        zoom: props.map.initial_zoom,
        minZoom: props.map.min_zoom,
        maxZoom: props.map.max_zoom,
        center: props.map.center,
        attributionControl: false,
        zoomControl: false,
    }

    if (! props.map.is_real) {
        options.crs = L.CRS.Simple
        options.maxBounds = bounds()
    }

    leafletMap = L.map(mapEl.value, options)

    L.control.zoom({ position: 'bottomleft' }).addTo(leafletMap)

    leafletMap.on('click', (e) => {
        if (props.activeMode === 'pin') {
            emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng })
        }
    })

    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
})

onBeforeUnmount(() => {
    leafletMap?.remove()
})
</script>

<style>
.marker {
    color: white;
    background-color: unset;
    text-align: center;
}

.marker-pin {
    width: var(--pin-size, 40px);
    height: var(--pin-size, 40px);
    border-radius: 50% 50% 50% 0;
    position: absolute;
    transform: rotate(-45deg);
    left: 50%;
    top: 50%;
    margin: calc(var(--pin-size, 40px) / -2) 0 0 calc(var(--pin-size, 40px) / -2);
    box-shadow: 0 6px 6px rgba(50, 50, 93, 0.31), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.marker-pin::after {
    content: '';
    width: calc(var(--pin-size, 40px) - 4px);
    height: calc(var(--pin-size, 40px) - 4px);
    margin: 2px 0 0 calc((var(--pin-size, 40px) - 4px) / -2);
    position: absolute;
    border-radius: 50%;
    background-image: var(--pin-avatar, none);
    background-position: 50% 50%;
    background-size: cover;
    background-repeat: no-repeat;
    transform: rotate(45deg);
}

.marker i {
    font-size: 1.25rem;
    margin: 0;
    position: absolute !important;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.marker-draft .marker-pin {
    outline: 2px dashed white;
    outline-offset: 2px;
}
</style>
```

- [ ] **Step 2: Add `draftPin`/`handleMapClick` to `MapExplorer.vue`**

Replace `resources/js/components/maps/MapExplorer.vue` in full:

```vue
<template>
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error"
    >
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
    </div>

    <template v-else>
        <div class="fixed top-4 left-4 z-[1200] flex items-center gap-4">
            <button
                class="legend-toggle btn2 btn-default"
                @click="legendOpen = !legendOpen"
            >
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <h1 class="text-lg font-semibold leading-tight">
                    {{ data.map.name }}
                </h1>
                <p class="text-sm opacity-75">{{ markersCountText }}</p>
            </div>
        </div>

        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :i18n="data.i18n"
            @select="selectPin"
        />

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

        <DetailPanel
            :pin="selectedPin"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            @mode-change="handleModeChange"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import Toolbar from "./Toolbar.vue";

const props = defineProps({
    api: { type: String, required: true },
    loadingText: { type: String, required: true },
    errorText: { type: String, required: true },
    canEdit: { type: Boolean, default: false },
});

const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function selectPin(pin) {
    selectedPin.value = pin;
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
}

function handleMapClick({ lat, lng }) {
    if (activeMode.value !== "pin") {
        return;
    }

    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };

        return;
    }

    draftPin.value = {
        name: "",
        colour: "#f2c14e",
        shape: "marker",
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        latitude: lat,
        longitude: lng,
    };
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
</script>
```

- [ ] **Step 3: Verify the build and manually check**

Run: `vendor/bin/sail yarn run build`, confirm no errors, revert `public/build/manifest.json`.

In a browser, as a user who can edit the map:
1. Click the Pin toolbar button, then click anywhere on the map — a yellow pin with a dashed ring appears exactly at the click location.
2. Click a different spot on the map while still in Pin mode — the same dashed pin moves to the new spot (no second pin appears).
3. Click a different toolbar mode (e.g. Text) — the dashed pin disappears.
4. Click a normal (already-saved) pin while in Pin mode — its own detail panel still opens as before (unaffected by the draft-pin logic).

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: drop a temporary pin on map click while in pin mode"
```

---

### Task 4: `MarkerPanel.vue` — name + Save persists the pin

**Files:**
- Create: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `draftPin` (Task 3), `data.map.create_url`/`i18n.error_save`/`i18n.new_pin`/`i18n.name_placeholder`/`i18n.save` (Task 1).
- Produces: `MarkerPanel.vue` — props `pin` (Object, default `null`), `i18n` (Object, required), `createUrl` (String, required); emits `close`, `created(pin)` where `pin` is the raw `PinResource`-shaped response body. `MapExplorer.vue` gains `onPinCreated(pin)`.

No automated test (DOM/network component). Verify manually per Step 3.

- [ ] **Step 1: Create `MarkerPanel.vue`**

```vue
<template>
    <aside
        v-if="pin"
        class="fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: pin.colour }"
                >
                    <i class="fa-solid fa-map-pin text-white" aria-hidden="true" />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">{{ i18n.new_pin }}</h2>
            </div>
            <button class="btn2 btn-default btn-sm flex-none" @click="$emit('close')">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-2">
            <input
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <button
                class="btn2 btn-primary btn-block"
                :disabled="saving || !name.trim()"
                @click="save"
            >
                {{ i18n.save }}
            </button>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
});

const emit = defineEmits(["close", "created"]);

const name = ref("");
const saving = ref(false);
const error = ref(null);

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        name.value = "";
        error.value = null;
    }
});

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const res = await axios.post(props.createUrl, {
            name: name.value,
            latitude: props.pin.latitude,
            longitude: props.pin.longitude,
            colour: props.pin.colour,
            shape_id: 1,
            icon: 1,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
```

- [ ] **Step 2: Render `MarkerPanel` and handle `created` in `MapExplorer.vue`**

Replace `resources/js/components/maps/MapExplorer.vue` in full:

```vue
<template>
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error"
    >
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
    </div>

    <template v-else>
        <div class="fixed top-4 left-4 z-[1200] flex items-center gap-4">
            <button
                class="legend-toggle btn2 btn-default"
                @click="legendOpen = !legendOpen"
            >
                <i class="fa-regular fa-list" aria-hidden="true" />
            </button>
            <div>
                <h1 class="text-lg font-semibold leading-tight">
                    {{ data.map.name }}
                </h1>
                <p class="text-sm opacity-75">{{ markersCountText }}</p>
            </div>
        </div>

        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :i18n="data.i18n"
            @select="selectPin"
        />

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

        <DetailPanel
            :pin="selectedPin"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />

        <MarkerPanel
            :pin="draftPin"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            @close="draftPin = null"
            @created="onPinCreated"
        />

        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            @mode-change="handleModeChange"
        />
    </template>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";

const props = defineProps({
    api: { type: String, required: true },
    loadingText: { type: String, required: true },
    errorText: { type: String, required: true },
    canEdit: { type: Boolean, default: false },
});

const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);

const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function selectPin(pin) {
    selectedPin.value = pin;
}

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id);
    selectedPin.value = null;
}

function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
}

function handleMapClick({ lat, lng }) {
    if (activeMode.value !== "pin") {
        return;
    }

    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };

        return;
    }

    draftPin.value = {
        name: "",
        colour: "#f2c14e",
        shape: "marker",
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        latitude: lat,
        longitude: lng,
    };
}

function onPinCreated(pin) {
    data.value.pins.push(pin);
    draftPin.value = null;
    activeMode.value = null;
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
</script>
```

- [ ] **Step 3: Verify the build and manually check end-to-end**

Run: `vendor/bin/sail yarn run build`, confirm no errors, revert `public/build/manifest.json`.

In a browser, as a user who can edit the map:
1. Click Pin mode, click the map — the dashed yellow preview pin appears and `MarkerPanel` opens on the right with an empty, focused-looking name input; Save is disabled.
2. Type a name — Save becomes enabled. Click a different spot on the map — the panel stays open, the name you typed is preserved, and the preview pin moves.
3. Click Save — the panel closes, the dashed preview pin is replaced by a normal solid yellow pin at the same spot, the toolbar's Pin button un-highlights, and the marker count in the header increments by one.
4. Click the newly-created pin — the normal `DetailPanel` opens for it (it's a real, persisted marker) and clicking "Center" pans to it correctly.
5. Reload the page — the new pin is still there (persisted server-side).
6. Repeat step 1, then click the panel's close (X) button instead of saving — the preview pin disappears and nothing is created (reload confirms no new marker).

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MarkerPanel.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: add MarkerPanel to create pins from the map explorer"
```
