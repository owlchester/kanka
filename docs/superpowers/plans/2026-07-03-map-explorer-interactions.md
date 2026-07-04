# Map Explorer Interactions Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add legend search/filtering, a full pin detail panel (entry text, entity image, group/type, edit/duplicate/delete/center actions with permission gating), and a map header + repositioned zoom control to the map explorer built in `docs/superpowers/plans/2026-07-03-entity-map-vue-explorer.md`.

**Architecture:** Two new backend endpoints (`entities.map-markers.preview` / `entities.map-markers.destroy`) under the existing `App\Http\Controllers\Entity\Maps` namespace, session-authed like everything else in this subsystem. The bulk `entities.map-api` payload gains per-pin `preview_url`/`destroy_url` fields so the frontend never has to construct marker URLs itself. On the frontend: a new pure `filterGroupTree()` helper in `groupTree.js`, a rewritten `LegendPanel.vue` (search box, always-open uncategorised), a rewritten `DetailPanel.vue` (fetches the preview endpoint, renders entry/image/actions), and small additions to `MapExplorer.vue`/`LeafletCanvas.vue` (centering, header, zoom control position).

**Tech Stack:** Laravel 11 / PHP 8.4, Pest 3, Vue 3 (`<script setup>`), Leaflet.

## Global Constraints

- Full design spec: `docs/superpowers/specs/2026-07-03-map-explorer-interactions-design.md` — read it if anything below is ambiguous. It builds on `docs/superpowers/specs/2026-07-03-entity-map-vue-explorer-design.md`.
- New routes are session-authed (cookie + CSRF via the global `axios` instance), **not** the OAuth-gated `api.v1` marker endpoints — do not reuse `App\Http\Controllers\Api\v1\MapMarkerApiController`.
- `MapMarkerPolicy::update()`/`::delete()` both just check `$user->can('update', $mapMarker->map->entity)` — there is one permission, not three. The existing convention (`app/Http/Controllers/Maps/MarkerController.php`) is to authorize directly against `$map->entity` rather than going through `MapMarkerPolicy`; follow that.
- No JS/Vue automated test harness exists in this repo — Vue components are verified manually in-browser. Pure, DOM-free JS logic (`groupTree.js`) is tested with `vendor/bin/sail node --test`.
- All PHP changes: run `vendor/bin/sail bin pint --dirty --format agent` before each task's final commit.
- All Artisan/PHP/Composer/Node/Yarn commands go through `vendor/bin/sail`.

---

