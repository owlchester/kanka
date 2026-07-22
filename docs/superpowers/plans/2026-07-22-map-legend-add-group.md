# Map Legend "Add Group" Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let map editors create a new map group from the legend panel via a dialog (Name, Colour, Parent group, Placement, "show group marker" toggle, Visibility), backed by a new JSON API endpoint.

**Architecture:** A new `entities.map-groups.store` route/controller/request creates a `MapGroup`, computing its `position` by reindexing its sibling list (root-level or under a chosen parent) so the new group lands exactly where "First" / "After X" placement says. The Vue explorer gets a `GroupModal.vue` (structural clone of the existing `PresetModal.vue` dialog pattern) opened from a new "Add group" button in `LegendPanel.vue`, owned by `MapExplorer.vue`.

**Tech Stack:** Laravel 11 (PHP 8.4), Pest, Vue 3 `<script setup>`, axios, native `<dialog>`, `node:test` for dependency-free JS modules.

## Global Constraints

- PHP: explicit return types and parameter type hints on every method touched; curly braces always.
- Laravel 10 file structure is in use (no `bootstrap/app.php`); don't migrate structure.
- Never hardcode UI copy — backend strings go through `__()`, Vue strings come from the `i18n` prop.
- Reuse existing components verbatim where they fit: `ColourPicker.vue` (emits `change` with a hex string), no `VisibilitySelect.vue` needed here (this dialog builds its own visibility `<select>` the same low-level way `GroupPicker.vue`/`VisibilitySelect.vue` do — see Task 6 for why).
- No shared modal wrapper exists in this codebase — every dialog is its own `<dialog class="dialog rounded-2xl bg-base-100 text-base-content ...">` element; match that.
- No database migration needed — `name`, `colour`, `parent_id`, `position`, `visibility_id`, `is_shown` all already exist on `map_groups`.
- Don't touch the legacy Blade group form/controller (`app/Http/Controllers/Maps/GroupController.php`) or its reorder endpoint.
- After any PHP change: `vendor/bin/sail bin pint --dirty --format agent`.
- Run tests via `vendor/bin/sail artisan test --compact --filter=<Name>`; run frontend pure-JS tests via `node --test <file>` from the repo root (this project has no `npm test` script — `node --test` is the established way, see `resources/js/maps/groupTree.test.js`).

---

### Task 1: Order groups by position in the explore API

