# Search Command Center Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the header search dropdown and full-text search page with a Raycast-style command center dialog supporting entity name search, inline full-text Meilisearch search with highlighted snippets, and quick navigation to admin/index pages.

**Architecture:** A new Vue 3 dialog (`CommandCenter.vue`) is teleported to `<body>` via `<Teleport>` to avoid z-index issues, opened by a slimmed-down `NavSearch.vue` trigger via a shared composable (`useCommandCenter.js`). Two new Laravel endpoints handle unified search (`/search/command`) and recent-entity logging (`/search/log/{entity}`). The existing full-text search page is preserved but made redundant.

**Tech Stack:** Vue 3 (Options API, `<Teleport>`), Meilisearch PHP SDK v1.x (`SearchQuery`), `SearchService`, `EntitySearchService`, Font Awesome icons, `localStorage` for mode persistence.

---

## File Map

**Created:**
- `app/Services/Search/AdminPageService.php`
- `app/Services/Search/CommandSearchService.php`
- `app/Http/Controllers/Search/CommandController.php`
- `app/Http/Controllers/Search/LogController.php`
- `resources/js/composables/useCommandCenter.js`
- `resources/js/components/search/CommandCenter.vue`
- `resources/js/components/search/CommandInput.vue`
- `resources/js/components/search/CommandResults.vue`

**Modified:**
- `config/scout.php` — add `searchableAttributes` to entities index settings
- `app/Console/Commands/SetupMeilisearch.php` — add `updateSearchableAttributes` call
- `app/Services/Search/EntitySearchService.php` — add `searchWithSnippets()` method
- `app/Http/Controllers/Search/RecentController.php` — add new text keys for command center sections
- `routes/campaigns/search.php` — add `/search/command` and `/search/log/{entity}` routes
- `resources/js/components/layout/NavSearch.vue` — slim to trigger button only
- `resources/js/header.js` — register `CommandCenter` component
- `resources/views/layouts/header.blade.php` — add `<command-center>` tag
- `app/Http/Controllers/Entity/PreviewController.php` — remove `logView` call

**Deleted:**
- `resources/js/components/layout/Lookup/LookupEntity.vue`
- `resources/js/components/layout/Lookup/LookupPage.vue`
- `resources/js/components/layout/Lookup/EntityPreview.vue`

---

## Task 1: Meilisearch searchableAttributes

**Files:**
- Modify: `config/scout.php`
- Modify: `app/Console/Commands/SetupMeilisearch.php`

- [ ] **Step 1: Update config/scout.php**

Add `searchableAttributes` to the entities index settings. Order matters — `name` matches rank higher than `entry`.

```php
// config/scout.php — inside 'meilisearch' => ['index-settings' => ['entities' => [...]]]
'filterableAttributes' => ['id', 'campaign_id'],
'sortableAttributes' => ['name', 'entry'],
'searchableAttributes' => ['name', 'entry'],
```

- [ ] **Step 2: Update SetupMeilisearch.php**

After the `updateFilterableAttributes` call on line 54, add:

```php
$client->index('entities')->updateFilterableAttributes(['campaign_id']);
$client->index('entities')->updateSearchableAttributes(['name', 'entry']);
```

- [ ] **Step 3: Sync settings to Meilisearch**

```bash
vendor/bin/sail artisan scout:sync-index-settings
```

Expected output: no errors, Meilisearch processes in the background (index stays live).

- [ ] **Step 4: Commit**

```bash
git add config/scout.php app/Console/Commands/SetupMeilisearch.php
git commit -m "feat: set meilisearch searchableAttributes priority for command center"
```

---

## Task 2: AdminPageService

**Files:**
- Create: `app/Services/Search/AdminPageService.php`

- [ ] **Step 1: Create the service**

```bash
vendor/bin/sail artisan make:class app/Services/Search/AdminPageService --no-interaction
```

- [ ] **Step 2: Implement AdminPageService**

Replace the generated file with:

