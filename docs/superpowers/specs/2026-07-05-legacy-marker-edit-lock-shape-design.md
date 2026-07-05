# Legacy Marker Edit Form: Lock Shape Type Design

## Goal

On the legacy map marker **edit** form, remove the ability to switch a marker's shape (pin/label/circle/area/path) via the tab UI. Once a marker is created, its shape is fixed. Show that marker's shape-specific fields inline instead of behind a tab bar. The **create** form is unaffected — it keeps its full tabbed UI (pin/label/circle/area/presets) for choosing a shape when making a new marker.

## Out of Scope

- No change to the create form's tabs, fields, or presets behavior.
- No change to `map-v3.js` — verified all shape-tab-dependent functions (`initTabs()`, `initCircle()`, `initPolygonDrawing()`) already early-return when their trigger element is absent, which is already what happens today when editing (e.g. `#start-drawing-polygon` never renders in edit mode currently either). Dropping the tab markup from the edit form changes no JS behavior.
- No change to `edit.blade.php`'s existing shape-dragging script block (`window.polygon.enableEdit()` etc.) — untouched, keeps working for circle/polygon/path exactly as today.
- No change to any shape-specific field's *content* (same fields, same validation, same premium gating) — this is a pure UI restructure of the edit form: tabs removed, fields shown inline instead.
- No change to the v4 explorer.
- Presets remain create-only; not addressed for edit (loading a preset doesn't make sense once a marker already exists — it re-derives a whole new marker's fields from scratch).

## Background

`resources/views/maps/markers/_form.blade.php` is currently a single shared partial included by 4 places:
- `create.blade.php` and `edit.blade.php` (always passes `$model`)
- `explore.blade.php` and `form/_markers.blade.php` (quick-add dialogs, always pass `model => null`)

Only `edit.blade.php` ever passes a real `$model`. The file currently renders a tab bar (Pin/Label/Circle/Area/[Path, edit-only]/Presets) and switches which tab is active via `$activeTab`, but nothing stops a user from clicking a *different* tab while editing, which changes the hidden `shape_id` input via `map-v3.js`'s per-tab click handlers — letting an already-created marker's fundamental shape change post-creation, which the underlying data (e.g. `custom_shape`, `circle_radius`) doesn't cleanly support.

The "main fields" section (name, entry, CSS class, opacity, background colour, marker group, tooltip popup, visibility, latitude/longitude) sits below the tabs and is common to every shape; it already branches internally on `isset($model)` for a couple of edit-only behaviors (the "entry" rich-text editor only applies once a marker exists; the WYSIWYG `editors.editor` include is only needed on edit) — these branches are legitimate and stay as they are, just relocated into a shared partial.

## Architecture

Three files:

1. **`resources/views/maps/markers/_form.blade.php`** (existing, simplified) — stays create-only (only ever included by the 3 places that pass `model => null`). Changes:
   - Remove the entire path tab `<li>` and tab-pane (currently gated `@if (isset($model) && $model->isPath())` — always false here, and paths are never created via legacy anyway).
   - Simplify the polygon tab: keep only the "start drawing" + hidden "reset" button branch (today's `@else` under `@if(isset($model))`); drop the `isset($model)` branch (helper text + always-visible reset button) since that's edit-only.
   - Replace the main-fields block with `@include('maps.markers._form_common_fields')`.
   - Remove `@includeWhen(isset($model), 'editors.editor')` (always false here now).
   - Hidden `shape_id` input keeps its `$source->shape_id ?? 1` fallback (still needed for the marker-duplication flow and the plain-pin default) but drops the now-always-null `$model->shape_id` term.

2. **`resources/views/maps/markers/_form_edit.blade.php`** (new) — included only by `edit.blade.php`. No tab markup at all. Shows, inline:
   - `isLabel()`: the existing label helper text.
   - `isCircle()`: size dropdown + circle radius field (same markup as today's circle tab-pane).
   - `isPolygon()`: custom_shape textarea + helper text + reset button + stroke colour/width/opacity fields (today's poly tab-pane, `isset($model)` branch only, unconditional now).
   - `isPath()`: custom_shape textarea + stroke width field, wrapped in the same `$campaign->boosted()` gate (today's path tab-pane content, unconditional now).
   - else (plain pin, `shape_id == 1`): icon picker, custom icon field, pin size, font colour, draggable checkbox (today's pin tab-pane).
   - `@include('maps.markers._form_common_fields')` for the shared fields.
   - `@include('editors.editor')` unconditionally (moved from `_form.blade.php`'s `@includeWhen`).
   - Hidden `shape_id` input: fixed to `{{ $model->shape_id }}`, no fallback needed (a model always exists here).

3. **`resources/views/maps/markers/_form_common_fields.blade.php`** (new) — the exact "main fields" block (name, entry, CSS class, opacity, background colour, marker group, tooltip popup, visibility, latitude/longitude) extracted verbatim from `_form.blade.php`, unchanged internally (its existing `isset($model)`/`isset($source)` branches stay, since both create and edit legitimately need different behavior for the "entry" widget). Included by both `_form.blade.php` and `_form_edit.blade.php`.

`edit.blade.php` changes one line: `@include('maps.markers._form')` becomes `@include('maps.markers._form_edit')`.

## Testing

No automated test coverage exists for Blade template rendering in this app. Verification is live/manual, covering:
- Edit a plain pin marker: shape fields show inline (icon/custom icon/pin size/font colour/draggable), no tab bar, `shape_id` hidden field is fixed.
- Edit a circle marker: size+radius fields show inline; dragging the circle on the map still works and still saves.
- Edit a polygon marker (boosted campaign): shape+stroke fields show inline; dragging a vertex still works and still saves. Also check a non-boosted campaign shows the premium CTA instead.
- Edit a path marker (boosted and non-boosted campaigns): same checks as polygon.
- Edit a label marker: helper text shows, no other shape fields.
- Create form: unchanged — all 5 tabs (Pin/Label/Circle/Area/Presets) present and working exactly as before, including drawing a brand new polygon from scratch and loading a preset.
- Quick-add dialogs (`explore.blade.php`, `form/_markers.blade.php`): unaffected, still use `_form.blade.php` unchanged.
