# Inline Marker Editing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let a map editor fully edit an existing marker (pin, label, circle, polygon, or path) directly on the v4 map explorer — dragging/reshaping its geometry live and changing any of its fields — without leaving the page, plus a mobile-friendly "peek" affordance so the panel doesn't permanently block the map on small screens.

**Architecture:** A new `PATCH entities.map-markers.update` endpoint (mirroring the existing `store`/`preview`/`destroy` trio) persists full-field updates and returns `PinResource`, which gains the extra raw fields (`shape_id`, `icon_id`, `custom_icon`, `entity_id`, `entity_name`, `visibility_id`, `update_url`) needed to pre-fill an edit form. On the frontend, `MapExplorer.vue` gains a fourth pin-state, `editingPin` (a staged local copy, separate from `draftPin`/`selectedPin`), fed to a generalized `MarkerPanel.vue` (now `variant: 'create' | 'edit'`) and to `LeafletCanvas.vue` (new `editingPin` prop), which renders a live-editable version of that one marker's actual geometry — via Leaflet.Editable's `enableEdit()` on the existing shape, not the "draw a new shape from scratch" `editTools.startX()` path already used for drafts — while hiding its static counterpart. Nothing is sent to the server until the panel's Save button is clicked; Cancel discards everything.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Vue 3 (Composition API), Leaflet 1.9 + `leaflet-editable` (existing dependency).

## Global Constraints

- Staged save: all geometry drags/resizes/reshapes and all field edits are held in `editingPin` and sent together in one `PATCH` on Save. Cancel discards everything, including geometry drags — nothing is persisted mid-edit.
- Dragging/reshaping during edit mode is always allowed for an editor, regardless of the marker's own `is_draggable` flag (that flag only gates the separate, pre-existing always-on quick-drag outside of edit mode).
- `App\Http\Controllers\Maps\Markers\MoveController` / `maps.markers.move` and the legacy Blade edit page (`maps.map_markers.edit`/`update`) are untouched and keep working as-is.
- `MarkerPanel.vue` is generalized to serve both create and edit (`variant` prop) rather than duplicated — it already has nearly every field an edit needs.
- Mobile (`< md`) panels are full-screen per the existing pattern (`docs/superpowers/specs/2026-07-11-map-explorer-mobile-panels-design.md`) — this plan adds a "peek" collapsed state to `MarkerPanel.vue` so the map stays visible/interactive during geometry edits on mobile, for both its create and edit variants.
- No hardcoded UI strings — all new copy goes through `lang/en/maps/explorer.php` → `App\Services\Maps\ExploreApiService::translations()` → `data.i18n`, matching every existing string in this feature.
- Never translate strings by hand in `resources/lang` or `lang/{locale}` for locales other than `en` — this repo's translations are community-maintained; only `lang/en/...` is touched here.

---

### Task 1: Backend — marker update endpoint, resource fields, and translation keys

**Files:**
- Modify: `routes/campaigns/entities.php`
- Modify: `app/Http/Controllers/Entity/Maps/MarkerController.php`
- Modify: `app/Http/Resources/Maps/Explore/PinResource.php`
- Modify: `lang/en/maps/explorer.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Test: `tests/Feature/Entities/Maps/MarkerControllerTest.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: existing `App\Http\Requests\StoreMapMarker` (reused as-is), existing `App\Http\Controllers\Entity\Maps\MarkerController::guardMarker()`.
- Produces: route `entities.map-markers.update` (`PATCH /w/{campaign}/entities/{entity}/map/markers/{map_marker}`); `PinResource::toArray()` gains `shape_id` (int), `icon_id` (int), `custom_icon` (string|null), `entity_id` (int|null), `entity_name` (string|null), `visibility_id` (int|null), `update_url` (string) — consumed by Task 3's `toEditingPin()`. `data.i18n` gains `edit_marker`, `save_changes`, `peek_map`, `peek_panel` — consumed by Task 3's `DetailPanel.vue`/`MarkerPanel.vue`.

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, change the existing `assertJsonStructure` call (line 39-45) — the `pins` line (currently):

```php
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url']],
```

to:

```php
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url', 'shape_id', 'icon_id', 'custom_icon', 'entity_id', 'entity_name', 'visibility_id', 'update_url']],
```

and the `i18n` line (currently):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

to:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'edit_marker', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'save_changes', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'peek_map', 'peek_panel', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

Then append these tests to the end of `tests/Feature/Entities/Maps/MarkerControllerTest.php`:

```php
it('updates a marker and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'name' => 'Old name',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ]);

    $response = $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => 'New name',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#123456',
        'shape_id' => 1,
        'icon' => 3,
        'group_id' => $group->id,
        'opacity' => 60,
    ])->assertStatus(200);

    expect($response->json('id'))->toBe($marker->id);
    expect($response->json('name'))->toBe('New name');
    expect($response->json('colour'))->toBe('#123456');
    expect($response->json('group_id'))->toBe($group->id);
    expect($response->json('opacity'))->toBe(60.0);
    expect($response->json('update_url'))->toBe(route('entities.map-markers.update', [1, $map->entity->id, $marker->id]));
    expect($marker->fresh()->name)->toBe('New name');
    expect($marker->fresh()->latitude)->toEqual(12.5);
});

it('updates a marker\'s entity link, visibility, and custom icon and returns them in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Pin']);

    $response = $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => 'Pin',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'custom_icon' => 'fa-solid fa-star',
        'entity_id' => $character->entity->id,
        'visibility_id' => 2,
    ])->assertStatus(200);

    expect($response->json('shape_id'))->toBe(1);
    expect($response->json('icon_id'))->toBe(1);
    expect($response->json('custom_icon'))->toBe('fa-solid fa-star');
    expect($response->json('entity_id'))->toBe($character->entity->id);
    expect($response->json('entity_name'))->toBe($character->entity->name);
    expect($response->json('visibility_id'))->toBe(2);
});

it('403s update for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Old name']);

    $this->asPlayer();

    $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => 'New name',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(403);

    expect($marker->fresh()->name)->toBe('Old name');
});

it('404s update for a marker belonging to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => 'New name',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(404);
});

it('404s update for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->patchJson(route('entities.map-markers.update', [1, $entity, $marker]), [
        'name' => 'New name',
        'latitude' => 1,
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(404);
});

it('422s update when latitude is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->patchJson(route('entities.map-markers.update', [1, $map->entity, $marker]), [
        'name' => 'New name',
        'longitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(422);
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="MarkerControllerTest|ExploreApiControllerTest"`
Expected: FAIL — the new `update` tests error with `Route [entities.map-markers.update] not defined`, and the two `assertJsonStructure` assertions in `ExploreApiControllerTest` fail because `shape_id`/`icon_id`/`custom_icon`/`entity_id`/`entity_name`/`visibility_id`/`update_url`/`edit_marker`/`save_changes`/`peek_map`/`peek_panel` don't exist yet.

