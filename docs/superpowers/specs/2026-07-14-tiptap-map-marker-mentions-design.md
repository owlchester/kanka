# Tiptap @ Mentions for Map Marker Descriptions Design

## Goal

Replace the plain-textarea marker description field (`DescriptionField.vue`, shipped as deliberate prep boilerplate) with the app's existing Tiptap rich-text editor, full toolbar, including working `@` mentions backed by real `entity_mentions` tracking. This forces every user onto the new editor for map markers specifically, both delivering the feature and gathering broader feedback on Tiptap ahead of a wider rollout.

Builds directly on the `entity_mentions` polymorphic refactor (merged): `MapMarker` becomes a new `mentionable_type` with zero schema changes.

## Out of Scope

- Replacing Summernote/legacy editors anywhere outside the Maps v4 marker panel. Entity pages, posts, etc. keep their existing per-user editor preference.
- The legacy Blade marker edit page (`resources/views/maps/markers/_form.blade.php`, `App\Http\Controllers\Maps\MarkerController`) — already has its own full Tiptap `entry` editor via the Blade-mount bootstrap, untouched by this work.
- Mentions rolling up under a map's own entity Mentions tab — deliberately out: `EntityMappingService::resolveEntityId()`'s new `MapMarker` branch returns `null`, matching `Campaign`'s precedent. Mentions remain fully tracked and backlinked from the target entity's side (`targetMentions()`); they just don't appear as "things I contain" on any owning entity's page.
- A self-mention guard for markers. Post/TimelineElement/QuestElement guard against mentioning their own structural parent entity; a marker's optional `entity_id` ("linked entity", what the pin *represents*) isn't a structural parent-child relationship the same way, so no guard is added.
- Inline quick-edit mode in `DescriptionField.vue`. Once the field holds real Tiptap HTML, a plain-text inline edit path could silently flatten formatting/mentions on save — it's removed rather than made conditionally unsafe.

## Background

Two things landed just before this spec: the `entity_mentions` polymorphic refactor (`mentionable_type`/`mentionable_id`, `docs/superpowers/specs/2026-07-14-entity-mentions-polymorphic-refactor-design.md`) and the marker description field prep work (plain textarea, `2026-07-13-map-marker-description-field-design.md`) — both already merged to `feature/map4`.

Current state, verified against the merged code:

- `MapMarker` already `use HasEntry` (purify + mention-parse pipeline already runs on every save) but has **no `mentions()` relation**, so `EntryObserver::saved()`'s `method_exists($model, 'mentions')` check fails and `EntityMappingJob` never dispatches for markers — no `EntityMention` rows are created today regardless of what's typed.
- `StoreMapMarker::validated()` unconditionally routes `entry` through `wrapEntryParagraphs()`, which HTML-escapes and wraps *plain text* into `<p>`/`<br>` — built specifically because the marker field was, until now, plain-text-only. Feeding it real Tiptap HTML would double-escape.
- `PinResource` returns raw `entry` (unparsed bracket-syntax text), no edit-friendly or display-parsed variant.
- `resources/js/editors/tiptap/Tiptap.vue` is never imported as a plain Vue component today — it's always mounted by a Blade-driven bootstrap (`editors/tiptap/index.js`) onto DOM nodes, writing output to a hidden `<input>` for classic form submits. It has no `update:modelValue` emit.
- `DescriptionField.vue` (from the prep spec) has three states — collapsed / inline-editing / preview-with-edit-button — plus an expand dialog, all plain-text, using `resources/js/maps/entryText.js`'s `htmlToPlainText`/`htmlToPreviewText`.
- Maps are Entity-backed (`Map extends MiscModel`, same auto-paired-Entity pattern as `Character`/`Quest`/`Timeline`), so a Campaign context is always available via `$map->campaign` — `route('search.mention', [$campaign])` only requires the campaign, not an entity.

## Architecture

### Backend: `MapMarker` as a mentionable type

- `MapMarker::mentions(): MorphMany` — `return $this->morphMany(EntityMention::class, 'mentionable');`, same hand-rolled pattern as `Post`/`TimelineElement`/`QuestElement` (not the `HasMentions` trait, which is `entity_id`-keyed and doesn't fit — a marker isn't an `Entity`).
- `EntityMappingService`:
  - `$model` type union gains `MapMarker`.
  - `createNewMention()`: new branch — `mentionable()->associate($this->model)`, no self-mention guard (falls into the same "no guard" shape as the existing `Campaign` branch).
  - `resolveEntityId()`: `MapMarker` → `null`.
  - `campaignID()`: `MapMarker` → `$this->model->map->campaign_id`.

