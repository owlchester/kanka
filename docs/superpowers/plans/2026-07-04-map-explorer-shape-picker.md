# Map Explorer Shape/Icon Picker Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a `ShapePicker.vue` component to `MarkerPanel.vue`'s full mode, letting the user pick the new pin's icon glyph (pin/circle/square/diamond/triangle/question/exclamation, or a custom FontAwesome class on boosted campaigns), reflected live on the map and in the panel header.

**Architecture:** Entirely frontend — `StoreMapMarker`, `MapMarker`, and `PinResource` already fully support the `icon`/`custom_icon` fields this feature sets, so no backend endpoint/model/resource changes are needed beyond one new i18n string. `draftPin` (in `MapExplorer.vue`) gains two new raw fields (`iconId`, `customIcon`) alongside its existing rendering `icon` object. `ShapePicker.vue` emits a `change` event carrying both the raw fields and a pre-resolved render object; `MarkerPanel.vue` forwards it; `MapExplorer.vue` replaces `draftPin` with a new object (never mutates in place — `LeafletCanvas.vue`'s draft-marker watcher is reference-based, not deep, the same class of bug already found and fixed once for the pins array).

**Tech Stack:** Laravel 11 / PHP 8.4, Pest 3, Vue 3 (`<script setup>`).

## Global Constraints

- Full design spec: `docs/superpowers/specs/2026-07-04-map-explorer-shape-picker-design.md` — read it if anything below is ambiguous.
- No backend changes beyond the one new i18n string — `icon`/`custom_icon` validation and resolution (`StoreMapMarker`, `MapMarker::exploreIcon()`, `PinResource`) already exist and are unmodified by this plan.
- All UI copy must come from `data.i18n` — no hardcoded strings in `.vue` files.
- Any place that replaces `draftPin` must assign a **new** object (spread), never mutate the existing one in place — `LeafletCanvas.vue`'s `watch(() => props.draftPin, ...)` is reference-based and won't fire on in-place mutation.
- No JS/Vue automated test harness exists in this repo — Vue component changes are verified manually in-browser (or by code trace when no browser is available), not via an automated test.
- All PHP changes: run `vendor/bin/sail bin pint --dirty --format agent` before each task's final commit.
- All Artisan/Node/Yarn commands go through `vendor/bin/sail`.

---

### Task 1: `premium_custom_icon` i18n string

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify (test): `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Produces: flat i18n key `i18n.premium_custom_icon` = "Unlock custom pins with a premium campaign". Task 3's `ShapePicker.vue` reads `props.i18n.premium_custom_icon` directly.

- [ ] **Step 1: Write the failing test**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, find this line (currently line 41):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
```

Replace it with:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: FAIL — `premium_custom_icon` missing from the `i18n` structure.

- [ ] **Step 3: Add the translation string**

In `lang/en/maps/explorer.php`, the `marker` array currently ends with:

```php
        'details'           => 'Details',
        'less'              => 'Less',
    ],
```

Replace with:

```php
        'details'           => 'Details',
        'less'              => 'Less',
        'premium_custom_icon' => 'Unlock custom pins with a premium campaign',
    ],
```

- [ ] **Step 4: Expose the string from `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, the `translations()` method currently has:

```php
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
```

Replace with:

```php
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
```

- [ ] **Step 5: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: PASS

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add premium_custom_icon translation for the shape picker"
```

---

### Task 2: `ShapePicker.vue` component

**Files:**
- Create: `resources/js/components/maps/ShapePicker.vue`

**Interfaces:**
- Consumes: `i18n.premium_custom_icon` (Task 1).
- Produces: default-exported SFC `ShapePicker` with props `{ pin: Object (required), boosted: Boolean (default false), i18n: Object (required) }`, and emits `change` with payload `{ icon: Number, custom_icon: String|null, render: { type: 'fa', value: String } }`. Task 3's `MarkerPanel.vue` renders it as `<ShapePicker :pin="pin" :boosted="boosted" :i18n="i18n" @change="$emit('icon-change', $event)" />` and reads `pin.iconId`/`pin.customIcon` to know the current selection.

Not yet rendered anywhere — verified this task via build success and manual code trace against the behaviors below. Task 3 wires it in and verifies it live.

- [ ] **Step 1: Create the component**

```vue
<template>
    <div class="flex flex-col gap-2">
        <input
            v-if="customMode"
            v-model="customText"
            type="text"
            class="input input-bordered w-full"
            autofocus
            @keydown.tab="commitCustom"
            @blur="commitCustom"
        />

        <div v-else class="flex flex-wrap gap-1">
            <button
                v-for="shape in shapes"
                :key="shape.key"
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer"
                :class="isSelected(shape) ? 'bg-accent text-accent-content' : 'bg-base-200'"
                @click="selectShape(shape)"
            >
                <i :class="shape.fa" aria-hidden="true" />
            </button>

            <button
                type="button"
                class="w-9 h-9 rounded-lg flex items-center justify-center cursor-pointer"
                :class="pin.customIcon ? 'bg-accent text-accent-content' : 'bg-base-200'"
                @click="clickCustom"
            >
                <i :class="pin.customIcon || 'fa-solid fa-ellipsis'" aria-hidden="true" />
            </button>
        </div>

        <p v-if="showPremiumError" class="text-sm text-error-content">{{ i18n.premium_custom_icon }}</p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    pin: { type: Object, required: true },
    boosted: { type: Boolean, default: false },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const shapes = [
    { key: "pin", icon: 1, fa: "fa-solid fa-map-pin" },
    { key: "question", icon: 2, fa: "fa-solid fa-question" },
    { key: "exclamation", icon: 3, fa: "fa-solid fa-exclamation" },
    { key: "square", icon: 6, fa: "fa-solid fa-square" },
    { key: "circle", icon: 7, fa: "fa-solid fa-circle" },
    { key: "diamond", icon: 8, fa: "fa-solid fa-diamond" },
    { key: "triangle", icon: 9, fa: "fa-solid fa-caret-up" },
];

const customMode = ref(false);
const customText = ref("");
const showPremiumError = ref(false);

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        customMode.value = false;
        customText.value = "";
        showPremiumError.value = false;
    }
});

function isSelected(shape) {
    return !props.pin.customIcon && props.pin.iconId === shape.icon;
}

function selectShape(shape) {
    showPremiumError.value = false;
    emit("change", { icon: shape.icon, custom_icon: null, render: { type: "fa", value: shape.fa } });
}

function clickCustom() {
    if (!props.boosted) {
        showPremiumError.value = true;

        return;
    }

    showPremiumError.value = false;
    customText.value = props.pin.customIcon || "";
    customMode.value = true;
}

function commitCustom() {
    if (!customMode.value) {
        return;
    }

    const value = customText.value.trim();
    customMode.value = false;

    if (!value) {
        return;
    }

    emit("change", { icon: 1, custom_icon: value, render: { type: "fa", value } });
}
</script>
```

- [ ] **Step 2: Verify the build**

Run: `vendor/bin/sail yarn run build`
Expected: no errors. Revert the incidentally-regenerated manifest: `git checkout -- public/build/manifest.json`, then confirm `git status` shows only the intended new file before committing.

- [ ] **Step 3: Code-trace verify (no browser needed — component isn't rendered anywhere yet)**

Confirm by reading the file:
1. Clicking a shape button when `boosted` is anything emits `change` with that shape's `icon` int, `custom_icon: null`, matching `render`.
2. Clicking "custom" when `boosted` is `false` sets `showPremiumError = true` and does NOT set `customMode = true` (the button row stays visible, no text input appears).
3. Clicking "custom" when `boosted` is `true` sets `customMode = true` and pre-fills `customText` from `pin.customIcon` (or empty if none).
4. Pressing Tab or blurring the text input calls `commitCustom`, which always exits `customMode` back to the button row; it only `emit`s if the trimmed text is non-empty (typing nothing and tabbing away is a silent no-op cancel, not an emit of an empty string).
5. `isSelected` highlights the custom button (not any shape button) whenever `pin.customIcon` is set, matching `exploreIcon()`'s own precedence of `custom_icon` over `icon`.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/ShapePicker.vue
git commit -m "feat: add ShapePicker component for the map explorer marker panel"
```

---

### Task 3: Wire `ShapePicker` into `MarkerPanel`/`MapExplorer`

**Files:**
- Modify: `resources/views/entities/pages/map/index.blade.php`
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`

**Interfaces:**
- Consumes: `ShapePicker` (Task 2, props `pin`/`boosted`/`i18n`, emits `change`).
- Produces: `MapExplorer.vue` gains a `boosted` prop (Boolean, default `false`); `draftPin` objects gain `iconId`/`customIcon` fields; new `handleIconChange(payload)` function. `MarkerPanel.vue` gains a `boosted` prop and emits `icon-change` (forwarded from `ShapePicker`'s `change`). No other task depends on anything new from this one — it's the last task.

No automated test (DOM/network component). Verify manually per Step 4.

- [ ] **Step 1: Pass `boosted` from the Blade view**

Replace `resources/views/entities/pages/map/index.blade.php` in full:

```blade
@extends('layouts.rich', [
    'title' => $entity->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'map-page',
])

@section('content')
    <div id="map-explorer">
        <map-explorer
            api="{{ route('entities.map-api', [$campaign, $entity]) }}"
            loading-text="{{ __('maps/explorer.loading') }}"
            error-text="{{ __('maps/explorer.errors.load') }}"
            :can-edit="@can('update', $entity) true @else false @endcan"
            :boosted="@if ($campaign->boosted()) true @else false @endif"
        ></map-explorer>
    </div>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/maps/explore.js')
@endsection
```

- [ ] **Step 2: Thread `boosted` and `iconId`/`customIcon` through `MapExplorer.vue`**

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
            :boosted="boosted"
            @close="draftPin = null"
            @created="onPinCreated"
            @icon-change="handleIconChange"
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
    boosted: { type: Boolean, default: false },
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
        iconId: 1,
        customIcon: null,
        latitude: lat,
        longitude: lng,
    };
}

function handleIconChange(payload) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = {
        ...draftPin.value,
        iconId: payload.icon,
        customIcon: payload.custom_icon,
        icon: payload.render,
    };
}

