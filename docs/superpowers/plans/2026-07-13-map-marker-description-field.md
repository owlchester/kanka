# Map Marker Description Field Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a "Description" field to the map explorer's marker create/edit panel, backed by the existing `entry` column on `MapMarker`, with the full collapsed/preview/editing/expand-dialog interaction flow — using a plain `<textarea>` (no formatting/HTML/mentions) as boilerplate to validate the flow before a tiptap-based editor replaces it later.

**Architecture:** `StoreMapMarker::validated()` is overridden to paragraph-wrap plain textarea text into `<p>`/`<br>` HTML before it reaches `MapMarker`'s existing `HasEntry`/`EntryObserver` save pipeline (which already purifies) — this only affects the v4 JSON API controller (the only caller of `->validated()`), leaving the legacy Blade tiptap editor's controller (which uses `->only(...)`) untouched. `PinResource` gains a raw `entry` field. On the frontend, a new dependency-free `entryText.js` module converts between that HTML and plain text (for populating/previewing the textarea), and a new `DescriptionField.vue` component (three states: collapsed/editing/preview, plus a native-`<dialog>` expand editor) plugs into `MarkerPanel.vue`/`MapExplorer.vue` exactly like the existing `ColourPicker`/`OpacityPicker`/etc. field components.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API), plain Node `node:test` for dependency-free JS modules.

## Global Constraints

- No migration — `entry` already exists on `map_markers`, is `$fillable` on `MapMarker`, and already runs through `HasEntry`/`EntryObserver` (mention-parsing + `Purify::clean()`) on every save.
- The legacy Blade marker edit page (`resources/views/maps/markers/_form.blade.php`, `App\Http\Controllers\Maps\MarkerController`) must be completely unaffected — it already has its own full tiptap `entry` editor.
- No tiptap integration, `@mention` support, or rich formatting — plain text only, this is deliberately temporary boilerplate.
- No hardcoded UI strings — all new copy goes through `lang/en/maps/explorer.php` → `App\Services\Maps\ExploreApiService::translations()` → `data.i18n`, matching every existing string in this feature.
- Never translate strings by hand in `lang/{locale}` for locales other than `en` — this repo's translations are community-maintained; only `lang/en/...` is touched here.
- New pure JS module (`entryText.js`) must have zero DOM/Vue dependencies so it stays testable with plain `node --test`, matching `resources/js/maps/polygon.js`/`panelExclusivity.js`.
- `resources/js/maps/*.js` files use no semicolons and single quotes (see `polygon.js`/`panelExclusivity.js`); `resources/js/components/maps/*.vue` `<script setup>` blocks use semicolons and double quotes (see `MarkerPanel.vue`/`StrokeWidthPicker.vue`) — follow whichever convention matches the file being edited.
- Dialogs in this app use a native `<dialog>` element styled `class="dialog rounded-2xl bg-base-100 text-base-content"` with `<header>`/`<article>`/`<footer>` structure, opened via `dialogRef.value?.showModal()` and closed via `.close()` (see `resources/js/editors/tiptap/extensions/gallery/GalleryDialog.vue`) — do not invent a different dialog pattern.
- Run PHP tests via `vendor/bin/sail artisan test --compact --filter=<Name>`. Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP change. Run JS tests via `node --test resources/js/maps/<file>.test.js` (no Sail needed — pure Node).

---

### Task 1: Backend — `entry` field + paragraph-wrapping

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Modify: `app/Http/Requests/StoreMapMarker.php`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: existing `App\Http\Requests\StoreMapMarker::rules()` (already validates `'entry' => 'nullable|string'`, unchanged), existing `App\Models\Concerns\HasEntry`/`App\Observers\EntryObserver` save pipeline (unchanged, already purifies).
- Produces: `PinResource::toArray()` gains `'entry' => string|null` (raw stored HTML) — consumed by Task 5's `toEditingPin()`. `StoreMapMarker::validated()` now returns an already `<p>`/`<br>`-wrapped `entry` value when called with no `$key` argument or `$key === 'entry'` — consumed transparently by `MarkerController@store`/`@update` (no changes needed there, they already do `MapMarker::create($request->validated() + [...])` / `$mapMarker->update($request->validated())`).

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the `pins` line inside the `assertJsonStructure` call (currently):