```php
<?php

namespace App\Services\Search;

use App\Traits\CampaignAware;
use Illuminate\Support\Str;

class AdminPageService
{
    use CampaignAware;

    /**
     * Return all admin pages matching the given query, or all pages if query is empty.
     */
    public function match(string $query): array
    {
        $pages = $this->allPages();

        if (empty($query)) {
            return $pages;
        }

        return array_values(array_filter($pages, function (array $page) use ($query): bool {
            return Str::containsAll(mb_strtolower($page['name']), [mb_strtolower($query)]) ||
                stripos($page['name'], $query) !== false ||
                stripos($page['group'], $query) !== false;
        }));
    }

    protected function allPages(): array
    {
        $campaign = $this->campaign;

        return [
            [
                'name' => __('campaigns.edit.title'),
                'icon' => 'fa-solid fa-cog',
                'url' => route('campaigns.edit', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.members.title'),
                'icon' => 'fa-solid fa-users',
                'url' => route('campaign_users.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.roles.title'),
                'icon' => 'fa-solid fa-shield-halved',
                'url' => route('campaign_roles.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('webhooks.title'),
                'icon' => 'fa-solid fa-webhook',
                'url' => route('webhooks.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('entity_types.title'),
                'icon' => 'fa-solid fa-layer-group',
                'url' => route('entity_types.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('campaigns.plugins.title'),
                'icon' => 'fa-solid fa-plug',
                'url' => route('campaign_plugins.index', $campaign),
                'group' => 'admin',
            ],
            [
                'name' => __('recovery.title'),
                'icon' => 'fa-solid fa-rotate-left',
                'url' => route('recovery', $campaign),
                'group' => 'admin',
            ],
        ];
    }
}
```

- [ ] **Step 3: Commit**

```bash
git add app/Services/Search/AdminPageService.php
git commit -m "feat: add AdminPageService for command center page search"
```

---

## Task 3: EntitySearchService — searchWithSnippets

**Files:**
- Modify: `app/Services/Search/EntitySearchService.php`

- [ ] **Step 1: Add the Avatar facade import and searchWithSnippets method**

Open `app/Services/Search/EntitySearchService.php`. Add the `Avatar` facade import after existing imports:

```php
use App\Facades\Avatar;
```

Then add this method after the existing `search()` method:

```php
/**
 * Search with Meilisearch snippets for the command center full-text mode.
 * Returns up to 20 results with a highlighted excerpt from the entry field.
 */
public function searchWithSnippets(string $term): array
{
    $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

    $query = (new SearchQuery)
        ->setIndexUid('entities')
        ->setQuery($term)
        ->setFilter(['campaign_id = ' . $this->campaign->id])
        ->setAttributesToRetrieve(['id', 'entity_id', 'type', 'name'])
        ->setAttributesToHighlight(['name', 'entry'])
        ->setAttributesToCrop(['entry'])
        ->setCropLength(20)
        ->setHighlightPreTag('<mark>')
        ->setHighlightPostTag('</mark>')
        ->setLimit(20)
        ->setHitsPerPage(20);

    $results = $client->multiSearch([$query]);
    $hits = $results['results'][0]['hits'] ?? [];

    if (empty($hits)) {
        return [];
    }

    $entityIds = array_unique(array_column($hits, 'entity_id'));
    $entities = Entity::select(['id', 'name', 'is_private'])
        ->with(['image', 'entityType'])
        ->whereIn('id', $entityIds)
        ->get()
        ->keyBy('id');

    $output = [];
    foreach ($hits as $hit) {
        $entity = $entities->get($hit['entity_id']);
        if (! $entity) {
            continue;
        }

        $rawSnippet = $hit['_formatted']['entry'] ?? '';
        $snippet = strip_tags($rawSnippet, '<mark>');
        if (! empty($snippet)) {
            $snippet = '…' . trim($snippet) . '…';
        }

        $output[] = [
            'id' => $entity->id,
            'name' => $entity->name,
            'is_private' => $entity->is_private,
            'image' => Avatar::entity($entity)->fallback()->size(64)->thumbnail(),
            'link' => $entity->url(),
            'type' => $entity->entityType->name(),
            'snippet' => $snippet,
            'log_url' => route('search.log', [$this->campaign, $entity->id]),
        ];
    }

    return $output;
}
```

- [ ] **Step 2: Commit**

