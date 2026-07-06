# Map Quick-Settings Panel for v4 Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let map editors change zoom bounds, grid spacing, the distance/measurement unit, and map centering directly from the v4 map explorer, without leaving for the legacy full settings form.

**Architecture:** Expose the map's raw (not computed) settings values and three new URLs (settings-update, entity-show, entity-edit) through the existing v4 map API (`MapResource`). Add a dedicated `PATCH` endpoint, namespaced and authorized the same way the existing `entities.map-markers.*` endpoints are, for partial updates to just these fields. On the frontend, the map's name becomes a tippy dropdown trigger (Go to overview / Settings / Edit map), "Settings" opens a new `SettingsPanel.vue` side panel (mirroring `MarkerPanel.vue`'s look and save convention), and centering gets a "pick center on map" mode that reuses the existing `activeMode`/`map-click` plumbing already wired for pin/text placement and the ruler.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API), Leaflet 1.9, tippy.js.

## Global Constraints

- Only these fields are in scope: `grid`, `min_zoom`, `max_zoom`, `initial_zoom`, `config.distance_measure`, `config.distance_name`, `center_x`, `center_y`, `center_marker_id`. Everything else the legacy settings form exposes (`is_real`, `has_clustering`, `is_private`, layers/groups CRUD, image, entry, attributes, tags, template) stays legacy-only, reachable via the new "Edit map" dropdown item.
- Validation bounds for zoom/distance fields must match `app/Http/Requests/StoreMap.php`'s existing rules exactly (`Map::MIN_ZOOM`, `Map::MAX_ZOOM_REAL`, distance factor `0.001`–`100.99`), so the same map is never accepted by one form and rejected by the other.
- The new update endpoint must follow the existing entity-scoped v4 map API convention (`App\Http\Controllers\Entity\Maps\*`, `GuestAuthTrait::authEntityView()`, explicit `EntityPermission::campaign($campaign)` before `$this->authorize('update', $entity)` — see the comment in `App\Http\Controllers\Entity\Maps\MarkerController::preview()` for why the explicit call is required), not the legacy `{map}`-keyed `Maps\*` controllers.
- No automated test coverage exists for Leaflet canvas interactions or Vue component interactions in this app (matching the established pattern from the polygon/circle/path/ruler drawing plans) — frontend verification for Tasks 3–6 is live/manual.
- Centering via "pick on map" and via "use a marker" are mutually exclusive: setting one via the panel must clear the other, both in the frontend form state and in what's persisted (a marker's own position always wins over stale coordinates).

---

### Task 1: Add the settings-update endpoint and expose it on the v4 map API

**Files:**
- Create: `app/Http/Requests/UpdateMapSettings.php`
- Create: `app/Http/Controllers/Entity/Maps/SettingsController.php`
- Modify: `routes/campaigns/entities.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`
- Test: `tests/Feature/Entities/Maps/MapSettingsControllerTest.php` (new)

**Interfaces:**
- Consumes: `App\Models\Map` raw columns `grid`, `min_zoom`, `max_zoom`, `initial_zoom`, `center_x`, `center_y`, `center_marker_id`, `config` (existing), `Map::MIN_ZOOM`/`MAX_ZOOM_REAL` constants (existing), `App\Traits\CampaignAware`/`GuestAuthTrait` (existing, same pattern as `Entity\Maps\MarkerController`).
- Produces: route `entities.map-settings.update` (`PATCH /w/{campaign}/entities/{entity}/map/settings`); the v4 map API's `map` object gains a nested `settings` object (`grid`, `min_zoom`, `max_zoom`, `initial_zoom`, `distance_measure`, `distance_name`, `center_x`, `center_y`, `center_marker_id`) plus `settings_url`, `show_url`, `edit_url` — consumed by Tasks 3–6 (frontend reads/writes it).

This task's pieces are interdependent (the resource's `settings_url` field needs the route to exist to resolve; the endpoint's own tests need the resource's `settings` field to assert against), so they're built and tested together rather than split across tasks — building only one half would leave every existing `entities.map-api` test throwing a `RouteNotFoundException`.

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the existing `assertJsonStructure` call (currently):

```php
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url', 'has_distance_unit', 'distance_measure', 'distance_name'],
```

to:

```php
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url', 'has_distance_unit', 'distance_measure', 'distance_name', 'settings' => ['grid', 'min_zoom', 'max_zoom', 'initial_zoom', 'distance_measure', 'distance_name', 'center_x', 'center_y', 'center_marker_id'], 'settings_url', 'show_url', 'edit_url'],
```

Then append two new tests to the end of the same file:

```php
it('exposes a map\'s raw settings values and edit urls for the quick-settings panel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'center_x' => 12.5,
        'center_y' => 34.5,
        'config' => ['distance_measure' => 0.5, 'distance_name' => 'Leagues'],
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings'))->toBe([
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'distance_measure' => 0.5,
        'distance_name' => 'Leagues',
        'center_x' => 12.5,
        'center_y' => 34.5,
        'center_marker_id' => null,
    ]);
    expect($response->json('map.settings_url'))->toBe(route('entities.map-settings.update', [1, $map->entity->id]));
    expect($response->json('map.show_url'))->toBe(route('entities.show', [1, $map->entity->id]));
    expect($response->json('map.edit_url'))->toBe(route('entities.edit', [1, $map->entity->id]));
});

it('returns null settings values for a map with none configured', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => []]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings'))->toBe([
        'grid' => null,
        'min_zoom' => null,
        'max_zoom' => null,
        'initial_zoom' => null,
        'distance_measure' => null,
        'distance_name' => null,
        'center_x' => null,
        'center_y' => null,
        'center_marker_id' => null,
    ]);
});
```

