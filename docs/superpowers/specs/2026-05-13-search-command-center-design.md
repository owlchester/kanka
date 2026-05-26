# Search Command Center — Design Spec

**Date:** 2026-05-13
**Status:** Approved

## Overview

Replaces the current inline search dropdown (NavSearch.vue) with a Raycast-style command center dialog. Clicking the search bar or pressing `K` opens a modal dialog that shows recent entities at rest, live entity-name search by default, and an inline full-text Meilisearch search when toggled. The separate full-text search page becomes redundant. The entity preview panel is removed.

---

## Section 1: Search Trigger (modified NavSearch.vue)

**File:** `resources/js/components/layout/NavSearch.vue`

NavSearch.vue is slimmed to a trigger-only button. It no longer manages search state, results, or the dropdown. It renders:
- A search icon
- A "Search…" placeholder text
- A keyboard shortcut hint (`K`)

On click (or `K` keypress via the existing `keyboard.js` shortcut), it sets a global `commandCenterOpen` state to `true`, which the CommandCenter component watches to open the dialog.

The global open/close state is managed via a small Vue composable (`useCommandCenter.js`) that both the trigger and the dialog import — a shared `ref(false)` exposed as `isOpen` with `open()` and `close()` helpers.

---

## Section 2: CommandCenter Dialog

**Files:**
- `resources/js/components/search/CommandCenter.vue` — dialog shell, overlay, keyboard handling
- `resources/js/components/search/CommandInput.vue` — input field + full-text toggle
- `resources/js/components/search/CommandResults.vue` — grouped result sections + keyboard navigation
- `resources/js/composables/useCommandCenter.js` — shared open/close state

**CommandCenter.vue** uses Vue's `<Teleport to="body">` to render the overlay and dialog at the document root, avoiding z-index conflicts with the sidebar or other positioned elements. It:
- Renders a full-screen backdrop (click to close)
- Renders the dialog panel (max-width ~640px, centered)
- Listens for `Escape` to close
- On open, fetches the rest-state data from `/search/recent`
- On close, resets query and results

**CommandInput.vue** renders:
- Search input, focused on mount
- A "Full text" toggle button (right side of input row)
- Emits `query-changed` (debounced 350ms) and `mode-changed` events
- Reads/writes full-text preference to `localStorage` key `kanka_search_mode` (`name` | `fulltext`)

**CommandResults.vue** receives `query`, `mode`, `restData` (recent/bookmarks/indexes), and `results` as props, and renders sections:

Rest state (empty query):
1. **Recent** — up to 5 recently clicked entities (avatar, name, type)
2. **Bookmarks** — user's sidebar bookmarks (icon, name)
3. **Quick jump** — entity type index pages (icon, name)

Name search state (query present, mode = `name`):
1. **Entities** — matched entities (avatar, name, type, private lock icon if applicable)
2. **Pages** — fuzzy-matched admin pages + entity type indexes

Full-text state (query present, mode = `fulltext`):
1. **Content matches** — Meilisearch results (avatar, name, type, highlighted snippet)

Keyboard navigation: arrow keys move a `focusedIndex` cursor across all visible items (flat list regardless of section). `Enter` navigates to the focused item's URL. `Ctrl+F` on the focused input toggles full-text mode (click on the toggle button also works).

Clicking any result navigates to its URL and fires a POST to `/search/log/{entity}` (for entity results only) to update the recent cache.

**Removed components** (files to delete):
- `resources/js/components/layout/Lookup/LookupEntity.vue`
- `resources/js/components/layout/Lookup/LookupPage.vue`
- `resources/js/components/layout/Lookup/EntityPreview.vue`

---

## Section 3: `/search/command` Endpoint

**Route:** `GET /w/{campaign}/search/command`
**Controller:** `app/Http/Controllers/Search/CommandController.php`
**Service:** `app/Services/Search/CommandSearchService.php`

Query parameters:
- `q` — search query (required, min 2 chars)
- `mode` — `name` (default) or `fulltext`

**Name mode response:**
```json
{
  "entities": [
    { "id": 1, "name": "Silvain Duskwood", "type": "Character", "is_private": false, "image": "...", "link": "..." }
  ],
  "pages": [
    { "name": "Campaign Settings", "icon": "cog", "url": "...", "group": "admin" },
    { "name": "All Characters", "icon": "...", "url": "...", "group": "index" }
  ]
}
```

