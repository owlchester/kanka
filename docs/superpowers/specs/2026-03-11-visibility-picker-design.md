# Visibility Picker Component

**Date:** 2026-03-11
**Status:** Approved

## Summary

Replace the current dialog-based visibility selector for entity posts with an inline Tippy.js dropdown. Clicking the visibility icon opens a dropdown with all available visibility options rendered as radio-style cards. Selecting an option sends a background request and updates the icon — no dialog, no form submit, no page reload.

The component is built as a reusable Blade + Alpine component (`x-forms.visibility-picker`) designed for future use in inventory, entity abilities, and other entity-scoped contexts.

## Interaction Flow

1. User clicks visibility icon → Tippy dropdown appears below
2. Dropdown shows all available options: FA icon (left) + name + helper text (center) + checkmark on right for current selection
3. User clicks an option →
   - Spinner (`fa-spinner fa-spin`) replaces the checkmark area on that option
   - Previous checkmark removed
   - POST request sent to update endpoint with `visibility_id`
4. On success → spinner becomes checkmark, trigger icon updates to match new visibility
5. On failure → spinner removed, checkmark restored on previous selection, `window.showToast(message, 'error')`
6. Tippy closes on click-outside only (not auto-close on success)

## Component: `x-forms.visibility-picker`

### Props

| Prop | Type | Description |
|------|------|-------------|
| `$entity` | `Entity` | The entity model (for `:entity` placeholder in helper text) |
| `$campaign` | `Campaign` | The campaign model (for admin role link) |
| `$selected` | `int` | Current visibility_id value |
| `$url` | `string` | POST endpoint to update visibility |
| `$options` | `array` | Available visibility options (pre-filtered by user permissions) |
| `$postId` | `int` | The post ID (for updating the trigger icon element ID) |

### Options Array Shape

The `$options` array is keyed by visibility enum value. Each entry contains the data needed to render one row:

```php
[
    1 => [
        'name' => 'All',           // translated visibility name
        'icon' => 'fa-regular fa-eye',  // FA icon class
    ],
    2 => [
        'name' => 'Admins',
        'icon' => 'fa-regular fa-lock',
    ],
    // ... etc
]
```

Helper text comes from translation keys `visibilities.picker.*` (see Translation Keys section). The component builds the key from the visibility enum case name, not from the options array.

### Rendering

The component renders both the trigger button and the dropdown content within a single Alpine scope:

```html
<span id="visibility-icon-{postId}" x-data="visibilityPicker({...})" x-init="initTippy()">
    <!-- Trigger: the visibility icon button -->
    <button x-ref="trigger">
        <i :class="currentIcon"></i>
    </button>
    <!-- Dropdown content (hidden, mounted into Tippy as a DOM node) -->
    <div x-ref="dropdown" class="hidden">
        <!-- option rows with Alpine bindings -->
    </div>
</span>
```

Each option row:
```
[FA icon] [Name]                    [✓ or spinner or empty]
          [Helper text with links]
```

- Selected option: highlighted background + border (primary color), checkmark on right
- Hover: subtle background highlight
- Loading: `fa-spinner fa-spin` on the right
- Admin role name rendered as `<a class="text-link">` linking to `route('campaigns.campaign_roles.admin', $campaign)`
- Screen-reader friendly: visually hidden radio inputs with proper labels, `aria-checked` states

### Tippy Integration

**Does NOT use the existing `data-dropdown` / `initDropdowns()` pattern.** The `initDropdowns()` function copies `.dropdown-menu` innerHTML as a raw string into Tippy's content, which strips Alpine directives and breaks reactivity. Instead, the component initializes Tippy manually in Alpine's `init()`, passing the actual DOM node (`$refs.dropdown`) as content. This preserves all Alpine bindings.

```js
initTippy() {
    tippy(this.$refs.trigger, {
        content: this.$refs.dropdown,
        theme: 'kanka-dropdown',
        placement: 'bottom',
        allowHTML: true,
        interactive: true,
        trigger: 'click',
        zIndex: 890,
        appendTo: document.body,
        onShow: () => this.$refs.dropdown.classList.remove('hidden'),
        onHide: () => this.$refs.dropdown.classList.add('hidden'),
    });
}
```