Create `tests/Feature/Entities/Maps/MapSettingsControllerTest.php`:

```php
<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

it('updates a map\'s quick settings and returns the updated MapResource', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => ['distance_measure' => 1, 'distance_name' => 'Km']]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'distance_measure' => 0.5,
        'distance_name' => 'Leagues',
        'center_x' => 12.5,
        'center_y' => 34.5,
    ])->assertStatus(200);

    expect($response->json('settings.grid'))->toBe(50);
    expect($response->json('settings.min_zoom'))->toBe(2);
    expect($response->json('settings.max_zoom'))->toBe(8);
    expect($response->json('settings.initial_zoom'))->toBe(4);
    expect($response->json('settings.distance_measure'))->toBe(0.5);
    expect($response->json('settings.distance_name'))->toBe('Leagues');
    expect($response->json('settings.center_x'))->toBe(12.5);
    expect($response->json('settings.center_y'))->toBe(34.5);

    $map->refresh();
    expect($map->grid)->toBe(50);
    expect($map->config)->toBe(['distance_measure' => 0.5, 'distance_name' => 'Leagues']);
});

it('sets a center_marker_id and clears any existing center_x/center_y', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_marker_id' => $marker->id,
    ])->assertStatus(200);

    $map->refresh();
    expect($map->center_marker_id)->toBe($marker->id);
    expect($map->center_x)->toBeNull();
    expect($map->center_y)->toBeNull();
});

it('sets center_x/center_y and clears any existing center_marker_id', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $map->update(['center_marker_id' => $marker->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_x' => 5,
        'center_y' => 6,
    ])->assertStatus(200);

    $map->refresh();
    expect($map->center_marker_id)->toBeNull();
    expect((float) $map->center_x)->toBe(5.0);
    expect((float) $map->center_y)->toBe(6.0);
});

it('422s when center_marker_id belongs to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_marker_id' => $marker->id,
    ])->assertStatus(422);
});

it('422s when min_zoom is out of range', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'min_zoom' => -999,
    ])->assertStatus(422);
});

it('422s when distance_measure is out of range', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'distance_measure' => 500,
    ])->assertStatus(422);
});

it('403s for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
    ])->assertStatus(403);

    expect($map->fresh()->grid)->not->toBe(50);
});

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->patchJson(route('entities.map-settings.update', [1, $entity]), [
        'grid' => 50,
    ])->assertStatus(404);
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="MapSettingsControllerTest|quick-settings panel|none configured|returns the full explore payload"`
Expected: FAIL/ERROR across the board — the route, controller, and `MapResource` fields referenced by these tests don't exist yet.

- [ ] **Step 3: Create the form request**

Create `app/Http/Requests/UpdateMapSettings.php`:

```php
<?php

namespace App\Http\Requests;

use App\Models\Map;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMapSettings extends FormRequest
{
    use ApiRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'grid' => 'nullable|integer|min:1',
            'min_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'max_zoom' => 'nullable|numeric|min:1|max:' . Map::MAX_ZOOM,
            'initial_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'distance_measure' => 'nullable|numeric|min:0.001|max:100.99',
            'distance_name' => 'nullable|string|max:20',
            'center_x' => 'nullable|numeric',
            'center_y' => 'nullable|numeric',
            'center_marker_id' => [
                'nullable',
                'integer',
                Rule::exists('map_markers', 'id')->where(function ($query) {
                    $entity = $this->route('entity');
                    $query->where('map_id', $entity?->child?->id);
                }),
            ],
        ];

        return $this->clean($rules);
    }
}
```

- [ ] **Step 4: Create the controller**

Create `app/Http/Controllers/Entity/Maps/SettingsController.php`:

```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMapSettings;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class SettingsController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function update(UpdateMapSettings $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        // See the comment in Entity\Maps\MarkerController::preview() - authorize() needs the
        // permission service explicitly scoped to this campaign, otherwise it falls back to
        // EntityPermission::loadAllPermissions()'s "no campaign set" admin bypass.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $map = $entity->child;
        $data = $request->validated();

        $config = $map->config ?? [];
        if (array_key_exists('distance_measure', $data)) {
            $config['distance_measure'] = $data['distance_measure'];
        }
        if (array_key_exists('distance_name', $data)) {
            $config['distance_name'] = $data['distance_name'];
        }
        unset($data['distance_measure'], $data['distance_name']);
        $data['config'] = $config;

        if (array_key_exists('center_marker_id', $data) && ! empty($data['center_marker_id'])) {
            $data['center_x'] = null;
            $data['center_y'] = null;
        } elseif (array_key_exists('center_x', $data) || array_key_exists('center_y', $data)) {
            $data['center_marker_id'] = null;
        }

        $map->update($data);

        return response()->json(new MapResource($map)->campaign($campaign));
    }
}
```

