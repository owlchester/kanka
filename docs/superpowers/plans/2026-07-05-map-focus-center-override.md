# Map Focus/Center URL Override for v4 Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Loading the v4 map explorer (`/entities/{entity}/map`) with a `focus` (marker ID) or `lat`/`lng` (raw coordinate) query parameter centers the map there on that page load, overriding the map's own configured center for that render only.

**Architecture:** Port legacy's render-time override (`resources/views/maps/_setup.blade.php`) to v4 in two small, independently-testable pieces: (1) `MapResource::toArray()` — which already receives the current `Request` — reads `focus`/`lat`/`lng` off it and overrides the computed `center` value with the same precedence and fallback behavior legacy uses; (2) the v4 map page controller forwards those same query params from the page request onto the API URL it hands to the Vue app, so they reach the request `MapResource` sees. No frontend code changes — `LeafletCanvas.vue` already seeds its one-time initial view from `map.center`.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest.

## Global Constraints

- Query param names must exactly match legacy: `focus` (a marker ID) and `lat`/`lng` (raw coordinates) — no renaming.
- Precedence: `lat`/`lng` (when both present) wins over `focus`, matching legacy exactly.
- An invalid, missing, or wrong-map `focus` marker ID silently falls back to the map's own configured center — never a 404/422/error.
- Zoom is never affected by this override — `initial_zoom` applies unconditionally regardless of `focus`/`lat`/`lng`.
- No frontend (`resources/js/components/maps/*.vue`) changes — the override rides entirely on the existing `map.center` field, which `LeafletCanvas.vue`'s `onMounted` already uses for its one-time initial view.
- Out of scope: rewriting any existing link-generation code elsewhere in the app to point at v4 with these params. This ports the receiving mechanism only.

---

### Task 1: Apply the focus/lat/lng override in `MapResource`

**Files:**
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: `Illuminate\Http\Request` (already injected into `MapResource::toArray(Request $request)`), `App\Models\Map::centerFocus()` (existing), `$map->markers` (existing `HasMany` relation, returns an `Illuminate\Database\Eloquent\Collection` with `firstWhere()`).
- Produces: `MapResource`'s `center` field reflects the override when `focus`/`lat`/`lng` query params are present on the request — consumed by Task 2 (which makes sure those params actually reach this request from the page URL) and already consumed by the existing, unmodified frontend (`LeafletCanvas.vue`'s `onMounted` reads `props.map.center`).

- [ ] **Step 1: Write the failing tests**

Append to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php` (the file already imports `App\Models\Map` and `App\Models\MapMarker` — no new imports needed):

```php
it('overrides the center with lat/lng query params', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'lat' => 12.5, 'lng' => 34.5]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([12.5, 34.5]);
});

it('overrides the center with a focus marker id query param', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'latitude' => 5.5, 'longitude' => 6.6]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([5.5, 6.6]);
});

it('falls back to the configured center when focus is a marker from a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([2.0, 1.0]);
});

it('falls back to the configured center when focus does not match any marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => 999999]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([2.0, 1.0]);
});

it('prefers lat/lng over focus when both are present', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'latitude' => 5.5, 'longitude' => 6.6]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id, 'lat' => 12.5, 'lng' => 34.5]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([12.5, 34.5]);
});
```

Note: `centerFocus()` builds `"{latitude}, {longitude}"` from `center_y, center_x` (not `center_x, center_y`) — a map created with `center_x => 1, center_y => 2` and no override reports `center` as `[2.0, 1.0]`, which is why the fallback-case tests above expect `[2.0, 1.0]`, not `[1.0, 2.0]`.

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="overrides the center|falls back to the configured center|prefers lat/lng over focus"`
Expected: FAIL — `map.center` still reflects only the configured center regardless of query params.

- [ ] **Step 3: Apply the override in `MapResource::toArray()`**

In `app/Http/Resources/Maps/Explore/MapResource.php`, change:

```php
    public function toArray(Request $request): array
    {
        $map = $this->resource;
        $isChunked = $map->isChunked() && $map->chunkingReady();

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_chunked' => $isChunked,
            'has_clustering' => (bool) $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => array_map('floatval', explode(', ', $map->centerFocus())),
```

