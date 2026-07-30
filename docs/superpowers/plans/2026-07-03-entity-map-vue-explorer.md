# Entity Map Vue+Leaflet Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ship a new read-only `entities/{entity}/map` page that renders a map entity's groups, layers, and pins with a Vue 3 root component on top of Leaflet, fed by a new `entities/{entity}/map-api` JSON endpoint.

**Architecture:** A thin Laravel controller pair (page + JSON API) under `App\Http\Controllers\Entity\Maps`, backed by a dedicated `App\Services\Maps\ExploreApiService` that assembles one JSON payload (map settings, layers, groups, pins) using small `App\Http\Resources\Maps\Explore\*` resources. The page is a single Blade view mounting one Vue root component (`MapExplorer.vue`), which fetches that payload and composes `LeafletCanvas.vue` (renders the map), `LegendPanel.vue` (left slide-over), and `DetailPanel.vue` (right slide-over).

**Tech Stack:** Laravel 11 / PHP 8.4, Pest 3, Vue 3 (`<script setup>`), Vite, Leaflet + leaflet.markercluster (npm), Tailwind.

## Global Constraints

- Full design spec: `docs/superpowers/specs/2026-07-03-entity-map-vue-explorer-design.md` — read it before starting if anything below is ambiguous.
- This is a new, parallel page. Do not modify `/maps/{map}/explore` (`ExploreController`, `maps/explore.blade.php`, `maps/_setup.blade.php`) or any of its routes/views/JS.
- New npm dependency: `leaflet` (core). `leaflet.markercluster` is already an npm dependency but was only vendored, not bundled — this project now imports it directly.
- No JS/Vue automated test harness exists in this repo. Pure, DOM-free JS logic (`groupTree.js`) is tested with Node's built-in test runner (`node --test`) via `vendor/bin/sail node`. Anything touching Vue/DOM/Leaflet is verified manually in the browser — steps say exactly what to check.
- All PHP changes: run `vendor/bin/sail bin pint --dirty --format agent` before the task's final commit if any PHP file was touched.
- All Artisan/PHP/Composer/Node/Yarn commands go through `vendor/bin/sail`.
- v1 scope cuts (confirmed in the design doc, don't second-guess these mid-implementation): no editing, no ruler tool, no layer-visibility toggle UI (only `overlay_shown` layers render), no polygon-shaped pins, no live position ticker.

---

### Task 1: `MapMarker::exploreIcon()` — resolve pin icons server-side

**Files:**
- Modify: `app/Models/MapMarker.php`
- Test: `tests/Feature/Entities/Maps/MapMarkerExploreIconTest.php`

**Interfaces:**
- Produces: `MapMarker::exploreIcon(): array` returning `['type' => 'fa'|'html'|'svg'|'avatar'|'none', 'value' => ?string]`. Task 2's `PinResource` calls this directly.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Facades\Avatar;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

it('resolves the default pin icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
});

it('resolves the question mark icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 2]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-question']);
});

it('resolves the exclamation icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 3]);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-exclamation']);
});

it('resolves the entity avatar icon', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 4, 'entity_id' => $entity->id]);

    $icon = $marker->exploreIcon();

    expect($icon['type'])->toBe('avatar');
    expect($icon['value'])->toBe(Avatar::entity($entity)->fallback()->size(276)->thumbnail());
});

it('resolves a custom fontawesome icon only when the campaign is boosted', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1, 'custom_icon' => 'fa-solid fa-skull']);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-skull']);
});

it('ignores a custom icon when the campaign is not boosted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'icon' => 1, 'custom_icon' => 'fa-solid fa-skull']);

    expect($marker->exploreIcon())->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
});

