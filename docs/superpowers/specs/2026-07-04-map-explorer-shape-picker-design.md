# Map Explorer Shape/Icon Picker — Design

**Goal:** Add a `ShapePicker.vue` component to `MarkerPanel.vue`'s full mode, letting the user pick the new pin's icon glyph (pin/circle/square/diamond/triangle/question/exclamation, or a custom FontAwesome class on boosted campaigns), reflected live on the map and in the panel header.

## Icon mapping

Matches the legacy `icon` int enum already resolved server-side by `MapMarker::exploreIcon()` (`app/Models/MapMarker.php:250-294`) — no backend changes needed, this is a frontend-only feature:

| Shape | `icon` int |
|---|---|
| pin (default) | 1 |
| question | 2 |
| exclamation | 3 |
| square | 6 |
| circle | 7 |
| diamond | 8 |
| triangle | 9 (renders as `fa-solid fa-caret-up`) |

"Custom" is not a numbered shape — it sets `custom_icon` (a free FontAwesome class string), which `exploreIcon()` already prefers over `icon` whenever it's non-empty and `campaign->boosted()` is true (confirmed by reading the method directly — this precedence is pre-existing, unrelated to this feature). `shape_id` is untouched, stays fixed at `marker` (1) per the original pin-creation plan's scope.

## Data flow

Entirely frontend, since `StoreMapMarker`, `MapMarker`, and `PinResource` already fully support `icon`/`custom_icon`.

- `draftPin` (owned by `MapExplorer.vue`) gains two new raw fields alongside the existing rendering `icon` object (`{type, value}`, used by `LeafletCanvas.pinIcon()`/`buildPin()` and the panel header): `iconId` (Number, default `1`) and `customIcon` (String|null, default `null`). A fresh draft (map click while no draft exists) initializes both to their defaults; repositioning an existing draft leaves them untouched (same spread pattern already used for lat/lng).
- `MarkerPanel.save()` sends `icon: props.pin.iconId, custom_icon: props.pin.customIcon` in the POST body, replacing the current hardcoded `icon: 1` (no `custom_icon` was sent before).
- `ShapePicker.vue` emits `change` with `{ icon, custom_icon, render }` — `render` is the resolved `{type:'fa', value}` object for immediate display — whenever a shape button is clicked or a custom value is committed. `MarkerPanel.vue` forwards this upward (a new event, e.g. `icon-change`); `MapExplorer.vue` handles it by replacing `draftPin` with a new spread object: `draftPin.value = { ...draftPin.value, iconId: payload.icon, customIcon: payload.custom_icon, icon: payload.render }`. A *new* object reference is required — `LeafletCanvas.vue`'s draft-marker watcher is reference-based (`watch(() => props.draftPin, ...)`, not deep), so an in-place mutation would silently fail to re-render, the same class of bug already found and fixed once in this codebase for the pins array.
- `MarkerPanel.vue`'s header swatch changes from hardcoded `fa-solid fa-map-pin` to `:class="pin.icon?.value"`, so it reflects the current selection too.

## `ShapePicker.vue`

- Props: `pin` (Object, required — reads `pin.iconId`/`pin.customIcon` to determine the highlighted button), `boosted` (Boolean, default `false`), `i18n` (Object, required).
- Emits: `change` (payload shape above).
- Default view: a row of 7 shape buttons (pin/question/exclamation/square/circle/diamond/triangle) plus an 8th "custom" button. The button matching the current selection is highlighted (`bg-accent`/`text-accent-content`, matching `Toolbar.vue`'s existing convention) — `customIcon` set wins the highlight over `iconId` (matches `exploreIcon()`'s own precedence).
- Custom button default face (before any custom value is set): `fa-solid fa-ellipsis`. Once a custom value exists, the button renders that value's own icon instead.
- Clicking "custom":
  - If `boosted`, replaces the entire button row with a text input (autofocused, prefilled with the current `pin.customIcon` if set).
  - If not `boosted`, does not enter text mode — shows `i18n.premium_custom_icon` ("Unlock custom pins with a premium campaign") below the row instead.
- While in the text input: committing on `keydown.tab` **or** `blur` (blur included so clicking Save right after typing, without tabbing out first, doesn't silently drop the value) emits `change` with the typed class as `custom_icon` (and `icon` left at `1` as an inert fallback, matching `exploreIcon()`'s precedence) and returns to the button row.

## Backend

One Blade change only (no controller/resource/route changes): `resources/views/entities/pages/map/index.blade.php` gains a `boosted` prop on `<map-explorer>`, mirroring the existing `can-edit` prop:

```blade
:boosted="@if ($campaign->boosted()) true @else false @endif"
```

`MapExplorer.vue` gains a `boosted` prop (Boolean, default `false`), threaded through `MarkerPanel.vue` to `ShapePicker.vue`.

New i18n string: `i18n.premium_custom_icon` = "Unlock custom pins with a premium campaign" (added to `lang/en/maps/explorer.php`'s `marker` group and `ExploreApiService::translations()`, matching the existing flat-i18n convention).

## Testing

No backend logic changed (icon/custom_icon fields and their resolution already existed and were already tested indirectly via the existing marker-creation tests), so no new Pest tests are needed for this pass. No JS/Vue automated test harness exists in this repo — verified manually in-browser: click each standard shape and confirm the map/header update; on a boosted campaign, enter a custom class, tab out, confirm it renders and persists on Save; on a non-boosted campaign, confirm clicking custom shows the error message and never enters text-input mode.