- [ ] **Step 5: Add the route**

In `routes/campaigns/entities.php`, add the import alongside the other `Entity\Maps` controller imports — change:

```php
use App\Http\Controllers\Entity\Maps\ApiController as EntityMapApiController;
use App\Http\Controllers\Entity\Maps\MarkerController as EntityMapMarkerController;
use App\Http\Controllers\Entity\Maps\ShowController as EntityMapShowController;
```

to:

```php
use App\Http\Controllers\Entity\Maps\ApiController as EntityMapApiController;
use App\Http\Controllers\Entity\Maps\MarkerController as EntityMapMarkerController;
use App\Http\Controllers\Entity\Maps\SettingsController as EntityMapSettingsController;
use App\Http\Controllers\Entity\Maps\ShowController as EntityMapShowController;
```

Then add the route next to the other `entities.map-*` routes — change:

```php
Route::get('/w/{campaign}/entities/{entity}/map-api', [EntityMapApiController::class, 'index'])->name('entities.map-api');
Route::get('/w/{campaign}/entities/{entity}/map', [EntityMapShowController::class, 'index'])->name('entities.map');
```

to:

```php
Route::get('/w/{campaign}/entities/{entity}/map-api', [EntityMapApiController::class, 'index'])->name('entities.map-api');
Route::get('/w/{campaign}/entities/{entity}/map', [EntityMapShowController::class, 'index'])->name('entities.map');
Route::patch('/w/{campaign}/entities/{entity}/map/settings', [EntityMapSettingsController::class, 'update'])->name('entities.map-settings.update');
```

- [ ] **Step 6: Add the fields to `MapResource`**

In `app/Http/Resources/Maps/Explore/MapResource.php`, change:

```php
            'has_distance_unit' => $map->hasDistanceUnit(),
            'distance_measure' => $map->config['distance_measure'] ?? null,
            'distance_name' => $map->config['distance_name'] ?? 'Km',
        ];
```

to:

```php
            'has_distance_unit' => $map->hasDistanceUnit(),
            'distance_measure' => $map->config['distance_measure'] ?? null,
            'distance_name' => $map->config['distance_name'] ?? 'Km',
            'settings' => [
                'grid' => $map->grid !== null ? (int) $map->grid : null,
                'min_zoom' => $map->min_zoom !== null ? (int) $map->min_zoom : null,
                'max_zoom' => $map->max_zoom !== null ? (int) $map->max_zoom : null,
                'initial_zoom' => $map->initial_zoom !== null ? (int) $map->initial_zoom : null,
                'distance_measure' => $map->config['distance_measure'] ?? null,
                'distance_name' => $map->config['distance_name'] ?? null,
                'center_x' => $map->center_x !== null ? (float) $map->center_x : null,
                'center_y' => $map->center_y !== null ? (float) $map->center_y : null,
                'center_marker_id' => $map->center_marker_id,
            ],
            'settings_url' => route('entities.map-settings.update', [$this->campaign->id, $map->entity->id]),
            'show_url' => route('entities.show', [$this->campaign->id, $map->entity->id]),
            'edit_url' => route('entities.edit', [$this->campaign->id, $map->entity->id]),
        ];
```

- [ ] **Step 7: Run all of this task's tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="MapSettingsControllerTest|quick-settings panel|none configured|returns the full explore payload"`
Expected: all passing.

- [ ] **Step 8: Commit**

```bash
git add app/Http/Requests/UpdateMapSettings.php app/Http/Controllers/Entity/Maps/SettingsController.php routes/campaigns/entities.php app/Http/Resources/Maps/Explore/MapResource.php tests/Feature/Entities/Maps/MapSettingsControllerTest.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add a v4 map settings-update endpoint and expose it on the map API"
```

---

### Task 2: Add i18n strings for the header dropdown and settings panel

**Files:**
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: none new.
- Produces: `i18n.header.{overview,settings,edit}` and `i18n.settings.{title,grid,zoom_min,zoom_max,zoom_initial,distance_name,distance_measure,center,center_coordinates,center_marker,pick_on_map,picking,no_marker,save,error_save}` — consumed by Task 4's header dropdown and Task 5/6's `SettingsPanel.vue`.

- [ ] **Step 1: Write the failing test**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the `i18n` line inside the `assertJsonStructure` call (currently):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
```

to:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save']],
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload"`
Expected: FAIL — `header` and `settings` keys missing from the actual `i18n` response.

- [ ] **Step 3: Add the translation strings**

In `lang/en/maps/explorer.php`, change the closing of the array (currently ending with):

```php
    'ungrouped' => 'Ungrouped',
];
```

to:

```php
    'ungrouped' => 'Ungrouped',
    'header'    => [
        'overview'  => 'Go to overview',
        'settings'  => 'Settings',
        'edit'      => 'Edit map',
    ],
    'settings'  => [
        'title'                 => 'Map settings',
        'grid'                  => 'Grid spacing',
        'zoom_min'              => 'Minimum zoom',
        'zoom_max'              => 'Maximum zoom',
        'zoom_initial'          => 'Initial zoom',
        'distance_name'         => 'Distance unit name',
        'distance_measure'      => 'Distance unit factor',
        'center'                => 'Center',
        'center_coordinates'    => 'Coordinates',
        'center_marker'         => 'Marker',
        'pick_on_map'           => 'Pick center on map',
        'picking'               => 'Click the map to set the center...',
        'no_marker'             => 'None selected',
        'save'                  => 'Save',
        'error_save'            => 'Unable to save these settings.',
    ],
];
```

- [ ] **Step 4: Wire the strings into `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, change:

```php
                'helper' => [
                    'pin' => __('maps/explorer.toolbar.helper.pin'),
                    'text' => __('maps/explorer.toolbar.helper.text'),
                    'area' => __('maps/explorer.toolbar.helper.area'),
                    'circle' => __('maps/explorer.toolbar.helper.circle'),
                    'path' => __('maps/explorer.toolbar.helper.path'),
                ],
            ],
        ];
    }
```

to:

```php
                'helper' => [
                    'pin' => __('maps/explorer.toolbar.helper.pin'),
                    'text' => __('maps/explorer.toolbar.helper.text'),
                    'area' => __('maps/explorer.toolbar.helper.area'),
                    'circle' => __('maps/explorer.toolbar.helper.circle'),
                    'path' => __('maps/explorer.toolbar.helper.path'),
                ],
            ],
            'header' => [
                'overview' => __('maps/explorer.header.overview'),
                'settings' => __('maps/explorer.header.settings'),
                'edit' => __('maps/explorer.header.edit'),
            ],
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps/explorer.settings.grid'),
                'zoom_min' => __('maps/explorer.settings.zoom_min'),
                'zoom_max' => __('maps/explorer.settings.zoom_max'),
                'zoom_initial' => __('maps/explorer.settings.zoom_initial'),
                'distance_name' => __('maps/explorer.settings.distance_name'),
                'distance_measure' => __('maps/explorer.settings.distance_measure'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps/explorer.settings.center_coordinates'),
                'center_marker' => __('maps/explorer.settings.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'save' => __('maps/explorer.settings.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
        ];
    }
```

- [ ] **Step 5: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter="returns the full explore payload"`
Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add i18n strings for the map header dropdown and settings panel"
```

---

### Task 3: Render the grid overlay in the v4 explorer

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `props.map.settings.grid`, `props.map.width`, `props.map.height` (Task 1).
- Produces: a `buildGrid()` function and `gridLayer` module variable, following the same build/rebuild pattern as `buildPins()`/`pinLayer` — no new props or emits, so nothing outside this file depends on it.

**Global Constraints reminder:** no automated test exists for Leaflet canvas rendering in this app; this task's verification is manual.

- [ ] **Step 1: Add the grid-layer variable and build function**

In `resources/js/components/maps/LeafletCanvas.vue`, change:

```js
let draftPath = null
let pathEditing = false
let rulerControl = null
```

to:

```js
let draftPath = null
let pathEditing = false
let rulerControl = null
let gridLayer = null

function buildGrid() {
    if (gridLayer) {
        leafletMap.removeLayer(gridLayer)
        gridLayer = null
    }

    const grid = props.map.settings?.grid
    if (! grid) {
        return
    }

    gridLayer = L.layerGroup()

    for (let i = grid; i <= props.map.height; i += grid) {
        L.polyline([[i, 0], [i, props.map.width]], { color: 'grey', opacity: 0.5 }).addTo(gridLayer)
    }

    for (let i = grid; i <= props.map.width; i += grid) {
        L.polyline([[0, i], [props.map.height, i]], { color: 'grey', opacity: 0.5 }).addTo(gridLayer)
    }

    gridLayer.addTo(leafletMap)
}
```

- [ ] **Step 2: Call it on mount and rebuild it when settings change**

Change:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()

    if (props.map.has_distance_unit) {
```

to:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildGrid()

    if (props.map.has_distance_unit) {
```

Then add a watcher next to the existing `watch(() => props.pins, ...)` block — change:

```js
watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})
```

to:

```js
watch(() => props.pins, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.map.settings?.grid, () => {
    if (leafletMap) {
        buildGrid()
    }
})
```

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify grid rendering**

Using `vendor/bin/sail artisan tinker --execute 'App\Models\Map::find(<id>)->update(["grid" => 100]);'` on a map with a known `width`/`height` (or via the legacy settings form's "Grid" field), open that map in the v4 explorer and confirm evenly-spaced grey grid lines appear across the whole image, matching what the legacy explorer shows for the same map. Then clear the grid value (`grid: null`) and confirm the lines disappear.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: render the grid overlay in the v4 map explorer"
```

---

### Task 4: Header dropdown — Go to overview / Settings / Edit map

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `data.map.show_url`/`edit_url`/`name` (Task 1), `data.i18n.header.*` (Task 2), existing `props.canEdit`.
- Produces: a `settingsOpen` ref and `openSettings()` function — consumed by Task 5, which renders `<SettingsPanel :open="settingsOpen" ...>` bound to this same ref.

