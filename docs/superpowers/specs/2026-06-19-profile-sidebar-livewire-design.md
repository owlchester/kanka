# Profile Sidebar Livewire Refactor

**Date:** 2026-06-19
**Branch:** `refactor/profile-sidebar-livewire`

## Problem

The entity profile sidebar (`pins.blade.php`) fires 6–10 database queries synchronously as part of the main entity page request. For large campaigns with many pinned relations, families, races, and other profile data, this adds meaningful latency to every entity page load. Users have also requested additional sidebar sections (e.g. maps an entity appears on), which would add further queries.

Caching the sidebar is difficult because permission flags (`is_private`) are embedded in the rendered output and vary by user role.

## Goal

Defer the sidebar's data loading to a second HTTP request using Livewire's lazy loading, so the main entity page HTML returns faster. Print mode must be unaffected.

## Architecture

### `pins.blade.php` — thin dispatcher

Becomes a branch:

```blade
<aside class="entity-sidebar ...">
    @if (isset($printing))
        @include('entities.components.pins-content')
    @else
        <livewire:entities.profile-sidebar :entity-id="$entity->id" lazy />
    @endif

    <div class="col-span-2">
        @include('ads.siderail_right')
    </div>
</aside>
```

The ad slot stays outside the Livewire component so the ad-rendering engine continues to work on the initial page response.

### `pins-content.blade.php` — new shared partial

Extracted from the current body of `pins.blade.php`. Contains:
- Pinned section (files, relations, members, starred attributes)
- Entity-type-specific profile partial (dispatched via `$entity->entityType->pluralCode()`)
- Links (boosted campaigns, gated on `!isset($printing)`)
- History

All existing entity-type partials in `entities/components/profile/` are unchanged. The dispatch logic (`@includeIf('entities.components.profile.' . $entity->entityType->pluralCode())`) lives here and works identically.

### `App\Livewire\Entities\ProfileSidebar` — new Livewire component

```
app/Livewire/Entities/ProfileSidebar.php
resources/views/livewire/entities/profile-sidebar.blade.php
```

**Properties:**
- `int $entityId` — passed from the template, `#[Locked]`
- `int $campaignId` — derived from the entity in `mount()`, not passed as a prop

**`mount()`:**
- Loads the entity by ID
- Sets up `UserCache`, `CampaignCache`, `Avatar` facades following the `EntityListing` pattern
- Makes `$entity`, `$campaign`, `$child` available to the view

**`render()`:**
- Also sets up the cache facades (required for Livewire re-renders)
- Returns the `livewire.entities.profile-sidebar` view

**View (`profile-sidebar.blade.php`):**
```blade
@include('entities.components.pins-content')
```

No wire actions. The component is read-only after initial render — no polling, no interactivity.

### Placeholder

The default Livewire lazy placeholder is an empty `<div>`. A minimal skeleton (3–4 grey rounded bars matching typical sidebar content height) should be provided via the component's `#[Lazy]` placeholder slot to reduce the perceived pop-in. The sidebar has a fixed width (`md:w-48`) so no horizontal layout shift occurs.

## Print Mode

Print mode sets `$printing = true` in the view data. The branch in `pins.blade.php` detects this and renders `pins-content.blade.php` directly — synchronous, no Livewire, no second HTTP request. Bulk printing (multiple entities rendered simultaneously in the browser) is fully unaffected.

The `!isset($printing)` check inside the links include in `pins-content.blade.php` continues to work as today since the variable is either in scope (print mode, direct include) or absent (Livewire render, where links are always shown).

## Data Flow

```
Normal mode:
  Page request → pins.blade.php → <aside> with empty placeholder + ad
  Browser → POST /livewire/update → ProfileSidebar::mount() → render pins-content → sidebar fills in

Print mode:
  Page request → pins.blade.php → @include('pins-content') → full sidebar rendered immediately
```

## Entity Type Handling

No changes to any entity-type-specific partials. The `pluralCode()` dispatch and `showProfileInfo()` guards work identically inside `pins-content.blade.php`. Custom entity types (`isCustom()`) also follow the existing path unchanged.

## Testing

- Existing entity show page feature tests must pass without modification.
- New Livewire component test (`ProfileSidebarTest`): assert the component renders for a character entity and includes family/race data; assert it renders for a location entity.
- Assert print mode renders `pins-content` directly and does not include a Livewire component in the output.