it('returns none for non-marker shapes', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'shape_id' => 3]); // circle

    expect($marker->exploreIcon())->toBe(['type' => 'none', 'value' => null]);
});
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerExploreIconTest`
Expected: FAIL — `Call to undefined method App\Models\MapMarker::exploreIcon()`

- [ ] **Step 3: Add the `Avatar` facade import**

In `app/Models/MapMarker.php`, add to the `use` block (alongside the existing `App\Facades\*` imports):

```php
use App\Facades\Avatar;
```

- [ ] **Step 4: Implement `exploreIcon()`**

Add this public method to `app/Models/MapMarker.php`, near `markerIcon()`/`datagridMarkerIcon()`:

```php
/**
 * Resolve this marker's icon into a clean, JSON-safe shape for the Vue map explorer,
 * mirroring the branching in markerIcon()/datagridMarkerIcon() without building JS strings.
 */
public function exploreIcon(): array
{
    if ($this->icon == 5 || $this->isLabel() || $this->isCircle() || $this->isPolygon()) {
        return ['type' => 'none', 'value' => null];
    }

    $campaign = CampaignLocalization::getCampaign();
    if (! empty($this->custom_icon) && $campaign->boosted()) {
        if (Str::startsWith($this->custom_icon, '<i ')) {
            return ['type' => 'html', 'value' => $this->custom_icon];
        }
        if (Str::startsWith($this->custom_icon, ['fa-', 'ra '])) {
            return ['type' => 'fa', 'value' => $this->custom_icon];
        }
        if (Str::startsWith($this->custom_icon, '<?xml')) {
            return ['type' => 'svg', 'value' => $this->resizedCustomIcon()];
        }
    }

    if ($this->icon == 2) {
        return ['type' => 'fa', 'value' => 'fa-solid fa-question'];
    }
    if ($this->icon == 3) {
        return ['type' => 'fa', 'value' => 'fa-solid fa-exclamation'];
    }
    if ($this->icon == 4 && $this->entity) {
        return [
            'type' => 'avatar',
            'value' => Avatar::entity($this->entity)->fallback()->size(276)->thumbnail(),
        ];
    }

    return ['type' => 'fa', 'value' => 'fa-solid fa-map-pin'];
}
```

- [ ] **Step 5: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapMarkerExploreIconTest`
Expected: PASS (7 tests)

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapMarker.php tests/Feature/Entities/Maps/MapMarkerExploreIconTest.php
git commit -m "feat: add MapMarker::exploreIcon() for the new map explorer API"
```

---

### Task 2: Explore API — resources, service, controller, route

**Files:**
- Create: `app/Http/Resources/Maps/Explore/MapResource.php`
- Create: `app/Http/Resources/Maps/Explore/LayerResource.php`
- Create: `app/Http/Resources/Maps/Explore/GroupResource.php`
- Create: `app/Http/Resources/Maps/Explore/PinResource.php`
- Create: `app/Services/Maps/ExploreApiService.php`
- Create: `app/Http/Controllers/Entity/Maps/ApiController.php`
- Modify: `routes/campaigns/entities.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: `MapMarker::exploreIcon(): array` (Task 1).
- Produces: route `entities.map-api` (`GET /w/{campaign}/entities/{entity}/map-api`), returning JSON `{ map: {...}, layers: [...], groups: [...], pins: [...] }` per the design doc's contract. Task 3's Blade view calls `route('entities.map-api', [$campaign, $entity])`. Task 5's `MapExplorer.vue` fetches this URL.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->get(route('entities.map-api', [1, $entity]))
        ->assertStatus(404);
});

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

    MapMarker::factory()->create(['map_id' => $map->id, 'group_id' => $group->id, 'name' => 'Waterdeep']);
    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Uncategorised pin']);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity']],
        ]);

    $response->assertJsonFragment(['name' => $map->name, 'is_real' => false, 'has_clustering' => true]);
    $response->assertJsonFragment(['name' => 'Waterdeep', 'group_id' => $group->id]);
    // The hidden (type_id=1) overlay layer must not be included, only the shown-by-default one
    expect($response->json('layers'))->toHaveCount(1);
    expect($response->json('layers.0.name'))->toBe('Winter');
});

it('marks a real map with a tile url and no image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_real'))->toBeTrue();
    expect($response->json('map.image'))->toBeNull();
    expect($response->json('map.tile_url'))->toBe('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
});