```bash
git add app/Services/Search/EntitySearchService.php
git commit -m "feat: add searchWithSnippets to EntitySearchService for command center"
```

---

## Task 4: CommandSearchService

**Files:**
- Create: `app/Services/Search/CommandSearchService.php`

- [ ] **Step 1: Create the service**

```bash
vendor/bin/sail artisan make:class app/Services/Search/CommandSearchService --no-interaction
```

- [ ] **Step 2: Implement CommandSearchService**

```php
<?php

namespace App\Services\Search;

use App\Services\SearchService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CommandSearchService
{
    use CampaignAware;
    use UserAware;

    public function __construct(
        protected SearchService $searchService,
        protected EntitySearchService $entitySearchService,
        protected AdminPageService $adminPageService,
    ) {}

    /**
     * Name mode: entity name search + matching admin/index pages.
     */
    public function name(string $term): array
    {
        $result = $this->searchService
            ->campaign($this->campaign)
            ->user($this->user)
            ->term($term)
            ->full()
            ->v2()
            ->limit(8)
            ->find();

        $entities = collect($result['entities'] ?? [])
            ->map(fn (array $entity) => array_merge($entity, [
                'log_url' => route('search.log', [$this->campaign, $entity['id']]),
            ]))
            ->values()
            ->toArray();

        return [
            'entities' => $entities,
            'pages' => $this->adminPageService->campaign($this->campaign)->match($term),
        ];
    }

    /**
     * Full-text mode: Meilisearch results with highlighted snippets.
     */
    public function fulltext(string $term): array
    {
        return [
            'results' => $this->entitySearchService
                ->campaign($this->campaign)
                ->searchWithSnippets($term),
        ];
    }
}
```

- [ ] **Step 3: Commit**

```bash
git add app/Services/Search/CommandSearchService.php
git commit -m "feat: add CommandSearchService for unified command center search"
```

---

## Task 5: CommandController + LogController + routes

**Files:**
- Create: `app/Http/Controllers/Search/CommandController.php`
- Create: `app/Http/Controllers/Search/LogController.php`
- Modify: `routes/campaigns/search.php`

- [ ] **Step 1: Create CommandController**

```bash
vendor/bin/sail artisan make:controller Search/CommandController --no-interaction
```

Replace contents with:

```php
<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\CommandSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function __construct(protected CommandSearchService $service) {}

    public function index(Campaign $campaign, Request $request): JsonResponse
    {
        $term = mb_trim(strip_tags($request->get('q', '')));
        $mode = $request->get('mode', 'name');

        if (mb_strlen($term) < 2) {
            return response()->json(['entities' => [], 'pages' => []]);
        }

        $this->service->campaign($campaign)->user(auth()->user());

        $results = $mode === 'fulltext'
            ? $this->service->fulltext($term)
            : $this->service->name($term);

        return response()->json($results);
    }
}
```

- [ ] **Step 2: Create LogController**

```bash
vendor/bin/sail artisan make:controller Search/LogController --no-interaction
```

Replace contents with:

```php
<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Search\RecentService;
use App\Traits\CampaignAware;

class LogController extends Controller
{
    use CampaignAware;

    public function __construct(protected RecentService $recentService) {}

    public function store(Campaign $campaign, Entity $entity): \Illuminate\Http\Response
    {
        $this->campaign($campaign)->authEntityView($entity);

        $this->recentService
            ->campaign($campaign)
            ->user(auth()->user())
            ->logView($entity);

        return response()->noContent();
    }
}
```

- [ ] **Step 3: Add routes to routes/campaigns/search.php**

Add these two lines after the existing `Route::get('/w/{campaign}/search/recent', ...)` line:

```php
Route::get('/w/{campaign}/search/command', [CommandController::class, 'index'])->name('search.command');
Route::post('/w/{campaign}/search/log/{entity}', [LogController::class, 'store'])->name('search.log');
```

Also add the use statements at the top of the file:

```php
use App\Http\Controllers\Search\CommandController;
use App\Http\Controllers\Search\LogController;
```

- [ ] **Step 4: Verify the endpoints respond**

```bash
vendor/bin/sail artisan route:list | grep search.command
vendor/bin/sail artisan route:list | grep search.log
```

