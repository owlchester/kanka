# Tiptap @ Mentions for Map Marker Descriptions Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the plain-textarea marker description field with the app's Tiptap rich-text editor (full toolbar, working `@` mentions backed by real `entity_mentions` tracking via the `mentionable_type`/`mentionable_id` polymorphic system).

**Architecture:** `MapMarker` becomes a new `EntityMention` `mentionable_type` (hand-rolled `morphMany`, mirroring `Post`/`TimelineElement`/`QuestElement`) with no self-mention guard and no `entity_id` rollup (mirrors `Campaign`). `StoreMapMarker` stops wrapping plain text into HTML — Tiptap sends ready HTML through the existing `HasEntry` purify/mention-parse pipeline. `PinResource.entry` switches from raw stored text to `parsedEntry()` (so preview/round-trip both work with real HTML) and gains `entry_for_edition` (bracket-syntax-friendly, feeds Tiptap's mention-hydration-on-load). `Tiptap.vue` gains an additive `update:modelValue` emit. `DescriptionField.vue` drops its inline quick-edit mode (unsafe against rich content) — collapsed/preview states remain, editing only happens through the expand dialog, which now hosts a full `<Tiptap>` instance instead of a `<textarea>`.

**Tech Stack:** Laravel 13, PHP 8.4, Vue 3 (`<script setup>`, TypeScript for Tiptap files), Tiptap v3, Pest 3.

## Global Constraints

- No self-mention guard for `MapMarker` in `EntityMappingService::createNewMention()` — mirrors `Campaign`'s existing no-guard branch. Must explicitly exclude `MapMarker` from the generic fallback guard (`elseif (! $this->model instanceof Campaign)`), not just fail to add a guard, or it silently inherits the wrong one.
- `resolveEntityId()` returns `null` for `MapMarker` — no rollup under any entity's own Mentions tab. Must explicitly branch for `MapMarker`, not fall through to the generic `return $this->model->id;` fallback (which would be meaningless — a marker's own PK is not an entity id).
- `campaignID()` resolves `MapMarker` via `$this->model->map->campaign_id`.
- Curly braces on all control structures, explicit return types and param type hints, PHPDoc blocks over inline comments (per project PHP conventions).
- Tiptap files (`resources/js/editors/tiptap/**`) use `<script setup lang="ts">` and the `defineEmits<{...}>()` generic syntax (see `SourceEditor.vue`) — match this convention exactly, not the runtime-array `defineEmits([...])` form used elsewhere in `resources/js/components/maps/`.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP file change, before committing.
- No automated Vue component test coverage exists anywhere in this codebase (confirmed precedent across every prior v4 map explorer spec) — frontend verification is manual, not a gap to invent new test infrastructure for.
- Tests via `vendor/bin/sail artisan test --compact --filter=<Name>`. This environment's PHP 8.4.23 + sqlite `:memory:` + `RefreshDatabase` combination has a confirmed, pre-existing, unrelated bug ("cannot start a transaction within a transaction") — use `DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite` (real file, recreated fresh before each run) as a shell env override for every test run in this worktree; never edit `.env.testing`/`phpunit.xml`.

---

### Task 1: `MapMarker` as a mentionable type

**Files:**
- Modify: `app/Models/MapMarker.php`
- Modify: `app/Services/EntityMappingService.php`
- Test: `tests/Feature/Services/EntityMappingServiceMapMarkerTest.php`

**Interfaces:**
- Produces: `MapMarker::mentions(): MorphMany` (returns `EntityMention` rows owned by that marker).

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Map;
use App\Models\MapMarker;

test('mentioning a character in a marker description creates a MapMarker-owned mention with no entity_id rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', MapMarker::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($marker->id);
    expect($mention->entity_id)->toBeNull();
});

test('a marker mentioning its own PK-coincidental id is not treated as a self-mention', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    // A character entity whose id happens to equal the marker's own id — MapMarker has
    // no self-mention guard (unlike Post/TimelineElement/QuestElement), so this must
    // still create a mention rather than being silently skipped.
    $target = Character::find(1)->entity;

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    expect(EntityMention::where('target_id', $target->id)->where('mentionable_type', MapMarker::class)->count())->toBe(1);
});