- [ ] **Step 3: Add the route**

In `routes/campaigns/entities.php`, change (line 65):

```php
Route::post('/w/{campaign}/entities/{entity}/map/markers', [EntityMapMarkerController::class, 'store'])->name('entities.map-markers.store');
```

to:

```php
Route::post('/w/{campaign}/entities/{entity}/map/markers', [EntityMapMarkerController::class, 'store'])->name('entities.map-markers.store');
Route::patch('/w/{campaign}/entities/{entity}/map/markers/{map_marker}', [EntityMapMarkerController::class, 'update'])->name('entities.map-markers.update');
```

- [ ] **Step 4: Add the controller method**

In `app/Http/Controllers/Entity/Maps/MarkerController.php`, change:

```php
    public function destroy(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        // See the comment in preview() above.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $mapMarker->delete();

        return response()->json(null, 204);
    }
```

to:

```php
    public function update(StoreMapMarker $request, Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        // See the comment in preview() above.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $mapMarker->update($request->validated());

        return response()->json(new PinResource($mapMarker)->campaign($campaign)->mapEntity($entity));
    }

    public function destroy(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        // See the comment in preview() above.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $mapMarker->delete();

        return response()->json(null, 204);
    }
```

- [ ] **Step 5: Add the new fields to `PinResource`**

In `app/Http/Resources/Maps/Explore/PinResource.php`, change:

```php
            'custom_shape' => $this->polygonPoints($marker->custom_shape),
            'polygon_style' => $marker->polygon_style ?? [],
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'is_draggable' => (bool) $marker->is_draggable,
            'move_url' => route('maps.markers.move', [$this->campaign->id, $marker->map_id, $marker->id]),
        ];
```

to:

```php
            'custom_shape' => $this->polygonPoints($marker->custom_shape),
            'polygon_style' => $marker->polygon_style ?? [],
            'shape_id' => $marker->shape_id?->value,
            'icon_id' => $marker->icon,
            'custom_icon' => $marker->custom_icon,
            'entity_id' => $marker->entity_id,
            'entity_name' => $marker->entity?->name,
            'visibility_id' => $marker->visibility_id?->value,
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'update_url' => route('entities.map-markers.update', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'is_draggable' => (bool) $marker->is_draggable,
            'move_url' => route('maps.markers.move', [$this->campaign->id, $marker->map_id, $marker->id]),
        ];
```