to:

```php
    public function toArray(Request $request): array
    {
        $map = $this->resource;
        $isChunked = $map->isChunked() && $map->chunkingReady();
        $center = array_map('floatval', explode(', ', $map->centerFocus()));

        if ($request->filled('lat') && $request->filled('lng')) {
            $center = [(float) $request->query('lat'), (float) $request->query('lng')];
        } elseif ($request->filled('focus')) {
            $pin = $map->markers->firstWhere('id', (int) $request->query('focus'));
            if ($pin) {
                $center = [(float) $pin->latitude, (float) $pin->longitude];
            }
        }

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_chunked' => $isChunked,
            'has_clustering' => (bool) $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => $center,
```

(`$map->markers->firstWhere('id', ...)` is scoped to this map's own markers relation, so a marker ID from a different map is simply not found — same fallback behavior as legacy's `$map->markers->where('id', ...)->first()`.)

- [ ] **Step 4: Scope the focus lookup to visible markers only**

Deviation from legacy, decided after implementation: legacy's own `$map->markers->where('id', ...)->first()` (`resources/views/maps/_setup.blade.php`) has the same gap this step closes — it doesn't check marker visibility, so `focus=<hidden marker id>` can leak that marker's coordinates to a viewer who can see the map but not that specific marker (e.g. one in a private group). The plan originally called for exact legacy parity, including this gap; the human decided to close it in v4 rather than reproduce it. Change:

```php
        } elseif ($request->filled('focus')) {
            $pin = $map->markers->firstWhere('id', (int) $request->query('focus'));
            if ($pin) {
                $center = [(float) $pin->latitude, (float) $pin->longitude];
            }
        }
```

to:

```php
        } elseif ($request->filled('focus')) {
            $focusId = (int) $request->query('focus');
            $pin = $map->markers->first(fn ($marker) => $marker->id === $focusId && $marker->visible());
            if ($pin) {
                $center = [(float) $pin->latitude, (float) $pin->longitude];
            }
        }
```

(`MapMarker::visible()` — the same method `ExploreApiService::load()` already uses to filter the `pins` list sent to the frontend — returns `false` for markers in a private group, or polygon/path markers on a non-boosted campaign.)

Add one more test to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, alongside the other focus/lat/lng tests. Note: this test exercises the `isPolygon()`/non-boosted-campaign branch of `MapMarker::visible()`, not its private-group branch — a pre-existing bug affecting this whole test file (documented in its own comment above the `'excludes pins whose linked entity has no child'` test) means `App\Models\Scopes\VisibilityIDScope` never actually filters anything under Pest (`app()->runningInConsole()` is always true in tests), so a private-group-based test would silently pass for the wrong reason. The polygon/non-boosted path has no such scope involved and reliably exercises a real `visible() === false` case:

```php
it('falls back to the configured center when focus points at a hidden polygon marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 5,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'latitude' => 5.5,
        'longitude' => 6.6,
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toEqual([2.0, 1.0]);
});
```

(`shape_id = 5` is `MapMarkerShape::poly`; combined with a non-empty `custom_shape`, `MapMarker::isPolygon()` is `true`, and the test campaign from `withCampaign()` is not boosted, so `MapMarker::visible()` returns `false` — no new imports needed, `MapMarker` is already imported in this file.)