test('MapMarker::mentions() returns only this marker\'s owned mentions', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $otherMarker = MapMarker::factory()->create(['map_id' => $map->id]);

    EntityMention::create(['mentionable_type' => MapMarker::class, 'mentionable_id' => $marker->id, 'target_id' => $target->id]);
    EntityMention::create(['mentionable_type' => MapMarker::class, 'mentionable_id' => $otherMarker->id, 'target_id' => $target->id]);

    expect($marker->mentions()->count())->toBe(1);
    expect($marker->mentions()->first()->mentionable_id)->toBe($marker->id);
});

test('removing a mention from a marker\'s description deletes the corresponding EntityMention row', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(1);

    $marker->entry = 'no more mentions';
    $marker->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(0);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=EntityMappingServiceMapMarkerTest"`
Expected: FAIL — `MapMarker::mentions()` doesn't exist yet, so `EntryObserver::saved()`'s `method_exists($model, 'mentions')` check fails and no `EntityMention` rows are ever created.

- [ ] **Step 3: Add `MapMarker::mentions()`**

In `app/Models/MapMarker.php`, add to the imports:

```php
use App\Models\EntityMention;
use Illuminate\Database\Eloquent\Relations\MorphMany;
```

Add this method (near the existing `map()`/`entity()`/`group()` relations, e.g. after `group()`):

```php
    /**
     * @return MorphMany<EntityMention, $this>
     */
    public function mentions(): MorphMany
    {
        return $this->morphMany(EntityMention::class, 'mentionable');
    }
```

- [ ] **Step 4: Add the `MapMarker` branch to `EntityMappingService`**

In `app/Services/EntityMappingService.php`, add `use App\Models\MapMarker;` to the imports.

Update the `$model` type union in both the property declaration and `with()`'s parameter type:

```php
    protected Model|Post|Entity|QuestElement|TimelineElement|Campaign|MapMarker $model;
```

```php
    public function with(Model|Post|Entity|QuestElement|TimelineElement|Campaign|MapMarker $model): self
```

Update `createNewMention()`'s guard chain — `MapMarker` must be excluded from the generic fallback, not fall into it:

```php
    protected function createNewMention(int $target): void
    {
        if ($this->model instanceof Post) {
            if ($this->model->entity_id == $target) {
                return;
            }
        } elseif ($this->model instanceof TimelineElement) {
            if ($this->model->timeline_id == $target) {
                return;
            }
        } elseif ($this->model instanceof QuestElement) {
            if ($this->model->quest_id == $target) {
                return;
            }
        } elseif (! $this->model instanceof Campaign && ! $this->model instanceof MapMarker) {
            // @phpstan-ignore-next-line
            if ($this->model->id == $target) {
                return;
            }
        }

        $mention = new EntityMention;
        $mention->mentionable()->associate($this->model);
        $mention->entity_id = $this->resolveEntityId();
        $mention->target_id = $target;
        $mention->save();
    }
```

Update `resolveEntityId()` to return `null` for `MapMarker` (not fall through to the generic `$this->model->id` fallback):

```php
    protected function resolveEntityId(): ?int
    {
        if ($this->model instanceof Campaign || $this->model instanceof MapMarker) {
            return null;
        } elseif ($this->model instanceof Post) {
            return $this->post()->entity_id;
        } elseif ($this->model instanceof TimelineElement) {
            return $this->model->timeline->entity->id;
        } elseif ($this->model instanceof QuestElement) {
            return $this->model->quest->entity->id;
        }

        // @phpstan-ignore-next-line
        return $this->model->id;
    }
```

Update `campaignID()` to resolve via the marker's map:

```php
    protected function campaignID(): int
    {
        // Todo: should be a method on the object or something, not the service's job to figure out
        if ($this->model instanceof Campaign) {
            return $this->model->id;
        } elseif ($this->model instanceof Post) {
            return $this->model->entity->campaign_id;
        } elseif ($this->model instanceof TimelineElement) {
            return $this->model->timeline->campaign_id;
        } elseif ($this->model instanceof QuestElement) {
            return $this->model->quest->campaign_id;
        } elseif ($this->model instanceof MapMarker) {
            return $this->model->map->campaign_id;
        }

        // @phpstan-ignore-next-line
        return $this->model->campaign_id;
    }
```

- [ ] **Step 5: Run test to verify it passes**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=EntityMappingServiceMapMarkerTest"`
Expected: PASS

- [ ] **Step 6: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 7: Commit**

```bash
git add app/Models/MapMarker.php app/Services/EntityMappingService.php tests/Feature/Services/EntityMappingServiceMapMarkerTest.php
git commit -m "feat: make MapMarker a mentionable type"
```

---

### Task 2: `StoreMapMarker` stops wrapping plain text

**Files:**
- Modify: `app/Http/Requests/StoreMapMarker.php`
- Test: `tests/Feature/Requests/StoreMapMarkerEntryTest.php`

**Interfaces:**
- Consumes: nothing new.
- Produces: `StoreMapMarker::validated()` passes `entry` through unmodified (no more `wrapEntryParagraphs()` call). The method itself is deleted.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Campaign;
use App\Models\Character;

test('a marker entry with real HTML and a mention anchor is not double-escaped or paragraph-wrapped', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = \App\Models\Map::factory()->create(['campaign_id' => 1]);

    $html = '<p>Some <strong>bold</strong> text with a mention: <a data-type="mention" data-mention="[character:' . $target->id . ']"><span>Character 1</span></a></p>';

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'entry' => $html,
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ]);

    $response->assertStatus(201);
    $marker = \App\Models\MapMarker::latest('id')->first();
    // The mention anchor is purified into bracket-syntax text by SaveService (unchanged,
    // pre-existing behavior via HasEntry) - what this test guards is that the surrounding
    // HTML was NOT additionally escaped/wrapped by wrapEntryParagraphs(), which would have
    // turned the real <strong> tag into literal "&lt;strong&gt;" text.
    expect($marker->entry)->not->toContain('&lt;strong&gt;');
    expect($marker->entry)->toContain('<strong>bold</strong>');
    expect($marker->entry)->toContain('[character:' . $target->id . ']');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=StoreMapMarkerEntryTest"`