### Task 1: Per-pin `preview_url`/`destroy_url` on the bulk map-api payload

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify (extend existing test): `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Produces: each pin in `entities.map-api`'s `pins` array gains `preview_url` (GET) and `destroy_url` (DELETE), both absolute URLs pointing at the routes Task 2 creates (`entities.map-markers.preview` / `entities.map-markers.destroy`). Task 4's `DetailPanel.vue` reads these two fields directly off the `pin` object — no other task computes these URLs client-side.

- [ ] **Step 1: Write the failing assertions**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, update the existing `'returns the full explore payload for a simple map'` test: add `preview_url` and `destroy_url` to the `pins` structure list, and add value assertions. Replace the whole test with:

```php
it('returns the full explore payload for a simple map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'has_clustering' => true]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);

    // image_path isn't mass-assignable (not in MapLayer::$fillable), set it directly like MapTest.php does for entities
    $hiddenLayer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Hidden overlay', 'type_id' => 1]);
    $hiddenLayer->image_path = 'maps/hidden.png';
    $hiddenLayer->saveQuietly();

    $shownLayer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Winter', 'type_id' => 2]);
    $shownLayer->image_path = 'maps/winter.png';
    $shownLayer->saveQuietly();

    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'group_id' => $group->id, 'name' => 'Waterdeep']);
    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Uncategorised pin']);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url']],
        ]);

    $response->assertJsonFragment(['name' => $map->name, 'is_real' => false, 'has_clustering' => true]);
    $response->assertJsonFragment(['name' => 'Waterdeep', 'group_id' => $group->id]);
    // The hidden (type_id=1) overlay layer must not be included, only the shown-by-default one
    expect($response->json('layers'))->toHaveCount(1);
    expect($response->json('layers.0.name'))->toBe('Winter');

    $pins = collect($response->json('pins'));
    $waterdeep = $pins->firstWhere('name', 'Waterdeep');
    expect($waterdeep['preview_url'])->toBe(route('entities.map-markers.preview', [1, $map->entity->id, $marker->id]));
    expect($waterdeep['destroy_url'])->toBe(route('entities.map-markers.destroy', [1, $map->entity->id, $marker->id]));
});
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL — `Route [entities.map-markers.preview] not defined.` (the route doesn't exist yet; Task 2 creates it) and/or missing `preview_url`/`destroy_url` keys.

- [ ] **Step 3: Add `mapEntity()` + the URL fields to `PinResource`**

Replace `app/Http/Resources/Maps/Explore/PinResource.php` in full:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinResource extends JsonResource
{
    use CampaignAware;

    protected Entity $mapEntity;

    public function mapEntity(Entity $mapEntity): self
    {
        $this->mapEntity = $mapEntity;

        return $this;
    }

    public function toArray(Request $request): array
    {
        $marker = $this->resource;

        return [
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'group_id' => $marker->group_id,
            'latitude' => (float) $marker->latitude,
            'longitude' => (float) $marker->longitude,
            'shape' => $marker->shape_id?->name ?? 'marker',
            'colour' => $marker->colour,
            'font_colour' => $marker->font_colour,
            'icon' => $marker->exploreIcon(),
            'size_id' => $marker->size_id,
            'pin_size' => $marker->pin_size,
            'circle_radius' => $marker->circle_radius,
            'opacity' => (float) ($marker->opacity ?: 100),
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
        ];
    }
}
```

- [ ] **Step 4: Wire `campaign()`/`mapEntity()` in `ExploreApiService`**

Replace `app/Services/Maps/ExploreApiService.php` in full:

```php
<?php

namespace App\Services\Maps;

use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;

class ExploreApiService
{
    use CampaignAware;

    protected Map $map;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function load(): array
    {
        $mapEntity = $this->map->entity;

        return [
            'map' => new MapResource($this->map)->campaign($this->campaign),
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->typeName() === 'overlay_shown' && $layer->hasImage())
                    ->values()
            ),
            'groups' => GroupResource::collection($this->map->groups),
            'pins' => $this->map->markers
                ->filter(fn ($marker) => $marker->visible())
                ->values()
                ->map(fn ($marker) => new PinResource($marker)->campaign($this->campaign)->mapEntity($mapEntity))
                ->all(),
        ];
    }
}
```

Note: this test cannot fully pass until Task 2 defines the `entities.map-markers.preview`/`entities.map-markers.destroy` routes (`route()` throws `RouteNotFoundException` otherwise) — that's expected; proceed to Task 2 next, then come back and confirm this test passes as part of Task 2's verification.

- [ ] **Step 5: Commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps/Explore/PinResource.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add per-pin preview/destroy URLs to the map-api payload"
```

---

### Task 2: Marker preview + delete endpoints

**Files:**
- Create: `app/Http/Resources/Maps/Explore/PinPreviewResource.php`
- Create: `app/Http/Controllers/Entity/Maps/MarkerController.php`
- Modify: `routes/campaigns/entities.php`
- Create: `tests/Feature/Entities/Maps/MarkerControllerTest.php`