it('marks a finished chunked map with a chunks url', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    // chunking_status isn't mass-assignable (not in Map::$fillable), set it directly like MapTest.php does for image_path
    $map->chunking_status = Map::CHUNKING_FINISHED;
    $map->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);
    $chunksUrl = $response->json('map.chunks_url');

    expect($response->json('map.is_chunked'))->toBeTrue();
    expect($chunksUrl)->toStartWith(route('maps.chunks', [1, $map->id]));
    expect($chunksUrl)->toEndWith('?z={z}&x={x}&y={y}');
});

it('excludes pins in an admin-only group when viewed by a non-admin player (mirrors MapMarker::visible())', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);
    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Admin only pin', 'group_id' => $group->id]);

    $this->asPlayer();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    // The group itself is filtered out by MapGroup's own visibility scope, and the marker's
    // group_id points at a group the player's query can't see, so MapMarker::visible() excludes it too.
    expect($response->json('groups'))->toHaveCount(0);
    expect($response->json('pins'))->toHaveCount(0);
});
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL — route `entities.map-api` not defined

- [ ] **Step 3: Create the four Resource classes**

`app/Http/Resources/Maps/Explore/GroupResource.php`:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapGroup $resource
 */
class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'parent_id' => $this->resource->parent_id,
            'position' => $this->resource->position,
        ];
    }
}
```

`app/Http/Resources/Maps/Explore/LayerResource.php`:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapLayer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property MapLayer $resource
 */
class LayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $layer = $this->resource;

        return [
            'id' => $layer->id,
            'name' => $layer->name,
            'type_id' => $layer->type_id,
            'image' => $layer->image ? $layer->image->url() : Storage::url($layer->image_path),
            'position' => $layer->position,
        ];
    }
}
```

`app/Http/Resources/Maps/Explore/PinResource.php`:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinResource extends JsonResource
{
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
        ];
    }
}
```

`app/Http/Resources/Maps/Explore/MapResource.php`:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\Map;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Map $resource
 */
class MapResource extends JsonResource
{
    use CampaignAware;

    public function toArray(Request $request): array
    {
        $map = $this->resource;
        $isChunked = $map->isChunked() && $map->chunkingReady();

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_chunked' => $isChunked,
            'has_clustering' => $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => array_map('floatval', explode(', ', $map->centerFocus())),
            'tile_url' => $map->isReal() ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : null,
            'chunks_url' => $isChunked
                ? route('maps.chunks', [$this->campaign, $map->id]) . '/?z={z}&x={x}&y={y}'
                : null,
        ];
    }
}
```

- [ ] **Step 4: Create `ExploreApiService`**

`app/Services/Maps/ExploreApiService.php`:

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
        return [
            'map' => new MapResource($this->map)->campaign($this->campaign),
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->typeName() === 'overlay_shown' && $layer->hasImage())
                    ->values()
            ),
            'groups' => GroupResource::collection($this->map->groups),
            'pins' => PinResource::collection(
                $this->map->markers->filter(fn ($marker) => $marker->visible())->values()
            ),
        ];
    }
}
```

- [ ] **Step 5: Create the controller**

`app/Http/Controllers/Entity/Maps/ApiController.php`:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Maps\ExploreApiService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected ExploreApiService $apiService) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->map($entity->child)
                ->load()
        );
    }
}
```

- [ ] **Step 6: Add the route**

In `routes/campaigns/entities.php`, add to the `use` block near the other `Entity\*` imports:

```php
use App\Http\Controllers\Entity\Maps\ApiController as EntityMapApiController;
```

Add the route right after the `entities.children` route (currently line 53):

```php
Route::get('/w/{campaign}/entities/{entity}/map-api', [EntityMapApiController::class, 'index'])->name('entities.map-api');
```

- [ ] **Step 7: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS (5 tests)