Entity results use the existing `SearchService` (name LIKE search) with `->limit(8)` — the service accepts a configurable limit, default is 10. Pages results are fuzzy-matched from `AdminPageService` (see Section 5) using a simple `str_contains` / Levenshtein approach — no DB query.

**Full-text mode response:**
```json
{
  "results": [
    {
      "entity_id": 12,
      "name": "Aldric Greymoor",
      "type": "Character",
      "image": "...",
      "link": "...",
      "snippet": "…trained under <mark>Silvain</mark> for three years before the fall of…"
    }
  ]
}
```

Full-text results come from `EntitySearchService` (existing Meilisearch client), enhanced with:
```php
'attributesToHighlight' => ['name', 'entry'],
'attributesToCrop' => ['entry'],
'cropLength' => 20,
'highlightPreTag' => '<mark>',
'highlightPostTag' => '</mark>',
```

After fetching hits, the service strips all HTML tags from `_formatted.entry` except `<mark>` (using a targeted regex or `strip_tags` with allowed tags), then eager-loads entity URLs and avatars in a single `whereIn` query. Returns up to 20 results per query.

---

## Section 4: `/search/log/{entity}` Endpoint

**Route:** `POST /w/{campaign}/search/log/{entity}`
**Controller:** `app/Http/Controllers/Search/LogController.php`

Calls `RecentService::logView($entity)`. Returns `204 No Content`. The Vue component fires this as a fire-and-forget `fetch` (no `await`, no error handling needed) on result click.

Replaces the previous logging in `PreviewController::index()`.

---

## Section 5: AdminPageService

**File:** `app/Services/Search/AdminPageService.php`

Returns a static array of pages available within a campaign. Each entry has `name`, `icon`, `url` (generated via `route()`), and `group` (`admin` | `index`). The controller passes the `$campaign` at construction time for URL generation.

Initial page list includes:
- Campaign Settings, Members, Roles, Entity Types, Webhooks, Plugins, Recover Entities
- All entity type index pages (Characters, Locations, Maps, Journals, etc.) — sourced from `EntityTypeService` (already used in `RecentService`)

Matching logic in `CommandController`: filter entries where `stripos($page['name'], $q) !== false`. Simple and fast — no fuzzy library needed at this scale.

---

## Section 6: Meilisearch Index Settings

**File:** `config/scout.php`

Add `searchableAttributes` to the `entities` index settings:
```php
'searchableAttributes' => ['name', 'entry'],
```

Order matters — `name` matches rank higher than `entry` matches.

**File:** `app/Console/Commands/SetupMeilisearch.php`

Add the corresponding call during index setup:
```php
$client->index('entities')->updateSearchableAttributes(['name', 'entry']);
```

Run `artisan scout:sync-index-settings` to apply — no reindex required.

---

## Section 7: Full-text Search Page (deprecation)

**File:** `app/Http/Controllers/Search/FullTextController.php`

The `/search/fulltext` route and view remain in place for now (avoid breaking bookmarked URLs or direct links). The view can be updated to show a notice pointing to the new command center. No immediate removal.

The "view all results" link in the old NavSearch dropdown is removed as part of the Vue component rewrite.

---

## Section 8: Recent Entity Logging

`PreviewController::index()` currently calls `RecentService::logView()`. Once the new `/search/log` endpoint is in place and the preview panel is removed, delete the `logView()` call from `PreviewController`. The preview endpoint itself can remain for any other consumers but no longer side-effects the recent cache.

---

## Section 9: Component Registration

**File:** `resources/js/header.js`

Replace:
```js
app.component('nav-search', NavSearch);
```
With:
```js
app.component('nav-search', NavSearch);         // now just the trigger
app.component('command-center', CommandCenter); // new dialog
```

The `<command-center>` tag is added to the header blade layout alongside `<nav-search>`. Because `CommandCenter` uses `<Teleport to="body">`, it renders outside `<header>` in the DOM regardless.

**File:** `resources/views/layouts/header.blade.php`

Add `<command-center />` alongside the existing `<nav-search>` tag. No other layout changes needed.
