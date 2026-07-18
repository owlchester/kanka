# Map Legend "Add Group" Design

## Goal

Let editors create a new map group directly from the legend panel (`LegendPanel.vue`), without leaving the map explorer. A new "Add group" button opens a dialog (styled like `PresetModal.vue`) with Name, Colour, Parent group, Placement, "show group marker" toggle, and Visibility. On save the group is persisted and spliced into the live legend tree.

## Out of Scope

- Editing or deleting groups from this dialog. Only creation.
- Any UI for reordering existing groups (drag-reorder). Placement only applies to where the *new* group lands.
- Indentation/tree-depth display in the Parent group `<select>` — it's a flat alphabetical list. Depth-aware rendering can be added later if it turns out to matter.
- Rendering an actual map marker for "show group marker" — the field is stored (`is_shown`) but nothing currently draws group-level markers on `LeafletCanvas`; that's an existing, separate feature gap.
- Any change to the legacy Blade group form/controller (`app/Http/Controllers/Maps/GroupController.php`) or its reorder endpoint — untouched.

## Background

`LegendPanel.vue` is currently read-only: it renders a searchable tree of existing groups/pins (via `buildGroupTree`/`filterGroupTree` in `resources/js/maps/groupTree.js`) with no create/edit/delete affordance anywhere in the Vue explorer. Groups can only be created today through the legacy full-page Blade form.

Presets already have this exact pattern end-to-end — `PresetModal.vue` (dialog UI), `entities.map-presets.store` (backend route), `MapPolicy`-gated creation — and groups have none of it. This design adds the group equivalent, reusing presets' shape wherever it fits.

Two real gaps surfaced during investigation that this design must also close, since "Placement" is meaningless without them:

1. **`ExploreApiService::load()` sends `groups` unordered.** `Map::groups()` has no default order, and `load()` calls it with no `orderBy`/`->ordered()`. `MapGroup::scopeOrdered()` exists (`orderByDesc('position')->orderBy('name')`) but is never invoked in the explorer path. Whatever order MySQL happens to return is what the Vue legend renders in.
2. **`position` is caller-assigned with no auto-append.** The column is nullable, has no DB default, and nothing in `MapGroup` computes it automatically. The legacy Blade form's own insert logic (`GroupController::store()`) shifts sibling `position` values when a `position` is submitted, and treats `position` as an **ascending** "slot number" (1 = first) — the opposite direction from `scopeOrdered()`'s descending read. That inherited inconsistency is legacy behavior we are not fixing; this design defines its own self-consistent, ascending convention (`position 0` = first) scoped to the new create-group path and the explorer's read path, without touching the legacy form or its reorder endpoint.

## Architecture

### Backend

**Ordering fix** — `app/Services/Maps/ExploreApiService.php::load()`: change `$this->map->groups` to `$this->map->groups()->orderBy('position')->orderBy('name')->get()`. Ascending: lower `position` (nulls sort first in MySQL) displays earlier. This only affects the Vue explorer's read path; the legacy Blade pages keep using `scopeOrdered()` untouched.

**New route** — `entities.map-groups.store`, added alongside `entities.map-presets.*` in `routes/campaigns/entities.php`.

**New controller** — `app/Http/Controllers/Entity/Maps/GroupController.php::store()`, same skeleton as `PresetController`/`MarkerController`: `CampaignAware`/`GuestAuthTrait`, `abort(404)` unless `$entity->isMap()`, `$this->authorize('addGroup', $map)` (existing `MapPolicy::addGroup`, already enforces the standard/premium group-count limit — no new limit logic needed), validate, create, return `response()->json(new GroupResource($group), 201)`.

**New form request** — `StoreExploreMapGroup` (the legacy request `StoreMapGroup` is already taken by `app/Http/Controllers/Maps/GroupController.php` and has different fields/semantics — same reason `PresetController` has its own `StoreMapPreset` distinct from legacy `StorePreset`, rather than reusing it):
```
name        => required|string|max:191
colour      => nullable|string|max:7
parent_id   => nullable|integer|exists:map_groups,id (scoped to same map)
visibility_id => required|integer|exists:visibilities,id
is_shown    => boolean
after_id    => nullable|integer|exists:map_groups,id (scoped to same map + same parent_id)
```
`after_id` absent/null means "insert first". Note this dialog only ever creates **new** groups, so there is no `position`/`update_url`/`destroy_url` concern for existing rows beyond the shift described below.

**Position assignment** (in the controller, inside a transaction):
1. Siblings = groups where `map_id` matches and `parent_id` equals the submitted `parent_id` (both null-safe), ordered `position asc, name asc` — same ordering `load()` now uses, so this matches what the user saw in the Placement dropdown.
2. `after_id` null → `newPosition = 0`; shift every sibling with `position >= 0` (i.e. all of them) up by 1.
3. `after_id` set → `newPosition = target.position + 1`; shift every sibling with `position > target.position` up by 1.
4. Create the group with `position = newPosition`.

**Resource / URL wiring** — no change to `GroupResource` (Explore): it already returns `id, name, parent_id, position, colour`, which is sufficient for the frontend to splice the new group into `data.groups` and have the legend tree re-render correctly. Add `group_store_url` to `Maps/Explore/MapResource.php`, built the same way `preset_store_url` is, and populate it from `ExploreApiService`.