**Interfaces:**
- Consumes: `entities.map-markers.preview`/`entities.map-markers.destroy` route names (defined in this task, referenced by Task 1's `PinResource`).
- Produces: `GET entities.map-markers.preview` → JSON `{entity_url, entity_image, marker_entry, entity_entry, type, group_name, can_edit, edit_url}`. `DELETE entities.map-markers.destroy` → `204 No Content` on success. Task 4's `DetailPanel.vue` fetches/calls these by URL (from `pin.preview_url`/`pin.destroy_url`), not by route name.

- [ ] **Step 1: Write the failing tests**

`tests/Feature/Entities/Maps/MarkerControllerTest.php`:

```php
<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapMarker;

it('returns a preview for a marker with an entity, group, and entries', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);
    // entry lives on the Entity itself (MapMarker::entity()->hasEntry()/parsedEntry() operate on
    // the Entity model, not the Character), and isn't mass-assignable, so set it directly like
    // MapTest.php does for other Entity fields
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $entity->entry = 'Entity entry text';
    $entity->saveQuietly();

    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'group_id' => $group->id,
        'entity_id' => $entity->id,
        'entry' => 'Marker entry text',
        'shape_id' => 1,
    ]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))
        ->assertStatus(200)
        ->assertJsonStructure(['entity_url', 'entity_image', 'marker_entry', 'entity_entry', 'type', 'group_name', 'can_edit', 'edit_url']);

    expect($response->json('entity_url'))->toBe($entity->url());
    expect($response->json('type'))->toBe('Marker');
    expect($response->json('group_name'))->toBe('Towns');
    expect($response->json('can_edit'))->toBeTrue();
    expect($response->json('edit_url'))->not->toBeNull();
    expect($response->json('marker_entry'))->toContain('Marker entry text');
    expect($response->json('entity_entry'))->toContain('Entity entry text');
});

it('returns nulls for entity-specific fields when the marker has no linked entity', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('entity_url'))->toBeNull();
    expect($response->json('entity_image'))->toBeNull();
    expect($response->json('entity_entry'))->toBeNull();
    expect($response->json('group_name'))->toBeNull();
});

it('denies edit permission and hides the edit url for a player', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->asPlayer();

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('can_edit'))->toBeFalse();
    expect($response->json('edit_url'))->toBeNull();
});

it('404s preview for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->get(route('entities.map-markers.preview', [1, $entity, $marker]))->assertStatus(404);
});

it('404s preview for a marker belonging to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(404);
});

it('deletes a marker and returns 204', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))
        ->assertStatus(204);

    expect(MapMarker::find($marker->id))->toBeNull();
});

it('403s delete for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->asPlayer();

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))
        ->assertStatus(403);

    expect(MapMarker::find($marker->id))->not->toBeNull();
});

it('404s delete for a marker belonging to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))->assertStatus(404);
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: FAIL — route `entities.map-markers.preview`/`entities.map-markers.destroy` not defined.

- [ ] **Step 3: Create `PinPreviewResource`**

`app/Http/Resources/Maps/Explore/PinPreviewResource.php`:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinPreviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $marker = $this->resource;
        $entity = $marker->entity;
        $canEdit = auth()->check() && auth()->user()->can('update', $marker->map->entity);

        return [
            'entity_url' => $entity?->url(),
            'entity_image' => $entity && $entity->hasImage() ? Avatar::entity($entity)->size(400, 200)->thumbnail() : null,
            'marker_entry' => $marker->hasEntry() ? $marker->parsedEntry() : null,
            'entity_entry' => $entity && $entity->hasEntry() ? $entity->parsedEntry() : null,
            'type' => $marker->typeLabel(),
            'group_name' => $marker->group?->name,
            'can_edit' => $canEdit,
            'edit_url' => $canEdit
                ? route('maps.map_markers.edit', [$marker->map->campaign_id, $marker->map, $marker])
                : null,
        ];
    }
}
```

- [ ] **Step 4: Create `MarkerController`**

`app/Http/Controllers/Entity/Maps/MarkerController.php`:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Http\Resources\Maps\Explore\PinPreviewResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class MarkerController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function preview(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);

        return response()->json(new PinPreviewResource($mapMarker));
    }

    public function destroy(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        $this->authorize('update', $entity);

        $mapMarker->delete();

        return response()->json(null, 204);
    }

    protected function guardMarker(Entity $entity, MapMarker $mapMarker): void
    {
        if (! $entity->isMap() || $mapMarker->map_id !== $entity->child->id) {
            abort(404);
        }
    }
}
```

- [ ] **Step 5: Add the routes**

In `routes/campaigns/entities.php`, add to the `use` block alongside the other `Entity\Maps\*` imports:

```php
use App\Http\Controllers\Entity\Maps\MarkerController as EntityMapMarkerController;
```

Add the routes next to the existing `entities.map`/`entities.map-api` routes:

```php
Route::get('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'preview'])->name('entities.map-markers.preview');
Route::delete('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'destroy'])->name('entities.map-markers.destroy');
```

- [ ] **Step 6: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: PASS (8 tests)

Then re-run Task 1's test, which depended on these routes existing:

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (6 tests)

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps/Explore/PinPreviewResource.php app/Http/Controllers/Entity/Maps/MarkerController.php routes/campaigns/entities.php tests/Feature/Entities/Maps/MarkerControllerTest.php
git commit -m "feat: add marker preview and delete endpoints for the map explorer"
```

---

### Task 3: Legend search + always-open uncategorised

**Files:**
- Modify: `resources/js/maps/groupTree.js`
- Modify: `resources/js/maps/groupTree.test.js`
- Modify: `resources/js/components/maps/LegendPanel.vue`

**Interfaces:**
- Produces: `filterGroupTree(tree, query): { groups, uncategorised, matchedGroupIds: Set<number> }`, where `tree` is `buildGroupTree()`'s return value. `matchedGroupIds` contains every group/subgroup id that has a matching pin itself or has a descendant that does — used to force-expand matching branches while a search is active.
- `LegendGroupNode.vue` is unchanged — it already just calls the `isOpen`/`toggle`/`select` functions passed down as props, so `LegendPanel.vue` can change what `isOpen` returns without touching it.

- [ ] **Step 1: Write the failing tests**

Append to `resources/js/maps/groupTree.test.js` (keep the existing two `buildGroupTree` tests, add these):

```js
import { filterGroupTree } from './groupTree.js'

test('filterGroupTree with an empty query returns the tree unchanged', () => {
    const tree = buildGroupTree(
        [{ id: 1, name: 'Towns', parent_id: null }],
        [{ id: 10, name: 'Waterdeep', group_id: 1 }, { id: 11, name: 'Loose pin', group_id: null }]
    )

    const filtered = filterGroupTree(tree, '')

    assert.equal(filtered.groups.length, 1)
    assert.equal(filtered.groups[0].pins.length, 1)
    assert.equal(filtered.uncategorised.length, 1)
})

test('filterGroupTree keeps only matching pins and prunes empty branches', () => {
    const groups = [
        { id: 1, name: 'Continent', parent_id: null },
        { id: 2, name: 'Region', parent_id: 1 },
        { id: 3, name: 'Empty branch', parent_id: null },
    ]
    const pins = [
        { id: 10, name: 'Waterdeep', group_id: 2 },
        { id: 11, name: 'Baldurs Gate', group_id: 2 },
        { id: 12, name: 'Uncategorised match', group_id: null },
        { id: 13, name: 'No match here', group_id: null },
    ]
    const tree = buildGroupTree(groups, pins)

    const filtered = filterGroupTree(tree, 'water')

    assert.equal(filtered.groups.length, 1) // "Empty branch" pruned entirely
    assert.equal(filtered.groups[0].id, 1)
    assert.equal(filtered.groups[0].children.length, 1)
    assert.equal(filtered.groups[0].children[0].pins.length, 1)
    assert.equal(filtered.groups[0].children[0].pins[0].name, 'Waterdeep')
    assert.deepEqual(filtered.uncategorised.map((p) => p.id), [])
    assert.ok(filtered.matchedGroupIds.has(1)) // ancestor of the match
    assert.ok(filtered.matchedGroupIds.has(2)) // the group with the direct match
    assert.ok(! filtered.matchedGroupIds.has(3)) // no match anywhere in this branch
})
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail node --test resources/js/maps/groupTree.test.js`
Expected: FAIL — `filterGroupTree is not a function` (or similar import error)

- [ ] **Step 3: Implement `filterGroupTree`**

Add to `resources/js/maps/groupTree.js` (keep the existing `buildGroupTree` function as-is, add this alongside it):

```js
export function filterGroupTree(tree, query) {
    const matchedGroupIds = new Set()

    if (! query) {
        return { groups: tree.groups, uncategorised: tree.uncategorised, matchedGroupIds }
    }

    const q = query.toLowerCase()
    const matchesPin = (pin) => pin.name.toLowerCase().includes(q)

    function filterGroup(group) {
        const pins = group.pins.filter(matchesPin)
        const children = group.children.map(filterGroup).filter(Boolean)

        if (pins.length === 0 && children.length === 0) {
            return null
        }

        matchedGroupIds.add(group.id)

        return { ...group, pins, children }
    }

    const groups = tree.groups.map(filterGroup).filter(Boolean)
    const uncategorised = tree.uncategorised.filter(matchesPin)

    return { groups, uncategorised, matchedGroupIds }
}
```

- [ ] **Step 4: Run the tests to verify they pass**

Run: `vendor/bin/sail node --test resources/js/maps/groupTree.test.js`
Expected: PASS (4 tests)

- [ ] **Step 5: Rewrite `LegendPanel.vue`**

Replace `resources/js/components/maps/LegendPanel.vue` in full:

```vue
<template>
    <aside v-if="open" class="fixed top-0 left-0 h-screen w-72 bg-base-100 shadow-lg z-[1100] overflow-y-auto p-4 flex flex-col gap-3">
        <input
            v-model="query"
            type="text"
            placeholder="Search markers"
            class="input input-bordered w-full"
        />

        <ul class="flex flex-col gap-1">
            <LegendGroupNode
                v-for="group in filtered.groups"
                :key="group.id"
                :group="group"
                :is-open="isOpen"
                :toggle="toggle"
                :select="selectPin"
            />

            <li v-if="filtered.uncategorised.length">
                <p class="font-semibold">Uncategorised</p>
                <ul class="pl-5 flex flex-col gap-1">
                    <li v-for="pin in filtered.uncategorised" :key="pin.id">
                        <button class="text-left" @click="selectPin(pin)">{{ pin.name }}</button>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { buildGroupTree, filterGroupTree } from '../../maps/groupTree.js'
import LegendGroupNode from './LegendGroupNode.vue'

const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
})

const emit = defineEmits(['select'])

const query = ref('')
const tree = computed(() => buildGroupTree(props.groups, props.pins))
const filtered = computed(() => filterGroupTree(tree.value, query.value))
const openIds = reactive(new Set())

function toggle(id) {
    if (openIds.has(id)) {
        openIds.delete(id)
    } else {
        openIds.add(id)
    }
}

function isOpen(id) {
    if (query.value && filtered.value.matchedGroupIds.has(id)) {
        return true
    }

    return openIds.has(id)
}

function selectPin(pin) {
    emit('select', pin)
}
</script>
```

Note what changed from the previous version: the "Uncategorised" `<button>`/chevron/`isOpen('uncategorised')` gate is gone — it's now a plain `<p>` label, always rendered alongside its list whenever non-empty. Both the group loop and the uncategorised list now read from `filtered` instead of `tree`.

- [ ] **Step 6: Manually verify**

Run `vendor/bin/sail yarn run build`, confirm no errors, then in a browser on a map with nested subgroups and an uncategorised pin:
1. Uncategorised has no collapse arrow/button and its pins are always visible.
2. Typing in the search box hides non-matching pins; a subgroup containing a match shows its header and only the matching pins, auto-expanded.
3. Clearing the search restores the previous manual expand/collapse state.

- [ ] **Step 7: Commit**

```bash
git add resources/js/maps/groupTree.js resources/js/maps/groupTree.test.js resources/js/components/maps/LegendPanel.vue
git commit -m "feat: add legend marker search and make uncategorised always open"
```

---

### Task 4: Pin detail panel — entry/image/actions, centering, delete

**Files:**
- Modify: `resources/js/components/maps/DetailPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `pin.preview_url`/`pin.destroy_url` (Task 1), the `entities.map-markers.preview` JSON shape (Task 2: `entity_url, entity_image, marker_entry, entity_entry, type, group_name, can_edit, edit_url`).
- Produces: `DetailPanel.vue` emits `close`, `center`, `deleted(pin)`. `MapExplorer.vue` gains `centerNonce` (passed to `LeafletCanvas` as `center-nonce`, alongside `selectedPin` as `center-pin`) and a `removePin(pin)` handler wired to `@deleted`.

No automated test (DOM/network component). Verify manually per Step 5.

- [ ] **Step 1: Rewrite `DetailPanel.vue`**

Replace `resources/js/components/maps/DetailPanel.vue` in full:

```vue
<template>
    <aside v-if="pin" class="fixed top-0 right-0 h-screen w-80 bg-base-100 shadow-lg z-[1100] flex flex-col overflow-y-auto">
        <div
            class="p-4 flex flex-col justify-end bg-cover bg-center"
            :style="preview?.entity_image ? { backgroundImage: `url('${preview.entity_image}')` } : {}"
        >
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-lg font-semibold">
                    <a v-if="preview?.entity_url" :href="preview.entity_url">{{ pin.name }}</a>
                    <template v-else>{{ pin.name }}</template>
                </h2>
                <button class="btn2 btn-default btn-sm flex-none" @click="$emit('close')">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </div>
        </div>

        <div v-if="loading" class="p-4 flex items-center gap-2">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>loading....</span>
        </div>

        <div v-else-if="preview" class="p-4 flex flex-col gap-3 grow">
            <p class="text-sm opacity-75">{{ preview.type }} - {{ preview.group_name || 'Uncategorised' }}</p>

            <div v-if="preview.marker_entry" v-html="preview.marker_entry"></div>

            <template v-if="preview.entity_entry">
                <p v-if="preview.marker_entry" class="text-sm font-semibold">From entry</p>
                <div v-html="preview.entity_entry"></div>
            </template>

            <div class="mt-auto flex flex-col gap-2 pt-4">
                <a
                    v-if="preview.can_edit && preview.edit_url"
                    :href="preview.edit_url"
                    target="_blank"
                    class="btn2 btn-primary btn-block"
                >
                    Edit details
                </a>

                <div class="flex gap-2">
                    <button class="btn2 btn-default grow" @click="$emit('center')">Center</button>
                    <button v-if="preview.can_edit" class="btn2 grow" @click="duplicate">Duplicate</button>
                </div>

                <button v-if="preview.can_edit" class="btn2 btn-danger" @click="handleDelete">
                    {{ confirming ? 'Click again to confirm' : 'Delete marker' }}
                </button>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    pin: { type: Object, default: null },
})

