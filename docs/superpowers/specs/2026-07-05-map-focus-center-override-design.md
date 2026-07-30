# Map Focus/Center URL Override for v4 Explorer Design

## Goal

Port the legacy map's URL-driven initial-centering override to the v4 (Vue/Leaflet) explorer: loading `/entities/{entity}/map` with a `focus` (marker ID) or `lat`/`lng` (raw coordinates) query parameter should center the map there on that page load, overriding the map's own configured center (`center_x`/`center_y`/`center_marker_id`) for that render only — never persisting it, never touching zoom.

## Out of Scope

- No changes to any existing link-generation code elsewhere in the app. This ports the *receiving* mechanism only; whatever currently links to the legacy map with these params keeps doing so, and nothing is rewritten to point at v4 as part of this work.
- No change to zoom behavior — legacy never adjusts zoom for this override, and v4 won't either (`initial_zoom` still applies unconditionally).
- No interaction with the quick-settings panel's centering feature (grid/zoom/distance/centering, shipped earlier on this branch) — this is a one-time render override, not a setting, and isn't surfaced or editable there.
- No frontend (`resources/js/components/maps/*.vue`) changes at all — see Architecture.

## Background

Legacy's override lives in `resources/views/maps/_setup.blade.php`, read directly off the current request:
```php
$focus = $map->centerFocus();                 // default: map's own configured center

if (isset($single) && $single) {
    $focus = "$model->latitude, $model->longitude";
} elseif (request()->has('lat') && request()->has('lng')) {
    $focus = ((float) request()->get('lat')) . ', ' . ((float) request()->get('lng'));
} elseif (request()->has('focus')) {
    $pin = $map->markers->where('id', request()->get('focus', 0))->first();
    if ($pin) {
        $focus = "$pin->latitude, $pin->longitude";
    }
}
```
Precedence: `lat`/`lng` wins over `focus`; an invalid, missing, or wrong-map marker ID silently falls back to the map's own configured center. Zoom is untouched — both Leaflet branches always use `$map->initialZoom()`. The only current caller is `App\Http\Controllers\Maps\MarkerController::store()`/`update()`, redirecting back to `maps.explore?focus=<new marker id>` after saving a pin in the legacy editor.

v4 has no equivalent today. `App\Http\Resources\Maps\Explore\MapResource::toArray()` always emits `'center' => array_map('floatval', explode(', ', $map->centerFocus()))` — the persisted center only, with no request awareness. `MapResource::toArray()` already receives `$request` as its second parameter (currently unused for this purpose), and `resources/js/components/maps/LeafletCanvas.vue`'s `onMounted` already seeds `L.map()`'s `center` option from `props.map.center` unconditionally — the same single field this override needs to change. No other code path reads `map.center` for anything beyond that one-time seed (the quick-settings panel's `previewCenter` mechanism and the `centerNonce`/`centerPin` mechanism are both separate, unrelated props). This means the override can live entirely server-side with zero frontend changes.

## Architecture

**1. Forward the query params from the page to the API call** — `App\Http\Controllers\Entity\Maps\ShowController::index()` currently renders `entities.pages.map.index` with just `campaign`/`entity`; the view builds the `<map-explorer api="...">` URL via `route('entities.map-api', [$campaign, $entity])`. Change this to forward any of `focus`/`lat`/`lng` present on the page request onto that URL, e.g.:
```php
$query = request()->only(['focus', 'lat', 'lng']);

return view('entities.pages.map.index', compact('campaign', 'entity', 'query'));
```
(`Request::only()` already omits any key not present on the request, so `$query` naturally contains just whichever of `focus`/`lat`/`lng` were actually passed.)
and in the view, `route('entities.map-api', array_merge([$campaign->id, $entity->id], $query))` — Laravel's URL generator appends array keys that don't match route path parameters as a query string, so this produces `.../map-api?focus=123` (or `?lat=...&lng=...`) exactly when those params were present on the page load, and the plain URL otherwise.

**2. Apply the override in `MapResource::toArray()`** — since the Vue app's initial `axios.get(props.api)` now carries the forwarded query string, `EntityMapApiController::index()`'s request (and therefore the `$request` already injected into `MapResource::toArray(Request $request)`) has `focus`/`lat`/`lng` available directly. Replace the unconditional `centerFocus()`-based center computation with the same precedence legacy uses:
```php
$center = array_map('floatval', explode(', ', $map->centerFocus()));

if ($request->filled('lat') && $request->filled('lng')) {
    $center = [(float) $request->query('lat'), (float) $request->query('lng')];
} elseif ($request->filled('focus')) {
    $pin = $map->markers->firstWhere('id', (int) $request->query('focus'));
    if ($pin) {
        $center = [(float) $pin->latitude, (float) $pin->longitude];
    }
}
```
`$map->markers->firstWhere('id', ...)` is naturally scoped to the map's own markers (mirrors legacy's `$map->markers->where('id', ...)->first()`), so a marker ID belonging to a different map is simply not found and falls back to the configured center, same as legacy. `'center'` in the returned array becomes this `$center` array instead of the always-`centerFocus()` value.

**3. No frontend changes** — `LeafletCanvas.vue`'s `onMounted` already does `center: props.map.center`; since that's the only consumer of this field, the override is already fully wired once steps 1–2 land.

## Testing

Backend: Pest feature tests on `GET /entities/{entity}/map-api` (the existing `entities.map-api` route) covering:
- `?lat=X&lng=Y` overrides the returned `map.center` to `[X, Y]`, regardless of the map's configured `center_x`/`center_y`/`center_marker_id`.
- `?focus=<valid marker id on this map>` overrides `map.center` to that marker's `[latitude, longitude]`.
- `?focus=<marker id belonging to a different map>` and `?focus=<nonexistent id>` both fall back to the map's own configured center (no error).
- Both `lat`/`lng` and `focus` present together — `lat`/`lng` wins (matches legacy precedence).
- No query params — unchanged existing behavior (`centerFocus()`), covered by already-existing tests, confirming no regression.
- A parallel test on `GET /entities/{entity}/map` (the page route, `entities.map`) confirming the rendered `<map-explorer api="...">` attribute's URL contains the forwarded `focus`/`lat`/`lng` query string when present on the page request, and omits it entirely when absent.

No frontend test needed — no frontend code changes.
