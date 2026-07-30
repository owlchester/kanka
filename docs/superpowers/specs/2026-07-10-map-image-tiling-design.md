# Map Image Tiling Design

## Goal

Large map images (≥ a configurable size threshold, default 10 MiB) currently render as a single giant `<img>`/`L.imageOverlay`, which is slow to load and hard on mobile. Instead, such images should be split into a zoom-dependent tile pyramid (deep-zoom style) and served via a Leaflet tile layer, exactly like the OpenStreetMap (`is_real`) case already does. While an image is being tiled, any map using it must show a "please try again soon" placeholder instead of attempting to render it, everywhere maps can render. Tiling is scoped **per gallery image**, not per map, so multiple maps/layers reusing the same large image share one tiling pass and one status.

## Out of Scope

- **Legacy `image_path` images.** Maps/layers whose image comes from the legacy direct-upload path (`entity->image_path`, no gallery `Image` row) are never tiled — there's no `Image` row to key tiling status/storage off of. They keep rendering as a plain image overlay regardless of size, same as today.
- **Iframe/mention embed.** No such feature exists in this codebase today (searched, only a static non-interactive tooltip/popover exists) — nothing to gate here.
- **General gallery-wide backfill sweep.** No blanket "walk every existing image and tile the big ones" job. Coverage for pre-existing large maps is the proactive in-app migration prompt (below) plus a manual `artisan maps:tile {map}` fallback — not an automatic mass job.
- **Gallery UI changes.** Tiles must not show up in the gallery in any special way (no separate "tiled" badge, no separate gallery entry) — this is naturally satisfied since tiling only ever touches the existing `Image` row's status and a side folder of derived files, not the gallery listing itself.
- **Non-map/layer images.** Portraits, tokens, entity avatars, etc. are never tiled even if they're huge — tiling only triggers when an oversized image is actually assigned as a `Map` base image or `MapLayer` image (see Architecture §2).

## Background

- A 2022-era attempt at this ("chunking") is already partially in the codebase, revived/half-wired on 2026-07-03 alongside the new Vue map explorer effort, but disconnected and stale:
  - `Map` (`app/Models/Map.php`) already has `MIN_ZOOM_CHUNK`/`MAX_ZOOM_CHUNK` constants, `CHUNKING_RUNNING`/`CHUNKING_FINISHED`/`CHUNKING_ERROR`, and `isChunked()`/`chunkingReady()`/`chunkingRunning()`/`chunkingError()`, all keyed off a `maps.chunking_status` column added in `2026_07_03_223222_add_chunking_status_to_maps_table.php`. Nothing in the app ever writes to this column outside of tests setting it directly.
  - `App\Services\Maps\ChunkingService` generates 256px tiles with 1px overlap using **Intervention Image v3's GD driver** (not Imagick, not libvips) — this is the "incredibly slow" implementation. It reads `$map->image`, a legacy string column that no current code path populates (the real image lives on `entity->image` (gallery) / `entity->image_path` (legacy), resolved via `Map::prepareBounds()`).
  - `App\Jobs\ChunkMapJob` wraps the service, runs on the `heavy` queue connection (already configured in `config/queue.php`, explicitly commented "for heavy jobs like map chunking"), but **is never dispatched anywhere** in the app.
  - `ChunkingService` also has a disk inconsistency: it hardcodes `Storage::disk('s3')->get()` to read the original image while writing tile output to the default disk — works by luck where `default == s3` in production, would break locally where default is `public`.
  - The gating logic is, however, already live and wired all the way through: `ExploreController` (legacy explore page) and `ShowController` (new Vue explorer) both already redirect away when `isChunked() && !chunkingReady()`; `ExploreResource` (grid/search list) already has explicit running/error branches; `MapResource` already emits `is_chunked`/`chunks_url`; `LeafletCanvas.vue`'s `buildBaseLayer()` already branches `is_chunked` into an `L.tileLayer(props.map.chunks_url, ...)`. None of this frontend/gating plumbing needs to be built from scratch — it needs to be re-pointed at a per-image status instead of a per-map one, and renamed.
  - `map_markers.chunking_status` is a separate, entirely unused leftover column (no code reads or writes it) — unrelated dead weight, cleaned up alongside this work.
