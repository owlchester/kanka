# Visibility Picker Implementation Plan

> **For agentic workers:** REQUIRED: Use superpowers:subagent-driven-development (if subagents available) or superpowers:executing-plans to implement this plan. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the dialog-based post visibility selector with an inline Tippy.js dropdown that updates visibility via background request.

**Architecture:** A reusable Blade component (`x-forms.visibility-picker`) with inline Alpine.js state manages a Tippy dropdown. Tippy is initialized manually via Alpine's `x-init` (not through `initDropdowns()` which copies innerHTML and breaks Alpine reactivity). The component POSTs to the existing `VisibilityController::update` endpoint.

**Tech Stack:** Blade, Alpine.js (inline x-data), Tippy.js, axios

**Spec:** `docs/superpowers/specs/2026-03-11-visibility-picker-design.md`

---

## Chunk 1: Foundation

### File Structure

| Action | File | Purpose |
|--------|------|---------|
| Create | `app/View/Components/Forms/VisibilityPicker.php` | Component class with props |
| Create | `resources/views/components/forms/visibility-picker.blade.php` | Blade template with Alpine + Tippy |
| Modify | `lang/en/visibilities.php` | Add `picker` translation keys |
| Modify | `resources/js/utility/tippy.js:112` | Export tippy to window |
| Modify | `resources/views/entities/components/posts/standard.blade.php:23-30` | Replace dialog trigger with component |
| Modify | `resources/views/entities/components/posts/custom.blade.php:19-26` | Replace dialog trigger with component |

---

### Task 1: Add translation keys

**Files:**
- Modify: `lang/en/visibilities.php`

- [ ] **Step 1: Add `picker` key group to visibilities lang file**

Add a new `picker` key group with context-rich helper text for each visibility level. Uses `:entity` and `:admin` as replacement placeholders.

```php
'picker' => [
    'all' => 'Anyone who can see :entity can see this.',
    'admin' => 'Only visible to members of the :admin role.',
    'admin-self' => 'Only you and members of the :admin role can see this.',
    'self' => 'Only you can see this.',
    'member' => 'Only visible to campaign members. Useful for public campaigns.',
'failed' => 'Failed to update visibility.',
],
```

Add this after the existing `helpers` array (before `'title'`). Do not modify the existing `helpers` keys — they are used by `HasVisibility::visibilityIcon()` for tooltips throughout the app.

**Note:** The spec defines `$options` as a nested array with `name` and `icon` keys. This plan intentionally deviates — we pass the flat `[visibility_id => translated_name]` array from `visibilityOptions()` directly and handle icon mapping separately via `buildIconMap()` in the component class. This avoids modifying the existing `HasVisibility` trait.

- [ ] **Step 2: Commit**

```bash
git add lang/en/visibilities.php
git commit -m "Add visibility picker translation keys"
```

---

### Task 2: Expose tippy to window

**Files:**
- Modify: `resources/js/utility/tippy.js:112`

- [ ] **Step 1: Add `window.tippy = tippy` export**

At the bottom of `resources/js/utility/tippy.js`, after the existing `window.initDropdowns = initDropdowns;` line (line 112), add:

```js
window.tippy = tippy;
```

This makes the tippy constructor available to Alpine components in Blade templates. The existing `initDropdowns`, `initTooltips`, and `ajaxTooltip` exports on window already follow this pattern.

- [ ] **Step 2: Commit**

```bash
git add resources/js/utility/tippy.js
git commit -m "Expose tippy constructor on window for Alpine components"
```

---

### Task 3: Create the component PHP class

**Files:**
- Create: `app/View/Components/Forms/VisibilityPicker.php`

- [ ] **Step 1: Create the component class**

Use `vendor/bin/sail artisan make:class App/View/Components/Forms/VisibilityPicker --no-interaction` to scaffold, then replace contents.

The class follows the same pattern as `app/View/Components/Forms/Select.php` — constructor property promotion, explicit return types.

```php
<?php

namespace App\View\Components\Forms;

use App\Enums\Visibility;
use App\Models\Campaign;
use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VisibilityPicker extends Component
{
    public function __construct(
        public Entity $entity,
        public Campaign $campaign,
        public int $selected,
        public string $url,
        public array $options,
        public ?string $id = null,
    ) {
        $this->id = $id ?? uniqid('visibility-');
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.visibility-picker', [
            'adminUrl' => route('campaigns.campaign_roles.admin', $this->campaign),
            'adminName' => $this->campaign->adminRoleName(),
            'entityName' => $this->entity->name,
            'iconMap' => $this->buildIconMap(),
        ]);
    }

    /**
     * @return array<int, string>
     */
    protected function buildIconMap(): array
    {
        return [
            Visibility::All->value => 'fa-regular fa-eye',
            Visibility::Admin->value => 'fa-regular fa-lock',
            Visibility::AdminSelf->value => 'fa-regular fa-user-lock',
            Visibility::Self->value => 'fa-regular fa-user-secret',
            Visibility::Member->value => 'fa-regular fa-users',
        ];
    }
}
```