const emit = defineEmits(['close', 'center', 'deleted'])

const loading = ref(false)
const preview = ref(null)
const confirming = ref(false)

function duplicate() {
    // No-op for now.
}

async function handleDelete() {
    if (! confirming.value) {
        confirming.value = true

        return
    }

    const res = await axios.delete(props.pin.destroy_url)
    if (res.status === 204) {
        emit('deleted', props.pin)
    }
}

async function load(pin) {
    confirming.value = false
    preview.value = null

    if (! pin) {
        return
    }

    loading.value = true
    try {
        const res = await axios.get(pin.preview_url)
        preview.value = res.data
    } finally {
        loading.value = false
    }
}

watch(() => props.pin, load, { immediate: true })
</script>
```

- [ ] **Step 2: Wire centering + deletion into `MapExplorer.vue`**

In `resources/js/components/maps/MapExplorer.vue`, add `centerNonce` to the script and a `removePin` handler:

```js
const centerNonce = ref(0)

function removePin(pin) {
    data.value.pins = data.value.pins.filter((p) => p.id !== pin.id)
    selectedPin.value = null
}
```

Update the `<LeafletCanvas>` and `<DetailPanel>` tags:

```vue
<LeafletCanvas
    :map="data.map"
    :layers="data.layers"
    :pins="data.pins"
    :center-pin="selectedPin"
    :center-nonce="centerNonce"
    @pin-click="selectPin"
