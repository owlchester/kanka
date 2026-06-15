# Date Mentions Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allow users to mention a specific date on a calendar via the Tiptap `@` mention flow, stored as `[calendar:id|date:Y-M-D]`, rendered as a formatted date string linking to that calendar month.

**Architecture:** Extend the existing mention config system with a `date` key. The `@` mention dropdown transitions to a keyboard-navigable date step when a calendar is selected. The backend parses the date config, formats using the calendar's date format, and links to the calendar URL with `?month=X&year=Y`.

**Tech Stack:** PHP 8.4, Laravel 11, Pest 3, Vue 3, TypeScript, Tiptap

---

## Files

**Create:**
- `tests/Feature/Calendars/DateMentionTest.php`

**Modify:**
- `app/Traits/MentionTrait.php:112` — add `date` to config key parsers
- `app/Models/Calendar.php` — add `formatDate(string $date): string` after `niceDate()` (~line 264)
- `app/Services/Search/MentionService.php:157-177` — refactor `formatEntity()` to conditionally include `date` + `months` for calendars
- `app/Services/MentionsService.php` — add `date` config handler after anchor handling (~line 320)
- `resources/js/editors/tiptap/extensions/mentions/suggestion.ts` — extend `MentionItem` interface + pass calendar fields
- `resources/js/editors/tiptap/extensions/mentions/MentionList.vue` — add date step state, handlers, and template

---

### Task 1: Parse `date` config key in MentionTrait

**Files:**
- Modify: `app/Traits/MentionTrait.php:112`
- Test: `tests/Feature/Calendars/DateMentionTest.php`

- [ ] **Step 1: Create the test file with the first failing test**

Create `tests/Feature/Calendars/DateMentionTest.php`:

```php
<?php

use App\Traits\MentionTrait;

it('extracts a date config key from a calendar mention', function () {
    $service = new class {
        use MentionTrait;

        public function testExtract(string $type, string $rest): array
        {
            return $this->extractData([1 => $type, 2 => $rest]);
        }
    };

    $data = $service->testExtract('calendar', '5|date:1000-3-15');

    expect($data['date'])->toBe('1000-3-15');
});
```

- [ ] **Step 2: Run the test to confirm it fails**

```bash
vendor/bin/sail artisan test --compact --filter="extracts a date config key"
```

Expected: FAIL — `$data['date']` is undefined

- [ ] **Step 3: Add `date` to the config key parser in MentionTrait**

In `app/Traits/MentionTrait.php`, on the line that reads:

```php
} elseif (in_array($type, ['anchor', 'params', 'tooltip'])) {
```

Change it to:

```php
} elseif (in_array($type, ['anchor', 'params', 'tooltip', 'date'])) {
```

- [ ] **Step 4: Run the test to confirm it passes**

```bash
vendor/bin/sail artisan test --compact --filter="extracts a date config key"
```

Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add app/Traits/MentionTrait.php tests/Feature/Calendars/DateMentionTest.php
git commit -m "feat: parse date config key in MentionTrait"
```

---

### Task 2: Add `Calendar::formatDate()` method

**Files:**
- Modify: `app/Models/Calendar.php` (add after `niceDate()` method, ~line 264)
- Test: `tests/Feature/Calendars/DateMentionTest.php`

- [ ] **Step 1: Add failing tests**

Append to `tests/Feature/Calendars/DateMentionTest.php`:

```php
it('formats a date using the calendar default format', function () {
    $calendar = new \App\Models\Calendar();
    $calendar->months = '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"February","length":28,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""}]';
    $calendar->suffix = 'AD';

    expect($calendar->formatDate('1000-3-15'))->toBe('15 March, 1000 AD');
});

it('formats a date using the calendar custom format', function () {
    $calendar = new \App\Models\Calendar();
    $calendar->months = '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"February","length":28,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""}]';
    $calendar->suffix = 'AC';
    $calendar->format = 'd M, s y';

    expect($calendar->formatDate('1000-3-15'))->toBe('15 March, AC 1000');
});