Expected: both routes listed with correct methods and URIs.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/Search/CommandController.php app/Http/Controllers/Search/LogController.php routes/campaigns/search.php
git commit -m "feat: add CommandController, LogController and routes for command center"
```

---

## Task 6: useCommandCenter composable + CommandInput.vue

**Files:**
- Create: `resources/js/composables/useCommandCenter.js`
- Create: `resources/js/components/search/CommandInput.vue`

- [ ] **Step 1: Create the composables directory and shared state**

```bash
mkdir -p /path/to/kanka/resources/js/composables
```

Create `resources/js/composables/useCommandCenter.js`:

```javascript
import { ref } from 'vue';

const isOpen = ref(false);

export function useCommandCenter() {
    return {
        isOpen,
        open() {
            isOpen.value = true;
        },
        close() {
            isOpen.value = false;
        },
    };
}
```

- [ ] **Step 2: Create the search components directory**

```bash
mkdir -p resources/js/components/search
```

- [ ] **Step 3: Create CommandInput.vue**

Create `resources/js/components/search/CommandInput.vue`:

```vue
<template>
    <div class="cmd-input-row">
        <span class="cmd-icon" aria-hidden="true">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
            ref="inputRef"
            type="text"
            class="cmd-input"
            :placeholder="placeholder"
            v-model="query"
            @input="onInput"
            @keydown.up.prevent="$emit('navigate', -1)"
            @keydown.down.prevent="$emit('navigate', 1)"
            @keydown.enter.prevent="$emit('submit')"
            @keydown.ctrl.f.prevent="toggleMode"
            autocomplete="off"
            spellcheck="false"
        />
        <button
            type="button"
            class="cmd-mode-toggle"
            :class="{ active: mode === 'fulltext' }"
            @click="toggleMode"
            :title="mode === 'fulltext' ? 'Switch to name search' : 'Switch to full-text search (Ctrl+F)'"
        >
            {{ fulltextLabel }}
        </button>
    </div>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';