- [ ] **Step 8: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps app/Services/Maps/ExploreApiService.php app/Http/Controllers/Entity/Maps/ApiController.php routes/campaigns/entities.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add entities.map-api endpoint for the new map explorer"
```

---

### Task 3: Map page route, controller, and view

**Files:**
- Create: `app/Http/Controllers/Entity/Maps/ShowController.php`
- Create: `resources/views/entities/pages/map/index.blade.php`
- Modify: `routes/campaigns/entities.php`
- Test: `tests/Feature/Entities/Maps/ShowControllerTest.php`

**Interfaces:**
- Consumes: route `entities.map-api` (Task 2).
- Produces: route `entities.map` (`GET /w/{campaign}/entities/{entity}/map`), rendering `entities.pages.map.index`. Task 5 modifies this view to add the `@section('scripts')` block.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Character;
use App\Models\Map;

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->get(route('entities.map', [1, $entity]))->assertStatus(404);
});

it('renders the map page for a map entity', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertStatus(200)
        ->assertSee('map-explorer', false)
        ->assertSee(route('entities.map-api', [1, $map->entity]), false);
});

it('redirects to the entity page when the map cannot be explored', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => false]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertRedirect(route('entities.show', [1, $map->entity]));
});
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ShowControllerTest`
Expected: FAIL — route `entities.map` not defined

- [ ] **Step 3: Create the controller**

`app/Http/Controllers/Entity/Maps/ShowController.php`:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ShowController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        /** @var \App\Models\Map $map */
        $map = $entity->child;

        if (! $map->explorable()) {
            return redirect()
                ->route('entities.show', [$campaign, $entity])
                ->withError(__('maps.errors.explore.missing'));
        }

        if ($map->isChunked() && ! $map->chunkingReady()) {
            return redirect()->route('entities.show', [$campaign, $entity]);
        }

        return view('entities.pages.map.index', compact('campaign', 'entity'));
    }
}
```

- [ ] **Step 4: Create the view**

`resources/views/entities/pages/map/index.blade.php`:

```blade
@extends('layouts.rich', [
    'title' => $entity->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'map-page',
])

@section('content')
    <div id="map-explorer">
        <map-explorer api="{{ route('entities.map-api', [$campaign, $entity]) }}"></map-explorer>
    </div>
@endsection
```

- [ ] **Step 5: Add the route**

In `routes/campaigns/entities.php`, add to the `use` block:

```php
use App\Http\Controllers\Entity\Maps\ShowController as EntityMapShowController;
```

Add the route next to the `entities.map-api` route added in Task 2:

```php
Route::get('/w/{campaign}/entities/{entity}/map', [EntityMapShowController::class, 'index'])->name('entities.map');
```

- [ ] **Step 6: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ShowControllerTest`
Expected: PASS (3 tests)

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Controllers/Entity/Maps/ShowController.php resources/views/entities/pages/map/index.blade.php routes/campaigns/entities.php tests/Feature/Entities/Maps/ShowControllerTest.php
git commit -m "feat: add entities.map page route for the new map explorer"
```

---

### Task 4: `groupTree.js` — pure group/pin nesting helper

**Files:**
- Create: `resources/js/maps/groupTree.js`
- Test: `resources/js/maps/groupTree.test.js`

**Interfaces:**
- Produces: `buildGroupTree(groups, pins): { groups: Array<Group & {children, pins}>, uncategorised: Array<Pin> }`. Task 7's `LegendPanel.vue` and Task 6's `LeafletCanvas.vue` both import this.
- Consumes: flat `groups` (`{id, name, parent_id, position}`) and `pins` (`{id, ..., group_id}`) arrays, matching Task 2's API contract.

- [ ] **Step 1: Write the failing test**

`resources/js/maps/groupTree.test.js`:

```js
import { test } from 'node:test'
import assert from 'node:assert/strict'
import { buildGroupTree } from './groupTree.js'

test('nests child groups under their parent, in root order', () => {
    const groups = [
        { id: 2, name: 'Region', parent_id: 1 },
        { id: 1, name: 'Continent', parent_id: null },
    ]

    const tree = buildGroupTree(groups, [])

    assert.equal(tree.groups.length, 1)
    assert.equal(tree.groups[0].id, 1)
    assert.equal(tree.groups[0].children.length, 1)
    assert.equal(tree.groups[0].children[0].id, 2)
})