```php
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url', 'shape_id', 'icon_id', 'custom_icon', 'entity_id', 'entity_name', 'visibility_id', 'update_url']],
```

to:

```php
            'pins' => [['id', 'name', 'entry', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url', 'shape_id', 'icon_id', 'custom_icon', 'entity_id', 'entity_name', 'visibility_id', 'update_url']],
```

Then append these tests to the end of `tests/Feature/Entities/Maps/MarkerControllerTest.php`:

```php
it('wraps a multi-paragraph plain-text entry into <p> tags on create via the v4 API', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'Wrapped entry pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
        'entry' => "First paragraph.\nStill first <paragraph>.\n\nSecond paragraph.",
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'Wrapped entry pin')->firstOrFail();
    $expected = '<p>First paragraph.<br>Still first &lt;paragraph&gt;.</p><p>Second paragraph.</p>';

    expect($response->json('entry'))->toBe($expected);
    expect($marker->fresh()->entry)->toBe($expected);
});

it('wraps a multi-paragraph plain-text entry into <p> tags on update via the v4 API', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 1, 'entry' => '<p>Old.</p>']);

    $response = $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => $marker->name,
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'entry' => "New first paragraph.\n\nNew second paragraph.",
    ])->assertStatus(200);

    $expected = '<p>New first paragraph.</p><p>New second paragraph.</p>';

    expect($response->json('entry'))->toBe($expected);
    expect($marker->fresh()->entry)->toBe($expected);
});

it('leaves a null entry untouched when creating a marker with no description', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'No entry pin',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(201);

    expect($response->json('entry'))->toBeNull();
    expect(MapMarker::where('name', 'No entry pin')->firstOrFail()->entry)->toBeNull();
});

it('does not paragraph-wrap entry submitted through the legacy marker edit form', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 1]);

    $this->put(route('maps.map_markers.update', [1, $map, $marker]), [
        'name' => $marker->name,
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'entry' => "Para one.\n\nPara two.",
    ])->assertRedirect();

    // The legacy controller reads $request->only($this->fields), which never calls
    // StoreMapMarker::validated() — so wrapEntryParagraphs() never runs here. The single
    // <p> wrapping the whole blank-line-separated text below is SaveService's own
    // pre-existing DOMDocument round-trip behavior (confirmed unchanged by this task,
    // not per-paragraph <p> splitting like the v4 API now does).
    expect($marker->fresh()->entry)->toBe("<p>Para one.\n\nPara two.</p>");
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest` and `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: the four new `MarkerControllerTest` cases FAIL (`entry` missing from the JSON response / not wrapped), and `ExploreApiControllerTest` FAILs on the `pins` structure assertion (missing `entry` key).

- [ ] **Step 3: Add `entry` to `PinResource`**

In `app/Http/Resources/Maps/Explore/PinResource.php`, in `toArray()`, change:

```php
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'group_id' => $marker->group_id,
```

to:

```php
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'entry' => $marker->entry,
            'group_id' => $marker->group_id,
