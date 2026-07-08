# Legacy Pin Style Toggle Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a per-map checkbox in the map explorer's Settings panel that lets an editor opt back into the old colour-teardrop pin rendering, defaulting to off (new compact-icon style) for every map.

**Architecture:** Store the flag as an optional `legacy_pins` boolean key inside the existing `Map::config` JSON blob (same pattern as `distance_measure`/`distance_name`), expose it through `MapResource`, add a checkbox to `SettingsPanel.vue`, thread it down through `MapExplorer.vue` to `LeafletCanvas.vue` as a `legacyPins` prop, and branch `LeafletCanvas.vue`'s marker-icon builder between the restored legacy teardrop renderer and the current bare-icon renderer.

**Tech Stack:** Laravel 11 / PHP 8.4 backend (FormRequest validation, Eloquent JSON cast, JsonResource), Vue 3 `<script setup>` SFCs, Leaflet.js, Pest for backend tests.

## Global Constraints

- Per-map setting only — no campaign-wide or global default (decided during brainstorming).
- Default is `false` (new style) for every map, including all existing ones — achieved by reading a missing config key as `false`, no migration/backfill.
- No realtime broadcast to other concurrent viewers — only the editor who saves sees the change applied live; other viewers get it on next load.
- Never hardcode UI strings — all copy goes through `__()` in `lang/en/maps/explorer.php`, wired through `App\Services\Maps\ExploreApiService`.
- No new Vue component test harness — this repo only has plain-JS unit tests (`resources/js/maps/*.test.js`), no Vue component test infra. Frontend verification is manual/live, per established pattern on this branch.
- PHP changes: run `vendor/bin/sail bin pint --dirty --format agent` before considering a task done.
- Run tests with `vendor/bin/sail artisan test --compact --filter=<Name>`.

---

### Task 1: Backend — `legacy_pins` config field, validation, resource, i18n

**Files:**
- Modify: `app/Http/Requests/UpdateMapSettings.php`
- Modify: `app/Http/Controllers/Entity/Maps/SettingsController.php:34-42`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php:56-68`
- Modify: `lang/en/maps/explorer.php:69-85`
- Modify: `app/Services/Maps/ExploreApiService.php:161-177`
- Test: `tests/Feature/Entities/Maps/MapSettingsControllerTest.php`

**Interfaces:**
- Produces: `MapResource`'s `settings` array gains `legacy_pins` (bool, always present, defaults `false`). The Settings-update endpoint (`PATCH entities.map-settings.update`) accepts an optional `legacy_pins` boolean in its payload. `ExploreApiService`'s `i18n.settings` block gains `legacy_pins` and `legacy_pins_help` string keys, consumed by later tasks' Vue components as `i18n.legacy_pins` / `i18n.legacy_pins_help`.

- [ ] **Step 1: Write the failing backend tests**

Add to `tests/Feature/Entities/Maps/MapSettingsControllerTest.php` (append after the existing tests, before the closing of the file):

```php
it('persists and returns legacy_pins', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'legacy_pins' => true,
    ])->assertStatus(200);

    expect($response->json('settings.legacy_pins'))->toBeTrue();

    $map->refresh();
    expect($map->config)->toBe(['legacy_pins' => true]);
});

it('defaults legacy_pins to false when never set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
    ])->assertStatus(200);

    expect($response->json('settings.legacy_pins'))->toBeFalse();
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="legacy_pins"`
Expected: FAIL — `settings.legacy_pins` key does not exist / assertion errors, since neither the validation rule nor the resource field exist yet.

- [ ] **Step 3: Add the validation rule**

In `app/Http/Requests/UpdateMapSettings.php`, add `legacy_pins` to the `$rules` array (inside `rules()`, alongside the existing keys):

```php
            'center_marker_id' => [
                'nullable',
                'integer',
                Rule::exists('map_markers', 'id')->where(function ($query) {
                    $entity = $this->route('entity');
                    $query->where('map_id', $entity?->child?->id);
                }),
            ],
            'legacy_pins' => 'sometimes|boolean',
```

(This is inserted as the last entry of the `$rules` array, right after the existing `center_marker_id` entry.)

- [ ] **Step 4: Merge `legacy_pins` into `Map::config` in the controller**

In `app/Http/Controllers/Entity/Maps/SettingsController.php`, replace:

```php
        $config = $map->config ?? [];
        if (array_key_exists('distance_measure', $data)) {
            $config['distance_measure'] = $data['distance_measure'];
        }
        if (array_key_exists('distance_name', $data)) {
            $config['distance_name'] = $data['distance_name'];
        }
        unset($data['distance_measure'], $data['distance_name']);
        $data['config'] = $config;