Expected: FAIL — `wrapEntryParagraphs()` HTML-escapes the input (`e()`), turning `<strong>` into `&lt;strong&gt;`.

- [ ] **Step 3: Remove the wrapping**

In `app/Http/Requests/StoreMapMarker.php`, replace the `validated()` method and delete `wrapEntryParagraphs()` entirely:

```php
    /**
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        return parent::validated($key, $default);
    }
```

Remove the `wrapEntryParagraphs()` method (lines 79-103 in the current file) and its doc comment entirely — it has no other caller.

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=StoreMapMarkerEntryTest"`
Expected: PASS

- [ ] **Step 5: Run the existing marker description field test suite to confirm no regression**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=MarkerController"`
Expected: PASS. If any test in that file specifically asserted the old paragraph-wrapping behavior (from the `2026-07-13-map-marker-description-field-design.md` spec), it needs updating here to match the new "no wrapping" behavior — this plan intentionally supersedes that spec's wrapping logic. Check the failing assertion, confirm it's testing the now-removed `wrapEntryParagraphs()` behavior specifically, and update it to assert the new pass-through-unmodified behavior instead.

- [ ] **Step 6: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 7: Commit**

```bash
git add app/Http/Requests/StoreMapMarker.php tests/Feature/Requests/StoreMapMarkerEntryTest.php
git commit -m "refactor: StoreMapMarker no longer wraps entry as plain text"
```

(If Step 5 required updating an existing test file, include it in this commit too.)

---

### Task 3: `PinResource`/`MapResource` — edit-ready content and mention/gallery URLs

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Test: `tests/Feature/Resources/PinResourceTest.php`
- Test: `tests/Feature/Resources/MapResourceTest.php`