- [ ] **Step 5: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="overrides the center|falls back to the configured center|prefers lat/lng over focus|returns the full explore payload"`
Expected: all passing (the last filter re-confirms the no-query-param path is unaffected).

- [ ] **Step 6: Commit**

```bash
git add app/Http/Resources/Maps/Explore/MapResource.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: scope the focus marker lookup to visible markers only"
```

---

### Task 2: Forward focus/lat/lng from the page request to the API URL

**Files:**
- Modify: `app/Http/Controllers/Entity/Maps/ShowController.php`
- Modify: `resources/views/entities/pages/map/index.blade.php`
- Test: `tests/Feature/Entities/Maps/ShowControllerTest.php`

**Interfaces:**
- Consumes: `App\Http\Resources\Maps\Explore\MapResource`'s new override behavior (Task 1) — this task is what actually gets `focus`/`lat`/`lng` from the page URL onto the request that resource sees.
- Produces: the `entities.map` page, when loaded with `?focus=X` or `?lat=Y&lng=Z`, renders a `<map-explorer api="...">` URL carrying the same query params — nothing later in this plan consumes this further; it's the end of the chain.

- [ ] **Step 1: Write the failing test**

Append to `tests/Feature/Entities/Maps/ShowControllerTest.php` (the file already imports `App\Models\Map` — no new imports needed):

```php
it('forwards focus/lat/lng query params onto the rendered api url', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $this->get(route('entities.map', [1, $map->entity]) . '?lat=12.5&lng=34.5')
        ->assertStatus(200)
        ->assertSee(route('entities.map-api', [$map->entity->campaign, $map->entity, 'lat' => '12.5', 'lng' => '34.5']), false);
});
```

The existing test `it('renders the map page for a map entity', ...)` in this same file already asserts the API URL has no query string when none is present on the page request — that test must keep passing unchanged, proving this task doesn't affect the no-query-param case.

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter="forwards focus"`
Expected: FAIL — the rendered page's `api` URL has no query string yet.

- [ ] **Step 3: Forward the query params in the controller**

In `app/Http/Controllers/Entity/Maps/ShowController.php`, change:

```php
        if ($map->isChunked() && ! $map->chunkingReady()) {
            return redirect()->route('entities.show', [$campaign, $entity]);
        }

        return view('entities.pages.map.index', compact('campaign', 'entity'));
```

to:

```php
        if ($map->isChunked() && ! $map->chunkingReady()) {
            return redirect()->route('entities.show', [$campaign, $entity]);
        }

        $query = request()->only(['focus', 'lat', 'lng']);

        return view('entities.pages.map.index', compact('campaign', 'entity', 'query'));
```

(`Request::only()` omits any key not present on the request, so `$query` naturally contains just whichever of `focus`/`lat`/`lng` were actually passed — an empty array when none were.)

- [ ] **Step 4: Forward the query params onto the rendered API URL**

In `resources/views/entities/pages/map/index.blade.php`, change:

```blade
        <map-explorer
            api="{{ route('entities.map-api', [$campaign, $entity]) }}"
```

to:

```blade
        <map-explorer
            api="{{ route('entities.map-api', array_merge([$campaign, $entity], $query)) }}"
```

(Laravel's `route()` maps unkeyed array items to route path parameters positionally, in order — `$campaign`/`$entity` — and appends any remaining keyed items as query string parameters. When `$query` is empty this produces the exact same URL as before.)

- [ ] **Step 5: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="forwards focus|renders the map page for a map entity"`
Expected: both passing.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/Entity/Maps/ShowController.php resources/views/entities/pages/map/index.blade.php tests/Feature/Entities/Maps/ShowControllerTest.php
git commit -m "feat: forward focus/lat/lng query params from the map page to the v4 map API"
```

---

### Task 3: End-to-end verification

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

Expected: no remaining style issues.

- [ ] **Step 3: Manual walkthrough**

Using a map with at least one existing marker (`id` known) and a known `campaign`/`entity` ID:
1. Visit `/w/{campaign}/entities/{entity}/map?focus={marker_id}` — confirm the v4 explorer opens centered on that marker, not the map's configured center.
2. Visit `/w/{campaign}/entities/{entity}/map?lat=X&lng=Y` with arbitrary in-bounds coordinates — confirm the explorer opens centered there instead.
3. Visit `/w/{campaign}/entities/{entity}/map?focus=999999999` (a marker ID that doesn't exist) — confirm the explorer opens at the map's normal configured center (no error page).
4. Visit `/w/{campaign}/entities/{entity}/map` with no query string — confirm nothing changed from before this plan.
5. In all four cases, confirm the zoom level is the same as it would be without any override (i.e., `focus`/`lat`/`lng` never change zoom).

- [ ] **Step 4: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own tests, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in focus/center override end-to-end verification"
```