- [ ] **Step 2: Commit**

```bash
git add app/View/Components/Forms/VisibilityPicker.php
git commit -m "Add VisibilityPicker Blade component class"
```

---

### Task 4: Create the Blade template

**Files:**
- Create: `resources/views/components/forms/visibility-picker.blade.php`

- [ ] **Step 1: Create the Blade template**

This is the core of the component. It renders a trigger button and a hidden dropdown that Alpine mounts into a Tippy instance.

Key implementation details:
- Uses inline `x-data` (codebase convention — no `Alpine.data()` registrations exist)
- Initializes Tippy manually via `x-init` using `window.tippy()`, passing the DOM node via `$refs.dropdown` to preserve Alpine reactivity
- Uses `kanka-dropdown` theme and `zIndex: 890` to match existing dropdowns
- Uses `axios` (globally available, auto-includes CSRF) for the POST request
- Helper text uses `__('visibilities.picker.*')` with `:entity` replaced inline and `:admin` replaced with an `<a class="text-link">` link
- The Visibility enum case names map to translation keys: `All` → `all`, `Admin` → `admin`, `AdminSelf` → `admin-self`, `Self` → `self`, `Member` → `member`

```blade
<?php
/**
 * @var string $id
 * @var string $url
 * @var int $selected
 * @var array $options
 * @var array $iconMap
 * @var string $adminUrl
 * @var string $adminName
 * @var string $entityName
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */

$visibilityKeys = [
    \App\Enums\Visibility::All->value => 'all',
    \App\Enums\Visibility::Admin->value => 'admin',
    \App\Enums\Visibility::AdminSelf->value => 'admin-self',
    \App\Enums\Visibility::Self->value => 'self',
    \App\Enums\Visibility::Member->value => 'member',
];

$adminLink = '<a href="' . e($adminUrl) . '" class="text-link">' . e($adminName) . '</a>';
?>
<span
    id="{{ $id }}"
    x-data="{
        selected: {{ $selected }},
        loading: null,
        icons: {{ Js::from($iconMap) }},
        get currentIcon() { return this.icons[this.selected] || 'fa-regular fa-eye'; },
        tippyInstance: null,
        initPicker() {
            this.tippyInstance = window.tippy(this.$refs.trigger, {
                content: this.$refs.dropdown,
                theme: 'kanka-dropdown',
                placement: 'bottom',
                allowHTML: true,
                interactive: true,
                trigger: 'click',
                zIndex: 890,
                appendTo: document.body,
                onShow: () => { this.$refs.dropdown.classList.remove('hidden'); },
                onHide: () => { this.$refs.dropdown.classList.add('hidden'); },
            });
        },
        update(visibilityId) {
            if (this.loading || visibilityId === this.selected) return;
            this.loading = visibilityId;
            axios.post('{{ $url }}', { visibility_id: visibilityId })
                .then((res) => {
                    this.selected = visibilityId;
                    this.loading = null;
                    window.showToast(res.data.toast);
                })
                .catch(() => {
                    this.loading = null;
                    window.showToast('{{ __('visibilities.picker.failed') }}', 'error');
                });
        },
    }"
    x-init="initPicker()"
>
    <button x-ref="trigger" class="btn2 btn-ghost btn-sm" type="button">
        <i :class="currentIcon" aria-hidden="true"></i>
        <span class="sr-only">{{ __('visibilities.title') }}</span>
    </button>

    <div x-ref="dropdown" class="hidden" role="radiogroup" aria-label="{{ __('visibilities.title') }}">
        <div class="flex flex-col gap-0.5 p-1 min-w-72">
            @foreach ($options as $value => $name)
                <button
                    type="button"
                    role="radio"
                    :aria-checked="selected === {{ $value }}"
                    class="flex items-start gap-2.5 p-2 px-3 rounded-lg cursor-pointer text-left transition-colors hover:bg-base-200/50"
                    :class="selected === {{ $value }} ? 'bg-primary/5 ring-1 ring-primary/30' : ''"
                    x-on:click="update({{ $value }})"
                    @if(count($options) === 1) disabled @endif
                >
                    <x-icon class="{{ $iconMap[$value] }} text-base mt-0.5 w-5 text-center shrink-0" />
                    <div class="flex flex-col gap-0 flex-1 min-w-0">
                        <span class="text-sm font-semibold">{{ $name }}</span>
                        <span class="text-xs text-neutral-content leading-relaxed">
                            {!! __('visibilities.picker.' . $visibilityKeys[$value], [
                                'entity' => e($entityName),
                                'admin' => $adminLink,
                            ]) !!}
                        </span>
                    </div>
                    <div class="w-5 shrink-0 mt-0.5 text-center">
                        <template x-if="loading === {{ $value }}">
                            <i class="fa-solid fa-spinner fa-spin text-primary" aria-hidden="true"></i>
                        </template>
                        <template x-if="loading !== {{ $value }} && selected === {{ $value }}">
                            <i class="fa-solid fa-check text-primary" aria-hidden="true"></i>
                        </template>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</span>
```

Note: The `failed` translation key was already added in Task 1.