it('returns the raw date string when formatDate fails', function () {
    $calendar = new \App\Models\Calendar();
    $calendar->months = '[]';
    $calendar->suffix = '';

    expect($calendar->formatDate('1000-3-15'))->toBe('15 3, 1000 ');
});
```

- [ ] **Step 2: Run tests to confirm they fail**

```bash
vendor/bin/sail artisan test --compact --filter="formats a date using the calendar"
```

Expected: FAIL — method `formatDate` does not exist

- [ ] **Step 3: Add `formatDate()` to Calendar model**

In `app/Models/Calendar.php`, add the following method after `niceDate()` (after line 264):

```php
public function formatDate(string $date): string
{
    if (empty($date)) {
        return '';
    }

    [$year, $month, $day] = $this->dateArray($date);
    $months = $this->months();
    $years = $this->years();

    try {
        if ($this->format) {
            return Str::replace(
                ['d', 's', 'y', 'm', 'M'],
                [
                    $day,
                    $this->suffix,
                    $years[$year] ?? $year,
                    $month,
                    isset($months[$month - 1]) ? $months[$month - 1]['name'] : $month,
                ],
                $this->format
            );
        }

        return $day . ' ' .
            (isset($months[$month - 1]) ? $months[$month - 1]['name'] : $month) . ', ' .
            ($years[$year] ?? $year) . ' ' .
            $this->suffix;
    } catch (Exception $e) {
        return $date;
    }
}
```

`Str` and `Exception` are already imported at the top of `Calendar.php`.

- [ ] **Step 4: Run tests to confirm they pass**

```bash
vendor/bin/sail artisan test --compact --filter="formats a date using the calendar"
```

Expected: all PASS

- [ ] **Step 5: Commit**

```bash
git add app/Models/Calendar.php tests/Feature/Calendars/DateMentionTest.php
git commit -m "feat: add Calendar::formatDate() for date mention rendering"
```

---

### Task 3: Include `date` and `months` in calendar suggestion results

**Files:**
- Modify: `app/Services/Search/MentionService.php:157-177` (`formatEntity` method)
- Test: `tests/Feature/Calendars/DateMentionTest.php`

- [ ] **Step 1: Add failing test**

Append to `tests/Feature/Calendars/DateMentionTest.php`:

```php
it('includes date and months in calendar mention search results', function () {
    $this->asUser()->withCampaign();

    \App\Models\Calendar::factory()->create([
        'campaign_id' => 1,
        'name' => 'Test Calendar',
        'months' => '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""}]',
        'suffix' => 'AD',
        'date' => '1000-3-15',
    ]);

    $response = $this->get('/w/test-campaign/search/mention?q=Test');

    $response->assertStatus(200);

    $entities = $response->json('entities');
    $calendar = collect($entities)->firstWhere('type', 'Calendar');

    expect($calendar)->not->toBeNull()
        ->and($calendar['date'])->toBe('1000-3-15')
        ->and($calendar['months'])->toHaveCount(2)
        ->and($calendar['months'][1]['name'])->toBe('March');
});
```

- [ ] **Step 2: Run test to confirm it fails**

```bash
vendor/bin/sail artisan test --compact --filter="includes date and months in calendar mention search"
```

Expected: FAIL — calendar result has no `date` or `months` keys

- [ ] **Step 3: Refactor `formatEntity()` in MentionService to include calendar fields**

In `app/Services/Search/MentionService.php`, replace the entire `formatEntity()` method (lines 157–177):

```php
protected function formatEntity(Entity $entity): array
{
    $mention = '[' . $entity->entityType->code . ':' . $entity->id . ']';
    // @phpstan-ignore-next-line
    if ($entity->alias_id) {
        $mention = '[' . $entity->entityType->code . ':' . $entity->id . '|alias:' . $entity->alias_id . ']';
    }

    $result = [
        'id' => $entity->id,
        'name' => $entity->name,
        'type' => $entity->entityType->name(),
        'is_private' => $entity->is_private,
        'image' => Avatar::entity($entity)->fallback()->size(32)->thumbnail(),
        'url' => $entity->url(),
        'preview' => route('entities.preview', [$this->campaign, $entity]),
        'mention' => $mention,
        'alias_name' => $entity->alias_name ?? null,
        'alias_id' => $entity->alias_id ?? null,
        'aliases' => $entity->aliases->map(fn ($alias) => [
            'id' => $alias->id,
            'name' => $alias->name,
        ])->toArray(),
    ];

    if ($entity->entityType->code === 'calendar') {
        $child = $entity->child;
        if ($child) {
            $result['date'] = $child->date;
            $result['months'] = $child->months();
        }
    }

    return $result;
}
```

- [ ] **Step 4: Run test to confirm it passes**

```bash
vendor/bin/sail artisan test --compact --filter="includes date and months in calendar mention search"
```

Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add app/Services/Search/MentionService.php tests/Feature/Calendars/DateMentionTest.php
git commit -m "feat: include date and months in calendar mention search results"
```

---

### Task 4: Render date mention in MentionsService

**Files:**
- Modify: `app/Services/MentionsService.php` (after anchor handling, ~line 320)
- Test: `tests/Feature/Calendars/DateMentionTest.php`