**Interfaces:**
- Produces: `PinResource` JSON gains `entry_for_edition`; `entry` now returns `$marker->parsedEntry()` instead of raw `$marker->entry`. `MapResource` JSON gains `mentions_url`, `gallery_url`, `gallery_upload_url`.

- [ ] **Step 1: Write the failing tests**

```php
<?php
// tests/Feature/Resources/PinResourceTest.php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

test('PinResource returns parsed entry and an edit-ready entry_for_edition', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id]));

    $response->assertStatus(200);
    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['entry'])->toContain('<a'); // parsedEntry() resolves the mention to a real link
    expect($pin)->toHaveKey('entry_for_edition');
});
```

```php
<?php
// tests/Feature/Resources/MapResourceTest.php

use App\Models\Campaign;
use App\Models\Map;

test('the map explore payload includes mentions/gallery URLs', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id]));

    $response->assertStatus(200);
    $response->assertJsonPath('map.mentions_url', route('search.mention', [1]));
    $response->assertJsonPath('map.gallery_url', route('gallery.tiptap', [1]));
    $response->assertJsonPath('map.gallery_upload_url', route('campaign.gallery.ajax-upload', 1));
});
```

(`entities.map-api` → `App\Http\Controllers\Entity\Maps\ApiController::index`, `routes/campaigns/entities.php:60` — confirmed via `ExploreApiService::load()` returning `map`/`pins` top-level keys, `app/Services/Maps/ExploreApiService.php:29-41`.)

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=PinResourceTest"`
Run: `vendor/bin/sail exec -T laravel.test bash -c "rm -f /tmp/pest_test.sqlite && touch /tmp/pest_test.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/pest_test.sqlite php artisan test --compact --filter=MapResourceTest"`
Expected: FAIL — `entry` is still raw, `entry_for_edition`/`mentions_url`/`gallery_url`/`gallery_upload_url` don't exist yet.

- [ ] **Step 3: Update `PinResource`**

In `app/Http/Resources/Maps/Explore/PinResource.php`, change the `entry` line and add `entry_for_edition` right after it:

```php
            'entry' => $marker->parsedEntry(),
            'entry_for_edition' => $marker->getEntryForEditionAttribute(),
```

- [ ] **Step 4: Update `MapResource`**

In `app/Http/Resources/Maps/Explore/MapResource.php`, add these three lines to the returned array (near the other `*_url` fields, e.g. after `search_url`):

```php
            'mentions_url' => route('search.mention', [$this->campaign->id]),
            'gallery_url' => route('gallery.tiptap', [$this->campaign->id]),
            'gallery_upload_url' => route('campaign.gallery.ajax-upload', $this->campaign->id),
```

- [ ] **Step 5: Run tests to verify they pass**

Run both filters from Step 2 again.
Expected: PASS

- [ ] **Step 6: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`

- [ ] **Step 7: Commit**

```bash
git add app/Http/Resources/Maps/Explore/PinResource.php app/Http/Resources/Maps/Explore/MapResource.php tests/Feature/Resources/PinResourceTest.php tests/Feature/Resources/MapResourceTest.php
git commit -m "feat: expose parsed entry, entry_for_edition, and mentions/gallery URLs to the map explorer"
```

---

### Task 4: `Tiptap.vue` gets an `update:modelValue` emit

**Files:**
- Modify: `resources/js/editors/tiptap/Tiptap.vue`

**Interfaces:**
- Produces: `Tiptap.vue` emits `update:modelValue` with the current HTML string every time its content changes, in addition to (not instead of) writing to the existing hidden `<input>`.

- [ ] **Step 1: Add the emit declaration**

In `resources/js/editors/tiptap/Tiptap.vue`, immediately after the existing `const props = withDefaults(defineProps<{...}>(), {...})` block, add:

```ts
    const emit = defineEmits<{
        'update:modelValue': [value: string]
    }>()