**Files:**
- Modify: `app/Services/Maps/ExploreApiService.php` (the `load()` method, `'groups' => ...` line)
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: nothing new.
- Produces: the `groups` array in the `entities.map-api` JSON response is now ordered ascending by `position`, then `name` — every later task (frontend placement, Task 7's ordering test) relies on this.

- [ ] **Step 1: Write the failing test**

Add to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php` (it already imports `MapGroup` at the top):

```php
it('returns groups ordered by position ascending, then name', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Zebra', 'position' => 1]);
    MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Beta', 'position' => 0]);
    MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Alpha', 'position' => 0]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect(collect($response->json('groups'))->pluck('name')->all())->toBe(['Alpha', 'Beta', 'Zebra']);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL on the new test — the three groups come back in DB insertion order (Zebra, Beta, Alpha), not `[Alpha, Beta, Zebra]`.

- [ ] **Step 3: Fix the ordering**

In `app/Services/Maps/ExploreApiService.php`, in `load()`:

```php
'groups' => GroupResource::collection($this->map->groups),
```

becomes:

```php
'groups' => GroupResource::collection(
    $this->map->groups()->orderBy('position')->orderBy('name')->get()
),
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (all tests in the file, including the new one).

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "fix: order map groups by position in the explore API"
```

---

### Task 2: i18n strings for the group modal

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php` (the `translations()` method)
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: nothing new.
- Produces: flat `i18n.*` keys the Vue `GroupModal`/`LegendPanel` will read in later tasks: `new_group`, `untitled_group`, `group_name_placeholder`, `parent_group`, `top_level`, `placement`, `placement_first`, `placement_after`, `show_group_marker`, `show_group_marker_help`, `create_group`, `add_group`, `error_save_group`, `error_group_name_required`. (`i18n.name`, `i18n.colour`, `i18n.cancel`, `i18n.visibility` already exist and will be reused as-is.)

- [ ] **Step 1: Write the failing test**

Add to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`:

```php
it('exposes group modal translations', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('i18n.new_group'))->toBe('New group');
    expect($response->json('i18n.untitled_group'))->toBe('Untitled group');
    expect($response->json('i18n.add_group'))->toBe('Add group');
    expect($response->json('i18n.create_group'))->toBe('Create group');
    expect($response->json('i18n.placement_after'))->toBe('After :name');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL — these `i18n` keys don't exist yet (all assertions return `null`).

- [ ] **Step 3: Add the lang strings**

In `lang/en/maps/explorer.php`, add a new top-level `'group'` array (sibling to the existing `'marker'` array). Insert it right after the closing `],` of the `'marker'` array (before `'markers_count'`):

```php
    'group'     => [
        'new_group'                 => 'New group',
        'untitled_group'            => 'Untitled group',
        'name_placeholder'          => 'Name this group...',
        'parent_group'              => 'Parent group',
        'top_level'                 => '— Top level —',
        'placement'                 => 'Placement',
        'first'                     => 'First',
        'after'                     => 'After :name',
        'show_group_marker'         => 'Show group markers',
        'show_group_marker_help'    => 'Show markers in this group by default on the map.',
        'create_group'              => 'Create group',
        'add_group'                 => 'Add group',
        'error_save_group'          => 'Unable to save this group.',
        'error_group_name_required' => 'Enter a name for this group.',
    ],
```

- [ ] **Step 4: Wire the strings into `translations()`**

In `app/Services/Maps/ExploreApiService.php`, in `translations()`, insert the following flat entries right after the `'css_class_help' => __('maps/explorer.marker.css_class_help'),` line and before `'toolbar' => [`:

```php
            'new_group' => __('maps/explorer.group.new_group'),
            'untitled_group' => __('maps/explorer.group.untitled_group'),
            'group_name_placeholder' => __('maps/explorer.group.name_placeholder'),
            'parent_group' => __('maps/explorer.group.parent_group'),
            'top_level' => __('maps/explorer.group.top_level'),
            'placement' => __('maps/explorer.group.placement'),
            'placement_first' => __('maps/explorer.group.first'),
            'placement_after' => __('maps/explorer.group.after'),
            'show_group_marker' => __('maps/explorer.group.show_group_marker'),
            'show_group_marker_help' => __('maps/explorer.group.show_group_marker_help'),
            'create_group' => __('maps/explorer.group.create_group'),
            'add_group' => __('maps/explorer.group.add_group'),
            'error_save_group' => __('maps/explorer.group.error_save_group'),
            'error_group_name_required' => __('maps/explorer.group.error_group_name_required'),
```

- [ ] **Step 5: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS.

- [ ] **Step 6: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add i18n strings for the map group modal"
```

---

### Task 3: Group creation API (route, request, controller, `group_store_url`)

**Files:**
- Create: `app/Http/Requests/StoreExploreMapGroup.php`
- Create: `app/Http/Controllers/Entity/Maps/GroupController.php`
- Modify: `routes/campaigns/entities.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Modify: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`
- Test: `tests/Feature/Entities/Maps/GroupControllerTest.php` (new)

**Interfaces:**
- Consumes: `MapPolicy::addGroup(User $user, Map $map, Campaign $campaign): bool` (`app/Policies/MapPolicy.php:14-20`, already exists, count-limit only); `MapGroup` fillable fields (`app/Models/MapGroup.php`); `GroupResource` (`app/Http/Resources/Maps/Explore/GroupResource.php`, returns `id, name, parent_id, position, colour` — unchanged).
- Produces: route `entities.map-groups.store` (POST `/w/{campaign}/entities/{entity}/map/groups`); `data.map.group_store_url` in the explore payload — consumed by `MapExplorer.vue` in Task 7.

**Newly-discovered constraint — read before writing the controller:** `MapGroup` already has an observer, `app/Observers/MapGroupObserver.php` (registered in `app/Providers/AppServiceProvider.php:219`), which manages `position` on every save:
- `saving()`: if `position` is falsy (`null`, `0`, or unset — note `empty(0) === true` in PHP), it silently overrides whatever was set with an auto-append value (`map->groups()->max('position') + 1`, or `1` if none exist). **Never pass `position: 0`** — it will be discarded, not honored as "first". A non-zero value you set explicitly is kept as-is.
- `created()` / `updated()` (via `App\Observers\ReorderTrait::reorder()`): after every write, walks `$model->map->groups()->orderBy('position')->get()` — **every group on the map, regardless of `parent_id`** — and resequences them to a clean `1..N`.
- This means `position` is a single flat, **map-global** sequence (not scoped per parent), 1-indexed (`1` = first), matching the legacy `App\Http\Controllers\Maps\GroupController::store()`'s own convention (`$map->groups()->where('position', '>', $data['position'] - 1)->increment('position')` before create).
- This does not break per-parent placement: a uniform shift-then-insert over the whole map preserves relative order within any parent-filtered subset (the only thing the frontend's `sortGroups`/legend tree ever compares). The controller below matches this existing convention instead of introducing a second, incompatible one.

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/GroupControllerTest.php`:

```php
<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;

it('creates a top-level group and returns it in GroupResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
        'colour' => '#93c5fd',
        'visibility_id' => Visibility::All->value,
        'is_shown' => true,
    ])->assertStatus(201);

    $group = MapGroup::where('name', 'Continent')->firstOrFail();

    expect($response->json())->toBe([
        'id' => $group->id,
        'name' => 'Continent',
        'parent_id' => null,
        'position' => 1,
        'colour' => '#93c5fd',
    ]);
    expect($group->map_id)->toBe($map->id);
    expect($group->visibility_id)->toBe(Visibility::All);
    expect($group->is_shown)->toBeTrue();
});