test('assigns pins to their group and buckets orphans as uncategorised', () => {
    const groups = [{ id: 1, name: 'Towns', parent_id: null }]
    const pins = [
        { id: 10, group_id: 1 },
        { id: 11, group_id: null },
        { id: 12, group_id: 999 },
    ]

    const tree = buildGroupTree(groups, pins)

    assert.deepEqual(tree.groups[0].pins.map((p) => p.id), [10])
    assert.deepEqual(tree.uncategorised.map((p) => p.id), [11, 12])
})
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail node --test resources/js/maps/groupTree.test.js`
Expected: FAIL — cannot find module `./groupTree.js`

- [ ] **Step 3: Implement `groupTree.js`**

`resources/js/maps/groupTree.js`:

```js
export function buildGroupTree(groups, pins) {
    const byId = new Map(groups.map((group) => [group.id, { ...group, children: [], pins: [] }]))
    const roots = []

    byId.forEach((group) => {
        const parent = group.parent_id ? byId.get(group.parent_id) : null
        if (parent) {
            parent.children.push(group)
        } else {
            roots.push(group)
        }
    })

    const uncategorised = []
    pins.forEach((pin) => {
        const group = pin.group_id ? byId.get(pin.group_id) : null
        if (group) {
            group.pins.push(pin)
        } else {
            uncategorised.push(pin)
        }
    })

    return { groups: roots, uncategorised }
}
```

- [ ] **Step 4: Run the test to verify it passes**

Run: `vendor/bin/sail node --test resources/js/maps/groupTree.test.js`
Expected: PASS (2 tests)

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/groupTree.js resources/js/maps/groupTree.test.js
git commit -m "feat: add buildGroupTree helper for the map legend"
```

---

### Task 5: Vue entry point + `MapExplorer.vue` root (loading/error/fetch)

**Files:**
- Create: `resources/js/maps/explore.js`
- Create: `resources/js/components/maps/MapExplorer.vue`
- Modify: `vite.config.js`
- Modify: `resources/views/entities/pages/map/index.blade.php`

**Interfaces:**
- Consumes: `api` prop (URL string, from `entities.map-api`, wired in Task 3's view).
- Produces: `MapExplorer.vue` holds reactive `data` (`{map, layers, groups, pins}`), `loading`, `error`, `legendOpen`, `selectedPin`, and a `selectPin(pin)` function — Tasks 6/7/8 each import and place a new child component here and wire it to this state. Do not rename these — later tasks depend on the exact names.

This task has no automated test (no Vue/DOM harness in this repo). Verify manually as described in Step 5.

- [ ] **Step 1: Add the Vite entry**

In `vite.config.js`, add `'resources/js/maps/explore.js',` to the `input` array, right after `'resources/js/entities/explore.js',`.

- [ ] **Step 2: Create `MapExplorer.vue`**

`resources/js/components/maps/MapExplorer.vue`:

```vue
<template>
    <div class="w-full h-screen flex items-center justify-center text-2xl" v-if="loading || error">
        <div class="flex items-center gap-2" v-if="loading && !error">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>loading....</span>
        </div>
        <div class="flex flex-col items-center gap-2 text-error-content" v-else-if="error">
            <span>{{ error }}</span>
        </div>
    </div>

    <div v-else class="p-4">
        Map data loaded for {{ data.map.name }}
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    api: { type: String, required: true },
})

const loading = ref(true)
const error = ref(null)
const data = ref({ map: {}, layers: [], groups: [], pins: [] })
const legendOpen = ref(false)
const selectedPin = ref(null)

function selectPin(pin) {
    selectedPin.value = pin
}

onMounted(async () => {
    try {
        const res = await axios.get(props.api)
        data.value = res.data
    } catch (e) {
        error.value = 'Unable to load this map.'
    } finally {
        loading.value = false
    }
})
</script>
```

- [ ] **Step 3: Create the entry point**

`resources/js/maps/explore.js`:

```js
import { createApp } from 'vue'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
```

- [ ] **Step 4: Wire the view to load the bundle**

In `resources/views/entities/pages/map/index.blade.php`, add below `@endsection`:

```blade
@section('scripts')
    @parent
    @vite('resources/js/maps/explore.js')
@endsection
```

- [ ] **Step 5: Manually verify**

Run `vendor/bin/sail yarn run dev` (or ask the user to, per project convention), then in a browser:
1. Visit a map entity's `/map` page (e.g. via `route('entities.map', [$campaign, $mapEntity])`).
2. Confirm the `fa-spinner fa-spin` "loading...." indicator shows briefly.
3. Confirm it's replaced by "Map data loaded for `<map name>`".
4. Temporarily break the API route name in the view to confirm the error state renders "Unable to load this map.", then revert.

- [ ] **Step 6: Commit**

```bash
git add resources/js/maps/explore.js resources/js/components/maps/MapExplorer.vue vite.config.js resources/views/entities/pages/map/index.blade.php
git commit -m "feat: mount MapExplorer.vue root with loading/error states"
```

---

### Task 6: `LeafletCanvas.vue` — base layer, image layers, pins, clustering

**Files:**
- Create: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/maps/explore.js`
- Modify: `package.json` (add `leaflet`)

**Interfaces:**
- Consumes: `map`, `layers`, `groups`, `pins` props (Task 2's API shapes) and `MapExplorer.vue`'s `selectPin` (Task 5).
- Produces: emits `pin-click(pin)`.

No automated test (Leaflet requires a real DOM/canvas). Verify manually per Step 6.

- [ ] **Step 1: Install `leaflet`**

Run: `vendor/bin/sail yarn add leaflet`
Expected: `leaflet` added to `dependencies` in `package.json` and `yarn.lock` updated. (`leaflet.markercluster` is already a dependency.)

- [ ] **Step 2: Import Leaflet's CSS in the entry point**

In `resources/js/maps/explore.js`, add at the top:

```js
import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
```

- [ ] **Step 3: Create `LeafletCanvas.vue`**

`resources/js/components/maps/LeafletCanvas.vue`:

```vue
<template>
    <div ref="mapEl" class="w-full h-screen"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'
import L from 'leaflet'
import 'leaflet.markercluster'

const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
})