```

- [ ] **Step 2: Fire the emit alongside the existing hidden-input sync**

In the `useEditor({...})` call's `onUpdate` handler, add the emit call right after `html.value` is set:

```ts
        onUpdate: ({ editor }) => {
            // Convert data-table-class to class for new tables, preserve existing classes
            html.value = editor.getHTML().replace(
                /<table([^>]*) data-table-class="([^"]+)"([^>]*)>/g,
                '<table$1 class="$2"$3>'
            )
            emit('update:modelValue', html.value)
            if (!hasReceivedInput.value && !editor.isEmpty) {
                hasReceivedInput.value = true
            }
        },
```

- [ ] **Step 3: Verify no build/type errors**

Run: `vendor/bin/sail yarn run build` (`package.json`'s `build` script, `vite build`) and confirm it completes without new TypeScript or Vite errors. This is the only verification available for this task — no automated Vue tests exist in this codebase, and this change has no server-side surface to hit with a Pest test.

- [ ] **Step 4: Commit**

```bash
git add resources/js/editors/tiptap/Tiptap.vue
git commit -m "feat: add update:modelValue emit to Tiptap.vue for standalone v-model usage"
```

---

### Task 5: Wire Tiptap into `DescriptionField.vue`, remove inline quick-edit

**Files:**
- Modify: `resources/js/components/maps/DescriptionField.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `Tiptap.vue`'s `update:modelValue` emit (Task 4), `pin.entry`/`pin.entry_for_edition` (Task 3), `data.map.mentions_url`/`gallery_url`/`gallery_upload_url` (Task 3).
- Produces: `DescriptionField.vue` emits `change` with real HTML (not plain text) from the dialog's Tiptap instance. `MarkerPanel.vue` gains `mentionsUrl`/`galleryUrl`/`galleryUploadUrl` props, threads them to `DescriptionField`, and `buildPayload()` sends `pin.entry` directly (no more `htmlToPlainText`).

- [ ] **Step 1: Rewrite `DescriptionField.vue`**

Replace the entire file with:

```vue
<template>
    <div class="flex flex-col gap-2">
        <button
            v-if="!hasContent"
            type="button"
            class="btn2 btn-default btn-sm self-start"
            @click="openDialog"
        >
            {{ i18n.add_description }}
        </button>

        <template v-else>
            <div class="flex items-center justify-between gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.description }}</label>
            </div>

            <div class="line-clamp-2 text-sm text-neutral-content">{{ preview }}</div>
            <button
                type="button"
                class="btn2 btn-default btn-sm self-start"
                @click="openDialog"
            >
                {{ i18n.edit_description }}
            </button>
        </template>

        <dialog
            ref="dialogRef"
            class="dialog rounded-2xl bg-base-100 text-base-content md:min-w-2xl"
            aria-modal="true"
            @close="dialogOpen = false"
        >
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h2>{{ i18n.description }}</h2>
                <button type="button" class="btn2 btn-default btn-sm" @click="closeDialog">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </header>
            <article class="max-w-2xl p-4 md:px-6">
                <Tiptap
                    v-if="dialogOpen"
                    :content="pin.entry_for_edition ?? pin.entry ?? ''"
                    v-model="dialogHtml"
                    :mentions="mentionsUrl"
                    :gallery="galleryUrl"
                    :gallery-upload="galleryUploadUrl"
                />
            </article>
            <footer class="p-4 md:px-6">
                <menu class="flex justify-end gap-3">
                    <button type="button" class="btn2 btn-default" @click="closeDialog">
                        {{ i18n.cancel }}
                    </button>
                    <button type="button" class="btn2 btn-primary" @click="saveDialog">
                        {{ i18n.save }}
                    </button>
                </menu>
            </footer>
        </dialog>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import Tiptap from "../../editors/tiptap/Tiptap.vue";
import { htmlToPlainText, htmlToPreviewText } from "../../maps/entryText.js";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
    mentionsUrl: { type: String, default: null },
    galleryUrl: { type: String, default: null },
    galleryUploadUrl: { type: String, default: null },
});

const emit = defineEmits(["change"]);

const dialogRef = ref(null);
const dialogOpen = ref(false);
const dialogHtml = ref("");

const hasContent = computed(() => htmlToPlainText(props.pin.entry).trim().length > 0);
const preview = computed(() => htmlToPreviewText(props.pin.entry));

function openDialog() {
    dialogHtml.value = "";
    dialogOpen.value = true;
    dialogRef.value?.showModal();
}

function closeDialog() {
    dialogRef.value?.close();
}

function saveDialog() {
    emit("change", dialogHtml.value);
    closeDialog();
}
</script>
```