```

with:

```php
        $config = $map->config ?? [];
        if (array_key_exists('distance_measure', $data)) {
            $config['distance_measure'] = $data['distance_measure'];
        }
        if (array_key_exists('distance_name', $data)) {
            $config['distance_name'] = $data['distance_name'];
        }
        if (array_key_exists('legacy_pins', $data)) {
            $config['legacy_pins'] = $data['legacy_pins'];
        }
        unset($data['distance_measure'], $data['distance_name'], $data['legacy_pins']);
        $data['config'] = $config;
```

- [ ] **Step 5: Expose `legacy_pins` on `MapResource`**

In `app/Http/Resources/Maps/Explore/MapResource.php`, inside the `'settings' => [...]` array, add a new entry after `'center_marker_id' => $map->center_marker_id,`:

```php
                'center_marker_id' => $map->center_marker_id,
                'legacy_pins' => (bool) ($map->config['legacy_pins'] ?? false),
```

- [ ] **Step 6: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="legacy_pins"`
Expected: PASS (2 passed)

- [ ] **Step 7: Add the i18n strings**

In `lang/en/maps/explorer.php`, inside the `'settings' => [...]` array, add two new entries after `'no_marker' => 'None selected',` and before `'save' => 'Save',`:

```php
        'no_marker'             => 'None selected',
        'legacy_pins'           => 'Use legacy pin style',
        'legacy_pins_help'      => 'Show pins with the older colour-teardrop look instead of the newer compact icons. Other people viewing this map will see the change after they reload the page.',
        'save'                  => 'Save',
```

- [ ] **Step 8: Wire the new strings through `ExploreApiService`**

In `app/Services/Maps/ExploreApiService.php`, inside the `'settings' => [...]` i18n block, add two new entries after `'no_marker' => __('maps/explorer.settings.no_marker'),` and before `'save' => __('maps/explorer.settings.save'),`:

```php
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'legacy_pins' => __('maps/explorer.settings.legacy_pins'),
                'legacy_pins_help' => __('maps/explorer.settings.legacy_pins_help'),
                'save' => __('maps/explorer.settings.save'),
```

- [ ] **Step 9: Format and run the full settings test file**

Run: `vendor/bin/sail bin pint --dirty --format agent`
Then run: `vendor/bin/sail artisan test --compact --filter=MapSettingsControllerTest`
Expected: PASS (all tests in the file, including the two new ones and every pre-existing one)

- [ ] **Step 10: Commit**

```bash
git add app/Http/Requests/UpdateMapSettings.php app/Http/Controllers/Entity/Maps/SettingsController.php app/Http/Resources/Maps/Explore/MapResource.php lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/MapSettingsControllerTest.php
git commit -m "feat: add legacy_pins map setting"
```

---

### Task 2: `SettingsPanel.vue` — checkbox UI

**Files:**
- Modify: `resources/js/components/maps/SettingsPanel.vue`

**Interfaces:**
- Consumes: `props.map.settings.legacy_pins` (bool, from Task 1's `MapResource`), `props.i18n.legacy_pins` / `props.i18n.legacy_pins_help` (strings, from Task 1's `ExploreApiService`).
- Produces: the `save()` PATCH payload gains a `legacy_pins` boolean field, sent to the endpoint Task 1 updated.

- [ ] **Step 1: Add `legacy_pins` to the reactive form**

In `resources/js/components/maps/SettingsPanel.vue`, replace:

```js
const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
    center_x: null,
    center_y: null,
    center_marker_id: null,
});
```

with:

```js
const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
    center_x: null,
    center_y: null,
    center_marker_id: null,
    legacy_pins: false,
});
```

- [ ] **Step 2: Initialize it when the panel opens**

Replace:

```js
        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        form.center_x = settings.center_x;
        form.center_y = settings.center_y;
        form.center_marker_id = settings.center_marker_id;
        centerMode.value = settings.center_marker_id ? "marker" : "coordinates";
        error.value = null;
```

with:

```js
        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        form.center_x = settings.center_x;
        form.center_y = settings.center_y;
        form.center_marker_id = settings.center_marker_id;
        form.legacy_pins = settings.legacy_pins ?? false;
        centerMode.value = settings.center_marker_id ? "marker" : "coordinates";
        error.value = null;
```

- [ ] **Step 3: Include it in the save payload**

Replace:

```js
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
            center_x: centerMode.value === "coordinates" ? form.center_x : null,
            center_y: centerMode.value === "coordinates" ? form.center_y : null,
            center_marker_id: centerMode.value === "marker" ? form.center_marker_id : null,
        });
```

with:

```js
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
            center_x: centerMode.value === "coordinates" ? form.center_x : null,
            center_y: centerMode.value === "coordinates" ? form.center_y : null,
            center_marker_id: centerMode.value === "marker" ? form.center_marker_id : null,
            legacy_pins: form.legacy_pins,
        });
```

