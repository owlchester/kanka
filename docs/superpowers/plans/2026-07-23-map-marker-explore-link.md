# Map Marker "Explore" Link Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an "Explore {name}" button to the Vue map explorer's `DetailPanel.vue` when a pin's linked entity is a Map, or a Location with attached maps — restoring a legacy parity gap.

**Architecture:** `PinPreviewResource` gains a `campaign()`-aware `explore_maps` field (array of `{name, url}`); `MarkerController::preview()` threads `$campaign` into it; one new i18n key; `DetailPanel.vue` renders one button per entry.

## Global Constraints

- PHP: explicit return types and parameter type hints on every method touched; curly braces always.
- Never hardcode UI copy — backend strings go through `__()`, Vue strings come from the `i18n` prop.
- `name` in `explore_maps` is always populated (never `null`) — the map entity's own name for the direct-map case, each attached map's name for the Location case. No bare "Explore" fallback string exists or is needed.
- After any PHP change: `vendor/bin/sail bin pint --dirty --format agent`.
- Run tests via `vendor/bin/sail artisan test --compact --filter=<Name>`.

---

### Task 1: `explore_maps` field, i18n, and `DetailPanel.vue` button

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/PinPreviewResource.php`
- Modify: `app/Http/Controllers/Entity/Maps/MarkerController.php`
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify: `resources/js/components/maps/DetailPanel.vue`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`

**Interfaces:**
- Consumes: `Entity::isMap()`/`isLocation()` (`app/Models/Concerns/EntityType.php`, delegates to `EntityType::isMap()`/`isLocation()`); `Location::maps(): HasMany` (`app/Models/Location.php:120-125`, FK `location_id`, eager-loads `entity`); route `entities.map` (`routes/campaigns/entities.php:63`, params `[$campaign, $entity]`); `App\Traits\CampaignAware` (fluent `campaign(Campaign $campaign): self`, already used identically by `PinResource`).
- Produces: `explore_maps: array<{name: string, url: string}>` in the `entities.map-markers.preview` JSON response; `i18n.explore_map` (flat key, `:name` placeholder) in the explore payload — both consumed only by `DetailPanel.vue` in this same task.

- [ ] **Step 1: Write the failing tests**

Add `use App\Models\Location;` to the existing import block at the top of `tests/Feature/Entities/Maps/MarkerControllerTest.php` (alongside the existing `use App\Models\Character;`, `use App\Models\Map;`, etc.), then add these tests anywhere in the file (e.g. after the existing `it('denies edit permission for a player', ...)` block):

```php
it('returns an explore_maps entry when the linked entity is a map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $linkedMap = Map::factory()->create(['campaign_id' => 1, 'name' => 'City Map']);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'entity_id' => $linkedMap->entity->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('explore_maps'))->toBe([
        ['name' => 'City Map', 'url' => route('entities.map', [1, $linkedMap->entity->id])],
    ]);
});

it('returns one explore_maps entry per attached map when the linked entity is a location', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $location = Location::factory()->create(['campaign_id' => 1]);
    $attachedMapA = Map::factory()->create(['campaign_id' => 1, 'location_id' => $location->id, 'name' => 'Overworld']);
    $attachedMapB = Map::factory()->create(['campaign_id' => 1, 'location_id' => $location->id, 'name' => 'Dungeon']);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'entity_id' => $location->entity->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('explore_maps'))->toBe([
        ['name' => 'Overworld', 'url' => route('entities.map', [1, $attachedMapA->entity->id])],
        ['name' => 'Dungeon', 'url' => route('entities.map', [1, $attachedMapB->entity->id])],
    ]);
});

it('returns an empty explore_maps for a location with no attached maps', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $location = Location::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'entity_id' => $location->entity->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('explore_maps'))->toBe([]);
});

it('returns an empty explore_maps for a linked entity that is neither a map nor a location', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'entity_id' => $character->entity->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('explore_maps'))->toBe([]);
});

it('returns an empty explore_maps for a marker with no linked entity', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('explore_maps'))->toBe([]);
});
```

Also extend the existing structure assertion in `it('returns a preview for a marker with an entity, group, and entries', ...)` (line 31) — add `'explore_maps'` to the `assertJsonStructure` array:

```php
->assertJsonStructure(['entity_name', 'entity_url', 'entity_image', 'marker_entry', 'entity_entry', 'type', 'group_name', 'can_edit', 'explore_maps']);
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: FAIL on the new tests and the structure assertion — `explore_maps` doesn't exist in the response yet.

- [ ] **Step 3: Add `explore_maps` to `PinPreviewResource`**

In `app/Http/Resources/Maps/Explore/PinPreviewResource.php`, change:

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
            'entity_name' => $entity?->name,
            'entity_url' => $entity?->url(),
            'entity_image' => $entity && $entity->hasImage() ? Avatar::entity($entity)->size(400, 200)->thumbnail() : null,
            'marker_entry' => $marker->hasEntry() ? $marker->parsedEntry() : null,
            'entity_entry' => $entity && $entity->hasEntry() ? $entity->parsedEntry() : null,
            'type' => $marker->typeLabel(),
            'group_name' => $marker->group?->name,
            'group_colour' => $marker->group?->colour,
            'can_edit' => $canEdit,
        ];
    }
}
```

