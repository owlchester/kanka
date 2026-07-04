# Map Explorer Toolbar Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a bottom toolbar to the Vue map explorer with a Rapid toggle and five mutually-exclusive drawing-mode buttons (Pin/Text/Area/Circle/Path), visible only to users who can edit the map, showing a helper-text pill above the bar when a mode is active. No map interaction is wired up yet — this is UI-only.

**Architecture:** One new presentational component (`Toolbar.vue`) holding its own local mode state, rendered by `MapExplorer.vue` behind a new `canEdit` prop sourced from a Blade `@can` gate. All copy comes through the existing `data.i18n` payload, extended with a new `toolbar` block built server-side.

**Tech Stack:** Vue 3 (`<script setup>`, in-DOM template compilation), Tailwind (`bg-base-100`/`bg-accent`/`text-accent-content` utility classes, no custom CSS), Laravel `__()` translations, Pest.

## Global Constraints

- All UI copy must come from `__()`/the `i18n` payload — no hardcoded strings in `.vue` files.
- Toolbar uses `bg-base-100` for its background (not a custom dark color), `bg-accent`/`text-accent-content` for the active/selected state, `cursor-pointer` on every button.
- Toolbar only renders when the current user can edit the map (mirrors `resources/views/maps/explore.blade.php`'s `@can('update', $map->entity)` gate).
- No backend behavior changes beyond translations and the permission gate — no new routes, models, or migrations.
- No JS/Vue automated test suite exists in this codebase (no vitest/jest in `package.json`) — Toolbar.vue is verified manually in-browser, not via an automated test.

---

### Task 1: Add `toolbar` translations and expose them via the explore API

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php:46-65` (the `translations()` method)
- Modify: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php:36-42` (the `assertJsonStructure` in `'returns the full explore payload for a simple map'`)

**Interfaces:**
- Produces: `data.i18n.toolbar` — an object with keys `rapid`, `pin`, `text`, `area`, `circle`, `path` (all strings), plus `helper` (an object with keys `pin`, `text`, `area`, `circle`, `path`, all strings). Task 2's `Toolbar.vue` reads exactly this shape via `props.i18n.toolbar.*` and `props.i18n.toolbar.helper[activeMode]`.

- [ ] **Step 1: Extend the existing structure assertion to require the new `toolbar` block (failing test)**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the `'i18n'` line inside the `assertJsonStructure` call (currently line 41) to:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'from_entry', 'linked_entity', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: FAIL — `i18n.toolbar` missing from the response.

- [ ] **Step 3: Add the translation strings**

In `lang/en/maps/explorer.php`, add a `toolbar` array (alongside the existing `errors`, `legend`, `loading`, `marker`, `markers_count`, `ungrouped` keys):

```php
    'toolbar'   => [
        'rapid'     => 'Rapid',
        'pin'       => 'Pin',
        'text'      => 'Text',
        'area'      => 'Area',
        'circle'    => 'Circle',
        'path'      => 'Path',
        'helper'    => [
            'pin'       => 'Click the map to drop a pin',
            'text'      => 'Click to place a text label',
            'area'      => 'Click to add points, double-click to close',
            'circle'    => 'Click and drag to draw a circle',
            'path'      => 'Click to add points along the path',
        ],
    ],
```

- [ ] **Step 4: Expose the strings from `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, inside the array returned by `translations()` (after the existing `'markers_count_other'` line), add:

```php
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
```

- [ ] **Step 5: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload for a simple map"`
Expected: PASS

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add toolbar translations to map explorer API"
```

---

### Task 2: Build `Toolbar.vue`

**Files:**
- Create: `resources/js/components/maps/Toolbar.vue`

**Interfaces:**
- Consumes: `i18n` prop shaped per Task 1 (`i18n.toolbar.{rapid,pin,text,area,circle,path}`, `i18n.toolbar.helper.{pin,text,area,circle,path}`); `canEdit` Boolean prop.
- Produces: default-exported SFC `Toolbar` with props `{ i18n: Object (required), canEdit: Boolean (default false) }`. No emits. Task 3 renders it as `<Toolbar :i18n="data.i18n" :can-edit="canEdit" />`.

- [ ] **Step 1: Create the component**

```vue
<template>
    <div
        v-if="canEdit"
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[1200] flex flex-col items-center gap-2"
    >
        <div
            v-if="activeMode"
            class="bg-accent text-accent-content rounded-full px-4 py-2 text-sm whitespace-nowrap"
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
                :class="activeMode === mode.key ? 'bg-accent text-accent-content' : ''"
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
});