- This design renames the whole concept from "chunking" to **"tiling"** throughout (columns, constants, methods, routes, JSON fields, JS branches, service/job classes) — since the data model is moving from `maps` to `images` anyway, touching every call site is unavoidable, so the clearer name comes for free.
- Storage limit tracking (`App\Services\Gallery\StorageService::usedSpace()`) sums `Image::sum('size')` — a column set once at gallery-upload time from the original file size. Tile output written straight to disk (outside the `images` table) never contributes to this sum. This is already true today for the original image-writing path even before this feature — no code change needed to exclude tile storage from campaign limits, just a documenting comment at the write site.
- The stock Laravel Sail Docker image (`vendor/laravel/sail/runtimes/8.4/Dockerfile`) installs `php8.4-imagick` but not libvips. This design uses libvips (via the `vips` CLI, shelled out to — avoiding a compiled PHP extension) for tiling, since it is dramatically faster than GD/Imagick for large-image tile generation. A published (`sail:publish`) custom Dockerfile adds `libvips-tools` for local dev; production install of `libvips-tools` is handled separately, out of scope for this change.

## Architecture

### 1. Data model

Migration:
- `images` table: add `tiling_status` (nullable unsigned tinyint: `1`=running, `2`=finished, `3`=error, `null`=not tiled/not applicable) and `tiling_error` (nullable text — last failure message, for debugging).
- `maps` table: add `tiling_prompt_dismissed_at` (nullable timestamp — tracks the one-time "migrate to faster rendering" UI offer, a UI concern distinct from the actual tiling status which now lives on `images`). Drop the now-redundant `chunking_status` column.
- `map_markers` table: drop the unused `chunking_status` column.

`Image` model (`app/Models/Image.php`) gains:
```php
public const TILING_RUNNING = 1;
public const TILING_FINISHED = 2;
public const TILING_ERROR = 3;

public function isTiled(): bool
{
    return ! empty($this->tiling_status);
}

public function tilingRunning(): bool
{
    return $this->tiling_status === self::TILING_RUNNING;
}

public function tilingError(): bool
{
    return $this->tiling_status === self::TILING_ERROR;
}

public function tilingReady(): bool
{
    return ! $this->tilingRunning();
}
```
Note `tilingReady()` is true for both `TILING_FINISHED` and `TILING_ERROR` (and `null`) — only `TILING_RUNNING` blocks rendering. A permanently-failed tiling attempt falls back to plain image rendering rather than blocking the map forever (see §4).

`Map` and `MapLayer` get thin proxies delegating to their gallery image, `false`/ready-by-default when there's no gallery image (legacy `image_path` case):
```php
// Map
public function isTiled(): bool
{
    return $this->entity->image?->isTiled() ?? false;
}

public function tilingRunning(): bool
{
    return $this->entity->image?->tilingRunning() ?? false;
}

public function tilingReady(): bool
{
    return $this->entity->image === null || $this->entity->image->tilingReady();
}
```
`MapLayer` mirrors this against its own `image` relation.

### 2. Trigger

Tiling is triggered only at the point a gallery `Image` is **assigned** as a `Map`'s base image or a `MapLayer`'s image (not on generic gallery upload — avoids wastefully tiling large portraits/handouts never used as a map surface, and avoids touching `EntitySaveService::applyGalleryFields()`, which is shared by every entity type, not just maps). Hook: whichever save-lifecycle point reliably sees the entity's `image_uuid` change for a map specifically (e.g. an `Entity`-level observer checking `wasChanged('image_uuid')` gated on the entity being a map, or `MapObserver::saved()` if entity and map saves are reliably ordered — exact wiring point to be confirmed against `EntitySaveService`'s save order during planning) calls `maybeTriggerTiling()` on the new image; `MapLayer`'s own save path does the same for its `image_uuid` field.