const emit = defineEmits(['pin-click'])

const mapEl = ref(null)
let leafletMap = null

function bounds() {
    return [[0, 0], [props.map.height, props.map.width]]
}

function buildBaseLayer() {
    if (props.map.is_real) {
        L.tileLayer(props.map.tile_url, {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(leafletMap)

        return
    }

    if (props.map.is_chunked) {
        L.tileLayer(props.map.chunks_url, { attribution: '&copy; Kanka' }).addTo(leafletMap)

        return
    }

    L.imageOverlay(props.map.image, bounds()).addTo(leafletMap)
}

function buildLayers() {
    props.layers.forEach((layer) => {
        L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
    })
}

function pinIcon(pin) {
    const size = pin.pin_size || 40
    let inner = '<i class="fa-solid fa-map-pin"></i>'
    let style = `background-color: ${pin.colour || '#ccc'};`

    if (pin.icon?.type === 'fa') {
        inner = `<i class="${pin.icon.value}" aria-hidden="true"></i>`
    } else if (pin.icon?.type === 'html' || pin.icon?.type === 'svg') {
        inner = pin.icon.value
    } else if (pin.icon?.type === 'avatar') {
        inner = ''
        style = `background-image: url('${pin.icon.value}'); background-size: cover;`
    }

    return L.divIcon({
        html: `<div class="marker-pin" style="${style}"></div>${inner}`,
        iconSize: [size, size],
        iconAnchor: [size / 2, size + size / 4],
        popupAnchor: [0, -(size + size / 4)],
        className: `marker marker-${pin.id}`,
    })
}

function buildPin(pin) {
    if (pin.shape === 'circle') {
        return L.circle([pin.latitude, pin.longitude], {
            radius: pin.circle_radius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity || 100) / 100,
        })
    }

    if (pin.shape === 'label') {
        return L.marker([pin.latitude, pin.longitude], { opacity: 0 })
            .bindTooltip(pin.name, { permanent: true, direction: 'center', className: 'map-label' })
    }

    return L.marker([pin.latitude, pin.longitude], {
        icon: pinIcon(pin),
        opacity: (pin.opacity || 100) / 100,
    })
}

function buildPins() {
    const pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    // Polygon pins are out of scope for v1 (see design doc) — skip rather than mis-render at the wrong spot
    props.pins.filter((pin) => pin.shape !== 'poly').forEach((pin) => {
        const marker = buildPin(pin)
        marker.on('click', () => emit('pin-click', pin))
        pinLayer.addLayer(marker)
    })

    pinLayer.addTo(leafletMap)
}

onMounted(() => {
    const options = {
        zoom: props.map.initial_zoom,
        minZoom: props.map.min_zoom,
        maxZoom: props.map.max_zoom,
        center: props.map.center,
        attributionControl: false,
    }

    if (! props.map.is_real) {
        options.crs = L.CRS.Simple
        options.maxBounds = bounds()
    }

    leafletMap = L.map(mapEl.value, options)

    buildBaseLayer()
    buildLayers()
    buildPins()
})

onBeforeUnmount(() => {
    leafletMap?.remove()
})
</script>
```

- [ ] **Step 4: Wire it into `MapExplorer.vue`**

In `resources/js/components/maps/MapExplorer.vue`, add the import:

```js
import LeafletCanvas from './LeafletCanvas.vue'
```

Replace the `<div v-else class="p-4">Map data loaded for {{ data.map.name }}</div>` block with:

```vue
<LeafletCanvas
    v-else
    :map="data.map"
    :layers="data.layers"
    :pins="data.pins"
    @pin-click="selectPin"
/>
```

- [ ] **Step 5: Update `package.json`**

Confirm `leaflet` now appears under `dependencies` (done automatically by `yarn add` in Step 1).

- [ ] **Step 6: Manually verify**

Run `vendor/bin/sail yarn run dev`, then in a browser, for each of these seeded via tinker or existing campaign data:
1. A simple (non-real, non-chunked) map: base image renders at the right size, any `overlay_shown` layer image is stacked on top, pins appear at their `latitude`/`longitude`.
2. A map with `has_clustering` on: pins near each other cluster into a bubble that expands on click/zoom.
3. A map with `has_clustering` off: pins render individually, no clustering.
4. A `circle`-shaped pin renders as a filled circle; a `label`-shaped pin renders as a permanent text tooltip with no visible marker icon.
5. Clicking any pin doesn't error (no visible effect expected yet — `DetailPanel` isn't wired until Task 8).

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue resources/js/maps/explore.js package.json yarn.lock
git commit -m "feat: render base layer, image layers, and pins with Leaflet"
```

---

### Task 7: `LegendPanel.vue` — left toggle + collapsible group list

**Files:**
- Create: `resources/js/components/maps/LegendPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `groupTree.js`'s `buildGroupTree` (Task 4), `groups`/`pins` props, `open` prop.
- Produces: emits `select(pin)`.

No automated test (DOM component). Verify manually per Step 3.

- [ ] **Step 1: Create `LegendPanel.vue`**

`resources/js/components/maps/LegendPanel.vue`:

```vue
<template>
    <aside v-if="open" class="fixed top-0 left-0 h-screen w-72 bg-base-100 shadow-lg z-30 overflow-y-auto p-4">
        <ul class="flex flex-col gap-1">
            <li v-for="group in tree.groups" :key="group.id">
                <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle(group.id)">
                    <i :class="isOpen(group.id) ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
                    <span>{{ group.name }}</span>
                </button>
                <ul v-if="isOpen(group.id)" class="pl-5 flex flex-col gap-1">
                    <li v-for="pin in group.pins" :key="pin.id">
                        <button class="text-left" @click="$emit('select', pin)">{{ pin.name }}</button>
                    </li>
                </ul>
            </li>

            <li v-if="tree.uncategorised.length">
                <button class="flex items-center gap-2 w-full text-left font-semibold" @click="toggle('uncategorised')">
                    <i :class="isOpen('uncategorised') ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-right'" aria-hidden="true" />
                    <span>Uncategorised</span>
                </button>
                <ul v-if="isOpen('uncategorised')" class="pl-5 flex flex-col gap-1">
                    <li v-for="pin in tree.uncategorised" :key="pin.id">
                        <button class="text-left" @click="$emit('select', pin)">{{ pin.name }}</button>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script setup>
import { computed, reactive } from 'vue'
import { buildGroupTree } from '../../maps/groupTree.js'

const props = defineProps({
    open: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
})

defineEmits(['select'])

const tree = computed(() => buildGroupTree(props.groups, props.pins))
const openIds = reactive(new Set())

function toggle(id) {
    if (openIds.has(id)) {
        openIds.delete(id)
    } else {
        openIds.add(id)
    }
}

function isOpen(id) {
    return openIds.has(id)
}
</script>
```

- [ ] **Step 2: Wire it into `MapExplorer.vue`**

In `resources/js/components/maps/MapExplorer.vue`:

Add the import:

```js
import LegendPanel from './LegendPanel.vue'
```

Add, right before the `<LeafletCanvas ... />` line (still inside the `v-else` branch — wrap the existing content in a `<template v-else>` if it's a single element, since there are now multiple siblings to render):

```vue
<template v-else>
    <button
        class="legend-toggle fixed top-4 left-4 z-40 btn2 btn-default"
        @click="legendOpen = !legendOpen"
    >
        <i class="fa-solid fa-list" aria-hidden="true" />
    </button>

    <LegendPanel :open="legendOpen" :groups="data.groups" :pins="data.pins" @select="selectPin" />

    <LeafletCanvas :map="data.map" :layers="data.layers" :pins="data.pins" @pin-click="selectPin" />
</template>
```

(Remove the `v-else` attribute directly on `<LeafletCanvas>` since the wrapping `<template v-else>` now handles it.)

- [ ] **Step 3: Manually verify**

Run `vendor/bin/sail yarn run dev`, then in a browser, on a map with at least one group with pins and one uncategorised pin:
1. A button with a list icon appears top-left; clicking it opens/closes the left panel.
2. The panel lists each group by name; clicking a group name expands/collapses its pin list.
3. An "Uncategorised" section appears last, listing pins with no group.
4. Clicking any pin name in the legend doesn't error (no visible effect yet — `DetailPanel` isn't wired until Task 8).

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/LegendPanel.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: add collapsible legend panel with uncategorised pins bucket"
```

---

### Task 8: `DetailPanel.vue` — right panel showing the selected pin

**Files:**
- Create: `resources/js/components/maps/DetailPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `pin` prop (nullable, shape from Task 2's `PinResource`).
- Produces: emits `close`.

No automated test (DOM component). Verify manually per Step 3 — this is the final task, so verify the full click-to-detail flow end to end.

- [ ] **Step 1: Create `DetailPanel.vue`**

`resources/js/components/maps/DetailPanel.vue`:

```vue
<template>
    <aside v-if="pin" class="fixed top-0 right-0 h-screen w-80 bg-base-100 shadow-lg z-30 p-4 flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ pin.name }}</h2>
            <button class="btn2 btn-default btn-sm" @click="$emit('close')">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>
    </aside>
</template>

<script setup>
defineProps({
    pin: { type: Object, default: null },
})

defineEmits(['close'])
</script>
```

- [ ] **Step 2: Wire it into `MapExplorer.vue`**

In `resources/js/components/maps/MapExplorer.vue`:

Add the import:

```js
import DetailPanel from './DetailPanel.vue'
```

Add, as the last child inside `<template v-else>`:

```vue
<DetailPanel :pin="selectedPin" @close="selectedPin = null" />
```

- [ ] **Step 3: Manually verify end to end**

Run `vendor/bin/sail yarn run dev`, then in a browser, on a map with at least one group with pins:
1. Click a pin directly on the map — a right-side panel slides in showing that pin's name.
2. Click the panel's close button — the panel disappears.
3. Open the legend (left panel), click a pin's name in the legend — the right panel opens showing the same pin's name.
4. Click a different pin (map or legend) while the panel is already open — the panel updates to the newly selected pin.

- [ ] **Step 4: Commit**

```bash
git add resources/js/components/maps/DetailPanel.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: add pin detail panel, completing the v1 map explorer flow"
```
