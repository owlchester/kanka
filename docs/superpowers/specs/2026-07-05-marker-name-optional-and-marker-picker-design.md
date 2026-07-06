# Optional Marker Name and Searchable Marker Picker Design

## Goal

Two small, independent improvements to the v4 map explorer:

1. Allow saving a new map marker with an empty name when an entity is linked to it (the marker already displays the entity's name in that case — the frontend just blocks the save unnecessarily).
2. Replace the plain `<select>` marker picker in the quick-settings panel's "center on a marker" mode with a searchable TomSelect widget, so it stays usable on maps with hundreds of markers.

## Out of Scope

- No backend, model, or `PinResource`/`markerTitle()` changes — research confirmed all three already correctly handle an empty marker name backed by a linked entity (`app/Http/Requests/StoreMapMarker.php`'s `'name' => 'nullable|string|required_without:entity_id'`, `App\Models\MapMarker::markerTitle()`, `App\Http\Resources\Maps\Explore\PinResource`). This is a frontend-only fix.
- No new npm dependency — `tom-select` is already installed and already used elsewhere in v4 (`resources/js/components/maps/EntityLinkSelect.vue`).
- No change to `EntityLinkSelect.vue` itself, or to its remote-search behavior — the new marker picker is a separate component with a local (not remote) data source.
- No "None" list entry in the new picker — clearing back to no-marker-selected uses TomSelect's own built-in clear control, not an explicit option.

## Architecture

**1. Optional marker name** — `resources/js/components/maps/MarkerPanel.vue`'s Save button currently disables whenever `name` is empty, regardless of whether an entity is linked (`:disabled="saving || !name.trim()"`, unaware of `pin.entityId`). Change the condition to `:disabled="saving || (!name.trim() && !pin.entityId)"` — save is blocked only when there's neither a name nor a linked entity, matching the backend's `required_without:entity_id` rule exactly.

**2. `MarkerPicker.vue`** (new component, `resources/js/components/maps/`) — mirrors `EntityLinkSelect.vue`'s structure (a bare `<select ref="selectEl">` mounted into a `TomSelect` instance in `onMounted`, destroyed in `onBeforeUnmount`), but swaps the remote `load()` callback for a one-time local `addOptions()` call, since every marker is already loaded client-side in `MapExplorer.vue`'s `data.pins`:
```js
props: { pins: Array (required), modelValue: Number|null (default null), i18n: Object (required) }
emits: ['change']  // payload: selected marker id (Number) or null when cleared

onMounted(() => {
    ts = new TomSelect(selectEl.value, {
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        placeholder: props.i18n.no_marker,
        onChange(value) {
            emit('change', value ? Number(value) : null)
        },
    })
    ts.addOptions([...props.pins].sort((a, b) => a.name.localeCompare(b.name)))
    if (props.modelValue) {
        ts.setValue(props.modelValue, true)  // true = silent, no onChange fired
    }
})
```
`SettingsPanel.vue`'s marker-mode block changes from the plain `<select v-model="form.center_marker_id" @change="selectCenterMarker(form.center_marker_id)">...</select>` to `<MarkerPicker :pins="pins" :model-value="form.center_marker_id" :i18n="i18n" @change="selectCenterMarker" />` — `selectCenterMarker(markerId)`'s existing signature (a single id or `null`) doesn't change, so no other code in `SettingsPanel.vue` needs updating.

## Testing

No automated test coverage exists for Vue component interaction in this app (matching the established pattern for every other v4 map explorer change on this branch) — verification for both changes is manual/live: (1) create a marker with an entity linked and no name, confirm Save is enabled and the marker saves correctly, displaying the entity's name; confirm Save still correctly stays disabled with neither a name nor an entity; (2) open the settings panel's marker mode on a map with several markers, confirm the picker shows a searchable/filterable dropdown seeded from the existing marker list, confirm selecting one sets the center as before, and confirm the picker correctly pre-selects the map's current `center_marker_id` (if any) when the panel opens.