export default {
    name: 'CommandInput',

    props: {
        placeholder: { type: String, default: 'Search…' },
        fulltextLabel: { type: String, default: 'Full text' },
    },

    emits: ['query-changed', 'mode-changed', 'navigate', 'submit'],

    data() {
        return {
            query: '',
            mode: localStorage.getItem('kanka_search_mode') || 'name',
            debounceTimer: null,
        };
    },

    mounted() {
        this.$nextTick(() => this.$refs.inputRef?.focus());
    },

    methods: {
        onInput() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.$emit('query-changed', this.query);
            }, 350);
        },

        toggleMode() {
            this.mode = this.mode === 'name' ? 'fulltext' : 'name';
            localStorage.setItem('kanka_search_mode', this.mode);
            this.$emit('mode-changed', this.mode);
            if (this.query.length >= 2) {
                this.$emit('query-changed', this.query);
            }
        },

        clear() {
            this.query = '';
            this.$emit('query-changed', '');
        },
    },
};
</script>
```

- [ ] **Step 4: Commit**

```bash
git add resources/js/composables/useCommandCenter.js resources/js/components/search/CommandInput.vue
git commit -m "feat: add useCommandCenter composable and CommandInput component"
```

---

## Task 7: CommandResults.vue

**Files:**
- Create: `resources/js/components/search/CommandResults.vue`

- [ ] **Step 1: Add new text keys to RecentController**

`__()` is not available in Vue templates — texts come from the `api_recent` JSON response via `restData.texts`. Open `app/Http/Controllers/Search/RecentController.php` and add three new keys to the `texts` array:

```php
'texts' => [
    'recents' => __('search.lookup.recents'),
    'results' => __('search.lookup.results'),
    'bookmarks' => __('entities.bookmarks'),
    'index' => __('search.lookup.lists'),
    'hint' => __('search.lookup.hint'),
    'fulltext' => __('search.fulltext'),
    'keyboard' => __('search.lookup.keyboard', [
        'k' => '<strong>k</strong>',
        'esc' => '<strong>esc</strong>',
    ]),
    'empty_results' => __('search.lookup.empty'),
    // New keys for command center
    'pages' => __('search.lookup.pages'),
    'content_matches' => __('search.lookup.content_matches'),
    'no_results' => __('search.lookup.empty'),
],
```

Then add the two new translation strings to `lang/en/search.php` (or wherever the `search.lookup.*` keys live — check `lang/en/search.php`):

```php
'lookup' => [
    // ... existing keys ...
    'pages'           => 'Pages',
    'content_matches' => 'Content matches',
],
```

- [ ] **Step 2: Create CommandResults.vue**

Create `resources/js/components/search/CommandResults.vue`:

```vue
<template>
    <div class="cmd-results" ref="resultsRef">
        <!-- Rest state: no query -->
        <template v-if="!hasQuery">
            <div v-if="recent.length > 0">
                <div class="cmd-section-label">{{ texts.recents }}</div>
                <button
                    v-for="(item, i) in recent"
                    :key="'recent-' + item.id"
                    type="button"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === i }"
                    @click="openItem(item)"
                    @mouseenter="focusedIndex = i"
                >
                    <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                    <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                    <span class="cmd-item-meta">
                        <span class="cmd-item-name">{{ item.name }}</span>
                        <span class="cmd-item-type">{{ item.type }}<i v-if="item.is_private" class="fa-solid fa-lock cmd-private-icon"></i></span>
                    </span>
                </button>
            </div>

            <div v-if="bookmarks.length > 0">
                <div class="cmd-section-label">{{ texts.bookmarks }}</div>
                <a
                    v-for="(item, i) in bookmarks"
                    :key="'bookmark-' + i"
                    :href="item.url"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === recent.length + i }"
                    @mouseenter="focusedIndex = recent.length + i"
                >
                    <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                    <span class="cmd-item-name">{{ item.text }}</span>
                </a>
            </div>

            <div v-if="indexes.length > 0">
                <div class="cmd-section-label">{{ texts.index }}</div>
                <a
                    v-for="(item, i) in indexes"
                    :key="'index-' + i"
                    :href="item.url"
                    class="cmd-item"
                    :class="{ focused: focusedIndex === recent.length + bookmarks.length + i }"
                    @mouseenter="focusedIndex = recent.length + bookmarks.length + i"
                >
                    <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                    <span class="cmd-item-name">{{ item.name }}</span>
                </a>
            </div>
        </template>

        <!-- Name search results -->
        <template v-else-if="mode === 'name'">
            <div v-if="loading" class="cmd-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>
            <template v-else>
                <div v-if="entities.length > 0">
                    <div class="cmd-section-label">{{ texts.results }}</div>
                    <button
                        v-for="(item, i) in entities"
                        :key="'entity-' + item.id"
                        type="button"
                        class="cmd-item"
                        :class="{ focused: focusedIndex === i }"
                        @click="openItem(item)"
                        @mouseenter="focusedIndex = i"
                    >
                        <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                        <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                        <span class="cmd-item-meta">
                            <span class="cmd-item-name">{{ item.name }}</span>
                            <span class="cmd-item-type">{{ item.type }}<i v-if="item.is_private" class="fa-solid fa-lock cmd-private-icon"></i></span>
                        </span>
                    </button>
                </div>

                <div v-if="pages.length > 0">
                    <div class="cmd-section-label">{{ texts.pages }}</div>
                    <a
                        v-for="(item, i) in pages"
                        :key="'page-' + i"
                        :href="item.url"
                        class="cmd-item"
                        :class="{ focused: focusedIndex === entities.length + i }"
                        @mouseenter="focusedIndex = entities.length + i"
                    >
                        <span class="cmd-item-icon"><i :class="item.icon"></i></span>
                        <span class="cmd-item-name">{{ item.name }}</span>
                    </a>
                </div>

                <div v-if="entities.length === 0 && pages.length === 0" class="cmd-empty">
                    {{ texts.no_results }}
                </div>
            </template>
        </template>

        <!-- Full-text results -->
        <template v-else-if="mode === 'fulltext'">
            <div v-if="loading" class="cmd-loading">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>
            <template v-else>
                <div v-if="results.length > 0">
                    <div class="cmd-section-label">{{ texts.content_matches }}</div>
                    <button
                        v-for="(item, i) in results"
                        :key="'result-' + item.id"
                        type="button"
                        class="cmd-item cmd-item-snippet"
                        :class="{ focused: focusedIndex === i }"
                        @click="openItem(item)"
                        @mouseenter="focusedIndex = i"
                    >
                        <img v-if="item.image" :src="item.image" class="cmd-avatar" alt="" />
                        <span v-else class="cmd-avatar cmd-avatar-placeholder"></span>
                        <span class="cmd-item-meta">
                            <span class="cmd-item-name">{{ item.name }}</span>
                            <span class="cmd-item-type">{{ item.type }}</span>
                            <span v-if="item.snippet" class="cmd-item-snippet-text" v-html="item.snippet"></span>
                        </span>
                    </button>
                </div>
                <div v-else class="cmd-empty">
                    {{ texts.no_results }}
                </div>
            </template>
        </template>
    </div>
