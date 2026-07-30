# Circle Drawing in MapExplorer v4

## Goal

Wire up the Toolbar's existing but unwired "circle" mode in the new map explorer (`resources/js/components/maps/MapExplorer.vue`), letting users draw a circle by clicking and dragging on the map, adjust its size by dragging the resize handle right up until save, style it (fill colour, opacity), and see it persist and re-render correctly on reload.

## Out of scope

- A discrete size picker (tiny/small/standard/large/huge/custom). Considered and dropped in favor of relying entirely on the native click-and-drag gesture plus a live-draggable resize handle — the drag already gives full, precise control over the radius before saving, so a separate numeric/preset UI would be redundant.
- Border colour / stroke width. Circles always render with `stroke: false` in the already-shipped rendering code (`LeafletCanvas.vue`'s existing `buildPin` circle branch) — there is no border to style.
- Escape-to-reset / Ctrl+Z. Circle drawing is a single continuous mousedown→drag→mouseup gesture with no multi-step vertex history to undo or abandon mid-shape the way polygon drawing has, so there's nothing meaningful for these shortcuts to do here.
- Whole-circle dragging (repositioning the center after the initial placement). Not requested; only the resize handle (radius) stays interactive, matching the same "vertex-level edits only, no whole-shape drag" scope already applied to polygons.
- Any change to `app/Models/MapMarker.php`'s legacy rendering methods (`circleRadius()`, `circleMarker()`) or to the old map page. This plan only touches the new v4 explorer stack and its already-exposed `circle_radius` field.

## Flow

1. User clicks the "circle" toolbar button → `activeMode = 'circle'`.
2. User clicks and drags on the map. Leaflet.Editable's native circle-drawing gesture (`editTools.startCircle()`) sets the center on mousedown and live-updates the radius as the user drags, exactly like the pre-written toolbar helper text already describes ("Click and drag to draw a circle").
3. Releasing the mouse commits the circle in the same motion — Leaflet.Editable's `CircleEditor.onDrawingMouseUp` calls `commitDrawing()` immediately, firing `editable:drawing:commit` (the same event polygon drawing already uses to signal "finished"). Unlike polygon, there is no separate double-click/click-first-vertex finish step, so the doubleClickZoom suppression added for polygons isn't needed for circles.
4. On commit, `MapExplorer.vue` builds a `draftPin` (shape `circle`) from the circle's center and radius and opens `MarkerPanel.vue`, same as the existing pin/text/polygon draft flow.
5. The circle's resize handle stays draggable while the panel is open (commit does not disable editing, matching polygon's live-vertex-edit behavior) — dragging it fires the same live-update path, keeping `draftPin.circleRadius` in sync, right up until Save.
6. Closing the panel or saving removes the draft circle layer and resets `activeMode`/`draftPin` (existing pattern), respecting Rapid mode exactly like polygon and marker/text drafts already do.

## Data model

No new columns needed. `MapMarker` already has:
- `circle_radius` (nullable integer, already validated in `StoreMapMarker` and already exposed in `PinResource`).
- `shape_id` = `MapMarkerShape::circle` (3).

`size_id` is not used by this feature at all — left null/unset on circles created through the new explorer. `MapMarker::circleRadius()` (the legacy PHP rendering helper) already prefers `circle_radius` whenever it's set, falling back to a `size_id`-derived formula only when `circle_radius` is empty, so this is safe and requires no backend changes.

Draft pin shape while drawing:

```js
{
  name: "",
  colour: defaultColour(),       // fill
  shape: "circle",
  shapeId: 3,
  icon: { type: "fa", value: "fa-solid fa-map-pin" },
  iconId: 1,
  customIcon: null,
  circleRadius: <current radius in meters, from the live circle>,
  groupId: null,
  entityId: null,
  entityName: null,
  visibilityId: <default>,
  opacity: 50,                    // matches the polygon default; full opacity is rarely wanted
  latitude: <center lat>,
  longitude: <center lng>,
}
```

