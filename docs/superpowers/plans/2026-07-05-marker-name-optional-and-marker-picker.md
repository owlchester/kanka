# Optional Marker Name and Searchable Marker Picker Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let a new v4 map marker save with an empty name when an entity is linked to it, and replace the quick-settings panel's plain marker `<select>` with a searchable TomSelect widget so it stays usable on maps with hundreds of markers.

**Architecture:** Two small, independent frontend-only changes. Task 1 relaxes `MarkerPanel.vue`'s Save-button guard to match validation the backend already enforces. Task 2 adds a new `MarkerPicker.vue` component that mirrors `EntityLinkSelect.vue`'s existing TomSelect wrapper pattern, but seeds its options from the already-loaded `pins` array locally instead of a remote search.

**Tech Stack:** Vue 3 (Composition API), tom-select (already a project dependency, already used by `EntityLinkSelect.vue`).

## Global Constraints

- No backend, model, or resource changes — `app/Http/Requests/StoreMapMarker.php`'s `'name' => 'nullable|string|required_without:entity_id'` rule, `App\Models\MapMarker::markerTitle()`, and `App\Http\Resources\Maps\Explore\PinResource` already correctly handle an empty marker name backed by a linked entity. Only `MarkerPanel.vue`'s frontend guard needs to change.
- No new npm dependency — `tom-select` is already installed and used by `resources/js/components/maps/EntityLinkSelect.vue`.
- The new marker picker has no explicit "None"/clear list entry — clearing uses TomSelect's own built-in clear control, matching how `EntityLinkSelect.vue` handles "no entity linked" (an empty `onChange` value, not a synthetic option).
- No automated test coverage exists for Vue component interaction in this app (matching the established pattern for every other v4 map explorer change on this branch) — verification for both tasks is manual/live.

---

### Task 1: Allow saving a marker with an empty name when an entity is linked

**Files:**
- Modify: `resources/js/components/maps/MarkerPanel.vue`

