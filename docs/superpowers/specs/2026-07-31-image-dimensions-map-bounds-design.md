# Image dimensions & map/layer bounds

## Context

Map bounds recalculation was recently fixed by bringing back `Map::prepareBounds()`
(`app/Models/Map.php`), which lazily calculates a map's width/height from its image and
caches the result on `maps.width`/`maps.height`. This works, but highlighted a design
smell: an image's dimensions are being cached on every *consumer* of that image (the
`Map` model) instead of living on the image itself — even though most maps now use a
gallery image (`Entity::image` / `App\Models\Image`) rather than the legacy
`Entity::image_path` upload.

Separately, `map_layers` overlays are built using the *base map's* bounds
(`resources/views/maps/_setup.blade.php:35,37`, `resources/js/components/maps/LeafletCanvas.vue:218`)
rather than the layer's own image dimensions, which is wrong whenever a layer's image
has a different size than the base map.

This spec covers moving dimension storage onto the `Image` model, and then teaching
`Map` and `MapLayer` to source their bounds from the right place depending on whether
they use a gallery image or a legacy direct-upload path.

## Phase 1 — Image dimensions

### Migration

Add a nullable `metadata` json column to `images`, following the existing pattern
already used by `entity_assets.metadata` and `campaign_events.metadata` (both simple
`array`-cast json columns for extensible, non-relational properties). Not part of
`Image::$fillable` — only ever set by application code, never user input.

Shape: `{"width": int, "height": int}`. Room to add more processed-at-upload
properties later (e.g. a dominant color, an EXIF-derived rotation) without another
migration.

### `Image` model additions

- `width(): ?int`, `height(): ?int`, `hasDimensions(): bool` — read from `metadata`.
- `static dimensionsForPath(string $path): array{width: int, height: int}` — the actual
  file-reading logic, extracted from the existing `Map::prepareBounds()` body:
  - SVG (`Str::endsWith($path, '.svg')`): `Storage::get()` the full contents, parse
    width/height off the root `<svg>` element via `simplexml_load_string()`.
  - Raster: `Storage::readStream()` and read only the first 64KB, then
    `getimagesizefromstring()` — dimensions live in the header, no need to pull a
    50MB+ file to parse a handful of bytes.
  - Fonts (`woff`/`woff2`) and folders are never asked for dimensions — callers guard
    on `hasThumbnail() || isSvg()` before calling this.
- `calculateDimensions(): array` — instance convenience wrapping
  `static::dimensionsForPath($this->path)`.
- `ensureDimensions(): void` — if `hasDimensions()` is false, calculate and merge into
  `metadata`, then `saveQuietly()`. Guarded by `auth()->check()`, mirroring the existing
  replica-safety guard in `Map::prepareBounds()` (don't write from an unauthenticated
  read-replica request).

`Map::prepareBounds()`'s legacy (`entity->image_path`) branch, and the new
`MapLayer` legacy branch (Phase 2), both call `Image::dimensionsForPath()` instead of
duplicating the SVG/raster parsing.

### Populate at upload time

`App\Services\Gallery\UploadService` is the shared entry point behind the gallery
page, the entity image picker (`EntityImageApiController`), and campaign import
(`ImportController`, `SignedUploadService`). In both `file()` and `url()`, right after
the file is physically written to disk (it must exist on disk first — `Storage`-based
reading needs a real path), call `$this->image->ensureDimensions()`.

This is a second small `update()` after the initial `save()` (which is needed first to
know the image's id-derived storage path) — acceptable, upload is already a multi-step
write path (save row, store file, clear cache).

Any image created outside this path (other/legacy upload code, pre-existing images
from before this feature shipped) simply has no `metadata` yet — that's fine, because
Phase 2's `ensureDimensions()` calls act as a universal lazy self-heal the first time a
map or layer touches that image, exactly like `Map::prepareBounds()` already
self-heals today.

## Phase 2 — Map and MapLayer bounds

### `Map`

`prepareBounds()` branches on image source:

- **Gallery image** (`entity->image` present): call
  `$this->entity->image->ensureDimensions()` and read width/height straight off the
  image. Nothing is cached on `Map` in this case — the image is the single source of
  truth. (`ensureDimensions()` is a cheap no-op array check once metadata exists, so
  calling it on every `bounds()` call is fine.)
- **Legacy `entity->image_path`** (pre-gallery direct-upload maps): unchanged
  behavior — calculate once via `Image::dimensionsForPath()` and cache onto
  `maps.width`/`maps.height` as today.

`Map::bounds()` reads from whichever source `prepareBounds()` populated.

### `MapLayer`

New `dimensions(): array` / `bounds(bool $extend = false): string` methods (same
shape/output format as `Map::bounds()`):

- **Gallery image** (`$layer->image` present): `ensureDimensions()` on the image, use
  its width/height live. Nothing persisted on `map_layers`.
- **Legacy `image_path`** layers (some older maps still have layers outside the
  gallery): calculate once via `Image::dimensionsForPath()` and cache onto the
  existing `map_layers.width`/`height` columns (present since the original
  `create_maps_table` migration, currently unpopulated dead weight) — same
  calculate-and-cache pattern as legacy `Map`.
- **Neither** (shouldn't normally happen — `hasImage()` already filters these out
  upstream): fall back to the parent map's dimensions, so nothing regresses.

`MapLayerResource` changes to call `$model->dimensions()` instead of reading the raw
`width`/`height` columns directly, so gallery-backed layers report their real image
size instead of `0`.

### Frontend

The actual bug that prompted this: layer overlays are built with the *map's* bounds
instead of their own.

- `resources/views/maps/_setup.blade.php` — both `L.imageOverlay('...', bounds{{
  $map->id }})` lines for layers (currently lines 35 and 37) change to
  `L.imageOverlay('...', {!! $layer->bounds() !!})`.
- `resources/js/components/maps/LeafletCanvas.vue` — the `bounds()` helper (line 178)
  is currently reused for every layer overlay (line 218: `L.imageOverlay(layer.image,
  bounds())`). Add a per-layer bounds calculation using `layer.width`/`layer.height`
  (now correctly populated via `MapLayerResource`), falling back to `props.map`'s
  dimensions only if a layer has no dimensions of its own.

## Out of scope

- No changes to `ImageResource` / gallery UI to surface dimensions to users — not
  needed by this work, can be added later against the same `metadata` column.
- No backfill migration/command to eagerly compute `metadata` for all existing
  images — the lazy `ensureDimensions()` self-heal covers this without a one-off
  script.
- SVG sanitization / upload validation behavior is unchanged.