The `icon`/`iconId`/`customIcon` defaults are included from the start this time — their absence on the polygon draft caused a live-testing-only-caught 422 (`StoreMapMarker`'s `icon` field is `required|integer` regardless of shape), so circle drafts get the same defaults `handleMapClick`'s marker/text draft already uses.

## Known edge case (documented, not fixed here)

`MapMarker::circleRadius()` (legacy PHP, used by the old map page's rendering) re-applies a real-map multiplier (50×) to *any* stored `circle_radius` value at render time, regardless of how it got there. A circle created through the new v4 explorer stores the radius Leaflet naturally produces from the drag gesture (already a true, final distance in the units the new explorer's own rendering expects — `LeafletCanvas.vue`'s existing `buildPin` circle branch uses `circle_radius` directly with no multiplier). If that same circle were ever viewed through the *old* legacy map page on a real/OSM map, it would render roughly 50× too large, since the legacy renderer would multiply a value that's already final. This mirrors the same class of narrow, non-blocking cross-path drift already accepted for polygon's two independent `custom_shape` parsers (flagged in that plan's final review as Minor). Not fixing legacy PHP rendering as part of this plan.

## Frontend changes

- **`LeafletCanvas.vue`**
  - Add a parallel circle-draft lifecycle (`startCircleDraft()`/`stopCircleDraft()`), mirroring the existing `startPolygonDraft()`/`stopPolygonDraft()` structure but for `L.Circle`:
    - `startCircleDraft()`: `leafletMap.editTools.startCircle(undefined, { fillColor, fillOpacity, stroke: false })`, using the same `defaultPolygonStyle`-style prop passed down from `MapExplorer.vue` (reusing `colour`/`opacity`, no `stroke`/`stroke-width` needed here).
    - Listens for `editable:vertex:dragend` (the resize-handle drag) → emits `circle-change` with the current center + radius.
    - Listens for `editable:drawing:commit` → emits `circle-finish` with the current center + radius, and marks the circle as "editing" (matching `polygonEditing`'s role) so a subsequent draftPin-cleared-while-still-in-circle-mode re-arms a fresh draw, exactly like polygon's restart pattern.
    - `stopCircleDraft()`: `disableEdit()`, remove the layer, clear state. No doubleClickZoom handling needed (see Flow, step 3).
  - Extend the `watch(() => [props.activeMode, props.draftPin], ...)` watcher (or add a parallel one) to drive `startCircleDraft`/`stopCircleDraft` the same way it already drives the polygon draft, keyed on `activeMode === 'circle'`.
  - No changes needed to `buildPin`'s existing circle branch (already renders saved circles correctly) or to `buildPins()` (circles were never filtered out).
  - New emits: `circle-change`, `circle-finish`.

- **`MapExplorer.vue`**
  - `handleCircleFinish({ lat, lng, radius })`: build the `draftPin` as shown above, open `MarkerPanel`.
  - `handleCircleChange({ lat, lng, radius })`: update `draftPin.circleRadius` (and center, in case the center ever needs adjusting) while a circle draftPin is active.
  - Wire the two new `LeafletCanvas` events in the template.

- **`MarkerPanel.vue`**
  - No new fields — `ColourPicker` and `OpacityPicker` already render unconditionally for `mode === 'full'` regardless of shape, so they already apply to circle drafts.
  - `save()` payload gains `circle_radius: pin.shape === 'circle' ? Math.round(pin.circleRadius) : undefined`.

## Testing

- Pest feature test on `MarkerController::store` with a `circle_radius` payload (`shape_id: 3`) — assert it persists and that `PinResource` returns it (mirrors the existing polygon test in `tests/Feature/Entities/Maps/MarkerControllerTest.php`).
- No new pure-JS helper module is needed this time (no formula to unit test), so no `node:test` additions.
- Manual/live verification (per the `verify` skill, as done for polygon): draw a circle, confirm the resize handle stays draggable before save, save, confirm it renders and persists after reload, and confirm Rapid mode lets you draw another circle immediately without reselecting the toolbar button.