to:

```php
<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinPreviewResource extends JsonResource
{
    use CampaignAware;

    public function toArray(Request $request): array
    {
        $marker = $this->resource;
        $entity = $marker->entity;
        $canEdit = auth()->check() && auth()->user()->can('update', $marker->map->entity);

        return [
            'entity_name' => $entity?->name,
            'entity_url' => $entity?->url(),
            'entity_image' => $entity && $entity->hasImage() ? Avatar::entity($entity)->size(400, 200)->thumbnail() : null,
            'marker_entry' => $marker->hasEntry() ? $marker->parsedEntry() : null,
            'entity_entry' => $entity && $entity->hasEntry() ? $entity->parsedEntry() : null,
            'type' => $marker->typeLabel(),
            'group_name' => $marker->group?->name,
            'group_colour' => $marker->group?->colour,
            'can_edit' => $canEdit,
            'explore_maps' => $this->exploreMaps($entity),
        ];
    }

    /**
     * @return array<int, array{name: string, url: string}>
     */
    protected function exploreMaps(?Entity $entity): array
    {
        if (! $entity) {
            return [];
        }

        if ($entity->isMap()) {
            return [['name' => $entity->name, 'url' => route('entities.map', [$this->campaign->id, $entity->id])]];
        }

        if ($entity->isLocation() && $entity->child && ! $entity->child->maps->isEmpty()) {
            return $entity->child->maps
                ->map(fn ($map) => ['name' => $map->name, 'url' => route('entities.map', [$this->campaign->id, $map->entity->id])])
                ->all();
        }

        return [];
    }
}
```

- [ ] **Step 4: Thread `$campaign` into the resource from the controller**

In `app/Http/Controllers/Entity/Maps/MarkerController.php`, in `preview()`, change:

```php
return response()->json(new PinPreviewResource($mapMarker));
```

to:

```php
return response()->json(new PinPreviewResource($mapMarker)->campaign($campaign));
```

- [ ] **Step 5: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=MarkerControllerTest`
Expected: PASS (all tests, including the 5 new ones).

- [ ] **Step 6: Add the `explore_map` i18n string**

In `lang/en/maps/explorer.php`, under the `'marker'` array, add a new line right after `'linked_entry' => 'Linked entry',`:

```php
        'explore_map'       => 'Explore :name',
```

In `app/Services/Maps/ExploreApiService.php`, in `translations()`, add a new flat entry right after `'linked_entry' => __('maps/explorer.marker.linked_entry'),`:

```php
            'explore_map' => __('maps/explorer.marker.explore_map'),
```

- [ ] **Step 7: Add the button to `DetailPanel.vue`**

In `resources/js/components/maps/DetailPanel.vue`, insert a new block immediately after the closing `</a>` of the existing `entity_url` linked-entry card (after line 118, before the `marker_entry` block on line 120):

```html
                <a
                    v-for="mapLink in preview.explore_maps"
                    :key="mapLink.url"
                    :href="mapLink.url"
                    class="btn2 btn-primary btn-block"
                >
                    <i class="fa-regular fa-map" aria-hidden="true" />
                    {{ i18n.explore_map.replace(':name', mapLink.name) }}
                </a>
```

- [ ] **Step 8: Build the frontend and verify manually**

Run: `vendor/bin/sail yarn run build` (or ask the user to run `vendor/bin/sail yarn run dev`/`vendor/bin/sail composer run dev` if a dev server is already running).

Then, in the browser:
1. Open a pin linked to a Map entity — confirm a single "Explore {map name}" button appears below the linked-entry card, and clicking it navigates to that map's explore page.
2. Open a pin linked to a Location entity that has two or more attached maps — confirm one "Explore {name}" button per attached map, each navigating correctly.
3. Open a pin linked to a Location entity with no attached maps, or to a non-map/non-location entity (e.g. a Character), or with no linked entity at all — confirm no explore button renders.

- [ ] **Step 9: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Resources/Maps/Explore/PinPreviewResource.php app/Http/Controllers/Entity/Maps/MarkerController.php lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php resources/js/components/maps/DetailPanel.vue tests/Feature/Entities/Maps/MarkerControllerTest.php
git commit -m "feat: add Explore link to map marker detail panel for linked maps/locations"
```
