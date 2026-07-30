# Map Explorer mobile panel layout

## Problem

`MapExplorer.vue` renders four floating side panels — Legend (top-left), and
Detail/Marker/Settings (all top-right, same slot) — plus a header row and a
tiling-migration prompt, all as `fixed`, fixed-width boxes. Nothing stops more
than one panel being open at once:

- Legend and any right-slot panel are already independent today and can be
  open together (desktop layout keeps them visually separate).
- The three right-slot panels (Detail, Marker, Settings) share the exact same
  `fixed top-4 right-4 bottom-4 w-80` box and can, in edge cases, end up open
  simultaneously (e.g. Detail panel open, user clicks the gear icon to open
  Settings) — they visually collide today, on desktop included.

On mobile there's no room for any of this: fixed 288–320px wide panels
consume the whole viewport, so any combination of panels open at once is
unusable.

## Goals

- Fix the right-slot collision (Detail/Marker/Settings) on all screen sizes.
- Preserve the ability to have Legend + one right-slot panel open together on
  wide/desktop screens (4k users use this to keep info and legend visible
  side by side).
- Make panels usable on mobile by going full-screen, with only one panel
  (Legend, or one right-slot panel) visible at a time below the `md` (768px)
  breakpoint — matching the existing mobile/desktop convention used elsewhere
  in the app (`maps.css`, `mobile.css`).

## Design

### Exclusivity model

Two independent groups:

- **Right-slot group**: `selectedPin` (Detail), `draftPin` (Marker),
  `settingsOpen` (Settings). Mutually exclusive at all times — opening any
  one clears the other two. Applies on every screen size; this is the fix for
  the existing desktop collision.
- **Legend**: independent of the right-slot group at `md` and up (both can be
  open together, as today). Below `md`, opening Legend clears whatever is
  open in the right-slot group and vice versa. This is a hard discard, not a
  hide/restore — closing a panel this way drops its state exactly like
  clicking its own close button would (deselects the pin, drops the in-progress
  draft, etc.), no separate "remember and restore" behavior.

No new tagged-union state is introduced. The existing refs
(`selectedPin`, `draftPin`, `settingsOpen`, `legendOpen`) stay as they are;
each of their setters (`selectPin`, the draft-pin creation branch in
`handleMapClick`, `openSettings`, and the legend-toggle handler) gains logic
to clear the refs it's now exclusive with. The mobile-only cross-group clear
is implemented in the same setters, gated on viewport width via a Tailwind
`md:` breakpoint check (no JS media-query logic — see below).

### Responsive panel shell

- `DetailPanel.vue`, `MarkerPanel.vue`, `SettingsPanel.vue` currently share
  `fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden`.
  This becomes `fixed inset-0 rounded-none ... md:top-4 md:right-4 md:bottom-4 md:left-auto md:w-80 md:rounded-2xl`
  (exact utility list to be finalized during implementation) — full-screen
  below `md`, unchanged floating corner box at `md` and up.
- `LegendPanel.vue` gets the equivalent treatment: `fixed inset-0 rounded-none ...`
  below `md`, existing `top-20 left-4 bottom-24 w-72 rounded-2xl` at `md` and up.
- `LegendPanel.vue` currently has no close affordance of its own — it's only
  toggled via the legend-toggle button in the header row. Since the header
  row hides on mobile while a panel is open (see below), Legend needs its own
  `[X]` button in its header, emitting a new `close` event that the parent
  wires to `legendOpen = false`. Shown at all screen sizes (harmless on
  desktop, not just a mobile-only addition).
- Detail/Marker/Settings already have working close buttons emitting `close`
  — no change needed there beyond the wrapper classes.

### Header and tiling-prompt visibility on mobile

The top header row (map name/menu, presence avatars, legend-toggle button)
and the tiling-migration-prompt box both sit at `z-[1200]`, above all panels.
Below `md`, while any panel is open, both are hidden entirely (not just
covered) so their controls don't overlap full-screen panel content and there
isn't a redundant way to trigger the same actions. Implemented as a Tailwind
class binding — e.g. `:class="anyPanelOpenOnMobile ? 'hidden md:flex' : 'flex'"`
— no JS-side viewport detection; `anyPanelOpenOnMobile` is a computed that
only cares whether a panel is open (the `hidden`/`md:flex` pairing handles the
breakpoint).

### Toolbar

Left unchanged. It's compact and bottom-centered and isn't part of the
collision problem; full-screen panels will naturally cover it while open,
same as they'd cover the map.

## Components touched

- `MapExplorer.vue` — exclusivity logic in the panel setters, header/tiling-prompt
  visibility binding.
- `LegendPanel.vue` — add close button + `close` emit.
- `DetailPanel.vue`, `MarkerPanel.vue`, `SettingsPanel.vue` — wrapper class
  changes only.

## Out of scope

- Toolbar layout changes.
- Any bottom-sheet / drag-to-resize interaction — full-screen overlay only.
- Changing how panels behave above `md` beyond the right-slot exclusivity fix.