**Global Constraints reminder:** no automated test exists for Vue component interaction in this app; this task's verification is manual.

- [ ] **Step 1: Replace the static header with a dropdown trigger**

In `resources/js/components/maps/MapExplorer.vue`, change:

```html
            <div>
                <h1 class="text-lg font-semibold leading-tight">
                    {{ data.map.name }}
                </h1>
                <p class="text-sm text-neutral-content">{{ markersCountText }}</p>
            </div>
```

to:

```html
            <div>
                <button
                    class="text-lg font-semibold leading-tight cursor-pointer"
                    :ref="el => (mapMenuBtnRef = el)"
                >
                    {{ data.map.name }}
                </button>
                <div ref="mapMenuRef" class="flex flex-col gap-1">
                    <a
                        :href="data.map.show_url"
                        class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content"
                    >
                        <i class="fa-regular fa-arrow-right w-5 text-center text-neutral-content" aria-hidden="true" />
                        <span>{{ data.i18n.header.overview }}</span>
                    </a>
                    <template v-if="canEdit">
                        <button
                            type="button"
                            class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content text-left w-full"
                            @click="openSettings"
                        >
                            <i class="fa-regular fa-gear w-5 text-center text-neutral-content" aria-hidden="true" />
                            <span>{{ data.i18n.header.settings }}</span>
                        </button>
                        <a
                            :href="data.map.edit_url"
                            class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content"
                        >
                            <i class="fa-regular fa-pencil w-5 text-center text-neutral-content" aria-hidden="true" />
                            <span>{{ data.i18n.header.edit }}</span>
                        </a>
                    </template>
                </div>
                <p class="text-sm text-neutral-content">{{ markersCountText }}</p>
            </div>
```

- [ ] **Step 2: Wire up the tippy dropdown and the settings-open state**

Change the script imports from:

```js
import { ref, computed, onMounted } from "vue";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";
```

to:

```js
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";
```

Change the state declarations from:

```js
const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], visibilities: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);
const rapid = ref(false);
```

to:

```js
const loading = ref(true);
const error = ref(null);
const data = ref({ map: {}, layers: [], groups: [], pins: [], visibilities: [], i18n: {} });
const legendOpen = ref(false);
const selectedPin = ref(null);
const centerNonce = ref(0);
const activeMode = ref(null);
const draftPin = ref(null);
const rapid = ref(false);
const settingsOpen = ref(false);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;

function openSettings() {
    mapMenuInstance?.hide();
    settingsOpen.value = true;
}
```

Change `onMounted` from:

```js
onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }
});
```

to:

```js
onMounted(async () => {
    try {
        const res = await axios.get(props.api);
        data.value = res.data;
    } catch (e) {
        error.value = props.errorText;
    } finally {
        loading.value = false;
    }

    await nextTick();

    if (mapMenuBtnRef.value && mapMenuRef.value) {
        mapMenuInstance = tippy(mapMenuBtnRef.value, {
            content: mapMenuRef.value,
            theme: "kanka-dropdown",
            placement: "bottom-start",
            interactive: true,
            trigger: "click",
            allowHTML: true,
            arrow: true,
            zIndex: 890,
        });
    }
});

onBeforeUnmount(() => {
    mapMenuInstance?.destroy();
});
```

- [ ] **Step 3: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 4: Manually verify the dropdown**

Open a map you can edit in the v4 explorer: click the map name, confirm a dropdown appears with "Go to overview", "Settings", "Edit map". Confirm "Go to overview" navigates to the entity's normal show page, and "Edit map" navigates to the legacy edit form. Confirm clicking "Settings" closes the dropdown (the panel itself renders empty/inert until Task 5 — that's expected here). Then view the same map as a non-editor (or log in as a Player) and confirm only "Go to overview" appears.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: add a header dropdown to the v4 map explorer (overview/settings/edit)"
```

---

### Task 5: Settings panel — grid, zoom, and distance unit

**Files:**
- Create: `resources/js/components/maps/SettingsPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `data.map.settings`/`settings_url` (Task 1), `data.i18n.settings` (Task 2), `settingsOpen` (Task 4).
- Produces: `SettingsPanel.vue` emits `close` and `saved` (the updated map resource) — `saved` is handled by replacing `data.map` in `MapExplorer.vue`, which flows down to `LeafletCanvas.vue` the same way every other map-level setting already does. Task 6 extends this same component and payload with centering fields.

**Global Constraints reminder:** no automated test exists for Vue component interaction in this app; this task's verification is manual.

- [ ] **Step 1: Create `SettingsPanel.vue`**

Create `resources/js/components/maps/SettingsPanel.vue`:

```vue
<template>
    <aside
        v-if="open"
        class="fixed top-4 right-4 bottom-4 w-80 bg-base-100 shadow-lg z-[1150] flex flex-col rounded-2xl overflow-hidden"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <h2 class="text-sm font-semibold uppercase tracking-wide">
                {{ i18n.title }}
            </h2>
            <button
                class="btn2 btn-default btn-sm flex-none"
                :disabled="saving"
                @click="$emit('close')"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.grid }}
                <input v-model.number="form.grid" type="number" min="1" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_min }}
                <input v-model.number="form.min_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_max }}
                <input v-model.number="form.max_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.zoom_initial }}
                <input v-model.number="form.initial_zoom" type="number" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_name }}
                <input v-model="form.distance_name" type="text" maxlength="20" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_measure }}
                <input v-model.number="form.distance_measure" type="number" min="0.001" max="100.99" step="0.0001" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <button
                class="btn2 btn-primary"
                :disabled="saving"
                @click="save"
            >
                {{ i18n.save }}
            </button>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
</template>

<script setup>
import { reactive, ref, watch } from "vue";

const props = defineProps({
    open: { type: Boolean, default: false },
    map: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["close", "saved"]);

const saving = ref(false);
const error = ref(null);

const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
});

watch(
    () => props.open,
    (isOpen) => {
        if (!isOpen) {
            return;
        }

        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        error.value = null;
    },
);

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
        });
        emit("saved", res.data);
        emit("close");
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
</script>
```

- [ ] **Step 2: Wire it into `MapExplorer.vue`**

Change the import list from:

```js
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import Toolbar from "./Toolbar.vue";
```

to:

```js
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

Add the component to the template, right after the `<Toolbar>` block — change:

```html
        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            :rapid="rapid"
            @mode-change="handleModeChange"
            @rapid-change="rapid = $event"
        />
    </template>
</template>
```

to:

```html
        <Toolbar
            :i18n="data.i18n"
            :can-edit="canEdit"
            :active-mode="activeMode"
            :rapid="rapid"
            @mode-change="handleModeChange"
            @rapid-change="rapid = $event"
        />

        <SettingsPanel
            :open="settingsOpen"
            :map="data.map"
            :i18n="data.i18n.settings"
            @close="settingsOpen = false"
            @saved="handleSettingsSaved"
        />
    </template>
</template>
```

Add the handler next to `handleMeasureChange` — change:

```js
function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
    }
}
```

to:

```js
function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
    }
}

function handleSettingsSaved(map) {
    data.value.map = map;
}
```

- [ ] **Step 3: Make zoom bounds and the ruler react live to settings changes**

`LeafletCanvas.vue` currently only applies `min_zoom`/`max_zoom`/the ruler's `factor`/`display` once, in `onMounted`'s `L.map(...)` call and ruler instantiation. Since `handleSettingsSaved` replaces the whole `data.map` object, `props.map` changes but nothing re-applies these to the live Leaflet instance. Extract ruler creation into a reusable function and add watchers for both.

Change:

```js
    if (props.map.has_distance_unit) {
        rulerControl = L.control.ruler({
            // Leaflet's control default is 'topright', which sits directly under
            // DetailPanel/MarkerPanel (fixed top-4 right-4 bottom-4) and becomes
            // fully hidden and unclickable whenever a pin is selected or a draft
            // is open. 'bottomleft' keeps it reachable, stacked with the zoom
            // control which was placed there for the same reason.
            position: 'bottomleft',
            lengthUnit: {
                factor: props.map.distance_measure,
                display: props.map.distance_name,
                decimal: 2,
            },
            onToggle: (active) => emit('measure-change', active),
        }).addTo(leafletMap)
    }

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

to:

```js
    buildRuler()

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

Add `buildRuler()` next to `buildGrid()` (defined in Task 3), and add the two live-update watchers next to the existing `watch(() => props.map.settings?.grid, ...)` watcher:

```js
function buildRuler() {
    if (rulerControl) {
        leafletMap.removeControl(rulerControl)
        rulerControl = null
    }

    if (! props.map.has_distance_unit) {
        return
    }

    rulerControl = L.control.ruler({
        // Leaflet's control default is 'topright', which sits directly under
        // DetailPanel/MarkerPanel (fixed top-4 right-4 bottom-4) and becomes
        // fully hidden and unclickable whenever a pin is selected or a draft
        // is open. 'bottomleft' keeps it reachable, stacked with the zoom
        // control which was placed there for the same reason.
        position: 'bottomleft',
        lengthUnit: {
            factor: props.map.distance_measure,
            display: props.map.distance_name,
            decimal: 2,
        },
        onToggle: (active) => emit('measure-change', active),
    }).addTo(leafletMap)
}

watch(() => props.map.settings?.grid, () => {
    if (leafletMap) {
        buildGrid()
    }
})

watch(() => [props.map.min_zoom, props.map.max_zoom], ([min, max]) => {
    if (leafletMap) {
        leafletMap.setMinZoom(min)
        leafletMap.setMaxZoom(max)
    }
})

watch(() => [props.map.has_distance_unit, props.map.distance_measure, props.map.distance_name], () => {
    if (leafletMap) {
        buildRuler()
    }
})
```

(The `watch(() => props.map.settings?.grid, ...)` block already exists from Task 3 — do not duplicate it; only add the two new watchers above.)

- [ ] **Step 4: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 5: Manually verify the settings panel**

As an editor, open a map in the v4 explorer, click the map name → Settings. Confirm the panel shows the map's current grid/zoom/distance values (blank if unset). Change the grid spacing and save — confirm the panel closes and the grid overlay updates immediately without a page reload. Change `min_zoom`/`max_zoom` to a narrower range and save — confirm you can no longer zoom past the new bounds. Change the distance unit name/factor and save — confirm the ruler control (if you toggle it on) now reports distances in the new unit. Reload the page and confirm all changes persisted.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/SettingsPanel.vue resources/js/components/maps/MapExplorer.vue resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: add a quick-settings panel for grid/zoom/distance unit to the v4 explorer"
```