### Backend: save path

- `StoreMapMarker::validated()` stops routing `entry` through `wrapEntryParagraphs()` — real HTML from Tiptap already goes through `HasEntry`'s existing purify + mention-parse pipeline (`Purify::clean()`, bracket-syntax rewrite), identical to every other `entry`-bearing model. `wrapEntryParagraphs()` itself is deleted (it has no other caller).
- `PinResource` gains `entry_for_edition` (`$marker->getEntryForEditionAttribute()`, from `HasEntry` — rewrites stored `[type:id]` bracket text into the shape Tiptap's `MentionParser` extension expects on load, so existing mentions reconstruct as real mention nodes when a marker is reopened for editing). The existing raw `entry` field stays for the `entryTouched`-guard comparison in `MarkerPanel.vue`.
- `DetailPanel.vue`'s read-only description display switches from raw `entry` to `$marker->parsedEntry()` (bracket syntax → real `<a>` links) so mentions render as clickable links there.
- `MapResource` gains `mentions_url` (`route('search.mention', [$campaign])`), `gallery_url` (`route('gallery.tiptap', [$campaign])`), `gallery_upload_url` (`route('campaign.gallery.ajax-upload', $campaign)`) — mirrors `tiptap_editor.blade.php`'s existing prop wiring exactly.

### Frontend: `Tiptap.vue` gets a v-model

Add `const emit = defineEmits(['update:modelValue'])`, firing at the same point the component currently writes its internal `html` ref to the hidden `<input>`. Purely additive — the Blade-mounted bootstrap path (`editors/tiptap/index.js`, every entity-page usage) doesn't listen for the emit and is unaffected; the hidden `<input>` write stays for that path.

### Frontend: `DescriptionField.vue`

State machine simplifies to two states: **collapsed** ("Add description" button, no content yet) and **preview** (rendered `htmlToPreviewText` truncation + "Edit" button). Both open the same expand dialog. The dialog hosts a full `<Tiptap>` instance (all extensions/toolbar buttons — tables, images, gallery, iframe, details — enabled, matching entity pages) instead of a plain `<textarea>`, wired with `mentions`/`gallery`/`galleryUpload` props threaded down from `data.map`. Save/Cancel semantics unchanged in shape — Save copies the dialog's draft (now HTML, not plain text) into the component's `text` ref and emits `change`; Cancel discards and closes.

### Frontend: wiring

- `MarkerPanel.vue`'s `buildPayload()` stops calling `htmlToPlainText(props.pin.entry)` for the `entry` field — sends the raw HTML through as-is. The existing `entryTouched` gate (only send `entry` if the user actually touched the field, protecting untouched content from flattening on unrelated saves) is unchanged — it now protects real Tiptap formatting/mentions instead of the plain text it protected before.
- `MapExplorer.vue` → `MarkerPanel.vue` → `DescriptionField.vue` thread `mentions_url`/`gallery_url`/`gallery_upload_url` from `data.map` (new `MapResource` fields) down as props, alongside the existing `i18n`/`pin` props.
- Initial content fed into the dialog's Tiptap instance on open comes from `pin.entry_for_edition` (new `PinResource` field), not `pin.entry`.

## Testing

**Backend (Pest)**:
- `MapMarker::mentions()` returns only markers-owned `EntityMention` rows.
- `EntityMappingService` creates a `MapMarker`-owned mention on marker save (via the full `HasEntry`/`EntryObserver`/`EntityMappingJob` pipeline, matching the `entity_mentions` refactor's existing test style), with `entity_id` staying `null` and no self-mention guard applied.
- `campaignID()` resolves correctly via `$marker->map->campaign_id`.
- `StoreMapMarker` accepts real HTML in `entry` without double-escaping (characterization test confirming `wrapEntryParagraphs()` no longer runs on this path).
- `PinResource` includes `entry_for_edition`; `MapResource` includes the three new URLs.

**Manual** (no automated Vue component test coverage exists anywhere in this codebase — established precedent per every prior v4 map explorer spec): create a marker, add a description with bold text, a link, and an `@` mention via the expand dialog; save and reopen — confirm formatting and the mention both round-trip correctly. Confirm the mentioned entity's own page shows the marker mention in its backlinks/mentions list. Confirm the map's own entity page does *not* show it. Confirm the collapsed/preview states render correctly for both an empty and a populated description.