it('creates a nested group under an existing parent', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $parent = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Continent']);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Region',
        'parent_id' => $parent->id,
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('parent_id'))->toBe($parent->id);
});

it('inserts a new group first and shifts the existing group back', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $existing = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);
    // Sanity check on the pre-existing MapGroupObserver's own auto-append behavior: the
    // first group ever created on a map gets position 1 with no explicit value needed.
    expect($existing->fresh()->position)->toBe(1);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Regions',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('position'))->toBe(1);
    expect($existing->fresh()->position)->toBe(2);
});

it('inserts a new group after a chosen sibling and shifts the following one back', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $first = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'A']);
    $second = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'B']);
    expect($first->fresh()->position)->toBe(1);
    expect($second->fresh()->position)->toBe(2);

    $response = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'A.5',
        'after_id' => $first->id,
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    expect($response->json('position'))->toBe(2);
    expect($first->fresh()->position)->toBe(1);
    expect($second->fresh()->position)->toBe(3);
});

it('shifts every later group on the map, including nested ones, when inserting first', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $parent = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Continent']);
    $child = MapGroup::factory()->create(['map_id' => $map->id, 'parent_id' => $parent->id, 'name' => 'Region']);
    expect($parent->fresh()->position)->toBe(1);
    expect($child->fresh()->position)->toBe(2);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'New root',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    // position is a single flat sequence across the whole map (matching the pre-existing
    // MapGroupObserver/ReorderTrait convention) — inserting "first" shifts every later
    // group regardless of nesting depth. This doesn't affect the legend's rendered order:
    // the frontend only ever compares position within one parent's children, and a
    // uniform shift preserves relative order within any such subset.
    expect($parent->fresh()->position)->toBe(2);
    expect($child->fresh()->position)->toBe(3);
});

it('makes newly created groups immediately available, in position order, from the map explore API', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $first = $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'First',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201)->json();

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Second',
        'after_id' => $first['id'],
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(201);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect(collect($response->json('groups'))->pluck('name')->all())->toBe(['First', 'Second']);
});

it('403s group creation for a player without edit permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(403);

    expect(MapGroup::where('name', 'Continent')->exists())->toBeFalse();
});

it('403s group creation past the standard plan group limit', function () {
    config(['limits.campaigns.maps.groups.standard' => 1]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Existing']);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'One too many',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(403);

    expect(MapGroup::where('name', 'One too many')->exists())->toBeFalse();
});

it('404s group creation for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->postJson(route('entities.map-groups.store', [1, $entity]), [
        'name' => 'Continent',
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(404);
});

it('422s group creation when name is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'visibility_id' => Visibility::All->value,
    ])->assertStatus(422);
});

it('422s group creation when visibility_id is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-groups.store', [1, $map->entity]), [
        'name' => 'Continent',
    ])->assertStatus(422);
});
```

Also add to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`:

```php
it('exposes the group_store_url for creating new groups', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.group_store_url'))->toBe(route('entities.map-groups.store', [1, $map->entity->id]));
});
```

And add `'group_store_url'` to the existing `'map' => [...]` key list inside the `assertJsonStructure` call in `it('returns the full explore payload for a simple map', ...)` (insert it right after `'create_url',`).

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=GroupControllerTest`
Expected: FAIL — route `entities.map-groups.store` doesn't exist (`RouteNotFoundException`).

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL on the two new/modified assertions — `group_store_url` doesn't exist yet, so calling `route('entities.map-groups.store', ...)` inside the test itself will also throw. This is expected; it clears once Step 3 lands.

- [ ] **Step 3: Add the route**

In `routes/campaigns/entities.php`, add the import after the existing `EntityMapApiController` import (alphabetically before `EntityMapMarkerController`):

```php
use App\Http\Controllers\Entity\Maps\GroupController as EntityMapGroupController;
```

Add the route right after the existing preset destroy route (`entities.map-presets.destroy`), before the tiling-prompt route:

```php
Route::post('/w/{campaign}/entities/{entity}/map/groups', [EntityMapGroupController::class, 'store'])->name('entities.map-groups.store');
```

- [ ] **Step 4: Add the form request**

Create `app/Http/Requests/StoreExploreMapGroup.php`:

```php
<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreExploreMapGroup extends FormRequest
{
    use ApiRequest;

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:191',
            'colour' => 'nullable|string|max:7',
            'parent_id' => 'nullable|integer|exists:map_groups,id',
            'visibility_id' => 'required|integer|exists:visibilities,id',
            'is_shown' => 'boolean',
            'after_id' => 'nullable|integer|exists:map_groups,id',
        ];

        return $this->clean($rules);
    }
}
```

(`parent_id`/`after_id` use a plain, unscoped `exists:map_groups,id` check — the same convention `StoreMapMarker::group_id` already uses, see `app/Http/Requests/StoreMapMarker.php:32`. No migration needed.)

- [ ] **Step 5: Add the controller**

Create `app/Http/Controllers/Entity/Maps/GroupController.php`:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExploreMapGroup;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function store(StoreExploreMapGroup $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        // Mirrors Entity/Maps/MarkerController::store() — scope EntityPermission to this
        // campaign so the update check below evaluates the user's actual role.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $map = $entity->child;
        $this->authorize('addGroup', [$map, $campaign]);

        $group = $this->createAtPosition($map, $request->validated());

        return response()->json(new GroupResource($group), 201);
    }

    /**
     * Insert the new group at the requested slot in the map's single, flat, 1-indexed
     * position sequence (matching the pre-existing MapGroupObserver/ReorderTrait
     * convention — see the note at the top of this task). Mirrors the legacy
     * Maps\GroupController::store()'s insert-and-shift pattern: bump every group at or
     * after the target position back by one via a query-builder mass update (this
     * bypasses MapGroupObserver, so it doesn't cascade into a reorder() per shifted row),
     * then create the new group at that now-vacated slot. MapGroupObserver::created()
     * fires once for that final create and renormalizes the whole map to a clean 1..N
     * sequence, confirming the order this method just produced.
     *
     * @param  array<string, mixed>  $data
     */
    protected function createAtPosition(Map $map, array $data): MapGroup
    {
        $afterId = $data['after_id'] ?? null;
        unset($data['after_id']);

        return DB::transaction(function () use ($map, $data, $afterId) {
            $position = 1;
            if ($afterId !== null) {
                $after = MapGroup::findOrFail($afterId);
                $position = $after->position + 1;
            }

            $map->groups()->where('position', '>=', $position)->increment('position');

            return MapGroup::create($data + [
                'map_id' => $map->id,
                'position' => $position,
            ]);
        });
    }
}
```

- [ ] **Step 6: Add `group_store_url` to `MapResource`**

In `app/Http/Resources/Maps/Explore/MapResource.php`, add a line right after `'preset_store_url' => route('entities.map-presets.store', [$this->campaign->id, $map->entity->id]),`:

```php
            'group_store_url' => route('entities.map-groups.store', [$this->campaign->id, $map->entity->id]),
```