- [ ] **Step 4: Add the checkbox to the template**

Replace:

```html
            <div class="flex flex-col gap-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.center }}</span>
```

with:

```html
            <label class="flex items-start gap-2 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                <input v-model="form.legacy_pins" type="checkbox" class="checkbox checkbox-sm mt-0.5" />
                <span class="flex flex-col gap-1">
                    {{ i18n.legacy_pins }}
                    <span class="normal-case font-normal text-neutral-content/70">{{ i18n.legacy_pins_help }}</span>
                </span>
            </label>

            <div class="flex flex-col gap-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.center }}</span>
```

(This places the checkbox right before the "Center" section, as its own field in the scrollable settings list.)

- [ ] **Step 5: Build the frontend and verify no errors**

Run: `vendor/bin/sail yarn run build`
Expected: build completes with `✓ built in ...`, no errors mentioning `SettingsPanel.vue`.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/SettingsPanel.vue
git commit -m "feat: add legacy pin style checkbox to map settings panel"
```

---

### Task 3: `MapExplorer.vue` — thread the setting down to `LeafletCanvas`

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue:92-116`

**Interfaces:**
- Consumes: `data.value.map.settings.legacy_pins` (bool, already reactive — `handleSettingsSaved(map)` at `MapExplorer.vue:284-286` already replaces `data.value.map` wholesale on save, so no new handler is needed here).
- Produces: `<LeafletCanvas>` receives a `legacy-pins` prop, consumed by Task 4.

- [ ] **Step 1: Pass the prop down**

In `resources/js/components/maps/MapExplorer.vue`, in the `<LeafletCanvas ... />` block, replace:

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
            :remote-cursors="remoteCursors"
            :default-polygon-style="defaultPolygonStyle()"
```

with:

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
            :remote-cursors="remoteCursors"
            :legacy-pins="data.map.settings?.legacy_pins"
            :default-polygon-style="defaultPolygonStyle()"
```

- [ ] **Step 2: Build the frontend and verify no errors**

Run: `vendor/bin/sail yarn run build`
Expected: build completes with `✓ built in ...`, no errors mentioning `MapExplorer.vue`.

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: pass legacy_pins map setting to LeafletCanvas"
```

---

### Task 4: `LeafletCanvas.vue` — restore the legacy renderer behind the `legacyPins` prop

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `legacyPins` prop (bool, from Task 3).
- Produces: `buildPin()`/`buildDraftMarker()` (unchanged call sites) get either the legacy teardrop icon or the current bare-icon rendering from `pinIcon(pin)`, chosen per-render based on `props.legacyPins`.

- [ ] **Step 1: Add the `legacyPins` prop**

Replace:

```js
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
    remoteCursors: { type: Object, default: () => ({}) },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})
```

with:

```js
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
    remoteCursors: { type: Object, default: () => ({}) },
    legacyPins: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})
```

- [ ] **Step 2: Split `pinIcon()` into `legacyPinIcon()` / `modernPinIcon()` and dispatch between them**

Replace the entire current `pinIcon()` implementation (the function and its three constants/helpers just above it):

```js
const DEFAULT_MARKER_SIZE = 24
const LEGACY_MARKER_SIZE = 40
const DEFAULT_PIN_ICON = 'fa-solid fa-map-pin'

function markerSize(pin) {
    const configured = pin.pin_size || LEGACY_MARKER_SIZE

    return Math.round(configured * (DEFAULT_MARKER_SIZE / LEGACY_MARKER_SIZE))
}

function isDefaultPinIcon(icon) {
    return !icon || (icon.type === 'fa' && icon.value === DEFAULT_PIN_ICON)
}

function pinIcon(pin) {
    const size = markerSize(pin)
    const colour = pin.colour || '#ccc'
    const icon = pin.icon

    if (icon?.type === 'avatar') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-avatar" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    if (icon?.type === 'svg') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-image" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    const isPin = isDefaultPinIcon(icon)
    const inner = icon?.type === 'html'
        ? icon.value
        : `<i class="${isPin ? 'fa-solid fa-location-pin' : (icon?.value || 'fa-solid fa-location-pin')}" aria-hidden="true"></i>`

    // The default pin keeps its tip anchored to the point, like a map pin; every
    // other shape/custom icon is anchored on its center, like a generic marker.
    const anchor = isPin ? size : size / 2

    return L.divIcon({
        html: `<div class="marker-icon" style="--pin-colour: ${colour}; color: ${colour}; font-size: ${size}px;">${inner}</div>`,
        iconSize: [size, size],
        iconAnchor: [size / 2, anchor],
        popupAnchor: [0, -anchor],
        className: `marker marker-${pin.id}`,
    })
}
```

with:

```js
const DEFAULT_MARKER_SIZE = 24
const LEGACY_MARKER_SIZE = 40
const DEFAULT_PIN_ICON = 'fa-solid fa-map-pin'