</template>

<script>
export default {
    name: 'CommandResults',

    props: {
        mode: { type: String, default: 'name' },
        query: { type: String, default: '' },
        loading: { type: Boolean, default: false },
        recent: { type: Array, default: () => [] },
        bookmarks: { type: Array, default: () => [] },
        indexes: { type: Array, default: () => [] },
        entities: { type: Array, default: () => [] },
        pages: { type: Array, default: () => [] },
        results: { type: Array, default: () => [] },
        texts: {
            type: Object,
            default: () => ({
                recents: 'Recent',
                bookmarks: 'Bookmarks',
                index: 'Quick jump',
                results: 'Entities',
                pages: 'Pages',
                content_matches: 'Content matches',
                no_results: 'No results found',
            }),
        },
    },

    data() {
        return {
            focusedIndex: 0,
        };
    },

    computed: {
        hasQuery() {
            return this.query.length >= 2;
        },

        flatItems() {
            if (!this.hasQuery) {
                return [
                    ...this.recent,
                    ...this.bookmarks.map(b => ({ ...b, link: b.url })),
                    ...this.indexes.map(ix => ({ ...ix, link: ix.url })),
                ];
            }
            if (this.mode === 'name') {
                return [
                    ...this.entities,
                    ...this.pages.map(p => ({ ...p, link: p.url })),
                ];
            }
            return this.results;
        },
    },

    watch: {
        query() {
            this.focusedIndex = 0;
        },
        mode() {
            this.focusedIndex = 0;
        },
    },

    methods: {
        navigate(direction) {
            const max = this.flatItems.length - 1;
            this.focusedIndex = Math.max(0, Math.min(max, this.focusedIndex + direction));
        },

        submit() {
            const item = this.flatItems[this.focusedIndex];
            if (item) {
                this.openItem(item);
            }
        },

        openItem(item) {
            const url = item.link || item.url;
            if (!url) {
                return;
            }
            if (item.log_url) {
                fetch(item.log_url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                });
            }
            window.location.href = url;
        },
    },
};
</script>
```

- [ ] **Step 2: Commit**

```bash
git add resources/js/components/search/CommandResults.vue
git commit -m "feat: add CommandResults component with keyboard navigation and snippet support"
```

---

## Task 8: CommandCenter.vue

**Files:**
- Create: `resources/js/components/search/CommandCenter.vue`

- [ ] **Step 1: Create CommandCenter.vue**

Create `resources/js/components/search/CommandCenter.vue`:

```vue
<template>
    <Teleport to="body">
        <div v-if="isOpen" class="cmd-overlay" @click.self="close" @keydown.esc="close">
            <div class="cmd-dialog" role="dialog" aria-modal="true" aria-label="Command Center">
                <CommandInput
                    :placeholder="restData.texts.hint || placeholder"
                    :fulltext-label="restData.texts.fulltext || 'Full text'"
                    @query-changed="onQueryChanged"
                    @mode-changed="onModeChanged"
                    @navigate="navigate"
                    @submit="submit"
                    ref="inputRef"
                />
                <div class="cmd-divider"></div>
                <CommandResults
                    :mode="mode"
                    :query="query"
                    :loading="loading"
                    :recent="restData.recent"
                    :bookmarks="restData.bookmarks"
                    :indexes="restData.indexes"
                    :entities="entities"
                    :pages="pages"
                    :results="results"
                    :texts="restData.texts"
                    ref="resultsRef"
                />
                <div class="cmd-footer">
                    <span class="cmd-hint"><kbd>↑↓</kbd> navigate</span>
                    <span class="cmd-hint"><kbd>↵</kbd> open</span>
                    <span class="cmd-hint"><kbd>Ctrl+F</kbd> full text</span>
                    <span class="cmd-hint"><kbd>Esc</kbd> close</span>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';