/>

<DetailPanel :pin="selectedPin" @close="selectedPin = null" @center="centerNonce++" @deleted="removePin" />
```

- [ ] **Step 3: Add centering to `LeafletCanvas.vue`**

In `resources/js/components/maps/LeafletCanvas.vue`, add `centerPin`/`centerNonce` props and a watcher. Update the `import` line and `defineProps`:

```js
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
```

```js
const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
})
```

Add this after `buildPins()`'s definition (anywhere in the `<script setup>` body, e.g. right before `onMounted`):

```js
watch(() => props.centerNonce, () => {
    if (props.centerPin && leafletMap) {
        leafletMap.setView([props.centerPin.latitude, props.centerPin.longitude])
    }
})
```

- [ ] **Step 4: Verify the build**

Run: `vendor/bin/sail yarn run build`
Expected: no errors. Revert the incidentally-regenerated manifest: `git checkout -- public/build/manifest.json`, then confirm `git status` shows only the intended files before committing.

- [ ] **Step 5: Manually verify**

In a browser, on a map with at least one marker linked to an entity (with its own image/entry) and one marker with no linked entity:
1. Click a pin — the panel opens immediately showing its name (linked, underlined, if the marker has an entity) while a brief loading spinner shows in the body.
2. Once loaded: header shows the entity's image as a background if it has one; body shows type + group ("Uncategorised" if none); marker/entity entry text renders correctly (including the "From entry" label only appearing when both entry sources are present).
3. As a user who can edit the map: Edit details opens the legacy edit form in a new tab; Center pans/zooms the map to the pin (click Center again after panning away — it should re-center); Duplicate does nothing (expected); Delete marker requires two clicks (button text changes on the first click) and, after the second click, the panel closes and the pin disappears from both the map and the legend.
4. As a player (no edit permission): Edit/Duplicate/Delete buttons are absent; Center is still present and works.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/DetailPanel.vue resources/js/components/maps/MapExplorer.vue resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: add pin detail panel actions (edit/duplicate/delete/center)"
```

