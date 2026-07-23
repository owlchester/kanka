# Map Marker Description Field Design

## Goal

Add a "Description" field to the map explorer's marker create/edit panel (`MarkerPanel.vue`), backed by the existing `entry` column on `MapMarker`. Ship the full interaction flow now — collapsed/preview/editing states and a full-screen expand dialog — using a plain `<textarea>` (no formatting, no HTML, no `@mentions`), so the flow can be validated end to end before a richer tiptap-based editor is dropped in later.

## Out of Scope

- The tiptap-based rich editor. This is deliberately deferred; the `<textarea>` built here is temporary boilerplate to prove the interaction flow, not the final editing surface.
- `@mention` support, inline formatting, or any WYSIWYG behavior.
- The legacy Blade marker edit page (`resources/views/maps/markers/_form.blade.php`, `App\Http\Controllers\Maps\MarkerController`). It already has its own full tiptap `entry` editor and keeps working exactly as today — see the "why `validated()`, not the controller" note below for how this is guaranteed.
- Any database migration — `entry` already exists on `map_markers`, is `$fillable`, and already runs through `HasEntry`/`EntryObserver` (mention-parsing + `Purify::clean()`) on every save.
- A character/length limit, client-side or server-side. No other `entry` field in this codebase (`StoreCharacter`, `StoreItem`, `StoreLocation`, `UpdateEntityEntry`, etc. — checked all of them) validates a `max:` length; this field stays consistent with that existing convention rather than inventing a new one. (Corrected post-implementation: an earlier draft of this section claimed a "generous safety cap" would be added — it wasn't, and per this consistency check, shouldn't be.)

## Background

`MapMarker` already `use HasEntry`, and `StoreMapMarker::rules()` already validates `'entry' => 'nullable|string'` — this FormRequest is shared by **two** controllers:

- `App\Http\Controllers\Entity\Maps\MarkerController` (the v4 JSON API used by `MapExplorer.vue`/`MarkerPanel.vue`) — calls `$request->validated()`.
- `App\Http\Controllers\Maps\MarkerController` (the legacy Blade form, with its own tiptap `entry` editor) — calls `$request->only($this->fields)`, which never touches `validated()`.