```

- [ ] **Step 4: Add paragraph-wrapping to `StoreMapMarker`**

In `app/Http/Requests/StoreMapMarker.php`, add a `validated()` override and a `wrapEntryParagraphs()` helper, after the existing `rules()` method:

```php
    /**
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if ($key === null && is_array($data) && array_key_exists('entry', $data)) {
            $data['entry'] = $this->wrapEntryParagraphs($data['entry']);
        } elseif ($key === 'entry') {
            $data = $this->wrapEntryParagraphs($data);
        }

        return $data;
    }

    /**
     * The map explorer's simple description field is a plain <textarea> (no HTML, no
     * mentions) — wrap each blank-line-separated block in its own <p> so it renders with
     * real paragraph structure, matching every other "entry" field in the app. Escaping
     * happens before wrapping so any literal <, >, or & the user types is treated as text,
     * not markup; Purify::clean() (already run by EntryObserver on every save via
     * MapMarker's HasEntry trait) is a second, redundant safety net on top.
     *
     * Only reached via validated() — the legacy Blade marker form's controller
     * (App\Http\Controllers\Maps\MarkerController) reads $request->only(...) instead and
     * never calls validated(), so its already-rich tiptap HTML is untouched by this.
     */
    protected function wrapEntryParagraphs(?string $text): ?string
    {
        if ($text === null || trim($text) === '') {
            return $text;
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", trim($text));
        $paragraphs = preg_split('/\n{2,}/', $normalized);

        return collect($paragraphs)
            ->map(fn ($paragraph) => '<p>' . str_replace("\n", '<br>', e(trim($paragraph))) . '</p>')
            ->implode('');
    }
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest` and `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: all PASS.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps/Explore/PinResource.php app/Http/Requests/StoreMapMarker.php tests/Feature/Entities/Maps/MarkerControllerTest.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: paragraph-wrap map marker descriptions from the v4 API

Adds entry to PinResource and wraps plain-text entry submissions from
the map explorer's v4 API into <p>/<br> HTML via StoreMapMarker's
validated() override, without touching the legacy Blade editor path."
```

---

### Task 2: Backend — i18n keys for the description field

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: nothing new.
- Produces: `data.i18n` gains `description`, `add_description`, `edit_description`, `description_expand`, `cancel` — consumed by Task 4's `DescriptionField.vue`.

- [ ] **Step 1: Write the failing test**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the `i18n` line inside the `assertJsonStructure` call (currently):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'error_name_required', 'from_entry', 'linked_entry', 'edit_details', 'edit_marker', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'save_changes', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'peek_map', 'peek_panel', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

to:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'error_name_required', 'from_entry', 'linked_entry', 'description', 'add_description', 'edit_description', 'description_expand', 'cancel', 'edit_details', 'edit_marker', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'save_changes', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'peek_map', 'peek_panel', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL — missing `description`/`add_description`/`edit_description`/`description_expand`/`cancel` keys.

- [ ] **Step 3: Add the lang keys**

In `lang/en/maps/explorer.php`, inside the `'marker' => [...]` array, change:

```php
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'new_pin'           => 'New pin',
```

to:

```php
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'description'         => 'Description',
        'add_description'     => 'Add description',
        'edit_description'    => 'Edit',
        'description_expand'  => 'Expand editor',
        'cancel'               => 'Cancel',
        'new_pin'           => 'New pin',
```

- [ ] **Step 4: Wire the keys through `ExploreApiService`**

In `app/Services/Maps/ExploreApiService.php`, in `translations()`, change:

```php
            'from_entry' => __('maps/explorer.marker.from_entry'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'edit_details' => __('maps/explorer.marker.edit'),
```

to:

```php
            'from_entry' => __('maps/explorer.marker.from_entry'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'description' => __('maps/explorer.marker.description'),
            'add_description' => __('maps/explorer.marker.add_description'),
            'edit_description' => __('maps/explorer.marker.edit_description'),
            'description_expand' => __('maps/explorer.marker.description_expand'),
            'cancel' => __('maps/explorer.marker.cancel'),
            'edit_details' => __('maps/explorer.marker.edit'),
```

- [ ] **Step 5: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS.

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add i18n keys for the map marker description field"
```

---

### Task 3: Frontend — `entryText.js` HTML/plain-text conversion module

**Files:**
- Create: `resources/js/maps/entryText.js`
- Test: `resources/js/maps/entryText.test.js`

**Interfaces:**
- Consumes: nothing (dependency-free).
- Produces: `htmlToPlainText(html: string|null|undefined): string`, `htmlToPreviewText(html: string|null|undefined): string` — both exported from `resources/js/maps/entryText.js` — consumed by Task 4's `DescriptionField.vue` and Task 5's `MarkerPanel.vue`.

- [ ] **Step 1: Write the failing test**

Create `resources/js/maps/entryText.test.js`:

```js
import { test } from 'node:test'
import assert from 'node:assert/strict'
import { htmlToPlainText, htmlToPreviewText } from './entryText.js'

test('htmlToPlainText converts <p> boundaries into blank lines', () => {
    assert.equal(htmlToPlainText('<p>First paragraph.</p><p>Second paragraph.</p>'), 'First paragraph.\n\nSecond paragraph.')
})

test('htmlToPlainText converts <br> into a single newline', () => {
    assert.equal(htmlToPlainText('<p>Line one.<br>Line two.</p>'), 'Line one.\nLine two.')
})

test('htmlToPlainText decodes escaped html entities back to literal characters', () => {
    assert.equal(
        htmlToPlainText('<p>5 &lt; 10 &amp; 10 &gt; 5 &quot;really&quot; &#039;yes&#039;</p>'),
        '5 < 10 & 10 > 5 "really" \'yes\'',
    )
})

test('htmlToPlainText strips unexpected tags without losing their text content', () => {
    assert.equal(htmlToPlainText('<p><strong>Bold</strong> text</p>'), 'Bold text')
})

test('htmlToPlainText does not treat tags merely starting with "p" as paragraph tags', () => {
    assert.equal(htmlToPlainText('<pre>code</pre>'), 'code')
})

test('htmlToPlainText returns an empty string for null, undefined, or empty input', () => {
    assert.equal(htmlToPlainText(null), '')
    assert.equal(htmlToPlainText(undefined), '')
    assert.equal(htmlToPlainText(''), '')
})

test('htmlToPlainText is a no-op on already-plain text', () => {
    assert.equal(htmlToPlainText('First paragraph.\n\nSecond paragraph.'), 'First paragraph.\n\nSecond paragraph.')
})

test('htmlToPreviewText collapses paragraph breaks and whitespace into single spaces', () => {
    assert.equal(htmlToPreviewText('<p>First paragraph.</p><p>Second paragraph.</p>'), 'First paragraph. Second paragraph.')
})

test('htmlToPreviewText returns an empty string for empty input', () => {
    assert.equal(htmlToPreviewText(''), '')
})
```

- [ ] **Step 2: Run test to verify it fails**

Run: `node --test resources/js/maps/entryText.test.js`
Expected: FAIL with a module-not-found error (`entryText.js` doesn't exist yet).

- [ ] **Step 3: Write the implementation**

Create `resources/js/maps/entryText.js`:

```js
const HTML_ENTITIES = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#039;': "'",
    '&#39;': "'",
}

function decodeHtmlEntities(text) {
    return text.replace(/&amp;|&lt;|&gt;|&quot;|&#0?39;/g, (match) => HTML_ENTITIES[match] ?? match)
}

/**
 * Convert entry HTML (server-purified, currently just <p>/<br> from the simple textarea
 * editor) back into editable plain text: paragraph boundaries become blank lines, <br>
 * becomes a single newline, remaining tags are stripped. Safe/idempotent on plain text
 * (no tags match), which matters because after a local unsaved edit `pin.entry` holds
 * plain text rather than HTML until the whole marker panel is saved.
 */
export function htmlToPlainText(html) {
    if (!html) {
        return ''
    }

    const withBreaks = html
        .replace(/<br\s*\/?>/gi, '\n')
        .replace(/<\/p>\s*<p(?:\s[^>]*)?>/gi, '\n\n')
        .replace(/<\/?p(?:\s[^>]*)?>/gi, '')

    const stripped = withBreaks.replace(/<[^>]+>/g, '')

    return decodeHtmlEntities(stripped).trim()
}

/**
 * Collapse entry HTML into a single-line, whitespace-normalized snippet for a truncated
 * preview — the visual truncation itself is CSS line-clamp, not this.
 */
export function htmlToPreviewText(html) {
    return htmlToPlainText(html).replace(/\s+/g, ' ').trim()
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `node --test resources/js/maps/entryText.test.js`
Expected: all 10 tests PASS.

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/entryText.js resources/js/maps/entryText.test.js
git commit -m "feat: add entryText.js for converting marker description html to/from plain text"
```

---

### Task 4: Frontend — `DescriptionField.vue` component

**Files:**
- Create: `resources/js/components/maps/DescriptionField.vue`

**Interfaces:**
- Consumes: `htmlToPlainText`, `htmlToPreviewText` from `resources/js/maps/entryText.js` (Task 3).
- Produces: a `DescriptionField` Vue component with props `pin: Object` (must have an `entry` key — `string|null`) and `i18n: Object` (must have `description`, `add_description`, `edit_description`, `description_expand`, `cancel`, `save` keys), emitting `change` with the current plain-text string on every edit — consumed by Task 5's `MarkerPanel.vue`.

- [ ] **Step 1: Write the component**

Create `resources/js/components/maps/DescriptionField.vue`:

```vue
<template>
    <div class="flex flex-col gap-2">
        <button
            v-if="!editing && !hasContent"
            type="button"
            class="btn2 btn-default btn-sm self-start"
            @click="startEditing"
        >
            {{ i18n.add_description }}
        </button>

        <template v-else>
            <div class="flex items-center justify-between gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.description }}</label>
                <button
                    type="button"
                    class="btn2 btn-default btn-sm"
                    v-tippy="i18n.description_expand"
                    @click="openDialog"
                >
                    <i class="fa-regular fa-up-right-and-down-left-from-center" aria-hidden="true" />
                    <span class="sr-only">{{ i18n.description_expand }}</span>
                </button>
            </div>

            <textarea
                v-if="editing"
                v-model="text"
                rows="3"
                class="w-full"
            />

            <template v-else>
                <div class="line-clamp-2 text-sm text-neutral-content">{{ preview }}</div>
                <button
                    type="button"
                    class="btn2 btn-default btn-sm self-start"
                    @click="startEditing"
                >
                    {{ i18n.edit_description }}
                </button>
            </template>
        </template>

        <dialog ref="dialogRef" class="dialog rounded-2xl bg-base-100 text-base-content" aria-modal="true">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h2>{{ i18n.description }}</h2>
                <button type="button" class="btn2 btn-default btn-sm" @click="closeDialog">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </header>
            <article class="max-w-2xl p-4 md:px-6">
                <textarea v-model="dialogText" rows="14" class="w-full" />
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
import { computed, ref, watch } from "vue";
import { htmlToPlainText, htmlToPreviewText } from "../../maps/entryText.js";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const editing = ref(false);
const text = ref(htmlToPlainText(props.pin.entry));
const dialogText = ref("");
const dialogRef = ref(null);

const hasContent = computed(() => htmlToPlainText(props.pin.entry).trim().length > 0);
const preview = computed(() => htmlToPreviewText(props.pin.entry));

function startEditing() {
    editing.value = true;
}

function openDialog() {
    dialogText.value = text.value;
    dialogRef.value?.showModal();
}

function closeDialog() {
    dialogRef.value?.close();
}

function saveDialog() {
    text.value = dialogText.value;
    editing.value = true;
    closeDialog();
}

watch(text, (value) => {
    emit("change", value);
});
</script>
```

Notes for the implementer:
- `text` is initialized once from `props.pin.entry` at component setup — this component is expected to fully remount whenever the marker panel opens for a different pin (matching the existing `StrokeWidthPicker.vue`/`OpacityPicker.vue` pattern in this codebase, neither of which re-syncs local state from prop changes after mount either), so no extra reset-on-prop-change watcher is needed.
- The preview (`hasContent`, `preview`) always reads `props.pin.entry` directly (never the local `text` ref) — it's only rendered while `!editing`, so `pin.entry` is guaranteed to be whatever the parent's canonical current value is.
- `saveDialog()` always sets `editing.value = true` regardless of which state (collapsed/preview) the dialog was opened from — "the dialog is just a bigger way to edit the same textarea."
- `<textarea>` intentionally has no border/background/padding styling classes (only `w-full` for width) — `resources/css/themes/base.css` already styles bare `input`/`textarea`/`select` elements identically (border, background, padding, focus ring) via element selectors, so no `.input`/`.textarea`-style class is needed (confirmed by reading `base.css:72-93` directly — do not add a `textarea-bordered`-style class, it isn't a real class in this app's stylesheet).

- [ ] **Step 2: Manually verify markup renders without errors**

This component has no automated test (no Vue component test harness exists in this repo — established pattern for every prior v4 map explorer component). Confirm it at least compiles cleanly by running the frontend build:

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors referencing `DescriptionField.vue`. (Full interactive verification happens in Task 5, once it's actually wired in and reachable in the UI.)

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/DescriptionField.vue
git commit -m "feat: add DescriptionField.vue component for map marker descriptions"
```

---

### Task 5: Frontend — wire `DescriptionField` into the marker panel

**Files:**
- Modify: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `DescriptionField` (Task 4), `htmlToPlainText` from `entryText.js` (Task 3), `entry` field on pin objects returned by `PinResource` (Task 1), `entry-change` event.
- Produces: nothing consumed by later tasks — this is the final integration task.

- [ ] **Step 1: Add `DescriptionField` to `MarkerPanel.vue`**

In `resources/js/components/maps/MarkerPanel.vue`, add the import — change:

```js
import ColourPicker from "./ColourPicker.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
```

to:

```js
import ColourPicker from "./ColourPicker.vue";
import DescriptionField from "./DescriptionField.vue";
import EntityLinkSelect from "./EntityLinkSelect.vue";
```

Add an import for `htmlToPlainText`, next to the existing `polygon.js` import — change:

```js
import { serializeVertices } from "../../maps/polygon.js";
```

to:

```js
import { htmlToPlainText } from "../../maps/entryText.js";
import { serializeVertices } from "../../maps/polygon.js";
```

In the template, add the component right after the name `<input>` — change:

```html
            <input
                ref="nameInputRef"
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />

            <ColourPicker
```

to:

```html
            <input
                ref="nameInputRef"
                v-model="name"
                type="text"
                class="input input-bordered w-full"
                :placeholder="i18n.name_placeholder"
            />

            <DescriptionField
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('entry-change', $event)"
            />

            <ColourPicker
```

Add `"entry-change"` to `defineEmits` — change:

```js
const emit = defineEmits([
    "close",
    "created",
    "updated",
    "deleted",
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
    "border-colour-change",
    "stroke-width-change",
]);
```

to:

```js
const emit = defineEmits([
    "close",
    "created",
    "updated",
    "deleted",
    "icon-change",
    "group-change",
    "entity-change",
    "visibility-change",
    "colour-change",
    "opacity-change",
    "name-change",
    "entry-change",
    "border-colour-change",
    "stroke-width-change",
]);
```

- [ ] **Step 2: Send plain text in the save payload**

In `buildPayload()`, change:

```js
    return {
        name: name.value,
        latitude: props.pin.latitude,
```

to:

```js
    return {
        name: name.value,
        // props.pin.entry may still be the raw HTML loaded from the server (if the user
        // never touched the description field this session) or already-plain text (if
        // they did) — htmlToPlainText() is a no-op on plain text, so this always sends
        // plain text to the backend regardless of which state it's currently in.
        entry: htmlToPlainText(props.pin.entry),
        latitude: props.pin.latitude,
```

- [ ] **Step 3: Wire `toEditingPin()`, draft defaults, and the change handler in `MapExplorer.vue`**

In `resources/js/components/maps/MapExplorer.vue`, in `toEditingPin()`, change:

```js
function toEditingPin(pin) {
    return {
        id: pin.id,
        name: pin.name,
        colour: pin.colour,
```

to:

```js
function toEditingPin(pin) {
    return {
        id: pin.id,
        name: pin.name,
        entry: pin.entry,
        colour: pin.colour,
```

Add `entry: "",` to all four draft-pin creation sites. In `handleMapClick()`, change:

```js
    draftPin.value = {
        name: "",
        colour: defaultColour(),
        shape: isText ? "label" : "marker",
```

to:

```js
    draftPin.value = {
        name: "",
        entry: "",
        colour: defaultColour(),
        shape: isText ? "label" : "marker",
```

In `handlePolygonFinish()`, change:

```js
    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "poly",
```

to:

```js
    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "poly",
```

In `handleCircleFinish()`, change:

```js
    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "circle",
```

to:

```js
    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "circle",
```

In `handlePathFinish()`, change:

```js
    draftPin.value = {
        name: "",
        colour: style.colour,
        shape: "path",
```

to:

```js
    draftPin.value = {
        name: "",
        entry: "",
        colour: style.colour,
        shape: "path",
```

Add the new handler right after `handleNameChange()`:

```js
function handleNameChange(name) {
    patchActivePin({ name });
}

function handleEntryChange(text) {
    patchActivePin({ entry: text });
}
```

In the template, wire the event on `<MarkerPanel>` — change:

```html
            @name-change="handleNameChange"
            @border-colour-change="handleBorderColourChange"
```

to:

```html
            @name-change="handleNameChange"
            @entry-change="handleEntryChange"
            @border-colour-change="handleBorderColourChange"
```

- [ ] **Step 4: Build and manually verify end to end**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds.

No automated coverage exists for live Vue component interaction in this app (established pattern for every prior v4 map explorer change) — verify by hand in a browser against a campaign with a map:

1. Open the map explorer, start creating a new pin, expand to full details ("Details" button). Confirm the Description field shows only an "Add description" button with no label.
2. Click "Add description" — confirm a label "Description", an expand-icon button (hover shows "Expand editor" tooltip), and a 3-row textarea appear. Type a two-paragraph description (blank line between). Save the pin.
3. Reopen that pin for editing, expand to full details. Confirm the description now shows as a label + expand icon + a truncated 2-line preview (no leftover HTML tags visible) + a small "Edit" button.
4. Click "Edit" — confirm the textarea repopulates with your original plain text, correctly split back into two paragraphs (blank line preserved).
5. Click the expand icon — confirm a dialog opens (styled like other dialogs in the app) with a large textarea pre-filled with the current text. Change the text and click Save — confirm the dialog closes and the inline textarea now shows the updated text. Save the pin and reopen it to confirm the change persisted correctly (still properly paragraph-wrapped).
6. Repeat step 5 but click Cancel instead of Save — confirm the inline textarea (and the saved pin, if you save without touching it further) is unaffected by whatever was typed in the dialog.
7. Edit an existing pin that already has a name and other fields, but do **not** touch the description field, then save — confirm (by reopening it) the description is unchanged, not mangled/double-escaped (this is the scenario Step 2 of this task's `buildPayload()` fix specifically guards against).
8. Create or edit a pin and leave the description empty — confirm it still shows the "Add description" collapsed state (not an empty preview).

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/MarkerPanel.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: wire the description field into the map marker create/edit panel"
```