(`$marker->entity` is already eager-loaded by `Map::markers()`'s `->with(['entity', ...])`, and already accessed elsewhere in this same method for the `name` fallback, so this adds no new query.)

- [ ] **Step 6: Add the translation keys**

In `lang/en/maps/explorer.php`, change the `marker` array:

```php
    'marker'    => [
        'center'            => 'Center',
        'delete'            => 'Delete marker',
        'delete_confirm'    => 'Click again to confirm',
        'duplicate'         => 'Duplicate',
        'edit'              => 'Edit details',
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'new_pin'           => 'New pin',
        'name_placeholder'  => 'Name this pin...',
        'save'              => 'Save',
        'save_continue'     => 'Save & continue',
        'details'           => 'Details',
        'less'              => 'Less',
        'shape'             => 'Shape',
        'group'             => 'Group',
        'none'              => 'None',
        'visibility'        => 'Visibility',
        'colour'            => 'Colour',
        'opacity'           => 'Opacity',
        'custom'            => 'Custom',
        'premium_custom_icon' => 'Unlock custom pins with a premium campaign',
        'border_colour'     => 'Border colour',
        'stroke_width'      => 'Border width',
        'stroke_thin'       => 'Thin',
        'stroke_normal'     => 'Normal',
        'stroke_bold'       => 'Bold',
    ],
```

to:

```php
    'marker'    => [
        'center'            => 'Center',
        'delete'            => 'Delete marker',
        'delete_confirm'    => 'Click again to confirm',
        'duplicate'         => 'Duplicate',
        'edit'              => 'Edit details',
        'edit_marker'       => 'Edit',
        'from_entry'        => 'From entry',
        'linked_entry'     => 'Linked entry',
        'new_pin'           => 'New pin',
        'name_placeholder'  => 'Name this pin...',
        'save'              => 'Save',
        'save_changes'      => 'Save changes',
        'save_continue'     => 'Save & continue',
        'details'           => 'Details',
        'less'              => 'Less',
        'shape'             => 'Shape',
        'group'             => 'Group',
        'none'              => 'None',
        'visibility'        => 'Visibility',
        'colour'            => 'Colour',
        'opacity'           => 'Opacity',
        'custom'            => 'Custom',
        'premium_custom_icon' => 'Unlock custom pins with a premium campaign',
        'border_colour'     => 'Border colour',
        'stroke_width'      => 'Border width',
        'stroke_thin'       => 'Thin',
        'stroke_normal'     => 'Normal',
        'stroke_bold'       => 'Bold',
        'peek_map'          => 'Show map',
        'peek_panel'        => 'Show details',
    ],
```

- [ ] **Step 7: Wire the new keys into `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, change:

```php
            'edit_details' => __('maps/explorer.marker.edit'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('maps/explorer.marker.save'),
            'save_continue' => __('maps/explorer.marker.save_continue'),
```

to:

```php
            'edit_details' => __('maps/explorer.marker.edit'),
            'edit_marker' => __('maps/explorer.marker.edit_marker'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('maps/explorer.marker.save'),
            'save_changes' => __('maps/explorer.marker.save_changes'),
            'save_continue' => __('maps/explorer.marker.save_continue'),
```

and change:

```php
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
```

to:

```php
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'peek_map' => __('maps/explorer.marker.peek_map'),
            'peek_panel' => __('maps/explorer.marker.peek_panel'),
```

- [ ] **Step 8: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="MarkerControllerTest|ExploreApiControllerTest"`
Expected: all passing.

- [ ] **Step 9: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`
Expected: no remaining style issues (fix and re-run if any).

- [ ] **Step 10: Commit**

```bash
git add routes/campaigns/entities.php app/Http/Controllers/Entity/Maps/MarkerController.php app/Http/Resources/Maps/Explore/PinResource.php lang/en/maps/explorer.php app/Services/Maps/ExploreApiService.php tests/Feature/Entities/Maps/MarkerControllerTest.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add marker update endpoint and resource fields for inline editing"
```

---

### Task 2: Panel exclusivity — add the "edit" kind

**Files:**
- Modify: `resources/js/maps/panelExclusivity.js`
- Modify: `resources/js/maps/panelExclusivity.test.js`

**Interfaces:**
- Produces: `panelsToClose(openingKind, isMobile)` now accepts `openingKind` including `"edit"`, and returns it as a closable kind alongside `"detail"`/`"marker"`/`"settings"` — consumed by Task 3's `MapExplorer.vue`.

- [ ] **Step 1: Write the failing test**

In `resources/js/maps/panelExclusivity.test.js`, change:

```js
test('opening a right-slot panel on desktop closes the other right-slot panels only', () => {
    assert.deepEqual(panelsToClose('detail', false).sort(), ['marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', false).sort(), ['detail', 'settings'])
    assert.deepEqual(panelsToClose('settings', false).sort(), ['detail', 'marker'])
})

test('opening a right-slot panel on mobile also closes legend', () => {
    assert.deepEqual(panelsToClose('detail', true).sort(), ['legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', true).sort(), ['detail', 'legend', 'settings'])
    assert.deepEqual(panelsToClose('settings', true).sort(), ['detail', 'legend', 'marker'])
})

test('opening legend on desktop closes nothing', () => {
    assert.deepEqual(panelsToClose('legend', false), [])
})

test('opening legend on mobile closes all right-slot panels', () => {
    assert.deepEqual(panelsToClose('legend', true).sort(), ['detail', 'marker', 'settings'])
})
```

to:

```js
test('opening a right-slot panel on desktop closes the other right-slot panels only', () => {
    assert.deepEqual(panelsToClose('detail', false).sort(), ['edit', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', false).sort(), ['detail', 'edit', 'settings'])
    assert.deepEqual(panelsToClose('edit', false).sort(), ['detail', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('settings', false).sort(), ['detail', 'edit', 'marker'])
})

test('opening a right-slot panel on mobile also closes legend', () => {
    assert.deepEqual(panelsToClose('detail', true).sort(), ['edit', 'legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('marker', true).sort(), ['detail', 'edit', 'legend', 'settings'])
    assert.deepEqual(panelsToClose('edit', true).sort(), ['detail', 'legend', 'marker', 'settings'])
    assert.deepEqual(panelsToClose('settings', true).sort(), ['detail', 'edit', 'legend', 'marker'])
})

test('opening legend on desktop closes nothing', () => {
    assert.deepEqual(panelsToClose('legend', false), [])
})

test('opening legend on mobile closes all right-slot panels', () => {
    assert.deepEqual(panelsToClose('legend', true).sort(), ['detail', 'edit', 'marker', 'settings'])
})
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test resources/js/maps/panelExclusivity.test.js`
Expected: FAIL — actual arrays don't include `'edit'`.

- [ ] **Step 3: Add the "edit" kind**

In `resources/js/maps/panelExclusivity.js`, change:

```js
const RIGHT_SLOT_KINDS = ['detail', 'marker', 'settings']
```

to:

```js
const RIGHT_SLOT_KINDS = ['detail', 'marker', 'settings', 'edit']
```

- [ ] **Step 4: Run the test to verify it passes**

Run: `node --test resources/js/maps/panelExclusivity.test.js`
Expected: PASS, 4 tests passing.

- [ ] **Step 5: Commit**

```bash
git add resources/js/maps/panelExclusivity.js resources/js/maps/panelExclusivity.test.js
git commit -m "feat: add edit panel to map explorer exclusivity rules"
```

---

### Task 3: Frontend — inline marker editing flow

**Files:**
- Modify: `resources/js/components/maps/DetailPanel.vue`
- Modify: `resources/js/components/maps/MarkerPanel.vue`
- Modify: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `entities.map-markers.update` + `PinResource`'s new fields (Task 1), `panelsToClose('edit', ...)` (Task 2).
- Produces: `DetailPanel.vue` emits `edit` (no payload). `MarkerPanel.vue` gains a `variant: 'create' | 'edit'` prop and emits `updated`/`deleted` in addition to its existing `created`. `LeafletCanvas.vue` gains an `editingPin` prop and emits `edit-move` (`{lat, lng}`), `edit-polygon-change`/`edit-path-change` (`[lat, lng][]`), `edit-circle-change` (`{lat, lng, radius}`).

These four files are mutually dependent — none of them is meaningfully testable in isolation (the button does nothing without the handler; the handler does nothing without the panel; the panel does nothing without the canvas prop) — so they land together as one task with one manual-verification pass at the end. There is no automated test coverage for Leaflet canvas or Vue component interactions anywhere in this app (confirmed: no `.test.js`/`.spec.js` files exist under `resources/js/components/maps/`), matching the established pattern for every prior v4 map explorer change.

- [ ] **Step 1: `DetailPanel.vue` — add the Edit button and `edit` emit**

In `resources/js/components/maps/DetailPanel.vue`, change:

```js
const emit = defineEmits(["close", "center", "deleted"]);
```

to:

```js
const emit = defineEmits(["close", "center", "deleted", "edit"]);
```

Change the footer block:

```html
            <div class="p-4 flex flex-col gap-2 flex-none">
                <a
                    v-if="preview.can_edit && preview.edit_url"
                    :href="preview.edit_url"
                    target="_blank"
                    class="btn2 btn-primary btn-block"
                >
                    {{ i18n.edit_details }}
                </a>

                <div class="flex gap-2">
```

to:

```html
            <div class="p-4 flex flex-col gap-2 flex-none">
                <button
                    v-if="preview.can_edit"
                    type="button"
                    class="btn2 btn-primary btn-block"
                    @click="$emit('edit')"
                >
                    {{ i18n.edit_marker }}
                </button>

                <a
                    v-if="preview.can_edit && preview.edit_url"
                    :href="preview.edit_url"
                    target="_blank"
                    class="btn2 btn-block"
                >
                    {{ i18n.edit_details }}
                </a>

                <div class="flex gap-2">
```

(Only the `<a>`'s class changes from `btn2 btn-primary btn-block` to `btn2 btn-block` — the new inline Edit button becomes the primary action, "Edit details" becomes the secondary fallback to the legacy full-page editor.)

- [ ] **Step 2: `MarkerPanel.vue` — add the `variant` prop and rename the light/full toggle**

In `resources/js/components/maps/MarkerPanel.vue`, change the props block:

```js
const props = defineProps({
    pin: { type: Object, default: null },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
    boosted: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    searchUrl: { type: String, required: true },
    visibilities: { type: Array, default: () => [] },
    rapid: { type: Boolean, default: false },
});
```

to:

```js
const props = defineProps({
    pin: { type: Object, default: null },
    variant: { type: String, default: "create" },
    i18n: { type: Object, required: true },
    createUrl: { type: String, required: true },
    boosted: { type: Boolean, default: false },
    groups: { type: Array, default: () => [] },
    searchUrl: { type: String, required: true },
    visibilities: { type: Array, default: () => [] },
    rapid: { type: Boolean, default: false },
});
```

Change the emits:

```js
const emit = defineEmits([
    "close",
    "created",
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
    "border-colour-change",
    "stroke-width-change",
]);
```

Change the state/watch block:

```js
const name = ref("");
const saving = ref(false);
const error = ref(null);
const mode = ref("light");

watch(
    () => props.pin,
    (newPin, oldPin) => {
        if (newPin && !oldPin) {
            name.value = "";
            error.value = null;
            saving.value = false;
            mode.value = "light";
        }
    },
);

watch(name, (value) => {
    emit("name-change", value);
});

function toggleMode() {
    mode.value = mode.value === "light" ? "full" : "light";
}
```

to:

```js
const name = ref("");
const saving = ref(false);
const deleting = ref(false);
const confirmingDelete = ref(false);
const error = ref(null);
const detailLevel = ref("light");
const peeked = ref(false);

const isEdit = computed(() => props.variant === "edit");

watch(
    () => props.pin,
    (newPin, oldPin) => {
        if (newPin && !oldPin) {
            name.value = isEdit.value ? (newPin.name || "") : "";
            error.value = null;
            saving.value = false;
            deleting.value = false;
            confirmingDelete.value = false;
            detailLevel.value = "light";
            peeked.value = false;
        }
    },
);

watch(name, (value) => {
    emit("name-change", value);
});

function toggleDetailLevel() {
    detailLevel.value = detailLevel.value === "light" ? "full" : "light";
}
```

Add `computed` to the Vue import — change:

```js
import { ref, watch } from "vue";
```

to:

```js
import { computed, ref, watch } from "vue";
```

- [ ] **Step 3: `MarkerPanel.vue` — extract `buildPayload()`, branch `save()` on variant, and add `handleDelete()`**

Change:

```js
async function save() {
    saving.value = true;
    error.value = null;

    try {
        const isPolygon = props.pin.shape === "poly";
        const isPath = props.pin.shape === "path";
        const isCircle = props.pin.shape === "circle";
        const hasCustomShape = isPolygon || isPath;
        const res = await axios.post(props.createUrl, {
            name: name.value,
            latitude: props.pin.latitude,
            longitude: props.pin.longitude,
            colour: props.pin.colour,
            shape_id: props.pin.shapeId,
            icon: props.pin.iconId,
            custom_icon: props.pin.customIcon,
            group_id: props.pin.groupId,
            entity_id: props.pin.entityId,
            visibility_id: props.pin.visibilityId,
            opacity: props.pin.opacity,
            custom_shape: hasCustomShape ? serializeVertices(props.pin.customShape) : undefined,
            polygon_style: hasCustomShape ? props.pin.polygonStyle : undefined,
            circle_radius: isCircle ? Math.round(props.pin.circleRadius) : undefined,
        });
        emit("created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}
```

to:

```js
function buildPayload() {
    const isPolygon = props.pin.shape === "poly";
    const isPath = props.pin.shape === "path";
    const isCircle = props.pin.shape === "circle";
    const hasCustomShape = isPolygon || isPath;

    return {
        name: name.value,
        latitude: props.pin.latitude,
        longitude: props.pin.longitude,
        colour: props.pin.colour,
        shape_id: props.pin.shapeId,
        icon: props.pin.iconId,
        custom_icon: props.pin.customIcon,
        group_id: props.pin.groupId,
        entity_id: props.pin.entityId,
        visibility_id: props.pin.visibilityId,
        opacity: props.pin.opacity,
        custom_shape: hasCustomShape ? serializeVertices(props.pin.customShape) : undefined,
        polygon_style: hasCustomShape ? props.pin.polygonStyle : undefined,
        circle_radius: isCircle ? Math.round(props.pin.circleRadius) : undefined,
    };
}

async function save() {
    saving.value = true;
    error.value = null;

    try {
        const payload = buildPayload();
        const res = isEdit.value
            ? await axios.patch(props.pin.update_url, payload)
            : await axios.post(props.createUrl, payload);

        emit(isEdit.value ? "updated" : "created", res.data);
    } catch (e) {
        error.value = props.i18n.error_save;
    } finally {
        saving.value = false;
    }
}

async function handleDelete() {
    if (!confirmingDelete.value) {
        confirmingDelete.value = true;
        error.value = null;

        return;
    }

    deleting.value = true;
    try {
        const res = await axios.delete(props.pin.destroy_url);
        if (res.status === 204) {
            emit("deleted", props.pin);
        }
    } catch (e) {
        confirmingDelete.value = false;
        error.value = props.i18n.error_delete;
    } finally {
        deleting.value = false;
    }
}
```

- [ ] **Step 4: `MarkerPanel.vue` — template: peek toggle, `detailLevel` rename, edit copy, delete button**

Change the root `<aside>` opening tag:

```html
    <aside
        v-if="pin"
        class="fixed inset-0 bg-base-100 shadow-lg z-[1150] flex flex-col overflow-hidden md:top-4 md:right-4 md:left-auto md:w-80 md:rounded-2xl"
        :class="mode === 'full' ? 'md:bottom-4' : 'md:bottom-auto'"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: pin.colour }"
                >
                    <span
                        v-if="pin.shape === 'label'"
                        class="text-white font-semibold"
                        >T</span
                    >
                    <i
                        v-else
                        :class="pin.icon?.value || 'fa-solid fa-map-pin'"
                        class="text-white"
                        aria-hidden="true"
                    />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">
                    {{ i18n.new_pin }}
                </h2>
            </div>
            <button
                class="btn2 btn-default btn-sm flex-none"
                :disabled="saving"
                @click="$emit('close')"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>

        <div class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
```

to:

```html
    <aside
        v-if="pin"
        class="fixed z-[1150] bg-base-100 shadow-lg flex flex-col overflow-hidden md:top-4 md:right-4 md:left-auto md:w-80 md:rounded-2xl"
        :class="[
            peeked ? 'bottom-0 left-0 right-0 top-auto rounded-t-2xl' : 'inset-0',
            detailLevel === 'full' ? 'md:bottom-4' : 'md:bottom-auto',
        ]"
    >
        <div class="flex items-center justify-between gap-2 p-4">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg flex items-center justify-center flex-none"
                    :style="{ backgroundColor: pin.colour }"
                >
                    <span
                        v-if="pin.shape === 'label'"
                        class="text-white font-semibold"
                        >T</span
                    >
                    <i
                        v-else
                        :class="pin.icon?.value || 'fa-solid fa-map-pin'"
                        class="text-white"
                        aria-hidden="true"
                    />
                </div>
                <h2 class="text-sm font-semibold uppercase tracking-wide">
                    {{ isEdit ? (pin.name || i18n.new_pin) : i18n.new_pin }}
                </h2>
            </div>
            <div class="flex items-center gap-2 flex-none">
                <button
                    type="button"
                    class="btn2 btn-default btn-sm md:hidden"
                    :disabled="saving || deleting"
                    @click="peeked = !peeked"
                >
                    <i
                        :class="peeked ? 'fa-solid fa-up-right-and-down-left-from-center' : 'fa-solid fa-down-left-and-up-right-to-center'"
                        aria-hidden="true"
                    />
                    <span class="sr-only">{{ peeked ? i18n.peek_panel : i18n.peek_map }}</span>
                </button>
                <button
                    class="btn2 btn-default btn-sm"
                    :disabled="saving || deleting"
                    @click="$emit('close')"
                >
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </div>
        </div>

        <div v-show="!peeked" class="px-4 flex flex-col gap-3 grow min-h-0 overflow-y-auto">
```

Change every `mode === 'full'`/`mode === "full"` in the fields block (5 occurrences: `ColourPicker` ×2, `StrokeWidthPicker`, `ShapePicker`, `GroupPicker`, `OpacityPicker`, `VisibilitySelect` — 7 total `v-if`s reference it) to `detailLevel === 'full'`. For example, change:

```html
            <ColourPicker
                v-if="mode === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />

            <ColourPicker
                v-if="mode === 'full' && pin.shape === 'poly'"
                :colour="pin.polygonStyle?.stroke"
                :label="i18n.border_colour"
                @change="$emit('border-colour-change', $event)"
            />

            <StrokeWidthPicker
                v-if="mode === 'full' && (pin.shape === 'poly' || pin.shape === 'path')"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />

            <ShapePicker
                v-if="mode === 'full' && pin.shape !== 'label'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />

            <GroupPicker
                v-if="mode === 'full' && groups.length"
                :pin="pin"
                :groups="groups"
                :i18n="i18n"
                @change="$emit('group-change', $event)"
            />
```

to:

```html
            <ColourPicker
                v-if="detailLevel === 'full'"
                :colour="pin.colour"
                :label="i18n.colour"
                @change="$emit('colour-change', $event)"
            />

            <ColourPicker
                v-if="detailLevel === 'full' && pin.shape === 'poly'"
                :colour="pin.polygonStyle?.stroke"
                :label="i18n.border_colour"
                @change="$emit('border-colour-change', $event)"
            />

            <StrokeWidthPicker
                v-if="detailLevel === 'full' && (pin.shape === 'poly' || pin.shape === 'path')"
                :width="pin.polygonStyle?.['stroke-width'] ?? 1"
                :i18n="i18n"
                @change="$emit('stroke-width-change', $event)"
            />

            <ShapePicker
                v-if="detailLevel === 'full' && pin.shape !== 'label'"
                :pin="pin"
                :boosted="boosted"
                :i18n="i18n"
                @change="$emit('icon-change', $event)"
            />

            <GroupPicker
                v-if="detailLevel === 'full' && groups.length"
                :pin="pin"
                :groups="groups"
                :i18n="i18n"
                @change="$emit('group-change', $event)"
            />
```

and change:

```html
            <OpacityPicker
                v-if="mode === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('opacity-change', $event)"
            />

            <VisibilitySelect
                v-if="mode === 'full'"
                :pin="pin"
                :options="visibilities"
                :i18n="i18n"
                @change="$emit('visibility-change', $event)"
            />
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <div class="flex gap-2">
                <button
                    class="btn2 btn-outline"
                    :disabled="saving"
                    @click="toggleMode"
                >
                    {{ mode === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || (!name.trim() && !pin.entityId)"
                    @click="save"
                >
                    {{ rapid ? i18n.save_continue : i18n.save }}
                </button>
            </div>
            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
```

to:

```html
            <OpacityPicker
                v-if="detailLevel === 'full'"
                :pin="pin"
                :i18n="i18n"
                @change="$emit('opacity-change', $event)"
            />

            <VisibilitySelect
                v-if="detailLevel === 'full'"
                :pin="pin"
                :options="visibilities"
                :i18n="i18n"
                @change="$emit('visibility-change', $event)"
            />
        </div>

        <div class="p-4 mt-auto flex flex-col gap-2">
            <div class="flex gap-2">
                <button
                    class="btn2 btn-outline"
                    :disabled="saving || deleting"
                    @click="toggleDetailLevel"
                >
                    {{ detailLevel === "full" ? i18n.less : i18n.details }}
                </button>
                <button
                    class="btn2 btn-primary grow"
                    :disabled="saving || deleting || (!name.trim() && !pin.entityId)"
                    @click="save"
                >
                    {{ isEdit ? i18n.save_changes : (rapid ? i18n.save_continue : i18n.save) }}
                </button>
            </div>

            <button
                v-if="isEdit"
                type="button"
                class="btn2 btn-error btn-outline"
                :disabled="saving || deleting"
                @click="handleDelete"
            >
                {{ confirmingDelete ? i18n.delete_confirm : i18n.delete_marker }}
            </button>

            <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
        </div>
    </aside>
```

- [ ] **Step 5: `LeafletCanvas.vue` — add the `editingPin` prop and new emits**

In `resources/js/components/maps/LeafletCanvas.vue`, change:

```js
const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    remoteCursors: { type: Object, default: () => ({}) },
    legacyPins: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved', 'cursor-move', 'draft-move'])
```

to:

```js
const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    editingPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    remoteCursors: { type: Object, default: () => ({}) },
    legacyPins: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved', 'cursor-move', 'draft-move', 'edit-move', 'edit-polygon-change', 'edit-circle-change', 'edit-path-change'])
```

- [ ] **Step 6: `LeafletCanvas.vue` — add edit-layer state variables**

Change:

```js
const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null
let draftPolygon = null
let polygonEditing = false
let draftCircle = null
let circleEditing = false
let draftPath = null
let pathEditing = false
let rulerControl = null
let gridLayer = null
```

to:

```js
const mapEl = ref(null)
let leafletMap = null
let pinLayer = null
let draftMarker = null
let draftPolygon = null
let polygonEditing = false
let draftCircle = null
let circleEditing = false
let draftPath = null
let pathEditing = false
let rulerControl = null
let gridLayer = null
let editMarker = null
let editCircle = null
let editPolygon = null
let editPath = null
```

- [ ] **Step 7: `LeafletCanvas.vue` — exclude the editing pin from the static layer**

Change:

```js
function buildPins() {
    if (pinLayer) {
        leafletMap.removeLayer(pinLayer)
    }

    pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    props.pins.forEach((pin) => {
        const marker = buildPin(pin)
        marker.on('click', (e) => {
            L.DomEvent.stopPropagation(e)
            emit('pin-click', pin)
        })
        pinLayer.addLayer(marker)
    })

    pinLayer.addTo(leafletMap)
}
```

to:

```js
function buildPins() {
    if (pinLayer) {
        leafletMap.removeLayer(pinLayer)
    }

    pinLayer = props.map.has_clustering ? L.markerClusterGroup() : L.layerGroup()

    props.pins
        .filter((pin) => pin.id !== props.editingPin?.id)
        .forEach((pin) => {
            const marker = buildPin(pin)
            marker.on('click', (e) => {
                L.DomEvent.stopPropagation(e)
                emit('pin-click', pin)
            })
            pinLayer.addLayer(marker)
        })

    pinLayer.addTo(leafletMap)
}
```

- [ ] **Step 8: `LeafletCanvas.vue` — add `clearEditLayer()`/`buildEditLayer()`**

Change:

```js
function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle' || props.draftPin.shape === 'path') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)

    if (props.canEdit) {
        draftMarker.dragging?.enable()
        draftMarker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng()
            emit('draft-move', { lat, lng })
        })
    }
}

function polygonLatLngs() {
```

to:

```js
function buildDraftMarker() {
    if (draftMarker) {
        leafletMap.removeLayer(draftMarker)
        draftMarker = null
    }

    if (! props.draftPin || props.draftPin.shape === 'poly' || props.draftPin.shape === 'circle' || props.draftPin.shape === 'path') {
        return
    }

    draftMarker = buildPin({ ...props.draftPin, id: 'draft' })
    draftMarker.addTo(leafletMap)

    if (props.canEdit) {
        draftMarker.dragging?.enable()
        draftMarker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng()
            emit('draft-move', { lat, lng })
        })
    }
}

function clearEditLayer() {
    if (editMarker) {
        leafletMap.removeLayer(editMarker)
        editMarker = null
    }

    if (editCircle) {
        editCircle.disableEdit()
        leafletMap.removeLayer(editCircle)
        editCircle = null
    }

    if (editPolygon) {
        editPolygon.disableEdit()
        leafletMap.removeLayer(editPolygon)
        editPolygon = null
    }

    if (editPath) {
        editPath.disableEdit()
        leafletMap.removeLayer(editPath)
        editPath = null
    }
}

// Rebuilds the whole live-editable layer for props.editingPin from scratch on every change
// (a geometry drag or a plain field edit alike), mirroring how buildDraftMarker() already
// tears down and recreates its marker on every draftPin change. Each vertex/handle drag
// completes (dragend) before this runs, so recreating the layer — and re-attaching a fresh
// Leaflet.Editable editor via enableEdit() — between drags is safe.
function buildEditLayer() {
    clearEditLayer()

    const pin = props.editingPin
    if (! pin) {
        return
    }

    if (pin.shape === 'poly') {
        editPolygon = L.polygon(pin.customShape || [], {
            color: pin.polygonStyle?.stroke || pin.colour || '#ccc',
            weight: pin.polygonStyle?.['stroke-width'] || 1,
            fillColor: pin.colour || '#ccc',
            fillOpacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editPolygon.enableEdit()
        editPolygon.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
            const rings = editPolygon.getLatLngs()
            emit('edit-polygon-change', (rings[0] || []).map((point) => [point.lat, point.lng]))
        })

        return
    }

    if (pin.shape === 'path') {
        editPath = L.polyline(pin.customShape || [], {
            color: pin.colour || '#ccc',
            weight: pin.polygonStyle?.['stroke-width'] || 1,
            opacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editPath.enableEdit()
        editPath.on('editable:vertex:new editable:vertex:dragend editable:dragend editable:vertex:deleted', () => {
            emit('edit-path-change', editPath.getLatLngs().map((point) => [point.lat, point.lng]))
        })

        return
    }

    if (pin.shape === 'circle') {
        editCircle = L.circle([pin.latitude, pin.longitude], {
            radius: pin.circleRadius || 50,
            fillColor: pin.colour || '#ccc',
            stroke: false,
            fillOpacity: (pin.opacity ?? 100) / 100,
        }).addTo(leafletMap)
        editCircle.enableEdit()
        editCircle.on('editable:vertex:dragend editable:dragend', () => {
            const center = editCircle.getLatLng()
            emit('edit-circle-change', { lat: center.lat, lng: center.lng, radius: editCircle.getRadius() })
        })

        return
    }

    editMarker = buildPin({ ...pin, id: 'editing' })
    editMarker.addTo(leafletMap)
    editMarker.dragging?.enable()
    editMarker.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng()
        emit('edit-move', { lat, lng })
    })
}

function polygonLatLngs() {
```

- [ ] **Step 9: `LeafletCanvas.vue` — watch `editingPin` and call `buildEditLayer()` on mount**

Change:

```js
watch(() => props.draftPin, (pin) => {
    if (! leafletMap) {
        return
    }

    buildDraftMarker()

    if (pin?.shape === 'poly') {
        styleDraftPolygon()
    }

    if (pin?.shape === 'circle') {
        styleDraftCircle()
    }

    if (pin?.shape === 'path') {
        styleDraftPath()
    }
})
```

to:

```js
watch(() => props.draftPin, (pin) => {
    if (! leafletMap) {
        return
    }

    buildDraftMarker()

    if (pin?.shape === 'poly') {
        styleDraftPolygon()
    }

    if (pin?.shape === 'circle') {
        styleDraftCircle()
    }

    if (pin?.shape === 'path') {
        styleDraftPath()
    }
})

watch(() => props.editingPin?.id, () => {
    if (leafletMap) {
        buildPins()
    }
})

watch(() => props.editingPin, () => {
    if (leafletMap) {
        buildEditLayer()
    }
})
```

Change (inside `onMounted`):

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildGrid()
    buildRuler()
    buildCursors()
```

to:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildEditLayer()
    buildGrid()
    buildRuler()
    buildCursors()
```

- [ ] **Step 10: `MapExplorer.vue` — add `editingPin` state and update `anyPanelOpen`/`closePanel`**

Change:

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
const editingPin = ref(null);
const rapid = ref(false);
```

Change:

```js
const isTilingRunning = computed(() => data.value.map.tiling === 'running');

const anyPanelOpen = computed(
    () => legendOpen.value || !!selectedPin.value || !!draftPin.value || settingsOpen.value,
);
```

to:

```js
const isTilingRunning = computed(() => data.value.map.tiling === 'running');

const anyPanelOpen = computed(
    () => legendOpen.value || !!selectedPin.value || !!draftPin.value || !!editingPin.value || settingsOpen.value,
);

const activePanelPin = computed(() => draftPin.value || editingPin.value);

const panelVariant = computed(() => (editingPin.value ? 'edit' : 'create'));
```

Change:

```js
function closePanel(kind) {
    if (kind === "legend") {
        legendOpen.value = false;
    } else if (kind === "detail") {
        selectedPin.value = null;
    } else if (kind === "marker") {
        draftPin.value = null;
    } else if (kind === "settings") {
        settingsOpen.value = false;
    }
}
```

to:

```js
function closePanel(kind) {
    if (kind === "legend") {
        legendOpen.value = false;
    } else if (kind === "detail") {
        selectedPin.value = null;
    } else if (kind === "marker") {
        draftPin.value = null;
    } else if (kind === "edit") {
        editingPin.value = null;
    } else if (kind === "settings") {
        settingsOpen.value = false;
    }
}
```

- [ ] **Step 11: `MapExplorer.vue` — add `handleEditMove` and clear `editingPin` on mode/measure changes**

Change:

```js
function handleDraftMove({ lat, lng }) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };
}

function handleCursorMove({ lat, lng }) {
    sendCursor(lat, lng);
}
```

to:

```js
function handleDraftMove({ lat, lng }) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, latitude: lat, longitude: lng };
}

function handleEditMove({ lat, lng }) {
    if (!editingPin.value) {
        return;
    }

    editingPin.value = { ...editingPin.value, latitude: lat, longitude: lng };
}

function handleCursorMove({ lat, lng }) {
    sendCursor(lat, lng);
}
```

Change:

```js
function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;

    if (mode !== "center-pick") {
        settingsOpen.value = false;
    }
}

function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
    }
}
```

to:

```js
function handleModeChange(mode) {
    activeMode.value = mode;
    selectedPin.value = null;
    draftPin.value = null;
    editingPin.value = null;

    if (mode !== "center-pick") {
        settingsOpen.value = false;
    }
}

function handleMeasureChange(active) {
    if (active) {
        activeMode.value = null;
        draftPin.value = null;
        editingPin.value = null;
    }
}
```

- [ ] **Step 12: `MapExplorer.vue` — add `patchActivePin()` and refactor the 9 field-change handlers**

Change:

```js
function handleNameChange(name) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, name };
}

function handleIconChange(payload) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = {
        ...draftPin.value,
        iconId: payload.icon,
        customIcon: payload.custom_icon,
        icon: payload.render,
    };
}

function handleGroupChange(groupId) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, groupId };
}

function handleEntityChange(payload) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, entityId: payload.id, entityName: payload.text };
}

function handleVisibilityChange(visibilityId) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, visibilityId };
}

function handleColourChange(colour) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, colour };
}

function handleOpacityChange(opacity) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, opacity };
}
```

to:

```js
function patchActivePin(patch) {
    if (draftPin.value) {
        draftPin.value = { ...draftPin.value, ...patch };
    } else if (editingPin.value) {
        editingPin.value = { ...editingPin.value, ...patch };
    }
}

function handleNameChange(name) {
    patchActivePin({ name });
}

function handleIconChange(payload) {
    patchActivePin({
        iconId: payload.icon,
        customIcon: payload.custom_icon,
        icon: payload.render,
    });
}

function handleGroupChange(groupId) {
    patchActivePin({ groupId });
}

function handleEntityChange(payload) {
    patchActivePin({ entityId: payload.id, entityName: payload.text });
}

function handleVisibilityChange(visibilityId) {
    patchActivePin({ visibilityId });
}

function handleColourChange(colour) {
    patchActivePin({ colour });
}

function handleOpacityChange(opacity) {
    patchActivePin({ opacity });
}
```

Change:

```js
function handleBorderColourChange(colour) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, stroke: colour } };
}

function handleStrokeWidthChange(width) {
    if (!draftPin.value) {
        return;
    }

    draftPin.value = { ...draftPin.value, polygonStyle: { ...draftPin.value.polygonStyle, "stroke-width": width } };
}
```

to:

```js
function handleBorderColourChange(colour) {
    const target = draftPin.value || editingPin.value;
    if (!target) {
        return;
    }

    patchActivePin({ polygonStyle: { ...target.polygonStyle, stroke: colour } });
}

function handleStrokeWidthChange(width) {
    const target = draftPin.value || editingPin.value;
    if (!target) {
        return;
    }

    patchActivePin({ polygonStyle: { ...target.polygonStyle, "stroke-width": width } });
}
```

- [ ] **Step 13: `MapExplorer.vue` — add `handleEditPolygonChange`/`handleEditCircleChange`/`handleEditPathChange`**

Change:

```js
function handlePolygonChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}
```

to:

```js
function handlePolygonChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function handleEditPolygonChange(vertices) {
    if (!editingPin.value || editingPin.value.shape !== "poly") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    editingPin.value = { ...editingPin.value, customShape: vertices, latitude: lat, longitude: lng };
}
```

Change:

```js
function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}
```

to:

```js
function handleCircleChange({ lat, lng, radius }) {
    if (!draftPin.value || draftPin.value.shape !== "circle") {
        return;
    }

    draftPin.value = { ...draftPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}

function handleEditCircleChange({ lat, lng, radius }) {
    if (!editingPin.value || editingPin.value.shape !== "circle") {
        return;
    }

    editingPin.value = { ...editingPin.value, circleRadius: radius, latitude: lat, longitude: lng };
}
```

Change:

```js
function handlePathChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}
```

to:

```js
function handlePathChange(vertices) {
    if (!draftPin.value || draftPin.value.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    draftPin.value = { ...draftPin.value, customShape: vertices, latitude: lat, longitude: lng };
}

function handleEditPathChange(vertices) {
    if (!editingPin.value || editingPin.value.shape !== "path") {
        return;
    }

    const [lat, lng] = centroid(vertices);

    editingPin.value = { ...editingPin.value, customShape: vertices, latitude: lat, longitude: lng };
}
```

- [ ] **Step 14: `MapExplorer.vue` — add `toEditingPin()`, `openEditFromDetail()`, `handlePanelClose()`, `handlePinUpdated()`, `handlePinDeletedFromPanel()`**

Change:

```js
function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
    draftPin.value = null;

    if (! rapid.value) {
        activeMode.value = null;
    }
}
```

to:

```js
function onPinCreated(pin) {
    data.value.pins = [...data.value.pins, pin];
    draftPin.value = null;

    if (! rapid.value) {
        activeMode.value = null;
    }
}

function toEditingPin(pin) {
    return {
        id: pin.id,
        name: pin.name,
        colour: pin.colour,
        shape: pin.shape,
        shapeId: pin.shape_id,
        icon: pin.icon,
        iconId: pin.icon_id,
        customIcon: pin.custom_icon,
        customShape: pin.custom_shape,
        polygonStyle: pin.polygon_style,
        circleRadius: pin.circle_radius,
        pin_size: pin.pin_size,
        groupId: pin.group_id,
        entityId: pin.entity_id,
        entityName: pin.entity_name,
        visibilityId: pin.visibility_id,
        opacity: pin.opacity,
        latitude: pin.latitude,
        longitude: pin.longitude,
        update_url: pin.update_url,
        destroy_url: pin.destroy_url,
    };
}

function openEditFromDetail() {
    const pin = selectedPin.value;
    if (! pin) {
        return;
    }

    enforceExclusivity("edit");
    editingPin.value = toEditingPin(pin);
}

function handlePanelClose() {
    draftPin.value = null;
    editingPin.value = null;
}

function handlePinUpdated(pin) {
    data.value.pins = data.value.pins.map((p) => (p.id === pin.id ? pin : p));
    editingPin.value = null;
}

function handlePinDeletedFromPanel(pin) {
    removePin(pin);
    editingPin.value = null;
}
```

(`toEditingPin()` maps `PinResource`'s snake_case fields — Task 1 — onto the camelCase shape `draftPin` already uses, so `MarkerPanel.vue` and its sub-pickers (`ShapePicker`, `GroupPicker`, `EntityLinkSelect`, `VisibilitySelect`) work identically for both variants without any changes of their own. `update_url`/`destroy_url` stay snake_case, matching every other `*_url` field already read directly off `PinResource`-shaped objects elsewhere in this file, e.g. `DetailPanel.vue`'s `props.pin.destroy_url`.)

- [ ] **Step 15: `MapExplorer.vue` — template wiring**

Change:

```html
        <DetailPanel
            :pin="selectedPin"
            :map="data.map"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
        />
```

to:

```html
        <DetailPanel
            :pin="selectedPin"
            :map="data.map"
            :i18n="data.i18n"
            @close="selectedPin = null"
            @center="centerNonce++"
            @deleted="removePin"
            @edit="openEditFromDetail"
        />
```

Change:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :remote-cursors="remoteCursors"
            :legacy-pins="data.map.settings?.legacy_pins"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
            @pin-moved="handlePinMoved"
            @draft-move="handleDraftMove"
            @cursor-move="handleCursorMove"
        />
```

to:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :editing-pin="editingPin"
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :remote-cursors="remoteCursors"
            :legacy-pins="data.map.settings?.legacy_pins"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
            @pin-moved="handlePinMoved"
            @draft-move="handleDraftMove"
            @cursor-move="handleCursorMove"
            @edit-move="handleEditMove"
            @edit-polygon-change="handleEditPolygonChange"
            @edit-circle-change="handleEditCircleChange"
            @edit-path-change="handleEditPathChange"
        />
```

Change:

```html
        <MarkerPanel
            :pin="draftPin"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :visibilities="data.visibilities"
            :rapid="rapid"
            @close="draftPin = null"
            @created="onPinCreated"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
            @name-change="handleNameChange"
            @border-colour-change="handleBorderColourChange"
            @stroke-width-change="handleStrokeWidthChange"
        />
```

to:

```html
        <MarkerPanel
            :pin="activePanelPin"
            :variant="panelVariant"
            :i18n="data.i18n"
            :create-url="data.map.create_url"
            :boosted="boosted"
            :groups="data.groups"
            :search-url="data.map.search_url"
            :visibilities="data.visibilities"
            :rapid="rapid"
            @close="handlePanelClose"
            @created="onPinCreated"
            @updated="handlePinUpdated"
            @deleted="handlePinDeletedFromPanel"
            @icon-change="handleIconChange"
            @group-change="handleGroupChange"
            @entity-change="handleEntityChange"
            @visibility-change="handleVisibilityChange"
            @colour-change="handleColourChange"
            @opacity-change="handleOpacityChange"
            @name-change="handleNameChange"
            @border-colour-change="handleBorderColourChange"
            @stroke-width-change="handleStrokeWidthChange"
        />
```

- [ ] **Step 16: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 17: Manual verification**

As an editor, open the v4 map explorer (`entities.map`) for a map with at least one of each marker shape (pin, label, circle, polygon, path — create them via the toolbar if needed):

1. Click a plain pin marker → `DetailPanel` opens with both an "Edit" button and an "Edit details" link. Click "Edit" → `DetailPanel` closes, `MarkerPanel` opens in edit mode showing the pin's actual name/colour/group/etc., and the pin's marker on the map becomes the only thing draggable (its static twin is gone — there's exactly one marker at that spot, not two).
2. Drag the pin to a new spot, change its name and colour, click Save → panel closes, marker appears at the new position with the new colour; reload the page to confirm it persisted.
3. Repeat for a label (drag it, confirm the tooltip text follows), a circle (drag it and resize via its radius handle, confirm both persist), a polygon (drag a vertex, add a vertex, remove a vertex via the standard Leaflet.Editable interaction, confirm the final shape persists), and a path (same vertex interactions).
4. Open a marker's edit form, make changes (drag position, edit fields), click the close (X) button instead of Save → confirm the marker reverts to its original position/appearance with no network request (check devtools) and no popup asking to confirm discard.
5. Open a marker's edit form and click Delete twice (confirm-then-delete, matching `DetailPanel`'s existing pattern) → marker disappears from the map and panel closes.
6. Confirm opening the legend, or a different marker's detail/edit, while one marker is mid-edit closes the in-progress edit (discarding it) — matches the existing panel-exclusivity behavior for `draftPin`.
7. Confirm a viewer without edit rights never sees the "Edit" button in `DetailPanel`.
8. On a mobile-width viewport (< 768px): open a marker for editing, confirm the panel is full-screen by default; tap the peek toggle → panel collapses to a bottom bar and the map (with the live-editable shape) becomes visible/interactable above it; drag the shape while peeked; tap the toggle again → panel expands back to full-screen with the drag already reflected in the (still staged, unsaved) form. Confirm Save/Close remain reachable while peeked. Confirm the same peek behavior works for the **create** flow too (e.g. drafting a new polygon on mobile — adjust a vertex after the initial draw commits, confirm peek reveals the map there as well).
9. Confirm dragging a marker in edit mode doesn't trigger `pin-click` (i.e., a genuine drag doesn't also fire the click-to-select handler on the marker underneath — there is no marker underneath during edit mode since it's excluded from the static layer, but confirm no console errors either).

- [ ] **Step 18: Commit**

```bash
git add resources/js/components/maps/DetailPanel.vue resources/js/components/maps/MarkerPanel.vue resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: support inline marker editing with live geometry and a mobile peek mode"
```

---

### Task 4: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the full backend test suite for maps**

Run: `vendor/bin/sail artisan test --compact --filter=Maps`
Expected: all passing.

- [ ] **Step 2: Run the frontend unit tests**

Run: `node --test resources/js/maps/panelExclusivity.test.js resources/js/maps/polygon.test.js resources/js/maps/groupTree.test.js`
Expected: all passing.

- [ ] **Step 3: Run Pint**

Run: `vendor/bin/sail bin pint --dirty --format agent`
Expected: no remaining style issues.

- [ ] **Step 4: Full manual walkthrough**

Repeat Task 3's Step 17 checks in one consolidated pass. Additionally confirm: creating a brand-new marker (the pre-existing `draftPin` flow) still works unaffected end to end (this plan's `patchActivePin()`/`variant` refactor touches shared code paths); the tiling-prompt banner and presence avatars still render correctly alongside the new Edit button; and the legacy `maps.map_markers.edit` page (linked from "Edit details") still opens and saves correctly, unaffected by this work.

- [ ] **Step 5: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own verification, then re-run this task's steps from the top.

- [ ] **Step 6: Final commit (if any fixes were made in Step 4)**

```bash
git add -A
git commit -m "fix: address issues found in inline marker editing end-to-end verification"
```