This split means `entry` can already be submitted and persisted through the v4 API today — nothing rejects it — but two things are missing: `PinResource` doesn't return `entry` in its response (so the panel has nothing to load on edit), and there's no server-side step that turns plain textarea text into the `<p>`-wrapped HTML the rest of the app expects `entry` to contain (`HasEntry`'s pipeline purifies and mention-parses whatever HTML it's given, but doesn't invent paragraph structure from bare newlines — confirmed `AutoFormat.AutoParagraph` is explicitly `false` in `config/purify.php`).

Because the legacy controller never calls `->validated()`, the paragraph-wrapping step can live on `StoreMapMarker::validated()` itself without any risk of it double-processing the legacy editor's already-rich HTML.

## Architecture

### Backend

- **`PinResource`**: add `'entry' => $marker->entry` — the raw stored HTML (not `parsedEntry()`), since the simple editor doesn't resolve mentions and we don't want mention-link markup complicating the plain-text round-trip.
- **`StoreMapMarker`**: override `validated($key = null, $default = null)`. After calling `parent::validated(...)`, if the result contains (or, for the single-key form, *is*) the `entry` value, run it through a new `wrapEntryParagraphs(?string $text): ?string` helper:
  - Return early (unchanged) for `null` or blank input.
  - Normalize line endings, split on blank lines (`/\n{2,}/`) into paragraphs.
  - For each paragraph: HTML-escape it (`e()`), convert single newlines within it to `<br>` (`nl2br`), wrap in `<p>…</p>`.
  - Join paragraphs with no separator (each is already a self-contained block element).
  - Escaping before wrapping means any literal `<`/`>`/`&` the user types is treated as plain text, matching "no HTML" — `Purify::clean()` (already run downstream by `EntryObserver`) is a second, redundant safety net, not the only one.
- No controller changes: `store()`/`update()` already do `MapMarker::create($request->validated() + [...])` / `$mapMarker->update($request->validated())`, so the wrapped value flows straight through the existing `HasEntry` save pipeline (mention-parse no-op on plain text + purify), exactly like every other `entry`-bearing model already works.

### Frontend: text conversion (pure JS)

New `resources/js/maps/entryText.js`, dependency-free (no Vue, no DOM APIs) so it's testable with plain `node:test`, matching `polygon.js`/`panelExclusivity.js`:

- **`htmlToPlainText(html)`**: `<br>` → `\n`; a paragraph boundary (`</p><p ...>`) → `\n\n`; remaining `<p>`/`</p>` and any other tags stripped; the five common HTML entities (`&amp;` `&lt;` `&gt;` `&quot;` `&#039;`/`&#39;`) decoded back to literal characters (symmetric with the backend's `e()` escaping); trimmed. Empty/falsy input → `""`. Running it on plain text (no tags) is a no-op — needed because after a local, unsaved edit, `pin.entry` holds plain text rather than HTML until the whole panel is saved.
- **`htmlToPreviewText(html)`**: `htmlToPlainText(html)` with all whitespace (including paragraph breaks) collapsed to single spaces — feeds the truncated preview, which relies on CSS `line-clamp-2` for the actual visual truncation rather than manual character-counting.

### Frontend: `DescriptionField.vue`

New component in `resources/js/components/maps/`, props `pin` (object) + `i18n` (object), emits `change` with plain text — same shape as `ColourPicker`/`OpacityPicker`/etc. so it drops into `MarkerPanel.vue`'s existing prop/emit relay pattern.

Local state: one `editing` ref (boolean) and one `text` ref (string, initialized via `htmlToPlainText(pin.entry)`), used solely as the inline/dialog textarea's `v-model`. A computed `hasContent = computed(() => htmlToPlainText(pin.entry).trim().length > 0)` drives which non-editing state to show. Three visual states:

- **A — collapsed** (`!editing && !hasContent`): just an "Add description" button. No label, no expand icon — matches the spec that the icon lives next to the label, and there is no label here.
- **B — editing** (`editing`): label "Description" + expand icon/tooltip + a 3-row `<textarea v-model="text">`. Typing emits `change` live on every input (mirroring `MarkerPanel.vue`'s existing `watch(name, ...)` → `emit("name-change", ...)` pattern for the name field).
- **C — preview** (`!editing && hasContent`): label + expand icon/tooltip + `<div class="line-clamp-2">{{ htmlToPreviewText(pin.entry) }}</div>` + a small "Edit" button. The preview always reads `pin.entry` directly (the parent's canonical value, per the one-way-data-flow pattern every other picker in `MarkerPanel.vue` already follows) rather than the local `text` ref — it's only shown while `!editing`, so `pin.entry` is guaranteed current.

Transitions: "Add description" (A) and "Edit" (C) both set `editing = true` (textarea already seeded). The expand icon is present in both B and C; clicking it always opens the dialog, seeded from the current `text` value, regardless of which state it was clicked from.

**Dialog**: native `<dialog>`, styled like the rest of the app (`dialog rounded-2xl bg-base-100 text-base-content`, `<header>`/`<article>`/`<footer>` structure), opened/closed via a template `ref` + `showModal()`/`close()` — modeled on `GalleryDialog.vue`. Contains a large `<textarea>` (its own local draft string, seeded from `text` on open) and Cancel/Save buttons.

- **Cancel**: discards the dialog's draft, closes. No change to `editing` or `text` — the component returns to whatever state it was in before the icon was clicked.
- **Save**: copies the dialog's draft into `text` (which emits `change`, same as inline typing would), sets `editing = true`, closes. One rule regardless of entry point: "the dialog is just a bigger way to edit the same textarea; after using it, you're in the normal edit view."

### Wiring

- **`MarkerPanel.vue`**: `<DescriptionField :pin="pin" :i18n="i18n" @change="$emit('entry-change', $event)" />` inside the existing `detailLevel === 'full'` block (same visibility gating as `ColourPicker`/`OpacityPicker`/etc. — only the name input is always visible), placed directly after the name input. `buildPayload()` gains `entry: props.pin.entry`.
- **`MapExplorer.vue`**: `toEditingPin()` gains `entry: pin.entry`; the four draft-creation sites (`handleMapClick`, `handlePolygonFinish`, `handleCircleFinish`, `handlePathFinish`) default `entry: ""`; new `handleEntryChange(text)` → `patchActivePin({ entry: text })`; `<MarkerPanel @entry-change="handleEntryChange" ... />`.
- **i18n**: new keys under `maps/explorer.marker.*` — `description`, `add_description`, `edit_description`, `description_expand` (expand-icon tooltip text), `cancel` (new, generic within this namespace — reused for any future dialog in this component). The dialog's Save button reuses the existing `save` key. Wired through `lang/en/maps/explorer.php` and `ExploreApiService::translations()`, same as every other string already flowing into this component.

## Testing

**Backend (Pest)**: extend `MarkerControllerTest.php` —
- Create and update via the v4 JSON route with a multi-paragraph, blank-line-separated plain-text `entry`; assert the stored/returned value is correctly `<p>`-wrapped (including a `<br>` for a single-newline case within one paragraph) and that literal `<`/`>` characters in the input are escaped, not interpreted as tags.
- A characterization test confirming the legacy `maps.map_markers.update` route's rich-HTML `entry` passes through unwrapped/unmodified — proving the `validated()` override doesn't touch that path.
- `PinResource` includes the correct `entry` value.

**Frontend (node:test)**: new `entryText.test.js` covering `htmlToPlainText`/`htmlToPreviewText` — multi-paragraph round-trip, `<br>` within a paragraph, entity decoding, empty/null input, and idempotence on already-plain text.

**Manual**: no automated coverage exists for live Vue component interaction in this app (established pattern for every prior v4 map explorer change, per `2026-07-12-inline-marker-editing-design.md` and others) — verify by hand: create a new pin, expand to full details, add a description, save, reopen and confirm the preview renders; edit an existing description via both the inline textarea and the expand dialog; confirm Cancel in the dialog discards changes; confirm a pin with no description shows the collapsed "Add description" state on both create and edit.