import CommandInput from './CommandInput.vue';
import CommandResults from './CommandResults.vue';

export default {
    name: 'CommandCenter',

    components: { CommandInput, CommandResults },

    props: {
        apiCommand: { type: String, required: true },
        apiRecent: { type: String, required: true },
        placeholder: { type: String, default: 'Search…' },
    },

    setup() {
        const { isOpen, close } = useCommandCenter();
        return { isOpen, close };
    },

    data() {
        return {
            query: '',
            mode: localStorage.getItem('kanka_search_mode') || 'name',
            loading: false,
            restData: { recent: [], bookmarks: [], indexes: [], texts: {} },
            entities: [],
            pages: [],
            results: [],
            abortController: null,
        };
    },

    watch: {
        isOpen(opened) {
            if (opened) {
                this.fetchRestData();
                document.addEventListener('keydown', this.onKeydown);
                document.body.style.overflow = 'hidden';
            } else {
                document.removeEventListener('keydown', this.onKeydown);
                document.body.style.overflow = '';
                this.reset();
            }
        },
    },

    methods: {
        async fetchRestData() {
            try {
                const response = await fetch(this.apiRecent);
                const data = await response.json();
                this.restData = {
                    recent: data.recent ?? [],
                    bookmarks: data.bookmarks ?? [],
                    indexes: data.indexes ?? [],
                };
            } catch {
                // non-critical
            }
        },

        async onQueryChanged(q) {
            this.query = q;

            if (q.length < 2) {
                this.entities = [];
                this.pages = [];
                this.results = [];
                return;
            }

            if (this.abortController) {
                this.abortController.abort();
            }
            this.abortController = new AbortController();
            this.loading = true;

            try {
                const url = `${this.apiCommand}?q=${encodeURIComponent(q)}&mode=${this.mode}`;
                const response = await fetch(url, { signal: this.abortController.signal });
                const data = await response.json();

                if (this.mode === 'fulltext') {
                    this.results = data.results ?? [];
                } else {
                    this.entities = data.entities ?? [];
                    this.pages = data.pages ?? [];
                }
            } catch (e) {
                if (e.name !== 'AbortError') {
                    this.entities = [];
                    this.pages = [];
                    this.results = [];
                }
            } finally {
                this.loading = false;
            }
        },

        onModeChanged(newMode) {
            this.mode = newMode;
            this.entities = [];
            this.pages = [];
            this.results = [];
        },

        navigate(direction) {
            this.$refs.resultsRef?.navigate(direction);
        },

        submit() {
            this.$refs.resultsRef?.submit();
        },

        onKeydown(e) {
            if (e.key === 'Escape') {
                this.close();
            }
        },

        reset() {
            this.query = '';
            this.entities = [];
            this.pages = [];
            this.results = [];
            this.loading = false;
        },
    },
};
</script>
```

- [ ] **Step 2: Commit**

```bash
git add resources/js/components/search/CommandCenter.vue
git commit -m "feat: add CommandCenter dialog component with Teleport"
```

---

## Task 9: Slim NavSearch.vue + wire header.js + blade

**Files:**
- Modify: `resources/js/components/layout/NavSearch.vue`
- Modify: `resources/js/header.js`
- Modify: `resources/views/layouts/header.blade.php`

- [ ] **Step 1: Replace NavSearch.vue with trigger-only component**

Replace the entire contents of `resources/js/components/layout/NavSearch.vue` with:

```vue
<template>
    <button
        type="button"
        class="search-trigger flex items-center gap-2 leading-4"
        data-shortcut="k"
        data-shortcut-action="click"
        @click="open"
        :title="keyboard_tooltip"
    >
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        <span class="search-trigger-text hidden md:inline">{{ placeholder }}</span>
        <span class="keyboard-shortcut hidden md:inline" aria-hidden="true">K</span>
    </button>
