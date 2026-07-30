# Map Explorer Mobile Panel Layout Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make Legend/Detail/Marker/Settings panels in `MapExplorer.vue` usable on mobile by going full-screen below the `md` breakpoint, while fixing the existing desktop collision between Detail/Marker/Settings and preserving the ability to have Legend + one right-side panel open together on desktop.

**Architecture:** A pure, unit-testable exclusivity-rules module (`resources/js/maps/panelExclusivity.js`) decides which panels must close when a given panel opens. `MapExplorer.vue` calls it from each panel-opening code path and exposes an `anyPanelOpen` computed used to hide the header/tiling-prompt chrome on mobile. The four panel components get responsive wrapper classes (full-screen below `md`, existing floating box at `md`+); `LegendPanel.vue` additionally gains its own close button since the header (which currently toggles it) hides on mobile.

**Tech Stack:** Vue 3 `<script setup>` SFCs, Tailwind CSS v4 utility classes, plain JS module tested with Node's built-in `node:test` runner (matches the existing `resources/js/maps/*.test.js` pattern — no new test framework/dependency).

## Global Constraints

- Mobile/desktop breakpoint is `md` (768px), matching the existing convention in `resources/css/maps/maps.css`, `resources/css/mobile.css`, etc. — one line each, with exact values copied verbatim from the spec.
- Right-slot group (Detail/Marker/Settings) is mutually exclusive on **all** screen sizes.
- Legend is independent of the right-slot group at `md`+ (both can be open together); below `md`, opening one closes the other, discarding state outright (no hide/restore).
- No new runtime dependencies (no `@vue/test-utils`, no `vitest`) — this project's CLAUDE.md requires approval before changing dependencies, and the existing test convention for plain-logic modules under `resources/js/maps/` already uses Node's built-in `node:test` + `node:assert/strict`.
- Do not touch `Toolbar.vue` — explicitly out of scope per the spec.

---

### Task 1: Panel exclusivity rules module

**Files:**
- Create: `resources/js/maps/panelExclusivity.js`
- Test: `resources/js/maps/panelExclusivity.test.js`

**Interfaces:**
- Produces: `panelsToClose(openingKind, isMobile)` — `openingKind` is one of `"legend" | "detail" | "marker" | "settings"`, `isMobile` is a boolean. Returns an array (subset of `["legend", "detail", "marker", "settings"]`, never containing `openingKind` itself) naming which panels must close. Task 2 consumes this exact signature.

- [ ] **Step 1: Write the failing test**

Create `resources/js/maps/panelExclusivity.test.js`:

```js
import { test } from 'node:test'
import assert from 'node:assert/strict'
import { panelsToClose } from './panelExclusivity.js'

test('opening a right-slot panel on desktop closes the other right-slot panels only', () => {
    assert.deepEqual(panelsToClose('detail', false).sort(), ['marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', false).sort(), ['detail', 'settings'])
    assert.deepEqual(panelsToClose('settings', false).sort(), ['detail', 'marker'])
})

test('opening a right-slot panel on mobile also closes legend', () => {
    assert.deepEqual(panelsToClose('detail', true).sort(), ['legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', true).sort(), ['detail', 'legend', 'settings'])
    assert.deepEqual(panelsToClose('settings', true).sort(), ['detail', 'legend', 'marker'])
})

test('opening legend on desktop closes nothing', () => {
    assert.deepEqual(panelsToClose('legend', false), [])
})

test('opening legend on mobile closes all right-slot panels', () => {
    assert.deepEqual(panelsToClose('legend', true).sort(), ['detail', 'marker', 'settings'])
})
```

- [ ] **Step 2: Run test to verify it fails**

Run: `node --test resources/js/maps/panelExclusivity.test.js`
Expected: FAIL — `Cannot find module './panelExclusivity.js'`

- [ ] **Step 3: Write minimal implementation**

Create `resources/js/maps/panelExclusivity.js`:

```js
const RIGHT_SLOT_KINDS = ['detail', 'marker', 'settings']

export function panelsToClose(openingKind, isMobile) {
    if (openingKind === 'legend') {
        return isMobile ? RIGHT_SLOT_KINDS : []
    }

    const closing = RIGHT_SLOT_KINDS.filter((kind) => kind !== openingKind)

    return isMobile ? [...closing, 'legend'] : closing
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `node --test resources/js/maps/panelExclusivity.test.js`
Expected: PASS, 4 tests passing

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/panelExclusivity.js resources/js/maps/panelExclusivity.test.js
git commit -m "feat: add panel exclusivity rules for map explorer"
```

---

### Task 2: Wire exclusivity + mobile chrome hiding into MapExplorer.vue

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `panelsToClose(openingKind, isMobile)` from Task 1 (`resources/js/maps/panelExclusivity.js`).
- Produces: `anyPanelOpen` (computed boolean, used in this same file's template), `toggleLegend()` (used in this same file's template).

- [ ] **Step 1: Import the exclusivity module**

Modify `resources/js/components/maps/MapExplorer.vue`, in the `<script setup>` imports (currently lines 196–205):

```js
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { colourForUser, useMapPresence } from "../../composables/useMapPresence.js";
import { centroid } from "../../maps/polygon.js";
import { panelsToClose } from "../../maps/panelExclusivity.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

- [ ] **Step 2: Add the panel-closing helpers and `anyPanelOpen` computed**

Modify `resources/js/components/maps/MapExplorer.vue`. Immediately after the existing `isTilingRunning` computed (currently line 255: `const isTilingRunning = computed(() => data.value.map.tiling === 'running');`), insert:

```js
const anyPanelOpen = computed(
    () => legendOpen.value || !!selectedPin.value || !!draftPin.value || settingsOpen.value,
);

function isMobileViewport() {
    return window.matchMedia("(max-width: 767px)").matches;
}

function closePanel(kind) {
    if (kind === "legend") {
        legendOpen.value = false;
    } else if (kind === "detail") {
        selectedPin.value = null;
    } else if (kind === "marker") {
        draftPin.value = null;
    } else if (kind === "settings") {
        settingsOpen.value = false;
    }
}

function enforceExclusivity(openingKind) {
    panelsToClose(openingKind, isMobileViewport()).forEach(closePanel);
}

function toggleLegend() {
    if (!legendOpen.value) {
        enforceExclusivity("legend");
    }

    legendOpen.value = !legendOpen.value;
}
```

- [ ] **Step 3: Call `enforceExclusivity` from every right-slot opening path**

Modify `openSettings` (currently lines 268–271):

```js
function openSettings() {
    mapMenuInstance?.hide();
    enforceExclusivity("settings");
    settingsOpen.value = true;
}
```

Modify `selectPin` (currently lines 280–282):

```js
function selectPin(pin) {
    enforceExclusivity("detail");
    selectedPin.value = pin;
}
```

Modify the new-draft-pin branch inside `handleMapClick` (currently lines 390–407 — the `isText` declaration through the end of the `draftPin.value = {...}` assignment):

```js
    const isText = activeMode.value === "text";

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        colour: defaultColour(),
        shape: isText ? "label" : "marker",
        shapeId: isText ? 2 : 1,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: 100,
        latitude: lat,
        longitude: lng,
    };