```php
public function maybeTriggerTiling(Image $image): void
{
    if ($image->tiling_status !== null) {
        return; // already tiled, running, or permanently errored — no-op
    }

    if ($image->size < config('maps.tiling_threshold_kb')) {
        return;
    }

    // Atomic guard: only one job per image, even if two maps/layers
    // are assigned the same oversized image concurrently.
    $updated = Image::where('id', $image->id)
        ->whereNull('tiling_status')
        ->update(['tiling_status' => Image::TILING_RUNNING]);

    if ($updated) {
        TileImageJob::dispatch($image)->onQueue('heavy');
    }
}
```
`config('maps.tiling_threshold_kb')` defaults to 10 * 1024 (10 MiB), matching `Image::size`'s KB unit.

### 3. Tiling engine

`App\Services\Maps\TilingService` (replaces `ChunkingService`) shells out to the `vips` CLI via `Symfony\Component\Process\Process` rather than a PHP extension:
- Reads the source file from the same disk/path resolution `Image` already uses for its own URL (fixing the old hardcoded-`s3` inconsistency — always the configured default disk, matching how the image was written).
- Generates a tile pyramid honoring the image's **native aspect ratio** (no padding to square) — 256px tiles, computing zoom levels from actual width/height (replacing the old hardcoded `MIN_ZOOM_CHUNK`/`MAX_ZOOM_CHUNK` with a per-image computed range, still exposed the same way to the frontend).
- Writes output to `{disk}/images/{uuid}/tiles/{z}/{x}_{y}.jpg`, keyed by **image UUID**, not map ID — this is what makes tiling shared across maps/layers reusing the same image.

`App\Jobs\TileImageJob` (replaces `ChunkMapJob`):
```php
public function __construct(public Image $image)
{
    $this->onConnection('heavy');
}

public int $tries = 3;
public array $backoff = [30, 60, 120];

public function handle(TilingService $service): void
{
    $service->tile($this->image);

    $this->image->update(['tiling_status' => Image::TILING_FINISHED, 'tiling_error' => null]);

    TilingChanged::broadcastForImage($this->image);
}

public function failed(\Throwable $e): void
{
    $this->image->update([
        'tiling_status' => Image::TILING_ERROR,
        'tiling_error' => $e->getMessage(),
    ]);

    Log::error('Map image tiling failed permanently', ['image_id' => $this->image->id, 'exception' => $e]);

    TilingChanged::broadcastForImage($this->image);
}
```

### 4. Serving & deletion