---

### Task 6: Centering — click-to-set and marker picker

**Files:**
- Modify: `resources/js/components/maps/SettingsPanel.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `data.pins` (existing, for the marker picker), `activeMode`/`handleMapClick` (existing, extended here), `data.i18n.settings.{center,center_coordinates,center_marker,pick_on_map,picking,no_marker}` (Task 2).
- Produces: a new `activeMode` value `'center-pick'`; `SettingsPanel.vue` gains a `pins` prop and emits `pick-center`; `MapExplorer.vue` gains a `pendingCenter` ref passed down to the panel.

**Global Constraints reminder:** no automated test exists for Vue/Leaflet interaction in this app; this task's verification is manual.

- [ ] **Step 1: Let `LeafletCanvas.vue` capture clicks for `center-pick` mode**

Change:

```js
    leafletMap.on('click', (e) => {
        if (props.activeMode === 'pin' || props.activeMode === 'text') {
            emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng })
        }
    })
```

to:

```js
    leafletMap.on('click', (e) => {
        if (props.activeMode === 'pin' || props.activeMode === 'text' || props.activeMode === 'center-pick') {
            emit('map-click', { lat: e.latlng.lat, lng: e.latlng.lng })
        }
    })
```

Add a crosshair cursor while picking, next to the existing `watch(() => props.activeMode, (mode) => {...})` ruler-disable watcher — change:

```js
watch(() => props.activeMode, (mode) => {
    if (mode && rulerControl) {
        rulerControl.disable()
    }
})
```

to:

```js
watch(() => props.activeMode, (mode) => {
    if (mode && rulerControl) {
        rulerControl.disable()
    }

    if (leafletMap) {
        leafletMap.getContainer().style.cursor = mode === 'center-pick' ? 'crosshair' : ''
    }
})
```

- [ ] **Step 2: Route `center-pick` clicks in `MapExplorer.vue` to a pending-center value instead of creating a pin**

Add a `pendingCenter` ref next to `settingsOpen` — change:

```js
const settingsOpen = ref(false);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;
```

to:

```js
const settingsOpen = ref(false);
const pendingCenter = ref(null);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;
```

Change `handleMapClick` from:

```js
function handleMapClick({ lat, lng }) {
    if (activeMode.value !== "pin" && activeMode.value !== "text") {
        return;
    }
```

to:

```js
function handleMapClick({ lat, lng }) {
    if (activeMode.value === "center-pick") {
        pendingCenter.value = { lat, lng };
        activeMode.value = null;

        return;
    }

    if (activeMode.value !== "pin" && activeMode.value !== "text") {
        return;
    }
```

Pass `pendingCenter` and `pins` to `<SettingsPanel>`, and add a handler for its `pick-center` emit — change:

```html
        <SettingsPanel
            :open="settingsOpen"
            :map="data.map"
            :i18n="data.i18n.settings"
            @close="settingsOpen = false"
            @saved="handleSettingsSaved"
        />
```

to:

```html
        <SettingsPanel
            :open="settingsOpen"
            :map="data.map"
            :pins="data.pins"
            :i18n="data.i18n.settings"
            :pending-center="pendingCenter"
            @close="settingsOpen = false"
            @saved="handleSettingsSaved"
            @pick-center="handleModeChange('center-pick')"
        />
```

- [ ] **Step 3: Add centering fields to `SettingsPanel.vue`**

Change the props/emits from:

```js
const props = defineProps({
    open: { type: Boolean, default: false },
    map: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["close", "saved"]);
```

to:

```js
const props = defineProps({
    open: { type: Boolean, default: false },
    map: { type: Object, required: true },
    pins: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
    pendingCenter: { type: Object, default: null },
});

const emit = defineEmits(["close", "saved", "pick-center"]);
```

Change the `form` reactive object and add a `centerMode` ref — change:

```js
const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
});
```

to:

```js
const form = reactive({
    grid: null,
    min_zoom: null,
    max_zoom: null,
    initial_zoom: null,
    distance_name: null,
    distance_measure: null,
    center_x: null,
    center_y: null,
    center_marker_id: null,
});

const centerMode = ref("coordinates");
```

Change the `watch(() => props.open, ...)` block to also seed centering state — change:

```js
watch(
    () => props.open,
    (isOpen) => {
        if (!isOpen) {
            return;
        }

        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        error.value = null;
    },
);
```

to:

```js
watch(
    () => props.open,
    (isOpen) => {
        if (!isOpen) {
            return;
        }

        const settings = props.map.settings || {};
        form.grid = settings.grid;
        form.min_zoom = settings.min_zoom;
        form.max_zoom = settings.max_zoom;
        form.initial_zoom = settings.initial_zoom;
        form.distance_name = settings.distance_name;
        form.distance_measure = settings.distance_measure;
        form.center_x = settings.center_x;
        form.center_y = settings.center_y;
        form.center_marker_id = settings.center_marker_id;
        centerMode.value = settings.center_marker_id ? "marker" : "coordinates";
        error.value = null;
    },
);

watch(
    () => props.pendingCenter,
    (center) => {
        if (!center) {
            return;
        }

        form.center_x = center.lng;
        form.center_y = center.lat;
        form.center_marker_id = null;
        centerMode.value = "coordinates";
    },
);

function pickOnMap() {
    emit("pick-center");
}

function selectCenterMarker(markerId) {
    form.center_marker_id = markerId;
    centerMode.value = "marker";
}
```

Change the `save()` payload from:

```js
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
        });