function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
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

- [ ] **Step 3: Render `ShapePicker` and update `save()` in `MarkerPanel.vue`**

Replace `resources/js/components/maps/MarkerPanel.vue` in full:

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
                    <i :class="pin.icon?.value || 'fa-solid fa-map-pin'" class="text-white" aria-hidden="true" />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">{{ i18n.new_pin }}</h2>
            </div>
            <button class="btn2 btn-default btn-sm flex-none" :disabled="saving" @click="$emit('close')">
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

            <ShapePicker
                v-if="mode === 'full'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <div class="flex gap-2">
                <button class="btn2 btn-outline" :disabled="saving" @click="toggleMode">
                    {{ mode === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || !name.trim()"
                    @click="save"
                >
                    {{ i18n.save }}
                </button>
            </div>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from "vue";
import ShapePicker from "./ShapePicker.vue";

const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
    boosted: { type: Boolean, default: false },
});

const emit = defineEmits(["close", "created", "icon-change"]);

const name = ref("");
const saving = ref(false);
const error = ref(null);
const mode = ref("light");

watch(() => props.pin, (newPin, oldPin) => {
    if (newPin && !oldPin) {
        name.value = "";
        error.value = null;
        saving.value = false;
        mode.value = "light";
    }
});

function toggleMode() {
    mode.value = mode.value === "light" ? "full" : "light";
}

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
            icon: props.pin.iconId,
            custom_icon: props.pin.customIcon,
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