</template>

<script>
import { useCommandCenter } from '../../composables/useCommandCenter.js';

export default {
    name: 'NavSearch',

    props: {
        placeholder: { type: String, default: 'Search…' },
        keyboard_tooltip: { type: String, default: '' },
    },

    setup() {
        const { open } = useCommandCenter();
        return { open };
    },
};
</script>
```

- [ ] **Step 2: Register CommandCenter in header.js**

```javascript
import { createApp } from 'vue';
import NavToggler from "./components/layout/NavToggler.vue";
import NavSearch from "./components/layout/NavSearch.vue";
import NavSwitcher from "./components/layout/NavSwitcher.vue";
import CommandCenter from "./components/search/CommandCenter.vue";
import vClickOutside from "click-outside-vue3";

const app = createApp({});
app.component('nav-toggler', NavToggler);
app.component('nav-search', NavSearch);
app.component('nav-switcher', NavSwitcher);
app.component('command-center', CommandCenter);
app.use(vClickOutside);
app.mount('header');
```

- [ ] **Step 3: Update header.blade.php**

Find the `<nav-search ...>` block (around line 17–22) and update it, adding `<command-center>` below. The nav-search no longer needs `api_lookup`:

```blade
@if (!empty($campaign))
    <nav-search
        placeholder="{{ __('search.placeholder') }}"
        keyboard_tooltip="{!! __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) !!}"
    ></nav-search>
    <command-center
        api_command="{{ route('search.command', $campaign) }}"
        api_recent="{{ route('search.recent', $campaign) }}"
        placeholder="{{ __('search.placeholder') }}"
    ></command-center>
@endif
```

- [ ] **Step 4: Build and verify in browser**

```bash
vendor/bin/sail yarn run build
```

Open the app. Press `K` — the command center dialog should open. Type a name — entity results should appear. Toggle full text — snippets should appear.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/layout/NavSearch.vue resources/js/header.js resources/views/layouts/header.blade.php
git commit -m "feat: wire up command center dialog in header"
```

---

## Task 10: Cleanup — PreviewController + remove old components

**Files:**
- Modify: `app/Http/Controllers/Entity/PreviewController.php`
- Delete: `resources/js/components/layout/Lookup/LookupEntity.vue`
- Delete: `resources/js/components/layout/Lookup/LookupPage.vue`
- Delete: `resources/js/components/layout/Lookup/EntityPreview.vue`

- [ ] **Step 1: Remove logView call from PreviewController**

In `app/Http/Controllers/Entity/PreviewController.php`, remove the block that calls `logView`. The `index` method should become:

```php
public function index(Campaign $campaign, Entity $entity)
{
    $this->campaign($campaign)->authEntityView($entity);

    return response()->json(
        $this
            ->service
            ->entity($entity)
            ->campaign($campaign)
            ->preview()
    );
}
```

Also remove the `RecentService` constructor injection and property, and the `use App\Services\Search\RecentService;` import.

The constructor becomes:

```php
public function __construct(protected PreviewService $service) {}
```

- [ ] **Step 2: Delete old Lookup components**

```bash
rm resources/js/components/layout/Lookup/LookupEntity.vue
rm resources/js/components/layout/Lookup/LookupPage.vue
rm resources/js/components/layout/Lookup/EntityPreview.vue
```

- [ ] **Step 3: Run pint to clean up formatting**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 4: Rebuild and smoke test**

```bash
vendor/bin/sail yarn run build
```

Verify:
- Press `K` → dialog opens
- Type 3+ chars → entity name results appear
- Toggle full text → Meilisearch snippet results appear with highlighted `<mark>` terms
- Click a result → navigates to entity page
- Close with `Esc` or backdrop click

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/Entity/PreviewController.php
git rm resources/js/components/layout/Lookup/LookupEntity.vue resources/js/components/layout/Lookup/LookupPage.vue resources/js/components/layout/Lookup/EntityPreview.vue
git commit -m "feat: remove preview panel and old lookup components, complete command center"
```