### Frontend

**`GroupModal.vue`** — new file, structural clone of `PresetModal.vue`:
- Native `<dialog class="dialog rounded-2xl bg-base-100 text-base-content w-full md:w-[32rem]" aria-modal="true">`, opened via `defineExpose({ open() })` + `showModal()`.
- Header: colour-swatch box (bound to the colour field) + kicker line `i18n.new_group` ("New group") + big title = `name || i18n.untitled_group` ("Untitled group") + close button.
- Body fields, in order:
  - Name — plain text input, `v-model`.
  - Colour — `<ColourPicker :colour="colour" :label="..." @change="colour = $event" />`.
  - Parent group — native `<select v-model="parentId">`: first option "— Top level —" (`null`), then every existing group flat, alphabetical by name.
  - Placement — native `<select v-model="afterId">`, **only rendered when `siblings.length > 0`** (siblings = groups sharing the currently-selected `parentId`, computed client-side from the `groups` prop, sorted `position asc, name asc` to match the backend). Options: "First" (`null`) then "After {sibling.name}" for each sibling in order.
  - Show group marker — checkbox + helper text, same markup as the existing `is_draggable` block in `PresetModal.vue`/`MarkerPanel.vue`, labels reusing the existing legacy strings ("Show group markers" / "Show markers in this group by default on the map.").
  - Visibility — `<VisibilitySelect :pin="{ visibilityId }" :options="visibilities" :i18n="i18n" @change="visibilityId = $event" />`. `VisibilitySelect` only reads `pin.visibilityId` off its `pin` prop, so passing a minimal `{ visibilityId }` object reuses the component as-is without modification.
- Footer: `Cancel` (`btn2 btn-default`) / `Create group` (`btn2 btn-primary`, disabled while `saving`). No delete button — this dialog never edits.
- `submit()`: `axios.post(props.groupStoreUrl, payload)`, emit `created` with the returned group on success; same `error` ref + inline error `<p>` pattern as `PresetModal.vue` for validation/limit failures (e.g. the `addGroup` policy's count limit surfaces as a normal 403/422 here).

**`LegendPanel.vue`**:
- New `canEdit: Boolean` prop (doesn't currently have one).
- "Add group" button appended at the end of the panel, visible only when `canEdit`, emits `add-group`.

**`MapExplorer.vue`**:
- Renders `<GroupModal ref="groupModalRef" :i18n="data.i18n" :groups="data.groups" :visibilities="data.visibilities" :group-store-url="data.map.group_store_url" @created="onGroupCreated" />`, following the same ownership pattern `PresetModal` has inside `MarkerPanel` — except this one is owned by `MapExplorer` since it's triggered from the legend, not the marker panel.
- `<LegendPanel :can-edit="canEdit" ... @add-group="groupModalRef.value?.open()" ... />`.
- `onGroupCreated(group)` → `data.value.groups = [...data.value.groups, group]` (mirrors `onPresetCreated`). Since `groups` is now delivered pre-ordered by the backend on initial load, and the new group's `position` was computed server-side to land in the right slot, appending to the array and letting `buildGroupTree` do its normal (insertion-order-preserving) walk is correct **only if** the frontend also sorts by `position`/`name` before building the tree — otherwise a "First" or "After X" placement wouldn't visually reflect until the next full reload. To avoid a live-ordering bug, sort `data.groups` by `(position ?? 0, name)` ascending immediately before passing to `buildGroupTree` in `LegendPanel.vue` (small addition to `groupTree.js` or inline in `LegendPanel.vue`, whichever keeps `buildGroupTree` itself pure).

## Testing

**Backend (Pest)**:
- New `GroupControllerTest.php` (or extend an existing explorer-controller test file, matching whatever convention `MarkerControllerTest`/`PresetControllerTest` use): create a group via the v4 JSON route; assert `201` + resource shape; assert `visibility_id`/`is_shown`/`colour` persist; assert `parent_id` scoping (rejects a `parent_id` belonging to a different map).
- Position math: create three groups with no parent — first with `after_id = null`, second `after_id = <first.id>`, third `after_id = null` — assert final `position` values place them in the expected order (third first, first second, second third) and that fetching the map's groups via `ExploreApiService`-equivalent ordering returns that exact sequence.
- `MapPolicy::addGroup` limit still enforced (mirrors whatever existing test covers preset/marker limits, adapted for groups) — creating past the standard-plan cap returns `403`.
- Legacy Blade `maps.map_groups.*` routes/tests untouched and still pass (characterization, not new coverage).

**Frontend**: no automated component-interaction coverage exists for this app's Vue map explorer (established pattern per prior specs, e.g. `2026-07-13-map-marker-description-field-design.md`) — verify by hand: open the legend, click "Add group" (only visible when `canEdit`), create a top-level group with no existing siblings (Placement hidden), create a second one as "First" and a third "After" the first, confirm the legend reflects the chosen order immediately without a reload; create a nested group via the Parent dropdown and confirm it appears under its parent in the tree; confirm the dialog's error state surfaces a policy-limit rejection.