- The existing `maps.tiles` route (renamed from `maps.chunks`, permission-checked via the **map's** own visibility — unchanged auth model) resolves tiles via `$map->entity->image->id` instead of the map's own ID, so two maps sharing one image serve from the same folder.
- A new equivalent route/action serves layer tiles, permission-checked via the **layer's** own visibility, resolving via the layer's image UUID.
- Deleting an `Image` (gallery delete, `app/Http/Controllers/Gallery/DeleteController.php`) also deletes its `images/{uuid}/tiles/` folder, hooked into the existing image-deletion path.
- Storage-limit exclusion needs no code change (see Background) — add a one-line comment at the tile-write site documenting this is deliberate, so a future storage audit doesn't start walking `images/*/tiles/` expecting it to count.

### 5. Rendering gating across all surfaces

| Surface | Change |
|---|---|
| Legacy explore page (`Maps\ExploreController`) | Keeps its existing redirect-with-flash-message behavior; repointed to check `$map->tilingRunning()`/`tilingReady()` (image-backed) instead of the map's own old column. |
| New Vue explorer (`ShowController` + `MapExplorer.vue`) | **No longer redirects.** Page renders normally; `entities.map-api` payload carries `tiling: 'running'\|'error'\|null`. `MapExplorer.vue` shows an inline placeholder (reusing the existing loading/error template pattern at the top of the file) — *"This map's resources are being tiled. Please try again soon."* — instead of the canvas, only while `tiling === 'running'`. |
| Dashboard widget (`dashboard/widgets/previews/map.blade.php`) | Already gated via `Map::explorable()`, which already factors in tiling state through the proxied methods; fallback copy tweaked to read sensibly ("map is being processed") rather than just rendering blank. |
| Grid/search list (`ExploreResource`) | Existing explicit running/error branches repointed at the image's tiling state. |
| Layers | A layer whose image `tilingRunning()` is simply omitted from the `layers` array in the map-api payload (and thus the layer toggle UI) until ready. Base map and other ready layers keep working — only that one layer is unavailable. |

### 6. Live updates

New `App\Events\Maps\TilingChanged` (`ShouldBroadcastNow`, `ShouldRescue`), following the exact `MarkerChanged`/`ContentsChanged` convention — broadcasts on `PresenceChannel('map.{id}')` via reverb. A static helper finds every `Map`/`MapLayer` currently referencing the image (by `image_uuid`) and dispatches one event per affected map:
```php
public static function broadcastForImage(Image $image): void
{
    $mapIds = Map::whereHas('entity', fn ($q) => $q->where('image_uuid', $image->id))->pluck('id')
        ->merge(MapLayer::where('image_uuid', $image->id)->pluck('map_id'))
        ->unique();

    foreach ($mapIds as $mapId) {
        static::dispatch($mapId, $image);
    }
}
```
`useMapPresence.js` adds a `.MapTilingChanged` listener (same public/admin channel split already used for markers/contents), wired to a new `onTilingChanged` callback. `MapExplorer.vue` handles it by re-fetching or patching the map's `tiling`/`tiles_url` state, swapping the waiting placeholder out for the live map automatically.

### 7. Migration prompt (existing large legacy maps)

In `MapExplorer.vue`, when the map is editable (`canEdit`), its base image is gallery-backed, over the threshold, not currently tiled/tiling, and `tiling_prompt_dismissed_at` is null, show a one-time banner:

> "This map has a large image and is using an older, slower rendering mode. Do you want to migrate to a new version? This will mean the map is unavailable for a few minutes, but in exchange the map will load much faster in the future." — **Migrate** / **No thanks**

Either choice sets `tiling_prompt_dismissed_at` (dismiss just hides it; migrate additionally triggers tiling via `maybeTriggerTiling()`, bypassing the "already assigned" trigger condition since the image was already assigned before this feature existed). A companion `artisan maps:tile {map}` command provides a manual CLI fallback that does the same thing.

## Testing

Backend (Pest, following existing map-explorer test conventions): `Image::isTiled()`/`tilingReady()`/`tilingRunning()`/`tilingError()` state transitions; `Map`/`MapLayer` proxy methods against a gallery-backed image vs. a legacy `image_path`-only entity (always not-tiled); `maybeTriggerTiling()` threshold gating and the atomic dedup guard (two concurrent assignments of the same oversized image only dispatch one job); `TileImageJob` success path (mocking the `vips` process call) and the final-failure path (exhausts retries → `TILING_ERROR` + `tiling_error` set + still `tilingReady()`); `TilingChanged::broadcastForImage()` fires once per distinct map/layer referencing the image; the `entities.map-api` payload's `tiling` field across running/error/null states; the legacy `ExploreController` redirect still occurs only while running; layer omission from the API payload while its image is tiling; tile/deletion cleanup when an `Image` is deleted.

Frontend: no automated Vue/Leaflet real-time test coverage exists in this app (established precedent, per `MarkerChanged` design). Manual verification: uploading/assigning an oversized image to a map shows the inline "being tiled" placeholder in the new Vue explorer and the legacy explore redirect-with-message; the map becomes interactive automatically (no refresh) once tiling finishes, via the live broadcast; a map with a still-tiling layer renders the base map and other layers normally, with the tiling layer absent from the toggle list; the one-time migration banner shows once on an eligible pre-existing large map, dismissing or migrating removes it permanently; the `artisan maps:tile {map}` command manually triggers tiling for a given map's image.