**Interfaces:**
- Consumes: `pin.entityId` (existing, set by `EntityLinkSelect.vue`'s `change` handler via `handleEntityChange` in `MapExplorer.vue`).
- Produces: nothing new — this task only relaxes an existing guard; no new props/emits.

- [ ] **Step 1: Relax the Save button's disabled condition**

In `resources/js/components/maps/MarkerPanel.vue`, change:

```html
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || !name.trim()"
                    @click="save"
                >
```

to:

```html
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || (!name.trim() && !pin.entityId)"
                    @click="save"
                >
```

This matches `app/Http/Requests/StoreMapMarker.php`'s existing `'name' => 'nullable|string|required_without:entity_id'` rule exactly: the button is disabled only when there's neither a name nor a linked entity.

- [ ] **Step 2: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 3: Manually verify**

In the v4 map explorer as an editor: start a new pin, link an entity via the entity picker (in "full" mode — click the "Details" toggle if the panel opens in light mode) without typing a name, confirm the Save button is now enabled and the marker saves successfully, showing the entity's name on the map/legend. Then start a new pin with no name and no linked entity — confirm Save remains disabled. Then type a name with no entity linked — confirm Save is enabled, as before.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MarkerPanel.vue
git commit -m "feat: allow saving a map marker with no name when an entity is linked"
```

---

### Task 2: Searchable TomSelect marker picker in the settings panel

**Files:**
- Create: `resources/js/components/maps/MarkerPicker.vue`
- Modify: `resources/js/components/maps/SettingsPanel.vue`

**Interfaces:**
- Consumes: `EntityLinkSelect.vue`'s TomSelect wrapper conventions (existing pattern, not code — this is a new sibling component, not a modification); `SettingsPanel.vue`'s existing `pins` prop and `selectCenterMarker(markerId)` function (existing, unchanged signature: takes a marker id or `null`).
- Produces: `MarkerPicker.vue` — props `pins: Array`, `modelValue: Number|null`, `i18n: Object`; emits `change` with the selected marker's numeric id, or `null` when cleared. Nothing later in this plan consumes this further; it's the end of the chain.

- [ ] **Step 1: Create `MarkerPicker.vue`**

Create `resources/js/components/maps/MarkerPicker.vue`:

```vue
<template>
    <select ref="selectEl" class="w-full"></select>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";
import TomSelect from "tom-select";

const props = defineProps({
    pins: { type: Array, default: () => [] },
    modelValue: { type: Number, default: null },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const selectEl = ref(null);
let ts = null;

onMounted(() => {
    ts = new TomSelect(selectEl.value, {
        valueField: "id",
        labelField: "name",
        searchField: "name",
        placeholder: props.i18n.no_marker,
        onChange(value) {
            emit("change", value ? Number(value) : null);
        },
    });

    ts.addOptions([...props.pins].sort((a, b) => a.name.localeCompare(b.name)));

    if (props.modelValue) {
        ts.setValue(props.modelValue, true);
    }
});

onBeforeUnmount(() => {
    ts?.destroy();
});
</script>
```

This mirrors `resources/js/components/maps/EntityLinkSelect.vue`'s exact mount/destroy lifecycle and `onChange`/`setValue(..., true)` conventions, but replaces its remote `load()` callback with a one-time local `addOptions()` call, since `pins` is already fully loaded — no network request needed.

- [ ] **Step 2: Wire it into `SettingsPanel.vue`**

Change the import from:

```js
import { reactive, ref, watch } from "vue";
```

to:

```js
import { reactive, ref, watch } from "vue";
import MarkerPicker from "./MarkerPicker.vue";
```

Change the marker-mode `<select>` block from:

```html
                <select
                    v-else
                    v-model="form.center_marker_id"
                    class="select select-bordered w-full"
                    @change="selectCenterMarker(form.center_marker_id)"
                >
                    <option :value="null">{{ i18n.no_marker }}</option>
                    <option v-for="pin in pins" :key="pin.id" :value="pin.id">{{ pin.name }}</option>
                </select>
```

to:

```html
                <MarkerPicker
                    v-else
                    :pins="pins"
                    :model-value="form.center_marker_id"
                    :i18n="i18n"
                    @change="selectCenterMarker"
                />
```

`selectCenterMarker(markerId)`'s existing implementation (already in this file, unchanged) already does exactly what's needed — sets `form.center_marker_id`, sets `centerMode.value = "marker"`, and emits `preview-center` when a matching pin is found:

```js
function selectCenterMarker(markerId) {
    form.center_marker_id = markerId;
    centerMode.value = "marker";

    const marker = props.pins.find((pin) => pin.id === markerId);
    if (marker) {
        emit("preview-center", [marker.latitude, marker.longitude]);
    }
}
```

No changes needed to this function — passing it directly as the `@change` handler works because `MarkerPicker`'s `change` payload (a marker id or `null`) matches its single parameter exactly.

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify**

Open the settings panel on a map with several markers, switch to "Marker" mode, confirm a searchable dropdown appears (typing filters the list by marker name) instead of a plain scrollable list. Select a marker — confirm the map previews centering on it (per the existing `preview-center` behavior) and `form.center_marker_id` updates. Close and reopen the settings panel with a marker already set as the center — confirm the picker opens pre-selected to that marker's name, not blank. Clear the selection via the picker's own clear control — confirm it reverts to the placeholder text and `selectCenterMarker(null)` fires (centering reverts to whatever "no marker" behavior already existed).

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/MarkerPicker.vue resources/js/components/maps/SettingsPanel.vue
git commit -m "feat: use a searchable TomSelect widget for the settings panel's marker picker"
```

---

### Task 3: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the full backend test suite for maps**

```bash
vendor/bin/sail artisan test --compact --filter=Maps
```

Expected: all passing (this plan makes no backend changes, so this just confirms no regression).

- [ ] **Step 2: Run Pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Expected: no remaining style issues (this plan is JS-only, so this should be a no-op, but run it to confirm nothing else was accidentally touched).

- [ ] **Step 3: Full manual walkthrough**

Repeat Task 1's Step 3 and Task 2's Step 4 manual checks together in one pass, plus: confirm saving a marker with a name AND a linked entity still works (the common case, unaffected by this plan), and confirm the settings panel's "Coordinates" mode (pick-on-map, preview-on-pick) still works correctly alongside the new marker picker in "Marker" mode.

- [ ] **Step 4: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own verification, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in marker-name/marker-picker end-to-end verification"
```