```

Modify `handlePolygonFinish` (currently lines 485–507), adding the call right after `const style = defaultPolygonStyle();`:

```js
function handlePolygonFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    enforceExclusivity("marker");

    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "poly",
        shapeId: 5,
        icon: { type: "fa", value: "fa-solid fa-map-pin" },
        iconId: 1,
        customIcon: null,
        customShape: vertices,
        polygonStyle: { stroke: style.stroke, "stroke-width": style["stroke-width"] },
        groupId: null,
        entityId: null,
        entityName: null,
        visibilityId: data.value.default_visibility_id,
        opacity: style.opacity,
        latitude: lat,
        longitude: lng,
    };
}
```

Modify `handleCircleFinish` (currently lines 535–555):

```js
function handleCircleFinish({ lat, lng, radius }) {
    const style = defaultPolygonStyle();

    enforceExclusivity("marker");

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
```

Modify `handlePathFinish` (currently lines 565–587):

```js
function handlePathFinish(vertices) {
    const [lat, lng] = centroid(vertices);
    const style = defaultPolygonStyle();

    enforceExclusivity("marker");

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
```

- [ ] **Step 4: Wire the template — legend toggle, header/tiling-prompt hiding, LegendPanel close**

Modify the legend-toggle button (currently lines 27–32):

```html
<button
    class="legend-toggle btn2 btn-default"
    @click="toggleLegend"
>
    <i class="fa-regular fa-list" aria-hidden="true" />
</button>
```

Modify the header row wrapper (currently line 26):

```html
<div
    class="fixed top-4 left-4 z-[1200] items-center gap-4"
    :class="anyPanelOpen ? 'hidden md:flex' : 'flex'"
>
```

Modify the tiling-prompt wrapper (currently lines 91–94):

```html
<div
    v-if="canEdit && data.map.tiling_prompt_eligible && !tilingPromptDismissed"
    class="fixed top-4 right-4 z-[1200] max-w-sm bg-base-100 border border-base-300 rounded-xl p-4 flex-col gap-2 shadow-lg"
    :class="anyPanelOpen ? 'hidden md:flex' : 'flex'"
>
```

Modify the `LegendPanel` usage (currently lines 106–112) to handle its new close emit:

```html
<LegendPanel
    :open="legendOpen"
    :groups="data.groups"
    :pins="data.pins"
    :i18n="data.i18n"
    @select="selectPin"
    @close="legendOpen = false"
/>
```

- [ ] **Step 5: Manual verification (no automated Vue component test harness exists in this repo)**

This repo has no `@vue/test-utils`/`vitest` setup, and adding one is a dependency change requiring separate approval — the logic this task depends on (`panelsToClose`) is already covered by Task 1's tests. Verify this task by hand:

Ask the user to confirm the dev server is running (`vendor/bin/sail yarn run dev`), then in a browser at a map's Explore page:
1. Resize to ≥768px wide. Open Legend, then click a pin to open Detail — both should stay open simultaneously.
2. With Detail still open, click the map-name menu → Settings — Detail should close, Settings should open, Legend should remain open.
3. Resize to <768px wide. Open Legend — any open right-slot panel should close. Then click a pin to open Detail — Legend should close.
4. At <768px with a panel open, confirm the top header row and any visible tiling-prompt box are not rendered; closing the panel brings them back.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: enforce panel exclusivity and hide chrome on mobile"
```

---

### Task 3: LegendPanel close button

**Files:**
- Modify: `resources/js/components/maps/LegendPanel.vue`

**Interfaces:**
- Produces: `close` emit (consumed by Task 2's `@close="legendOpen = false"` wiring, already in place).

- [ ] **Step 1: Add the close button and emit**

Modify `resources/js/components/maps/LegendPanel.vue`. Replace the title row (currently lines 7–16):

```html
<p class="flex items-center justify-between gap-2">
    <span>{{ i18n.legend_title }}</span>
    <span class="flex items-center gap-2">
        <button
            v-tippy="allOpen ? i18n.legend_collapse : i18n.legend_expand"
            class="cursor-pointer"
            @click="toggleAll"
        >
            <i class="fa-regular fa-sort" aria-hidden="true" />
        </button>
        <button
            class="btn2 btn-default btn-sm flex-none"
            @click="$emit('close')"
        >
            <i class="fa-solid fa-xmark" aria-hidden="true" />
        </button>
    </span>
</p>
```

Modify the emits declaration (currently line 78: `const emit = defineEmits(["select"]);`):

```js
const emit = defineEmits(["select", "close"]);
```

- [ ] **Step 2: Manual verification**

In the browser, open the Legend panel and click the new `[X]` button — it should close (same as clicking the header legend-toggle button again).

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/LegendPanel.vue
git commit -m "feat: add close button to legend panel"
```

---

### Task 4: Responsive full-screen wrapper for all four panels

**Files:**
- Modify: `resources/js/components/maps/DetailPanel.vue`
- Modify: `resources/js/components/maps/SettingsPanel.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `resources/js/components/maps/LegendPanel.vue`

**Interfaces:**
- None — pure CSS class changes, no script/behavior changes.

- [ ] **Step 1: DetailPanel.vue**

Modify the `<aside>` wrapper class (currently line 4):

```html
class="fixed inset-0 bg-base-100 shadow-lg z-[1150] flex flex-col overflow-hidden md:top-4 md:right-4 md:bottom-4 md:left-auto md:w-80 md:rounded-2xl"
```

- [ ] **Step 2: SettingsPanel.vue**

Modify the `<aside>` wrapper class (currently line 4) — identical replacement to Step 1:

```html
class="fixed inset-0 bg-base-100 shadow-lg z-[1150] flex flex-col overflow-hidden md:top-4 md:right-4 md:bottom-4 md:left-auto md:w-80 md:rounded-2xl"
```

- [ ] **Step 3: MarkerPanel.vue**

Modify the `<aside>` wrapper (currently lines 2–6):

```html
<aside
    v-if="pin"
    class="fixed inset-0 bg-base-100 shadow-lg z-[1150] flex flex-col overflow-hidden md:top-4 md:right-4 md:left-auto md:w-80 md:rounded-2xl"
    :class="mode === 'full' ? 'md:bottom-4' : ''"
>
```

- [ ] **Step 4: LegendPanel.vue**

Modify the `<aside>` wrapper class (currently line 4):

```html
class="fixed inset-0 bg-base-100 shadow-lg z-[1100] overflow-y-auto p-4 flex flex-col gap-3 md:top-20 md:left-4 md:right-auto md:bottom-24 md:w-72 md:rounded-2xl"
```

- [ ] **Step 5: Manual verification**

At <768px wide, open each of the four panels one at a time and confirm each fills the entire viewport with square corners. Resize to ≥768px wide and confirm each panel returns to its original floating rounded-corner box in its original position (Legend top-left, Detail/Marker/Settings top-right) with no visual regression.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/DetailPanel.vue resources/js/components/maps/SettingsPanel.vue resources/js/components/maps/MarkerPanel.vue resources/js/components/maps/LegendPanel.vue
git commit -m "feat: make map explorer panels full-screen below md breakpoint"
```

---

### Task 5: End-to-end verification pass

**Files:**
- None (verification only).

- [ ] **Step 1: Run the panel exclusivity test suite**

Run: `node --test resources/js/maps/panelExclusivity.test.js`
Expected: PASS, 4 tests passing

- [ ] **Step 2: Full manual walkthrough**

Ask the user to confirm the dev server is running, then walk through, on an Explore map page with edit permissions:

1. **Desktop (≥768px):**
   - Open Legend + Detail together — both visible, no overlap.
   - Open Legend + Settings together — both visible, no overlap.
   - Open Detail, then open Settings — Detail closes, Settings opens, Legend (if open) stays open.
   - Start drawing a marker (Marker panel opens via draft pin) while Settings is open — Settings closes.
2. **Mobile (<768px, e.g. browser devtools responsive mode at 375px):**
   - Header row and legend-toggle button, presence avatars, and tiling-prompt (if eligible) are visible with no panel open.
   - Open Legend — fills the screen, header disappears.
   - Tap a pin to open Detail — Legend closes, Detail fills the screen.
   - Close Detail (via its `[X]`) — header reappears, no panel open.
   - Open Settings — fills the screen; open Legend while Settings is open — Settings closes, Legend opens full-screen.
3. Confirm no console errors in the browser during the above (check via browser devtools or the `browser-logs` MCP tool).

- [ ] **Step 3: Report results to the user**

Summarize pass/fail for each item above. Do not mark the task complete until every item passes.