const activeMode = ref(null);
const rapid = ref(false);

const modes = computed(() => [
    { key: "pin", icon: "fa-regular fa-location-dot", label: props.i18n.toolbar.pin },
    { key: "text", icon: "fa-regular fa-font", label: props.i18n.toolbar.text },
    { key: "area", icon: "fa-regular fa-draw-polygon", label: props.i18n.toolbar.area },
    { key: "circle", icon: "fa-regular fa-circle", label: props.i18n.toolbar.circle },
    { key: "path", icon: "fa-regular fa-route", label: props.i18n.toolbar.path },
]);

const helperText = computed(() => {
    if (!activeMode.value) {
        return "";
    }

    return props.i18n.toolbar.helper[activeMode.value];
});

function selectMode(key) {
    activeMode.value = activeMode.value === key ? null : key;
}
</script>
```

- [ ] **Step 2: Commit**

```bash
git add resources/js/components/maps/Toolbar.vue
git commit -m "feat: add map explorer Toolbar component"
```

---

### Task 3: Render `Toolbar` from `MapExplorer.vue`

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `Toolbar` from Task 2 (`import Toolbar from "./Toolbar.vue"`, props `i18n`/`can-edit` as defined above).
- Produces: `MapExplorer` gains a new prop `canEdit` (Boolean, default `false`). Task 4's Blade template binds this via `:can-edit`.

- [ ] **Step 1: Import `Toolbar` and add the `canEdit` prop**

In `resources/js/components/maps/MapExplorer.vue`, update the imports (line 63-65) and `defineProps` (line 67-71):

```js
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
```

- [ ] **Step 2: Render the toolbar**

In the `<template>`, inside the `v-else` block (after the `<DetailPanel>` element, before its closing `</template>` at line 58), add:

```html
        <Toolbar :i18n="data.i18n" :can-edit="canEdit" />
```

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: render Toolbar in MapExplorer"
```

---

### Task 4: Pass `can-edit` from the Blade view

**Files:**
- Modify: `resources/views/entities/pages/map/index.blade.php`

**Interfaces:**
- Consumes: `MapExplorer`'s `canEdit` prop from Task 3, bound via the `<map-explorer>` custom element's `:can-edit` attribute (this element is compiled in-DOM — confirmed by `vite.config.js:134` aliasing `vue` to `vue/dist/vue.esm-bundler`, the full build with the runtime compiler — so a `:can-edit="..."` binding here is evaluated as a real Vue expression, not a literal string).

- [ ] **Step 1: Add the `@can` gate to the `<map-explorer>` tag**

```blade
    <div id="map-explorer">
        <map-explorer
            api="{{ route('entities.map-api', [$campaign, $entity]) }}"
            loading-text="{{ __('maps/explorer.loading') }}"
            error-text="{{ __('maps/explorer.errors.load') }}"
            :can-edit="@can('update', $entity) true @else false @endcan"
        ></map-explorer>
    </div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/entities/pages/map/index.blade.php
git commit -m "feat: gate map explorer toolbar behind edit permission"
```

---

### Task 5: Manual verification in the browser

**Files:** none (verification only)

- [ ] **Step 1: Build frontend assets**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 2: Verify as a user who can edit the map**

Open a map's explorer page (`/w/{campaign}/entities/{entity}`) logged in as a user with update permission on that map entity.
Expected:
- Toolbar renders at the bottom-center, `bg-base-100` background, Rapid pill + divider + Pin/Text/Area/Circle/Path buttons with icons and labels.
- Clicking Rapid toggles it to `bg-accent`/`text-accent-content` independently of any selected mode; clicking it again turns it off.
- Clicking Pin highlights it (`bg-accent`/`text-accent-content`) and shows the "Click the map to drop a pin" pill above the bar; clicking Text switches the highlight and pill text to Text's copy ("Click to place a text label"); clicking the already-active button clears the selection and hides the pill.
- Area/Circle/Path show their respective helper copy ("Click to add points, double-click to close" / "Click and drag to draw a circle" / "Click to add points along the path").
- All buttons show a pointer cursor on hover.

- [ ] **Step 3: Verify as a user without edit permission**

Open the same map's explorer page logged in as a user without update permission (or logged out, if guest viewing is supported).
Expected: no toolbar renders anywhere on the page.
