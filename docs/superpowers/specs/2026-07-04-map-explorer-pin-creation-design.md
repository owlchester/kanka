# Map Explorer Pin Creation (v1) — Design

**Goal:** In the Vue map explorer (`resources/js/components/maps/`), clicking a toolbar mode closes the detail panel; while in "pin" mode, clicking the map drops a temporary yellow pin at that spot and opens a new `MarkerPanel` with a name field and a Save button that persists it.

**Explicitly out of scope for this pass** (may come later): Template/preset picker, custom colour picker, shape picker, group picker, entity-link select, "Details"/full-form expansion, Rapid-mode chaining, duplicate.

## Architecture

`Toolbar.vue` becomes a controlled component for its mode selection — `MapExplorer.vue` owns `activeMode` as the single source of truth, since it now needs to react to mode changes (close the detail panel, discard any pending draft). `LeafletCanvas.vue` gains a map-wide click listener gated on `activeMode === 'pin'`, plus rendering for one optional "draft" pin (not part of the persisted `pins` array). `MarkerPanel.vue` is a new sibling to `DetailPanel.vue`, same panel shell, with just a name field and Save. Save POSTs to one new backend endpoint and the response is pushed straight into `data.pins` — no new Vue after that, it's just a normal pin.

## Frontend changes

**`Toolbar.vue`**
- `activeMode` becomes a prop (`String, default: null`) instead of a local ref; `rapid` stays local (untouched by this feature).
- `selectMode(key)` now emits `mode-change` with the new value (`props.activeMode === key ? null : key`) instead of mutating local state.
- Template/`helperText` read `props.activeMode` instead of the old local ref.

**`MapExplorer.vue`**
- New `activeMode = ref(null)`, new `draftPin = ref(null)`.
- `handleModeChange(mode)`: `activeMode.value = mode`; `selectedPin.value = null` (closes `DetailPanel`); `draftPin.value = null` (discards any unsaved draft — covers both switching away from pin mode and re-entering it).
- `Toolbar` gets `:active-mode="activeMode" @mode-change="handleModeChange"`.
- `LeafletCanvas` gets `:active-mode="activeMode" :draft-pin="draftPin" @map-click="handleMapClick"`.
- `handleMapClick({ lat, lng })`: if no draft yet, create one:
  ```js
  draftPin.value = {
      name: '',
      colour: '#f2c14e',
      shape: 'marker',
      icon: { type: 'fa', value: 'fa-solid fa-map-pin' },
      latitude: lat,
      longitude: lng,
  }
  ```
  If a draft already exists (panel already open), reposition it instead of creating a second one: `draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng }`.
- `MarkerPanel` rendered alongside `DetailPanel`: `<MarkerPanel :pin="draftPin" :i18n="data.i18n" :create-url="data.map.create_url" @close="draftPin = null" @created="onPinCreated" />`.
- `onPinCreated(pin)`: `data.value.pins.push(pin); draftPin.value = null; activeMode.value = null` (also resets `Toolbar`'s highlighted button since it's now controlled).