```

to:

```js
        const res = await axios.patch(props.map.settings_url, {
            grid: form.grid,
            min_zoom: form.min_zoom,
            max_zoom: form.max_zoom,
            initial_zoom: form.initial_zoom,
            distance_name: form.distance_name,
            distance_measure: form.distance_measure,
            center_x: centerMode.value === "coordinates" ? form.center_x : null,
            center_y: centerMode.value === "coordinates" ? form.center_y : null,
            center_marker_id: centerMode.value === "marker" ? form.center_marker_id : null,
        });
```

Add the centering UI to the template, after the distance-measure `<label>` and before the closing `</div>` of the scrollable fields section — change:

```html
            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_measure }}
                <input v-model.number="form.distance_measure" type="number" min="0.001" max="100.99" step="0.0001" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>
        </div>
```

to:

```html
            <label class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wide text-neutral-content">
                {{ i18n.distance_measure }}
                <input v-model.number="form.distance_measure" type="number" min="0.001" max="100.99" step="0.0001" class="input input-bordered w-full normal-case text-sm font-normal" />
            </label>

            <div class="flex flex-col gap-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.center }}</span>

                <div class="flex gap-1">
                    <button
                        type="button"
                        class="btn2 btn-sm grow"
                        :class="centerMode === 'coordinates' ? 'btn-primary' : 'btn-default'"
                        @click="centerMode = 'coordinates'"
                    >
                        {{ i18n.center_coordinates }}
                    </button>
                    <button
                        type="button"
                        class="btn2 btn-sm grow"
                        :class="centerMode === 'marker' ? 'btn-primary' : 'btn-default'"
                        @click="centerMode = 'marker'"
                    >
                        {{ i18n.center_marker }}
                    </button>
                </div>

                <button
                    v-if="centerMode === 'coordinates'"
                    type="button"
                    class="btn2 btn-outline btn-sm"
                    @click="pickOnMap"
                >
                    {{ i18n.pick_on_map }}
                </button>

                <select
                    v-else
                    v-model="form.center_marker_id"
                    class="select select-bordered w-full"
                    @change="selectCenterMarker(form.center_marker_id)"
                >
                    <option :value="null">{{ i18n.no_marker }}</option>
                    <option v-for="pin in pins" :key="pin.id" :value="pin.id">{{ pin.name }}</option>
                </select>
            </div>
        </div>
```

- [ ] **Step 4: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 5: Manually verify centering**

Open the settings panel, choose "Coordinates", click "Pick center on map", confirm the cursor turns to a crosshair and any in-progress pin/circle/area/path draft is cancelled. Click a point on the map — confirm the click doesn't create a pin, the crosshair mode exits, and (reopening the panel if it auto-closed, or checking it's still open) the coordinates fields now reflect that point. Save, reload the page, and confirm the map now centers there. Then switch to "Marker", pick one of the map's existing pins from the dropdown, save, reload, and confirm the map centers on that marker instead. Switch back to "Coordinates" and save again — confirm `center_marker_id` is cleared (the marker no longer determines centering).

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/SettingsPanel.vue resources/js/components/maps/MapExplorer.vue resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: add click-to-set and marker-based centering to the map settings panel"
```

---

### Task 7: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the full backend test suite for maps**

```bash
vendor/bin/sail artisan test --compact --filter=Maps
```

Expected: all passing.

- [ ] **Step 2: Run Pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Expected: no remaining style issues (Pint auto-fixes; re-run `git status`/`git diff` afterward to confirm nothing unexpected changed).

- [ ] **Step 3: Full manual walkthrough**

Using a map you can edit:
1. Click the map name — confirm the dropdown shows all three items; each navigates/opens correctly.
2. As a non-editor, confirm only "Go to overview" shows.
3. Open Settings, change every field (grid, min/max/initial zoom, distance name/factor, both centering modes), save, and confirm each change is visibly reflected in the live map without a reload, and persists after an actual reload.
4. Confirm starting a pin/circle/area/path draft or the ruler while "pick center on map" is active cancels the center-pick (and vice versa) — mirroring the existing mode-conflict behavior already established for the ruler.
5. Confirm the legacy map settings form (`entities.edit` → Settings tab) still works unchanged and both forms agree on the same underlying values (edit in one, refresh the other, confirm they match).

- [ ] **Step 4: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in map quick-settings panel end-to-end verification"
```