- [ ] **Step 7: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=GroupControllerTest`
Expected: PASS (all 11 tests).

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (all tests, including the modified structure assertion and the two new tests from Tasks 1–3).

- [ ] **Step 8: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Requests/StoreExploreMapGroup.php app/Http/Controllers/Entity/Maps/GroupController.php routes/campaigns/entities.php app/Http/Resources/Maps/Explore/MapResource.php tests/Feature/Entities/Maps/GroupControllerTest.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add map group creation API"
```

---

### Task 4: `sortGroups` helper in `groupTree.js`

**Files:**
- Modify: `resources/js/maps/groupTree.js`
- Test: `resources/js/maps/groupTree.test.js`

**Interfaces:**
- Consumes: nothing new.
- Produces: `sortGroups(groups: Array): Array` — a pure function, exported alongside `buildGroupTree`/`filterGroupTree`. Sorts ascending by `position` (`null` treated as `0`), ties broken by `name` (locale-aware). Consumed by `LegendPanel.vue` (Task 6) and `GroupPicker.vue` (Task 8).

- [ ] **Step 1: Write the failing tests**

Add to `resources/js/maps/groupTree.test.js`:

```js
test('sortGroups orders by position ascending, ties broken by name', () => {
    const groups = [
        { id: 1, name: 'Zebra', position: 1 },
        { id: 2, name: 'Beta', position: 0 },
        { id: 3, name: 'Alpha', position: 0 },
    ]

    const sorted = sortGroups(groups)

    assert.deepEqual(sorted.map((g) => g.id), [3, 2, 1])
})

test('sortGroups treats a null position as 0', () => {
    const groups = [
        { id: 1, name: 'B', position: null },
        { id: 2, name: 'A', position: null },
    ]

    const sorted = sortGroups(groups)

    assert.deepEqual(sorted.map((g) => g.id), [2, 1])
})

test('sortGroups does not mutate the input array', () => {
    const groups = [{ id: 1, name: 'B', position: 1 }, { id: 2, name: 'A', position: 0 }]

    sortGroups(groups)

    assert.deepEqual(groups.map((g) => g.id), [1, 2])
})
```

And update the import line at the top of the file:

```js
import { buildGroupTree, filterGroupTree, sortGroups } from './groupTree.js'
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `node --test resources/js/maps/groupTree.test.js`
Expected: FAIL — `sortGroups` is not exported yet (`TypeError: sortGroups is not a function`).

- [ ] **Step 3: Implement `sortGroups`**

Add to `resources/js/maps/groupTree.js`:

```js
export function sortGroups(groups) {
    return [...groups].sort((a, b) => {
        const positionDiff = (a.position ?? 0) - (b.position ?? 0)
        if (positionDiff !== 0) {
            return positionDiff
        }

        return a.name.localeCompare(b.name)
    })
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `node --test resources/js/maps/groupTree.test.js`
Expected: PASS (all tests in the file, including the 3 new ones).

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/groupTree.js resources/js/maps/groupTree.test.js
git commit -m "feat: add sortGroups helper for group placement ordering"
```

---

### Task 5: `GroupModal.vue` component

**Files:**
- Create: `resources/js/components/maps/GroupModal.vue`

**Interfaces:**
- Consumes: `sortGroups` from `../../maps/groupTree.js` (Task 4); `ColourPicker.vue` (`:colour`, `:label`, `@change`); `POST <groupStoreUrl>` returning a `GroupResource`-shaped object (Task 3).
- Produces: props `i18n` (Object, required), `groups` (Array, default `[]`), `visibilities` (Array, default `[]`), `groupStoreUrl` (String, default `null`); emits `created` with the new group object; exposes `open(defaultVisibilityId)` via `defineExpose`. Consumed by `MapExplorer.vue` in Task 7.

No automated test — this codebase has no Vue component-interaction test coverage anywhere (confirmed pattern across every prior map-explorer feature, e.g. `docs/superpowers/specs/2026-07-13-map-marker-description-field-design.md`'s Testing section). Verified manually as part of Task 7.

- [ ] **Step 1: Create the component**

Create `resources/js/components/maps/GroupModal.vue`:

```vue
<template>
    <dialog
        ref="dialogRef"
        class="dialog rounded-2xl bg-base-100 text-base-content w-full md:w-[32rem]"
        aria-modal="true"
        @close="dialogOpen = false"
        @click.self="closeDialog"
    >
        <header class="flex gap-4 items-center p-4 md:p-6 justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-lg flex-none" :style="{ backgroundColor: colour }" />
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.new_group }}</p>
                    <h2 class="text-lg font-semibold truncate">{{ name || i18n.untitled_group }}</h2>
                </div>
            </div>
            <button type="button" class="btn2 btn-default btn-sm flex-none" @click="closeDialog">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </header>

        <article class="p-4 md:p-6 flex flex-col gap-3 w-full overflow-x-hidden">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.name }}</label>
                <input
                    ref="nameInputRef"
                    v-model="name"
                    type="text"
                    class="input input-bordered w-full"
                    :placeholder="i18n.group_name_placeholder"
                />
            </div>

            <ColourPicker :colour="colour" :label="i18n.colour" @change="colour = $event" />

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.parent_group }}</label>
                <select class="select select-bordered w-full" :value="parentId ?? ''" @change="onParentChange">
                    <option value="">{{ i18n.top_level }}</option>
                    <option v-for="group in groups" :key="group.id" :value="group.id">{{ group.name }}</option>
                </select>
            </div>

            <div v-if="siblings.length" class="flex flex-col gap-1">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.placement }}</label>
                <select class="select select-bordered w-full" :value="afterId ?? ''" @change="onAfterChange">
                    <option value="">{{ i18n.placement_first }}</option>
                    <option v-for="sibling in siblings" :key="sibling.id" :value="sibling.id">
                        {{ i18n.placement_after.replace(':name', sibling.name) }}
                    </option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="isShown" type="checkbox" class="checkbox checkbox-sm mt-0.5" />
                    <span class="text-sm">{{ i18n.show_group_marker }}</span>
                </label>
                <p class="text-xs text-neutral-content">{{ i18n.show_group_marker_help }}</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.visibility }}</label>
                <select class="select select-bordered w-full" :value="visibilityId" @change="onVisibilityChange">
                    <option v-for="option in visibilities" :key="option.id" :value="option.id">{{ option.name }}</option>
                </select>
            </div>

            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </article>

        <footer class="p-4 md:px-6">
            <menu class="flex justify-end gap-3">
                <button type="button" class="btn2 btn-default" :disabled="saving" @click="closeDialog">
                    {{ i18n.cancel }}
                </button>
                <button type="button" class="btn2 btn-primary" :disabled="saving" @click="submit">
                    {{ i18n.create_group }}
                </button>
            </menu>
        </footer>
    </dialog>
</template>

<script setup>
import { computed, nextTick, ref } from "vue";
import { sortGroups } from "../../maps/groupTree.js";
import ColourPicker from "./ColourPicker.vue";

const props = defineProps({
    i18n: { type: Object, required: true },
    groups: { type: Array, default: () => [] },
    visibilities: { type: Array, default: () => [] },
    groupStoreUrl: { type: String, default: null },
});

const emit = defineEmits(["created"]);

const dialogRef = ref(null);
const nameInputRef = ref(null);
const dialogOpen = ref(false);
const saving = ref(false);
const error = ref(null);

const name = ref("");
const colour = ref("#93c5fd");
const parentId = ref(null);
const afterId = ref(null);
const isShown = ref(false);
const visibilityId = ref(null);

const siblings = computed(() =>
    sortGroups(props.groups.filter((group) => (group.parent_id ?? null) === parentId.value)),
);

function resetState(defaultVisibilityId) {
    name.value = "";
    colour.value = "#93c5fd";
    parentId.value = null;
    afterId.value = null;
    isShown.value = false;
    visibilityId.value = defaultVisibilityId ?? props.visibilities[0]?.id ?? null;
    error.value = null;
    saving.value = false;
}

async function open(defaultVisibilityId) {
    resetState(defaultVisibilityId);
    dialogOpen.value = true;
    dialogRef.value?.showModal();

    await nextTick();
    nameInputRef.value?.focus();
}

function closeDialog() {
    dialogRef.value?.close();
}

function onParentChange(event) {
    const value = event.target.value;
    parentId.value = value === "" ? null : Number(value);
    // The sibling list depends on the chosen parent, so any previously chosen "after"
    // placement no longer refers to a sibling in scope.
    afterId.value = null;
}