function markerSize(pin) {
    const configured = pin.pin_size || LEGACY_MARKER_SIZE

    return Math.round(configured * (DEFAULT_MARKER_SIZE / LEGACY_MARKER_SIZE))
}

function isDefaultPinIcon(icon) {
    return !icon || (icon.type === 'fa' && icon.value === DEFAULT_PIN_ICON)
}

function legacyPinIcon(pin) {
    const size = pin.pin_size || LEGACY_MARKER_SIZE
    let inner = `<i class="${DEFAULT_PIN_ICON}"></i>`
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

function modernPinIcon(pin) {
    const size = markerSize(pin)
    const colour = pin.colour || '#ccc'
    const icon = pin.icon

    if (icon?.type === 'avatar') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-avatar" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    if (icon?.type === 'svg') {
        return L.divIcon({
            html: `<img src="${icon.value}" class="marker-image" style="width: ${size}px; height: ${size}px; --pin-colour: ${colour};" />`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -(size / 2)],
            className: `marker marker-${pin.id}`,
        })
    }

    const isPin = isDefaultPinIcon(icon)
    const inner = icon?.type === 'html'
        ? icon.value
        : `<i class="${isPin ? 'fa-solid fa-location-pin' : (icon?.value || 'fa-solid fa-location-pin')}" aria-hidden="true"></i>`

    // The default pin keeps its tip anchored to the point, like a map pin; every
    // other shape/custom icon is anchored on its center, like a generic marker.
    const anchor = isPin ? size : size / 2

    return L.divIcon({
        html: `<div class="marker-icon" style="--pin-colour: ${colour}; color: ${colour}; font-size: ${size}px;">${inner}</div>`,
        iconSize: [size, size],
        iconAnchor: [size / 2, anchor],
        popupAnchor: [0, -anchor],
        className: `marker marker-${pin.id}`,
    })
}

function pinIcon(pin) {
    return props.legacyPins ? legacyPinIcon(pin) : modernPinIcon(pin)
}
```

- [ ] **Step 3: Re-render pins live when the setting changes**

Replace:

```js
watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})
```

with:

```js
watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.legacyPins, () => {
    if (leafletMap) {
        buildPins()
    }
})
```

- [ ] **Step 4: Restore the legacy CSS alongside the current styles**

Replace:

```css
.marker {
    color: white;
    background-color: unset;
    text-align: center;
}

.marker-icon {
```

with:

```css
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

.marker-pin i {
    font-size: 1.25rem;
    margin: 0;
    position: absolute !important;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.marker-icon {
```

(Note: the restored rule is scoped to `.marker-pin i` rather than the original's bare `.marker i`, so it only targets icons nested in the legacy teardrop div and can't bleed into the new `.marker-icon`'s own `<i>` layout.)

- [ ] **Step 5: Restore the legacy draft-outline rule alongside the current one**

Replace:

```css
.marker-draft .marker-icon,
.marker-draft .marker-avatar,
.marker-draft .marker-image {
    outline: 2px dashed var(--pin-colour, white);
    outline-offset: 3px;
    border-radius: 9999px;
}
```

with:

```css
.marker-draft .marker-icon,
.marker-draft .marker-avatar,
.marker-draft .marker-image {
    outline: 2px dashed var(--pin-colour, white);
    outline-offset: 3px;
    border-radius: 9999px;
}

.marker-draft .marker-pin {
    outline: 2px dashed white;
    outline-offset: 2px;
}
```

- [ ] **Step 6: Build the frontend and verify no errors**

Run: `vendor/bin/sail yarn run build`
Expected: build completes with `✓ built in ...`, no errors mentioning `LeafletCanvas.vue`.

- [ ] **Step 7: Manual verification in the browser**

Since there's no Vue component test harness in this repo, verify live:
1. Start the dev server if not running (`vendor/bin/sail up -d`) and open any campaign map in the v4 explorer as an editor.
2. Open the map's Settings panel, confirm the new checkbox appears above "Center", unchecked by default, with its helper text visible beneath the label.
3. Check the box, save. Confirm pins on the map immediately switch to the old colour-teardrop style with no page reload (default pin, other FA shape choices, avatar, and any custom-uploaded image markers if the campaign is boosted).
4. Reload the page. Confirm the checkbox is still checked and pins still render in the legacy style (persistence).
5. Uncheck the box, save. Confirm pins immediately revert to the new bare-icon style with no reload, then reload and confirm it stuck.
6. While in "place a new pin" draft mode, confirm the dragging/draft outline still renders correctly in both styles (dashed white teardrop outline in legacy mode, dashed pin-colour outline in the new mode).

- [ ] **Step 8: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: restore legacy pin rendering behind the legacy_pins map setting"
```