Uses the same `kanka-dropdown` theme and `zIndex` as `initDropdowns()` for visual consistency.

### Alpine.js State

```js
Alpine.data('visibilityPicker', ({ selected, url, icons }) => ({
    selected: selected,
    loading: null,
    icons: icons,          // map of visibility_id => icon class
    currentIcon: icons[selected],
    initTippy() { /* see above */ },
    update(visibilityId) {
        if (this.loading || visibilityId === this.selected) return;
        const previous = this.selected;
        this.loading = visibilityId;
        axios.post(url, { visibility_id: visibilityId })
            .then((res) => {
                this.selected = visibilityId;
                this.currentIcon = this.icons[visibilityId];
                this.loading = null;
                window.showToast(res.data.toast);
            })
            .catch(() => {
                this.loading = null;
                window.showToast('Failed to update visibility.', 'error');
            });
    }
}));
```

Uses `axios` (already globally available) which auto-includes the CSRF token from the meta tag.

### Options Array Construction

The parent template builds the `$options` array from the existing `visibilityOptions()` method (which returns `[visibility_id => translated_name]`) enriched with icon classes from the `Visibility` enum. A helper method or inline Blade logic maps each visibility to its icon class. The component receives the fully constructed array — it does not call `visibilityOptions()` itself.

### Authorization Context

The component is placed inside existing authorization blocks in both templates:
- `standard.blade.php`: inside `@can('post', [$entity, 'edit', $post])` + `@can('visibility', $post)`
- `custom.blade.php`: inside `@auth` + `@can('visibility', $post)`

The component itself has no authorization logic — it relies on the parent template's guards.

## Translation Keys

Added to `lang/en/visibilities.php` under a **new `picker` key** (separate from existing `helpers` to avoid breaking current tooltip consumers):

```php
'picker' => [
    'all' => 'Anyone who can see :entity can see this.',
    'admin' => 'Only visible to members of the :admin role.',
    'member' => 'Only visible to campaign members. Useful for public campaigns.',
    'self' => 'Only you can see this.',
    'admin-self' => 'Only you and members of the :admin role can see this.',
],
```

`:entity` — replaced with the entity name at render time.
`:admin` — replaced with an `<a class="text-link">` linking to the admin role page via `route('campaigns.campaign_roles.admin', $campaign)`.

The existing `visibilities.helpers.*` keys remain untouched — they are used by `HasVisibility::visibilityIcon()` for tooltips throughout the app.

## File Changes

### New Files

- `resources/views/components/forms/visibility-picker.blade.php` — Blade + Alpine component

### Modified Files

- `resources/views/entities/components/posts/standard.blade.php` — replace `data-toggle="dialog"` visibility button with `<x-forms.visibility-picker>`
- `resources/views/entities/components/posts/custom.blade.php` — same replacement
- `lang/en/visibilities.php` — add `picker` key group

### Dead Code (cleanup later, not in this PR)

- `resources/js/post.js` — `initPostVisibility()` (lines 85-101) becomes unused for posts once the dialog is removed. Left in place since other consumers may exist; can be cleaned up in a follow-up.
- `resources/views/entities/pages/posts/dialogs/visibility.blade.php` — dialog view no longer triggered from posts
- `resources/views/entities/pages/posts/dialogs/_visibility.blade.php` — dialog partial

### Unchanged Files

- `VisibilityController.php` — `update` endpoint reused as-is (returns JSON with toast, icon, post_id, visibility_id). `index` method becomes unused for posts but kept for potential other consumers.
- `routes/campaigns/entities.php` — routes unchanged
- `EditPostVisibility` form request — unchanged
- `HasVisibility` trait — `visibilityOptions()` and `visibilityIcon()` reused as-is
- `Visibility` enum — unchanged

## Accessibility

- Visually hidden `<input type="radio">` elements for screen reader semantics
- Proper `<label>` associations
- `aria-checked` states on the visual cards
- Keyboard navigation within the Tippy dropdown (interactive: true)

## Future Reuse

The component accepts `$entity`, `$url`, and `$options` — making it generic enough for:
- Inventory item visibility
- Entity ability visibility
- Any entity-scoped visibility picker

No post-specific logic lives in the component.