function onAfterChange(event) {
    const value = event.target.value;
    afterId.value = value === "" ? null : Number(value);
}

function onVisibilityChange(event) {
    visibilityId.value = Number(event.target.value);
}

async function submit() {
    if (!name.value.trim()) {
        error.value = props.i18n.error_group_name_required;

        return;
    }

    saving.value = true;
    error.value = null;

    try {
        const payload = {
            name: name.value.trim(),
            colour: colour.value,
            parent_id: parentId.value,
            after_id: afterId.value,
            is_shown: isShown.value,
            visibility_id: visibilityId.value,
        };
        const res = await axios.post(props.groupStoreUrl, payload);

        emit("created", res.data);
        closeDialog();
    } catch (e) {
        error.value = props.i18n.error_save_group;
    } finally {
        saving.value = false;
    }
}

defineExpose({ open });
</script>
```

- [ ] **Step 2: Commit**

```bash
git add resources/js/components/maps/GroupModal.vue
git commit -m "feat: add GroupModal component for creating map groups"
```

---

### Task 6: "Add group" button in `LegendPanel.vue`

**Files:**
- Modify: `resources/js/components/maps/LegendPanel.vue`

**Interfaces:**
- Consumes: `sortGroups` from `../../maps/groupTree.js` (Task 4).
- Produces: new prop `canEdit` (Boolean, default `false`); new emit `add-group`. Consumed by `MapExplorer.vue` in Task 7.

No automated test (see Task 5's note on this codebase's Vue testing convention) — verified manually in Task 7.

- [ ] **Step 1: Add the `canEdit` prop and `add-group` emit**

In `resources/js/components/maps/LegendPanel.vue`, change:

```js
const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["select", "close"]);
```

to:

```js
const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    canEdit: { type: Boolean, default: false },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["select", "close", "add-group"]);
```

- [ ] **Step 2: Sort groups before building the tree**

Change:

```js
import { computed, onMounted, reactive, ref } from "vue";
import { buildGroupTree, filterGroupTree } from "../../maps/groupTree.js";
import LegendGroupNode from "./LegendGroupNode.vue";
```

```js
const tree = computed(() => buildGroupTree(props.groups, props.pins));
```

to:

```js
import { computed, onMounted, reactive, ref } from "vue";
import { buildGroupTree, filterGroupTree, sortGroups } from "../../maps/groupTree.js";
import LegendGroupNode from "./LegendGroupNode.vue";
```

```js
const tree = computed(() => buildGroupTree(sortGroups(props.groups), props.pins));
```

This ensures a newly created group (Task 7 splices it into `data.groups`) renders in the position its "First"/"After X" placement implies, without needing a full reload.

- [ ] **Step 3: Add the "Add group" button**

In the `<template>`, change the end of the file from:

```html
                </ul>
            </li>
        </ul>
    </aside>
</template>
```

to:

```html
                </ul>
            </li>
        </ul>

        <button
            v-if="canEdit"
            type="button"
            class="btn2 btn-default btn-sm"
            @click="$emit('add-group')"
        >
            <i class="fa-regular fa-plus" aria-hidden="true" />
            <span>{{ i18n.add_group }}</span>
        </button>
    </aside>
</template>
```

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/LegendPanel.vue
git commit -m "feat: add \"Add group\" button to the legend panel"
```

---

### Task 7: Wire `GroupModal` into `MapExplorer.vue`

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `GroupModal` (Task 5, `open(defaultVisibilityId)` exposed method, `created` emit); `LegendPanel`'s `canEdit` prop and `add-group` emit (Task 6); `data.map.group_store_url` (Task 3); `data.default_visibility_id` (already exists in the explore payload).
- Produces: nothing new consumed elsewhere — this is the integration point.

- [ ] **Step 1: Import `GroupModal` and add a ref**

In the `<script setup>` imports, change:

```js
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

to:

```js
import DetailPanel from "./DetailPanel.vue";
import GroupModal from "./GroupModal.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

Add a new ref next to the other template refs:

```js
const leafletCanvasRef = ref(null);
```

becomes:

```js
const leafletCanvasRef = ref(null);
const groupModalRef = ref(null);
```

- [ ] **Step 2: Add `openGroupModal` and `onGroupCreated`**