**`LeafletCanvas.vue`**
- New props: `activeMode: { type: String, default: null }`, `draftPin: { type: Object, default: null }`.
- New emit: `map-click`.
- In `onMounted`, after `leafletMap = L.map(...)`: `leafletMap.on('click', (e) => { if (props.activeMode === 'pin') emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng }) })`. (Leaflet marker clicks don't bubble to this handler, so clicking an existing pin is unaffected.)
- New `draftMarker` local layer variable (parallel to `pinLayer`), managed by a watcher on `props.draftPin`: remove the old one if present, and if `props.draftPin` is set, build it via the existing `buildPin()`/`pinIcon()` functions (reused as-is — draft pin's `shape`/`colour`/`icon` fields already match the same shape normal pins use) and add it directly to `leafletMap` (not the clustered `pinLayer`, so it's never grouped into a cluster). Give it `id: 'draft'` for the icon's `className` so a CSS rule can style it distinctly (dashed ring) without touching the shared `.marker-pin` styling used by real pins.
- No click handler bound to the draft marker — it's just a preview.

**`MarkerPanel.vue`** (new)
- Props: `pin: { type: Object, default: null }`, `i18n: { type: Object, required: true }`, `createUrl: { type: String, required: true }`.
- Emits: `close`, `created`.
- `v-if="pin"`, same panel shell/positioning as `DetailPanel.vue` (`fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] rounded-2xl`).
- Header: small swatch (background `pin.colour`, `fa-solid fa-map-pin` icon) + `i18n.marker.new_pin` label + close button (`@click="$emit('close')"`).
- Body: single text input, `v-model="name"`, placeholder `i18n.marker.name_placeholder`.
- Footer: Save button (`btn2 btn-primary btn-block`, label `i18n.marker.save`), disabled while saving; on click POST `{ name, latitude: pin.latitude, longitude: pin.longitude, colour: pin.colour, shape_id: 1, icon: 1 }` to `props.createUrl` via `axios.post`, then `emit('created', res.data)`.
- `watch(() => props.pin, (newPin, oldPin) => { if (newPin && !oldPin) name.value = '' })` — resets the name only when a *new* draft session starts (null → object), not when an existing draft is just repositioned (object → object).

## Backend changes

**New route** in `routes/campaigns/entities.php`, next to the existing `entities.map-markers.*` routes:
```php
Route::post('/w/{campaign}/entities/{entity}/map/markers', [EntityMapMarkerController::class, 'store'])->name('entities.map-markers.store');
```

**`EntityMapMarkerController::store()`** (`app/Http/Controllers/Entity/Maps/MarkerController.php`), same auth pattern as the existing `destroy()`:
```php
public function store(StoreMapMarker $request, Campaign $campaign, Entity $entity)
{
    $this->campaign($campaign)->authEntityView($entity);
    if (! $entity->isMap()) {
        abort(404);
    }
    EntityPermission::campaign($campaign);
    $this->authorize('update', $entity);

    $marker = MapMarker::create($request->validated() + ['map_id' => $entity->child->id]);

    return response()->json(new PinResource($marker)->campaign($campaign)->mapEntity($entity), 201);
}
```
Reuses the existing `StoreMapMarker` form request unmodified (name/lat/lng required, shape_id/icon required — all satisfied by the fixed payload above) and the existing `PinResource` (so the response can be pushed into `data.pins` with no client-side remapping, exactly like the bulk `entities.map-api` payload).

**`MapResource`** (`app/Http/Resources/Maps/Explore/MapResource.php`): add one field so the client never constructs the URL itself:
```php
'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
```

**Translations** — add to `lang/en/maps/explorer.php` under `marker`:
```php
'new_pin'           => 'New pin',
'name_placeholder'  => 'Name this pin...',
'save'              => 'Save',
```
and to `ExploreApiService::translations()`. The existing `marker.*` strings are already flattened onto `i18n` (e.g. `i18n.center`, `i18n.duplicate`, not `i18n.marker.center`) — match that: add `'new_pin' => __('maps/explorer.marker.new_pin')`, `'name_placeholder' => __('maps/explorer.marker.name_placeholder')`, `'save' => __('maps/explorer.marker.save')` alongside the existing `center`/`duplicate`/etc. entries.

## Testing

- Extend `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`: assert `map.create_url` and the three new flat `i18n` keys are present.
- Extend `tests/Feature/Entities/Maps/MarkerControllerTest.php` with `store()` coverage: creates a marker and returns it in `PinResource` shape (201); 403 for a player without update permission; 404 for a non-map entity; validation failure when both `name` and `entity_id` are missing.
- No JS test harness in this repo — `Toolbar.vue`/`MapExplorer.vue`/`LeafletCanvas.vue`/`MarkerPanel.vue` changes are verified manually in-browser: click a mode → detail panel closes; click the map in pin mode → yellow dashed-ring pin appears + panel opens; click elsewhere while panel open → pin moves; Save → pin becomes a real, clickable, non-dashed pin and persists across reload; switching to a different toolbar mode with an open draft discards it.