- [ ] **Step 2: Update `MarkerPanel.vue`**

Add three new props (in the `defineProps({...})` block, alongside the existing `searchUrl`):

```js
    mentionsUrl: { type: String, default: null },
    galleryUrl: { type: String, default: null },
    galleryUploadUrl: { type: String, default: null },
```

Thread them into `DescriptionField`:

```vue
            <DescriptionField
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                :mentions-url="mentionsUrl"
                :gallery-url="galleryUrl"
                :gallery-upload-url="galleryUploadUrl"
                @change="handleEntryFieldChange"
            />
```

In `buildPayload()`, stop converting to plain text — replace:

```js
        entry: (!isEdit.value || entryTouched.value) ? htmlToPlainText(props.pin.entry) : undefined,
```

with:

```js
        entry: (!isEdit.value || entryTouched.value) ? props.pin.entry : undefined,
```

Remove the now-unused `htmlToPlainText` import (`import { htmlToPlainText } from "../../maps/entryText.js";`) from `MarkerPanel.vue`'s script block — check first that nothing else in the file still uses it (it shouldn't, `buildPayload()` was the only caller).

- [ ] **Step 3: Update `MapExplorer.vue`**

In the `<MarkerPanel ... />` template block, add the three new props sourced from `data.map`:

```vue
            :mentions-url="data.map.mentions_url"
            :gallery-url="data.map.gallery_url"
            :gallery-upload-url="data.map.gallery_upload_url"
```

(Add alongside the existing `:search-url="data.map.search_url"` line.)

In `toEditingPin(pin)`, add `entry_for_edition` passthrough so editing an existing marker has it available:

```js
        entry: pin.entry,
        entryForEdition: pin.entry_for_edition,
```

Then update `DescriptionField.vue`'s dialog `:content` binding to also check the camelCase form as a fallback for the client-side draft/editing-pin shape (draft pins created client-side via `handleMapClick`/etc. never have `entry_for_edition` at all, only saved-and-reloaded pins from `PinResource` do) — this is already handled by the `pin.entry_for_edition ?? pin.entry ?? ''` fallback chain written in Task 5 Step 1, since a client-only draft pin's `entry_for_edition` will simply be `undefined`, falling through to `pin.entry` (empty string for a new draft). No additional change needed here beyond the `toEditingPin` addition above — it's for when a marker is loaded from the server for editing.

- [ ] **Step 4: Manual verification**

No automated Vue test coverage exists in this codebase. Verify by hand (start the dev server with `vendor/bin/sail yarn run dev`, `package.json`'s `dev` script):

1. Create a new marker, click "Add description," confirm the full Tiptap toolbar renders in the dialog.
2. Add bold text, a link, and type `@` then select an entity to insert a mention. Save the dialog, save the marker.
3. Reopen the marker for editing — confirm the description reopens with formatting and the mention intact (not showing raw `[type:id]` bracket text, not showing the mention as broken).
4. Confirm the collapsed preview (marker panel closed and reopened, or a different marker selected then back) shows a readable plain-text teaser, not bracket syntax or raw HTML tags.
5. Visit the mentioned entity's page → Mentions/backlinks — confirm the marker mention appears there.
6. Visit the map's own entity page → Mentions tab — confirm the marker mention does NOT appear there (no rollup, per this plan's design).
7. Confirm a marker with no description still shows the collapsed "Add description" button correctly.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/DescriptionField.vue resources/js/components/maps/MarkerPanel.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: wire Tiptap into the map marker description field, remove inline quick-edit"
```