Add near `onPresetCreated`/`onPresetUpdated`/`onPresetDeleted`:

```js
function openGroupModal() {
    groupModalRef.value?.open(data.value.default_visibility_id);
}

function onGroupCreated(group) {
    data.value.groups = [...data.value.groups, group];
}
```

- [ ] **Step 3: Pass `canEdit` and wire `add-group` on `LegendPanel`**

Change:

```html
        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :i18n="data.i18n"
            @select="selectPin"
            @close="legendOpen = false"
        />
```

to:

```html
        <LegendPanel
            :open="legendOpen"
            :groups="data.groups"
            :pins="data.pins"
            :can-edit="canEdit"
            :i18n="data.i18n"
            @select="selectPin"
            @close="legendOpen = false"
            @add-group="openGroupModal"
        />
```

- [ ] **Step 4: Render `GroupModal`**

Add right after the `<LegendPanel ... />` block:

```html
        <GroupModal
            ref="groupModalRef"
            :i18n="data.i18n"
            :groups="data.groups"
            :visibilities="data.visibilities"
            :group-store-url="data.map.group_store_url"
            @created="onGroupCreated"
        />
```

- [ ] **Step 5: Build the frontend and verify manually**

Run: `vendor/bin/sail yarn run build` (or ask the user to run `vendor/bin/sail yarn run dev`/`vendor/bin/sail composer run dev` if they're already running a dev server).

Then, in the browser, on a map you can edit:
1. Open the legend panel — confirm "Add group" is visible (and hidden if you view as a non-editor).
2. Click "Add group" — confirm the dialog opens titled "New group" / "Untitled group", switching to your typed name as you type.
3. Create a group with no existing groups yet — confirm the Placement field is absent (no siblings), and the group appears in the legend immediately after creating.
4. Create a second top-level group choosing "After {first group}" — confirm it appears after the first in the legend, without a page reload.
5. Create a third group, this time picking the first group as its Parent — confirm it nests under that parent in the legend tree.
6. Toggle "Show group markers" and pick a non-default Visibility — confirm no error and the dialog closes on Create.
7. Trigger the group-limit 403 (e.g. via `config(['limits.campaigns.maps.groups.standard' => 1])` in tinker, or just check the error text renders) — confirm the dialog shows `i18n.error_save_group` and stays open.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: wire up group creation in the map explorer"
```

---

### Task 8: Fix `GroupPicker.vue`'s sort direction

**Files:**
- Modify: `resources/js/components/maps/GroupPicker.vue`

**Interfaces:**
- Consumes: `sortGroups` from `../../maps/groupTree.js` (Task 4).
- Produces: nothing new consumed elsewhere.

**Why this is in scope:** `GroupPicker.vue` (the group-select control in the marker create/edit panel) already sorts its flat group list by `position` descending (`b.position - a.position`), written against the assumption that the explorer used `MapGroup::scopeOrdered()`'s descending convention. Task 1 established the opposite, ascending convention (`0` = first) for the explorer's own `position` semantics, and Task 3's placement logic assigns positions accordingly. Left alone, `GroupPicker`'s dropdown would now list groups in the reverse of the order the legend and the new group dialog show them in — a direct, newly-introduced inconsistency from this same change, not a pre-existing unrelated bug.

- [ ] **Step 1: Update the sort**

In `resources/js/components/maps/GroupPicker.vue`, change:

```js
<script setup>
import { computed } from "vue";

const props = defineProps({
    pin: { type: Object, required: true },
    groups: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const sortedGroups = computed(() =>
    [...props.groups].sort((a, b) => b.position - a.position),
);
```

to:

```js
<script setup>
import { computed } from "vue";
import { sortGroups } from "../../maps/groupTree.js";

const props = defineProps({
    pin: { type: Object, required: true },
    groups: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const sortedGroups = computed(() => sortGroups(props.groups));
```

- [ ] **Step 2: Verify manually**

Run: `vendor/bin/sail yarn run build` (skip if a dev server from Task 7 is still running — Vite hot-reloads).

In the browser: open the marker create/edit panel on a map with several groups at different positions (e.g. the ones created in Task 7's manual test); confirm the group picker's pill list matches the legend's top-to-bottom order.

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/GroupPicker.vue
git commit -m "fix: match GroupPicker's sort direction to the new position convention"
```
