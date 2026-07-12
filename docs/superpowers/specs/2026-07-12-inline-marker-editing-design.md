# Inline Marker Editing Design

## Goal

Let a map editor fully edit an existing marker (pin, label, circle, polygon, or path) directly on the map — repositioning/reshaping it live and changing any of its fields (name, colour, group, entity link, visibility, opacity, icon/shape, border colour, stroke width, circle radius) — without navigating to the legacy `maps.map_markers.edit` Blade page. Also fix the mobile UX gap where a full-screen panel covers the map, making it impossible to see what you're dragging.

## Out of Scope

- The legacy Blade edit page (`resources/views/maps/markers/edit.blade.php`, `App\Http\Controllers\Maps\MarkerController@update`) is untouched — it keeps working for anyone who navigates to it directly, this just gives the v4 explorer its own path.
- `App\Http\Controllers\Maps\Markers\MoveController` / `maps.markers.move` (the existing lat/lng-only quick-drag endpoint used outside edit mode, per [[2026-07-06-draggable-map-markers-design]]) is untouched. Quick-drag for `is_draggable` markers stays exactly as-is; it's an independent feature from explicit edit mode.
- No changes to marker creation's validation rules or payload shape — the edit payload reuses `StoreMapMarker` and the same serialization `MarkerPanel.vue` already builds for creation.
- No offline/conflict handling beyond what already exists for concurrent edits (the existing `map-marker-changed` broadcast in `useMapPresence.js` already updates `data.pins` for other viewers; editing further hardens nothing here — if two editors edit the same marker simultaneously, last save wins, same as today's behavior for any other field).
- No change to `is_draggable` semantics — during edit mode, dragging is always allowed regardless of that flag (it only gates the separate, always-on quick-drag).

## Background

Today `MapExplorer.vue` has three marker-related states: `selectedPin` (read-only, drives `DetailPanel`'s preview + delete), `draftPin` (a new, unsaved marker being placed/drawn, drives `MarkerPanel`), and `data.pins` (persisted markers rendered by `LeafletCanvas`). There is no "editing an existing marker" state — `DetailPanel`'s only route to changing a marker's fields is its `edit_url` link, which opens the legacy Blade page in a new tab, and its only live-on-map affordance is `@center`.

No JSON endpoint exists to update a marker's full field set. `App\Http\Controllers\Entity\Maps\MarkerController` has `preview`, `store`, `destroy` only. The only server-side "update" paths are `maps.markers.move` (lat/lng only, no validation) and the legacy Blade-form `maps.map_markers.update` (accepts the full field set via `StoreMapMarker`, but is a redirect/ajax-ack endpoint, not something the SPA's axios flow can consume for a JSON response).

`LeafletCanvas.vue` already has an established pattern for live, staged geometry editing — it's just scoped to *drafts*, not existing markers: `buildDraftMarker()` for pin/label placement, `startPolygonDraft()`/`startCircleDraft()`/`startPathDraft()` (using Leaflet.Editable's `editTools.startX()` to draw a *new* shape from scratch) emitting `polygon-change`/`circle-change`/`path-change` as the shape is drawn, and `*-finish` once committed. `MarkerPanel.vue` renders whenever `draftPin` is set, collecting field edits and POSTing everything together on Save.

## Architecture

### Backend: new update endpoint

- **Route**: `PATCH /w/{campaign}/entities/{entity}/map/markers/{map_marker}`, named `entities.map-markers.update`, added alongside the existing `preview`/`destroy`/`store` routes in `routes/campaigns/entities.php`.
- **Controller**: `App\Http\Controllers\Entity\Maps\MarkerController@update(StoreMapMarker $request, Campaign $campaign, Entity $entity, MapMarker $mapMarker)`. Same guard sequence as `destroy`/`preview` (`$this->campaign($campaign)->authEntityView($entity)`, `$this->guardMarker($entity, $mapMarker)`, `EntityPermission::campaign($campaign)`, `$this->authorize('update', $entity)`). Body: `$mapMarker->update($request->validated())`, return `response()->json(new PinResource($mapMarker)->campaign($campaign)->mapEntity($entity))`.
- **`PinResource`** gains `'update_url' => route('entities.map-markers.update', [$this->campaign->id, $this->mapEntity->id, $marker->id])`, following the same pattern as its existing `preview_url`/`destroy_url`.
- Reuses `StoreMapMarker` as-is — its rules already match the full field set a marker needs (`name`, `entry`, `visibility_id`, `entity_id`, `group_id`, `latitude`/`longitude`, `colour`, `shape_id`, `custom_shape`, `polygon_style.*`, `icon`, `custom_icon`, `circle_radius`, `opacity`).

### Frontend: `editingPin` state

`MapExplorer.vue` adds a fourth pin-related ref, **`editingPin`** — a local mutable copy of a marker currently being edited, kept separate from `draftPin` (create) and `selectedPin` (preview) so the three flows don't collide:

- **Entry point**: `DetailPanel.vue` adds an **Edit** button next to "Edit details" (shown under the same `preview.can_edit` condition). Clicking it copies the currently-previewed pin's full data into `editingPin.value`, closes `DetailPanel`, and — via `panelExclusivity.js` (extended with an `'edit'` kind alongside `'detail'`/`'marker'`/`'settings'`) — closes any other right-slot panel.
- **`LeafletCanvas.vue`** gains an `editingPin` prop. `buildPins()` excludes `editingPin.value?.id` from the static layer it builds from `props.pins`, and a parallel `buildEditLayer()` renders a live-editable version of that one marker instead, seeded from its existing geometry:
  - `marker`/`label` shapes: a draggable `L.marker`, `dragend` emits `edit-move` (mirrors `draft-move`). Label's tooltip already re-anchors to the marker automatically.
  - `circle`: `L.circle(latlng, {radius}).enableEdit()` (attaches Leaflet.Editable's circle editor for drag + radius-handle, vs. the draft flow's `editTools.startCircle()` which begins drawing a brand-new circle) — `editable:vertex:dragend`/`editable:dragend` emit `edit-circle-change`.
  - `poly`/`path`: `L.polygon(...)`/`L.polyline(...)`.`enableEdit()` on the existing vertices (vs. `editTools.startPolygon()`/`startPolyline()`) — same `editable:vertex:*`/`editable:dragend` events, emitting `edit-polygon-change`/`edit-path-change`.
- **`MapExplorer.vue`** handles these four new events by patching `editingPin.value` locally only (`{...editingPin.value, latitude, longitude}` etc.) — nothing is sent to the server as the user drags, per the staged-save decision.
- **Panel**: `MarkerPanel.vue` is generalized rather than duplicated. It gains a `variant: 'create' | 'edit'` prop (in addition to its existing `pin`/`i18n`/etc. props, now fed `editingPin` when `variant === 'edit'`) and:
  - Its existing internal `mode` ref (light/full detail toggle) is renamed to `detailLevel` to free up `mode` conceptually from the new `variant` prop.
  - Header/button copy switches on `variant` ("New pin" / "Save" vs. the pin's name / "Save changes").
  - Name field pre-fills from `editingPin.name` when editing.
  - `save()` branches on `variant`: POST `createUrl` (unchanged) vs. PATCH `pin.update_url`, both building the same payload shape already used today.
  - A **Delete** button is added, visible only in `variant === 'edit'`, reusing `DetailPanel`'s existing confirm-then-`destroy_url` pattern (tap once to arm, again to confirm) — this makes `DetailPanel` purely preview + Edit-button, with delete living wherever editing is happening.
- **Save/Cancel**: Save PATCHes the full payload, then `handleMarkerChanged`-style replaces the entry in `data.pins` with the response and clears `editingPin` (the static layer reappears, now updated). Cancel just clears `editingPin` — since nothing was persisted mid-edit, the original static layer reappears completely unchanged.

### Mobile: collapse-to-peek

Both `MarkerPanel.vue` flows (`create` and `edit`) render full-screen (`inset-0`) below the `md` breakpoint, per the existing pattern from [[2026-07-11-map-explorer-mobile-panels-design]]. This already blocks seeing the map during polygon/path vertex adjustment *after* the initial draw commits in the create flow today, and would block all live geometry editing in the new edit flow. Fixed once, in `MarkerPanel.vue`, for both variants:

- A new **peek** display state (distinct from the existing `detailLevel` light/full toggle, which only controls which *fields* are shown): instead of `inset-0`, the panel collapses to a compact bar pinned to the bottom (name + Save/Cancel + an expand handle), leaving the map visible and interactive above it.
- Available whenever the pin has draggable/editable geometry (i.e., not for a plain non-draggable field-only edit) — an explicit affordance in the panel toggles peek ↔ full; exact trigger is nailed down during implementation planning.
- Desktop (`md+`) is unaffected — the panel is already docked beside a fully visible map there.

## Testing

**Backend**: Pest feature tests on `entities.map-markers.update` — happy path (valid full payload persists and returns updated `PinResource`), authorization (non-editor gets 403, wrong map's marker/entity 404s via `guardMarker`), validation (reuses `StoreMapMarker`'s existing rule coverage — no new cases needed beyond confirming the route wires it up), and a check that `PinResource::toArray()` includes a correct `update_url`.

**Frontend**: no automated coverage exists for Leaflet canvas interactions in this app (established pattern for every prior v4 map explorer change) — verification is manual/live: open a marker's preview, click Edit, confirm the map shows a live-editable version of its actual current geometry (not a reset draft); drag/resize/reshape each shape type (pin, label, circle, polygon, path) and confirm the panel's Save persists exactly what was shown, while Cancel reverts to the original with no server call; confirm field edits (name/colour/group/entity link/visibility/opacity/icon/border/stroke width) round-trip correctly; confirm Delete from the edit panel works and matches `DetailPanel`'s existing confirm-twice UX; on a mobile viewport, confirm the panel can collapse to peek while dragging/reshaping and the map is visible/interactive underneath; confirm a non-editor never sees the Edit button.