- [ ] **Step 1: Add failing test**

Append to `tests/Feature/Calendars/DateMentionTest.php`:

```php
it('renders a calendar date mention as a formatted link', function () {
    $this->asUser()->withCampaign();

    $calendar = \App\Models\Calendar::factory()->create([
        'campaign_id' => 1,
        'months' => '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"February","length":28,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""}]',
        'suffix' => 'AD',
        'date' => '1000-3-15',
    ]);

    $entityId = $calendar->entity->id;

    $response = $this->postJson('/api/1.0/campaigns/1/characters', [
        'name' => 'Test Character',
        'entry' => "[calendar:{$entityId}|date:1000-3-15]",
    ])->assertStatus(201);

    $entryParsed = $response->json('data.entry_parsed');

    expect($entryParsed)
        ->toContain('15 March, 1000 AD')
        ->toContain('month=3')
        ->toContain('year=1000');
});
```

- [ ] **Step 2: Run test to confirm it fails**

```bash
vendor/bin/sail artisan test --compact --filter="renders a calendar date mention as a formatted link"
```

Expected: FAIL — `entry_parsed` does not contain the formatted date or URL params

- [ ] **Step 3: Add date config handling to MentionsService**

In `app/Services/MentionsService.php`, find the anchor handling block (which reads `$url .= '#' . $data['anchor'];`). After that entire `if (! empty($data['anchor']))` block, add:

```php
if (! empty($data['date'])) {
    $child = $entity->child;
    if ($child instanceof Calendar) {
        [$year, $month] = $child->dateArray($data['date']);
        $url = $entity->url('show', ['month' => (int) $month, 'year' => (int) $year]);
        $data['text'] = $child->formatDate($data['date']);
    }
}
```

`Calendar` is already imported at the top of `MentionsService.php` (`use App\Models\Calendar;`).

- [ ] **Step 4: Run test to confirm it passes**

```bash
vendor/bin/sail artisan test --compact --filter="renders a calendar date mention as a formatted link"
```

Expected: PASS

- [ ] **Step 5: Run the full test suite for this feature**

```bash
vendor/bin/sail artisan test --compact tests/Feature/Calendars/DateMentionTest.php
```

Expected: all tests PASS

- [ ] **Step 6: Run Pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 7: Commit**

```bash
git add app/Services/MentionsService.php tests/Feature/Calendars/DateMentionTest.php
git commit -m "feat: render calendar date mentions as formatted date links"
```

---

### Task 5: Pass calendar fields through suggestion.ts

**Files:**
- Modify: `resources/js/editors/tiptap/extensions/mentions/suggestion.ts`

- [ ] **Step 1: Extend the `MentionItem` interface**

In `suggestion.ts`, update the `MentionItem` interface by adding two fields at the bottom:

```typescript
interface MentionItem {
    id?: string
    name: string
    image?: string
    url?: string
    mention?: string
    type?: string
    aliases?: any
    alias_name?: string
    alias_id?: number
    inject?: string
    value?: string
    section: 'entities' | 'posts' | 'new' | 'attributes'
    calendarDate?: string
    calendarMonths?: Array<{name: string; length: number; type: string}>
}
```

- [ ] **Step 2: Include calendar fields in the entity items loop**

In the `data.entities.forEach` block (~line 55), replace the existing `items.push({...})` call with:

```typescript
data.entities.forEach((item: any) => {
    items.push({
        id: item.id,
        name: item.name,
        image: item.image,
        url: item.url,
        aliases: item.aliases,
        alias_name: item.alias_name,
        alias_id: item.alias_id,
        mention: item.mention,
        type: item.type,
        section: 'entities',
        calendarDate: item.date,
        calendarMonths: item.months,
    })
})
```

- [ ] **Step 3: Verify the build compiles**

```bash
vendor/bin/sail yarn run build 2>&1 | tail -20
```

Expected: no TypeScript errors, build succeeds

- [ ] **Step 4: Commit**

```bash
git add resources/js/editors/tiptap/extensions/mentions/suggestion.ts
git commit -m "feat: pass calendar date and months through mention suggestion items"
```

---

### Task 6: Add date step UI to MentionList.vue

**Files:**
- Modify: `resources/js/editors/tiptap/extensions/mentions/MentionList.vue`

This task adds a second "step" inside the mention dropdown that activates when a calendar is selected. The user navigates entirely by keyboard (arrow keys + Enter/Escape), so the editor never loses focus and the suggestion plugin stays open.

- [ ] **Step 1: Update the `MentionItem` interface in MentionList.vue**

In the `<script setup>` block, add `calendarDate` and `calendarMonths` to the `MentionItem` interface:

```typescript
interface MentionItem {
    id?: string
    name: string
    image?: string
    url?: string
    mention?: string
    type?: string
    alias_name?: string
    alias_id?: number
    inject?: string
    value?: string
    section: SectionType
    calendarDate?: string
    calendarMonths?: Array<{name: string; length: number; type: string}>
}
```

- [ ] **Step 2: Add date step state refs**

After `const selectedIndex = ref(0)`, add:

```typescript
const dateStep = ref(false)
const pendingItem = ref<MentionItem | null>(null)
const dateYear = ref(0)
const dateMonth = ref(1)
const dateDay = ref(1)
const activeDateField = ref<'year' | 'month' | 'day'>('year')
const dateFields: Array<'year' | 'month' | 'day'> = ['year', 'month', 'day']
```

- [ ] **Step 3: Add date step helper functions**

Add the following functions before the existing `selectItem` function:

```typescript
const parseDateString = (dateStr: string): [number, number, number] => {
    if (!dateStr) return [0, 1, 1]
    const isNegative = dateStr.startsWith('-')
    const clean = isNegative ? dateStr.slice(1) : dateStr
    const parts = clean.split('-')
    if (parts.length !== 3) return [0, 1, 1]
    const year = isNegative ? -parseInt(parts[0]) : parseInt(parts[0])
    return [year, parseInt(parts[1]), parseInt(parts[2])]
}

const cycleField = (direction: number) => {
    const current = dateFields.indexOf(activeDateField.value)
    activeDateField.value = dateFields[(current + direction + dateFields.length) % dateFields.length]
}

const incrementActive = () => {
    if (activeDateField.value === 'year') {
        dateYear.value++
    } else if (activeDateField.value === 'month') {
        const maxMonth = pendingItem.value?.calendarMonths?.length ?? 12
        dateMonth.value = dateMonth.value >= maxMonth ? 1 : dateMonth.value + 1
    } else {
        dateDay.value++
    }
}

const decrementActive = () => {
    if (activeDateField.value === 'year') {
        dateYear.value--
    } else if (activeDateField.value === 'month') {
        const maxMonth = pendingItem.value?.calendarMonths?.length ?? 12
        dateMonth.value = dateMonth.value <= 1 ? maxMonth : dateMonth.value - 1
    } else if (dateDay.value > 1) {
        dateDay.value--
    }
}

const confirmDate = () => {
    if (!pendingItem.value) return
    const dateStr = `${dateYear.value}-${dateMonth.value}-${dateDay.value}`
    const mention = pendingItem.value.mention!.replace(']', `|date:${dateStr}]`)
    props.command({ ...pendingItem.value, mention })
    dateStep.value = false
    pendingItem.value = null
}

const skipDate = () => {
    if (!pendingItem.value) return
    props.command(pendingItem.value)
    dateStep.value = false
    pendingItem.value = null
}

const handleDateStepKeyDown = (event: KeyboardEvent): boolean => {
    if (event.key === 'ArrowUp') { incrementActive(); return true }
    if (event.key === 'ArrowDown') { decrementActive(); return true }
    if (event.key === 'ArrowRight') { cycleField(1); return true }
    if (event.key === 'ArrowLeft') { cycleField(-1); return true }
    if (event.key === 'Tab') { event.preventDefault(); cycleField(event.shiftKey ? -1 : 1); return true }
    if (event.key === 'Enter') { confirmDate(); return true }
    if (event.key === 'Escape') { skipDate(); return true }
    return true
}
```

- [ ] **Step 4: Modify `selectItem` to intercept calendar selections**

Replace the existing `selectItem` function:

```typescript
const selectItem = (index: number) => {
    const item = props.items[index]
    if (!item) return

    if (item.calendarDate !== undefined) {
        const [year, month, day] = parseDateString(item.calendarDate ?? '')
        dateYear.value = year
        dateMonth.value = month
        dateDay.value = day
        activeDateField.value = 'year'
        pendingItem.value = item
        dateStep.value = true
        return
    }

    props.command(item)
}
```

- [ ] **Step 5: Modify `onKeyDown` to delegate to date step handler when active**

Replace the existing `onKeyDown` function:

```typescript
const onKeyDown = ({ event }: { event: KeyboardEvent }): boolean => {
    if (dateStep.value) {
        return handleDateStepKeyDown(event)
    }

    if (event.key === 'ArrowUp') {
        upHandler()
        return true
    }

    if (event.key === 'ArrowDown') {
        downHandler()
        return true
    }

    if (event.key === 'Enter') {
        enterHandler()
        return true
    }

    return false
}
```

