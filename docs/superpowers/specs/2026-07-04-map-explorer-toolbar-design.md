# Map Explorer: Drawing Toolbar (v1)

**Date:** 2026-07-04
**Branch:** `feature/map4`

Builds on `docs/superpowers/specs/2026-07-03-entity-map-vue-explorer-design.md` (base `MapExplorer.vue` / `LeafletCanvas.vue` / `LegendPanel.vue` / `DetailPanel.vue`) and `docs/superpowers/specs/2026-07-03-map-explorer-interactions-design.md`. This spec adds a bottom toolbar for entering drawing/placement modes. **Scope for this pass: render the toolbar and its mode-selection UI only** — no actual map interaction (dropping pins, drawing shapes) is wired up yet; that's future work.

## Goal

A toolbar fixed to the bottom-center of the map, visible only to users who can edit the map (`@can('update', $entity)`), with:
- A **Rapid** toggle, independent of the other modes (stays on/off regardless of which drawing tool is selected).
- Five mutually-exclusive mode buttons: **Pin**, **Text**, **Area**, **Circle**, **Path**.
- Selecting a mode highlights that button and shows a helper-text pill above the toolbar describing what clicking on the map will do in that mode.

## Frontend: `Toolbar.vue` (new, `resources/js/components/maps/Toolbar.vue`)

Props: `i18n` (object, required), `canEdit` (Boolean, default `false`).

State: `activeMode` ref (`null | 'pin' | 'text' | 'area' | 'circle' | 'path'`), `rapid` ref (Boolean, default `false`). Clicking a mode button toggles it (clicking the active mode again clears `activeMode` back to `null`). Clicking Rapid just flips `rapid` — never touches `activeMode`.

Markup, top to bottom:
1. Helper pill (`v-if="activeMode"`): `bg-accent text-accent-content rounded-full px-4 py-2 text-sm`, centered above the bar. Text from `i18n.toolbar.helper[activeMode]`.
2. Bar: `bg-base-100 rounded-2xl shadow-lg flex items-center gap-1 px-2 py-2`, `v-if="canEdit"`.
   - Rapid button: pill-shaped (`rounded-full`), a small dot + `i18n.toolbar.rapid` label; `bg-accent text-accent-content` when `rapid` is true, otherwise neutral.
   - Vertical divider (`border-l`).
   - Five buttons (icon stacked above label), each `cursor-pointer`, `bg-accent text-accent-content rounded-xl` when it's the `activeMode`:
     - Pin — `fa-regular fa-location-dot`, `i18n.toolbar.pin`
     - Text — `fa-regular fa-font`, `i18n.toolbar.text`
     - Area — `fa-regular fa-draw-polygon`, `i18n.toolbar.area`
     - Circle — `fa-regular fa-circle`, `i18n.toolbar.circle`
     - Path — `fa-regular fa-route`, `i18n.toolbar.path`

No emits yet — purely local UI state, since nothing downstream consumes the selected mode in this pass.

## Frontend: `MapExplorer.vue`

New prop `canEdit` (Boolean, default `false`), passed straight through to a new `<Toolbar :i18n="data.i18n" :can-edit="canEdit" />` rendered alongside the existing panels.

## Blade: `entities/pages/map/index.blade.php`

`<map-explorer>` gets a new bound attribute:
```
:can-edit="@can('update', $entity) true @else false @endcan"
```
Mirrors the legacy `resources/views/maps/explore.blade.php`'s `@can('update', $map->entity)` gate. Works as a real Vue boolean binding (not a string attribute) because this app's Vue build uses the full compiler (`vite.config.js` aliases `vue` to `vue/dist/vue.esm-bundler`, which supports in-DOM template compilation — confirmed by how `api`/`loading-text`/`error-text` already work on this same element).

## i18n

New keys in `lang/en/maps/explorer.php` under a `toolbar` array: `rapid`, `pin`, `text`, `area`, `circle`, `path`, and `helper` sub-array (`pin`, `text`, `area`, `circle`, `path`) with the helper strings from the spec ("Click the map to drop a pin", "Click to place a text label", "Click to add points, double-click to close", "Click and drag to draw a circle", "Click to add points along the path").

`ExploreApiService::translations()` adds a `toolbar` key building this nested structure from `__()` calls, passed through as `data.i18n.toolbar` — no change to the flat top-level keys already there.

## Testing

No backend logic changes beyond a translation array and a Blade `@can` gate — no new Pest tests needed (existing `entities.map-api` tests already cover the `i18n` shape generically, and the `@can` gate mirrors an already-tested policy). Toolbar rendering/toggle behavior verified manually in-browser (no JS/Vue test suite exists for this page, per the base spec).