- [ ] **Step 2: Commit**

```bash
git add resources/views/components/forms/visibility-picker.blade.php lang/en/visibilities.php
git commit -m "Add visibility picker Blade template with Alpine + Tippy"
```

---

### Task 5: Integrate into post templates

**Files:**
- Modify: `resources/views/entities/components/posts/standard.blade.php:23-30`
- Modify: `resources/views/entities/components/posts/custom.blade.php:19-26`

- [ ] **Step 1: Build the options array and replace dialog trigger in `standard.blade.php`**

In `standard.blade.php`, replace lines 23-30 (the `@can('post', ...)` block containing the visibility button):

**Before (lines 23-30):**
```blade
@can('post', [$entity, 'edit', $post])
    @can('visibility', $post)
        <span id="visibility-icon-{{ $post->id }}" class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-url="{{ route('posts.edit.visibility', [$campaign, $entity->id, $post->id]) }}">
            @include('icons.visibility', ['icon' => $post->visibilityIcon()])
        </span>
    @else
        @include('icons.visibility', ['icon' => $post->visibilityIcon()])
    @endif
```

**After:**
```blade
@can('post', [$entity, 'edit', $post])
    @can('visibility', $post)
        <x-forms.visibility-picker
            :entity="$entity"
            :campaign="$campaign"
            :selected="$post->visibility_id instanceof \App\Enums\Visibility ? $post->visibility_id->value : (int) $post->visibility_id"
            :url="route('posts.update.visibility', [$campaign, $entity->id, $post->id])"
            :options="$post->visibilityOptions()"
        />
    @else
        @include('icons.visibility', ['icon' => $post->visibilityIcon()])
    @endif
```

Note: The `:selected` prop handles the case where `visibility_id` might be a `Visibility` enum (the model casts it) by extracting the integer value. The `:url` points to the POST update route (not the GET dialog route). The `:options` array comes from the existing `visibilityOptions()` method which returns `[visibility_id => translated_name]` and already handles permission filtering.

- [ ] **Step 2: Replace dialog trigger in `custom.blade.php`**

In `custom.blade.php`, replace lines 19-26 (the `@auth` block containing the visibility button):

**Before (lines 19-26):**
```blade
@auth
    @can('visibility', $post)
        <span id="visibility-icon-{{ $post->id }}" class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-url="{{ route('posts.edit.visibility', [$campaign, $entity->id, $post->id]) }}">
        @include('icons.visibility', ['icon' => $post->visibilityIcon()])
    </span>
    @else
        @include('icons.visibility', ['icon' => $post->visibilityIcon()])
    @endif
```

**After:**
```blade
@auth
    @can('visibility', $post)
        <x-forms.visibility-picker
            :entity="$entity"
            :campaign="$campaign"
            :selected="$post->visibility_id instanceof \App\Enums\Visibility ? $post->visibility_id->value : (int) $post->visibility_id"
            :url="route('posts.update.visibility', [$campaign, $entity->id, $post->id])"
            :options="$post->visibilityOptions()"
        />
    @else
        @include('icons.visibility', ['icon' => $post->visibilityIcon()])
    @endif
```

- [ ] **Step 3: Verify the app compiles**

Run: `vendor/bin/sail yarn run build`

This ensures no Blade syntax errors or missing imports break the build.

- [ ] **Step 4: Commit**

```bash
git add resources/views/entities/components/posts/standard.blade.php resources/views/entities/components/posts/custom.blade.php
git commit -m "Replace post visibility dialog with inline picker component"
```

---

### Task 6: Run Pint and final cleanup

- [ ] **Step 1: Run Pint on changed PHP files**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Fix any formatting issues it reports.

- [ ] **Step 2: Commit formatting fixes (if any)**

```bash
git add -A
git commit -m "Apply Pint formatting"
```

---

## Chunk 2: Manual Testing Checklist

Since this is a UI component with Tippy.js integration, manual browser testing is essential. The implementer should verify:

- [ ] **Test 1:** Navigate to an entity with posts. Click the visibility icon on a post. Verify the Tippy dropdown appears below with all available options.
- [ ] **Test 2:** Verify the currently selected visibility has a checkmark on the right and highlighted background.
- [ ] **Test 3:** Click a different visibility option. Verify the spinner appears on the right, then becomes a checkmark on success.
- [ ] **Test 4:** Verify the trigger icon updates to match the new visibility.
- [ ] **Test 5:** Verify the toast appears with success message.
- [ ] **Test 6:** Click outside the dropdown. Verify it closes.
- [ ] **Test 7:** As a non-admin user, verify only "All" (and "Only me" / "Only me & Admins" if creator) appear.
- [ ] **Test 8:** Verify the admin role name in helper text is a clickable link with `text-link` class.
- [ ] **Test 9:** Verify the entity name appears correctly in the "All" helper text.
- [ ] **Test 10:** Test on a custom-layout post to verify it works in `custom.blade.php` too.

**Reminder:** If frontend changes don't appear, run `vendor/bin/sail yarn run build` or `vendor/bin/sail yarn run dev`.