- [ ] **Step 6: Replace the template with date step support**

Replace the entire `<template>` block with the following. The date step renders in place of the suggestion list when active:

```vue
<template>
    <div class="mention-list bg-base-100 shadow-lg rounded-lg z-50 max-h-[300px] overflow-y-auto">
        <template v-if="dateStep && pendingItem">
            <div class="px-3 py-3 min-w-[220px]">
                <p class="text-xs font-semibold mb-2">
                    Set date — {{ pendingItem.name }}
                </p>
                <div class="flex flex-col gap-1 mb-2">
                    <div
                        v-for="field in dateFields"
                        :key="field"
                        class="flex items-center gap-2 px-2 py-1 rounded"
                        :class="{ 'bg-base-200': activeDateField === field }"
                    >
                        <span class="text-xs text-neutral-content capitalize w-12">{{ field }}</span>
                        <span class="text-xs font-mono">
                            <template v-if="field === 'year'">{{ dateYear }}</template>
                            <template v-else-if="field === 'month'">
                                {{ pendingItem.calendarMonths?.[dateMonth - 1]?.name ?? dateMonth }}
                            </template>
                            <template v-else>{{ dateDay }}</template>
                        </span>
                    </div>
                </div>
                <p class="text-xs text-neutral-content/60">
                    ↑↓ adjust · ←→ switch · Enter confirm · Esc skip
                </p>
            </div>
        </template>
        <template v-else-if="items.length">
            <div v-for="section in sections" :key="section.key" class="mention-section">
                <div class="section-header px-3 py-1 text-xs font-semibold text-neutral-content/70 bg-base-200/50 flex items-center gap-2">
                    <i :class="section.icon" aria-hidden="true"></i>
                    {{ section.label }}
                </div>

                <button
                    v-for="(item, itemIndex) in section.items"
                    :key="item.id ?? `${section.key}-${itemIndex}`"
                    @click="selectItem(getFlatIndex(section.key, itemIndex))"
                    class="mention-item flex items-center gap-2 w-full text-left px-3 py-2 hover:bg-base-200 text-xs justify-between cursor-pointer"
                    :class="{ 'bg-base-200': getFlatIndex(section.key, itemIndex) === selectedIndex }"
                >
                    <div class="flex gap-2 items-center">
                        <template v-if="section.key === 'new'">
                            <i class="fa-regular fa-plus text-success" aria-hidden="true"></i>
                        </template>
                        <img
                            v-else-if="item.image"
                            :src="item.image"
                            :alt="item.name"
                            loading="lazy"
                            class="w-6 h-6 rounded-full object-cover"
                        />
                        <span class="mention-name flex gap-1">
                            <span v-html="item.name"></span>
                            <template v-if="item.alias_name">
                                <i class="fa-regular fa-masks-theater" aria-hidden="true"></i>
                                ({{ item.alias_name }})
                            </template>
                        </span>
                    </div>
                    <span v-if="item.type" class="mention-type text-neutral-content" v-html="item.type"></span>
                    <span v-if="item.value" class="text-neutral-content" v-html="item.value"></span>
                </button>
            </div>
        </template>
        <div v-else class="px-3 py-2 text-neutral-content text-xs">
            <span v-if="showMinCharacterMessage">
                Type at least 3 characters
            </span>
            <span v-else-if="showLoading">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                Loading...
            </span>
            <span v-else-if="showNoResults">
                No results
            </span>
        </div>
    </div>
</template>
```

The `<style scoped>` block remains unchanged.

- [ ] **Step 7: Build and verify no errors**

```bash
vendor/bin/sail yarn run build 2>&1 | tail -20
```

Expected: build succeeds with no TypeScript errors

- [ ] **Step 8: Manually verify the feature**

Start dev server (`vendor/bin/sail composer run dev`), then:

1. Open any entity's edit page in the browser
2. Click into the Tiptap editor
3. Type `@` followed by 3+ characters matching a calendar name
4. Select the calendar from the dropdown — the date step should appear showing pre-filled year/month/day from the calendar's current date
5. Use ↑/↓ to adjust the active field value, ←/→ (or Tab) to switch between year/month/day
6. Press Enter to confirm — the mention node inserts into the editor
7. Save and reload the page — the mention should render as a formatted date text (e.g., "15 March, 1000 AD") linking to the calendar with `?month=3&year=1000`
8. Press Esc during the date step — the calendar mention inserts without a date (as a plain calendar link)

- [ ] **Step 9: Commit**

```bash
git add resources/js/editors/tiptap/extensions/mentions/MentionList.vue
git commit -m "feat: add date step UI to calendar mentions in Tiptap editor"
```