- [ ] **Step 4: Verify the build and manually check**

Run: `vendor/bin/sail yarn run build`, confirm no errors, revert `public/build/manifest.json`.

In a browser, on a **boosted** campaign, as a user who can edit the map:
1. Click Pin mode, click the map, click Details — the shape button row appears below the name field, "pin" highlighted by default.
2. Click "circle" — the row highlights circle instead, the draft preview pin on the map switches from the pin-shaped icon to a circle icon, and the panel header's swatch icon also switches to the circle glyph.
3. Click "custom" — the button row is replaced by a text input. Type `fa-solid fa-gem` and press Tab — the row reappears, the last button now shows a gem icon and is highlighted, and both the map preview and header swatch show the gem icon.
4. Click Save — the created pin (visible after the panel closes) still shows the gem icon; reload the page and confirm it persists.
5. Start a new pin (click the map again in Pin mode) — Details/full mode resets to light, and if you open Details again, "pin" is highlighted by default again (not gem/circle from the previous pin).

On a **non-boosted** campaign:
6. Click Pin mode, click the map, click Details, click "custom" — the button row stays visible (no text input appears) and "Unlock custom pins with a premium campaign" appears below the row.

- [ ] **Step 5: Commit**

```bash
git add resources/views/entities/pages/map/index.blade.php resources/js/components/maps/MapExplorer.vue resources/js/components/maps/MarkerPanel.vue
git commit -m "feat: wire ShapePicker into the map explorer marker panel"
```