---

### Task 5: Map header + zoom control position

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:** None new — purely visual, no props/emits change.

No automated test. Verify manually per Step 3.

- [ ] **Step 1: Add the map name/marker count header**

In `resources/js/components/maps/MapExplorer.vue`, replace the toggle button block:

```vue
<button
    class="legend-toggle fixed top-4 left-4 z-[1100] btn2 btn-default"
    @click="legendOpen = !legendOpen"
>
    <i class="fa-solid fa-list" aria-hidden="true" />
</button>
```

with:

```vue
<div class="fixed top-4 left-4 z-[1100] flex items-start gap-3">
    <button class="legend-toggle btn2 btn-default" @click="legendOpen = !legendOpen">
        <i class="fa-solid fa-list" aria-hidden="true" />
    </button>
    <div>
        <h1 class="text-lg font-semibold leading-tight">{{ data.map.name }}</h1>
        <p class="text-sm opacity-75">{{ data.pins.length }} markers</p>
    </div>
</div>
```

- [ ] **Step 2: Move the zoom control to bottom-left**

In `resources/js/components/maps/LeafletCanvas.vue`, add `zoomControl: false` to the `options` object built in `onMounted`:

```js
const options = {
    zoom: props.map.initial_zoom,
    minZoom: props.map.min_zoom,
    maxZoom: props.map.max_zoom,
    center: props.map.center,
    attributionControl: false,
    zoomControl: false,
}
```

Then, right after `leafletMap = L.map(mapEl.value, options)`, add:

```js
L.control.zoom({ position: 'bottomleft' }).addTo(leafletMap)
```

- [ ] **Step 3: Verify the build and manually check**

Run: `vendor/bin/sail yarn run build`, confirm no errors, revert `public/build/manifest.json`.

In a browser:
1. The map name and "N markers" text appear next to the legend toggle button, top-left, and don't overlap it.
2. The +/- zoom buttons appear bottom-left, not overlapping the legend toggle button/header.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: add map name/marker count header, move zoom control to bottom-left"
```
