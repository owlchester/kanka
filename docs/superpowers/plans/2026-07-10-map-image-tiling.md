# Map Image Tiling Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Large map/layer images (≥ a configurable threshold, default 10 MiB) get split into a Leaflet-servable tile pyramid via libvips, generated on the `heavy` queue, scoped per gallery `Image` (shared across maps/layers reusing the same image) rather than per map — resurrecting and fixing the dead 2022 "chunking" attempt already partially wired into this codebase.

**Architecture:** Move tiling status from `maps.chunking_status` (dead, unused) to a new `images.tiling_status`/`images.tiling_error`. `Map`/`MapLayer` keep thin proxy methods delegating to their gallery `Image`. A `TilingTriggerService` is called from `EntityObserver`/`MapLayerObserver` whenever a map/layer's image assignment changes, atomically guarding against duplicate jobs for a shared image. `TileImageJob` (on the existing `heavy` queue) shells out to the `vips` CLI via `TilingService`, writes tiles keyed by image UUID, and broadcasts a `TilingChanged` event (mirroring the existing `MarkerChanged`/`ContentsChanged` reverb convention) to every map/layer using that image. Rename "chunking" → "tiling" throughout every touched call site, since the data model move touches them all anyway.

**Tech Stack:** Laravel 11, PHP 8.4, Pest 3, Vue 3, Leaflet, Reverb (websockets), Redis-backed `heavy` queue, `vips` CLI (libvips-tools) shelled out to via `Symfony\Component\Process\Process`.

## Global Constraints

- Legacy `entity->image_path`-only maps/layers (no gallery `Image` row) are never tiled — all proxy methods must return "not tiled" for them, never throw.
- Tiling triggers only when an oversized image is assigned as a `Map`'s base image or a `MapLayer`'s image — never on generic gallery upload.
- A permanently failed tiling attempt (`TILING_ERROR`) must fall back to plain image rendering, not block the map. Only `TILING_RUNNING` blocks/gates rendering.
- No new Composer dependency (`Symfony\Component\Process\Process` is already a transitive dependency, already used directly elsewhere in this codebase — see `app/Providers/AppServiceProvider.php:75,146-149`).
- Tile storage must not count toward campaign gallery storage limits (already true by omission — `StorageService::usedSpace()` only sums `images.size`; document this, no code change needed there).
- Follow existing code conventions exactly: Pest functional (`it('...', function () {...})`) tests, `$this->asUser()->withCampaign()` helper, non-fillable columns set via direct property assignment + `saveQuietly()` when a test needs to bypass observers, `App\Facades\Limit`-style config access, PHP 8 constructor promotion, curly braces always, explicit return types.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP changes in a task before committing that task, and `vendor/bin/sail artisan test --compact --filter=<Name>` to verify the affected tests, per this repo's CLAUDE.md.

---

## Task 1: Migrations & config

**Files:**
- Create: `database/migrations/2026_07_10_000001_add_tiling_status_to_images_table.php`
- Create: `database/migrations/2026_07_10_000002_move_tiling_status_off_maps_table.php`
- Create: `database/migrations/2026_07_10_000003_drop_chunking_status_from_map_markers_table.php`
- Create: `config/maps.php`
- Test: `tests/Feature/Migrations/TilingMigrationsTest.php`

**Interfaces:**
- Produces: `images.tiling_status` (nullable unsigned tinyint), `images.tiling_error` (nullable text); `maps.tiling_prompt_dismissed_at` (nullable timestamp); `maps.chunking_status` dropped; `map_markers.chunking_status` dropped; `config('maps.tiling_threshold_kb')` (int, default `10 * 1024`).

- [ ] **Step 1: Write the failing test**

```php
<?php

use Illuminate\Support\Facades\Schema;

it('adds tiling columns to images and maps, and drops the dead chunking columns', function () {
    expect(Schema::hasColumn('images', 'tiling_status'))->toBeTrue();
    expect(Schema::hasColumn('images', 'tiling_error'))->toBeTrue();
    expect(Schema::hasColumn('maps', 'tiling_prompt_dismissed_at'))->toBeTrue();
    expect(Schema::hasColumn('maps', 'chunking_status'))->toBeFalse();
    expect(Schema::hasColumn('map_markers', 'chunking_status'))->toBeFalse();
});

it('defaults the tiling threshold config to 10 MiB', function () {
    expect(config('maps.tiling_threshold_kb'))->toBe(10 * 1024);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=TilingMigrationsTest`
Expected: FAIL (columns don't exist yet, `config('maps.tiling_threshold_kb')` is `null`)

- [ ] **Step 3: Write the migrations and config**

`database/migrations/2026_07_10_000001_add_tiling_status_to_images_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table): void {
            $table->unsignedTinyInteger('tiling_status')->nullable();
            $table->text('tiling_error')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table): void {
            $table->dropColumn(['tiling_status', 'tiling_error']);
        });
    }
};
```

`database/migrations/2026_07_10_000002_move_tiling_status_off_maps_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->timestamp('tiling_prompt_dismissed_at')->nullable();
            $table->dropColumn('chunking_status');
        });
    }

    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->dropColumn('tiling_prompt_dismissed_at');
            $table->unsignedTinyInteger('chunking_status')->nullable();
        });
    }
};
```

`database/migrations/2026_07_10_000003_drop_chunking_status_from_map_markers_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('map_markers', function (Blueprint $table): void {
            $table->dropColumn('chunking_status');
        });
    }

    public function down(): void
    {
        Schema::table('map_markers', function (Blueprint $table): void {
            $table->unsignedTinyInteger('chunking_status')->nullable();
        });
    }
};
```

`config/maps.php` (new file):
```php
<?php

return [
    /**
     * Images at or above this size (in KB) get tiled into a Leaflet-servable
     * pyramid when assigned as a map's base image or a map layer's image.
     */
    'tiling_threshold_kb' => env('MAP_TILING_THRESHOLD_KB', 10 * 1024),
];
```

- [ ] **Step 4: Run migrations and the test**

Run: `vendor/bin/sail artisan migrate && vendor/bin/sail artisan test --compact --filter=TilingMigrationsTest`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add database/migrations/2026_07_10_000001_add_tiling_status_to_images_table.php \
        database/migrations/2026_07_10_000002_move_tiling_status_off_maps_table.php \
        database/migrations/2026_07_10_000003_drop_chunking_status_from_map_markers_table.php \
        config/maps.php \
        tests/Feature/Migrations/TilingMigrationsTest.php
git commit -m "feat: add per-image tiling columns, drop dead chunking columns"
```

---

## Task 2: `Image` model tiling support

**Files:**
- Modify: `app/Models/Image.php`
- Test: `tests/Feature/Models/ImageTilingTest.php`

**Interfaces:**
- Consumes: `images.tiling_status`/`tiling_error` columns (Task 1).
- Produces: `Image::TILING_RUNNING/FINISHED/ERROR` constants; `Image::isTiled()`, `tilingRunning()`, `tilingError()`, `tilingReady()`; `Image::tilesPath(): string` (disk-relative folder, `images/{uuid}/tiles`).

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Image;

it('is not tiled by default', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingRunning())->toBeFalse();
    expect($image->tilingError())->toBeFalse();
    expect($image->tilingReady())->toBeTrue();
});

it('reports running state and blocks readiness while tiling', function () {
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingRunning())->toBeTrue();
    expect($image->tilingReady())->toBeFalse();
});

it('reports tiled true only once finished', function () {
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);

    expect($image->isTiled())->toBeTrue();
    expect($image->tilingReady())->toBeTrue();
});

it('treats a permanent tiling error as ready (fallback to plain rendering), not tiled', function () {
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingError())->toBeTrue();
    expect($image->tilingReady())->toBeTrue();
});

it('builds the tiles storage path keyed by image uuid', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);

    expect($image->tilesPath())->toBe('images/' . $image->id . '/tiles');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ImageTilingTest`
Expected: FAIL with "Call to undefined method App\Models\Image::isTiled()"

- [ ] **Step 3: Implement on the `Image` model**

Add to `database/factories/ImageFactory.php`'s allowed mass-assignment isn't needed — `tiling_status` is set directly in tests like `chunking_status` was, since it stays out of `Image::$fillable` (status columns aren't mass-assignable in this codebase's convention).

In `app/Models/Image.php`, add after the `public $casts = [...]` block (line 80):
```php
    public const TILING_RUNNING = 1;

    public const TILING_FINISHED = 2;

    public const TILING_ERROR = 3;
```

Add these methods (near `isFolder()`/`isSvg()`, e.g. after `hasThumbnail()` at line 334):
```php
    /**
     * Check if this image has a finished tile pyramid ready to serve.
     */
    public function isTiled(): bool
    {
        return $this->tiling_status === self::TILING_FINISHED;
    }

    /**
     * Check if this image is currently being tiled.
     */
    public function tilingRunning(): bool
    {
        return $this->tiling_status === self::TILING_RUNNING;
    }

    /**
     * Check if this image permanently failed tiling.
     */
    public function tilingError(): bool
    {
        return $this->tiling_status === self::TILING_ERROR;
    }

    /**
     * Check if rendering can proceed (tiled, permanently errored/fallback, or never tiled) —
     * only an in-progress tiling job blocks rendering.
     */
    public function tilingReady(): bool
    {
        return ! $this->tilingRunning();
    }

    /**
     * Disk-relative folder this image's tile pyramid is written to and served from.
     */
    public function tilesPath(): string
    {
        return 'images/' . $this->id . '/tiles';
    }
```

Also add `@property ?int $tiling_status` and `@property ?string $tiling_error` to the class docblock (after `@property ?int $focus_y` at line 32).

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ImageTilingTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/Image.php tests/Feature/Models/ImageTilingTest.php
git commit -m "feat: add tiling state methods to Image model"
```

---

## Task 3: `Map` model — rename chunking → tiling, proxy to image

**Files:**
- Modify: `app/Models/Map.php`
- Test: `tests/Feature/Entities/MapTest.php` (append)

**Interfaces:**
- Consumes: `Image::isTiled()/tilingRunning()/tilingError()/tilingReady()` (Task 2), `$this->entity->image` (existing `Entity::image()` relation), `$this->entity->hasImage()` (existing).
- Produces: `Map::isTiled()`, `tilingRunning()`, `tilingError()`, `tilingReady()` (all `false`/`true`-safe with no gallery image); `Map::MIN_ZOOM_TILE`/`MAX_ZOOM_TILE` (renamed from `MIN_ZOOM_CHUNK`/`MAX_ZOOM_CHUNK`, same values 8/13); `explorable()` now returns `true` for a permanently-errored tiling image (falls back to plain rendering) and `false` only while actively tiling.

- [ ] **Step 1: Write the failing test**

Append to `tests/Feature/Entities/MapTest.php`:
```php
it('is not tiled when its entity has no gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeFalse();
    expect($map->tilingReady())->toBeTrue();
});

it('is not tiled for a legacy image_path-only map (no gallery Image row)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_path = 'maps/legacy.png';
    $map->entity->saveQuietly();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeFalse();
    expect($map->tilingReady())->toBeTrue();
    expect($map->explorable())->toBeTrue();
});

it('proxies tiling state from its entity\'s gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_RUNNING]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->refresh();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeTrue();
    expect($map->tilingReady())->toBeFalse();
    expect($map->explorable())->toBeFalse();
});

it('falls back to explorable plain rendering when tiling permanently errored', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_ERROR]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->refresh();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingError())->toBeTrue();
    expect($map->tilingReady())->toBeTrue();
    expect($map->explorable())->toBeTrue();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapTest`
Expected: FAIL with "Call to undefined method App\Models\Map::isTiled()"

- [ ] **Step 3: Rewrite the chunking methods on `Map`**

In `app/Models/Map.php`, replace lines 62-70 (the `MIN_ZOOM_CHUNK`/`MAX_ZOOM_CHUNK`/`CHUNKING_*` constants):
```php
    public const MIN_ZOOM_TILE = 8;

    public const MAX_ZOOM_TILE = 13;
```

Replace the `@property int $chunking_status` docblock line (34) — delete it entirely (status now lives on `Image`, not `Map`).

Replace lines 340-361 (`minZoom()`):
```php
    /**
     * Minimum zoom of a map
     */
    public function minZoom(): int
    {
        if (! is_numeric($this->min_zoom)) {
            if ($this->isReal() || $this->isTiled()) {
                return self::MIN_ZOOM_REAL;
            }

            return -2;
        }

        // if the initial zoom is further away than the min zoom, adapt
        if ($this->min_zoom > $this->initial_zoom && $this->initial_zoom > self::MIN_ZOOM) {
            return $this->initial_zoom;
        }
        // The max zoom is based on the tiled image so we trust this.
        if ($this->isTiled()) {
            return $this->min_zoom;
        }
        $min = $this->isReal() ? self::MIN_ZOOM_REAL : self::MIN_ZOOM;

        return (int) max($this->min_zoom, $min);
    }
```

Replace lines 366-385 (`maxZoom()`):
```php
    /**
     * Maximum zoom of a map
     */
    public function maxZoom(): float
    {
        if (! is_numeric($this->max_zoom)) {
            if ($this->isTiled()) {
                return self::MAX_ZOOM_TILE;
            }
            if ($this->isReal()) {
                return self::MAX_ZOOM_REAL;
            }

            return 2.75;
        }
        // The max zoom is based on the tiled image so we trust this.
        if ($this->isTiled()) {
            return $this->max_zoom;
        }
        $max = $this->isReal() ? self::MAX_ZOOM_REAL : self::MAX_ZOOM;

        return (float) min($this->max_zoom, $max);
    }
```

Replace lines 390-408 (`initialZoom()`), only the `isChunked()` reference changes:
```php
    /**
     * Initiall zoom of a map
     */
    public function initialZoom(): int
    {
        if (! is_numeric($this->initial_zoom)) {
            if ($this->isReal() || $this->isTiled()) {
                return 12;
            }

            return 0;
        }

        if ($this->initial_zoom > self::MAX_ZOOM) {
            return self::MAX_ZOOM;
        }
        if ($this->initial_zoom < self::MIN_ZOOM) {
            return self::MIN_ZOOM;
        }

        return (int) $this->initial_zoom;
    }
```

Replace lines 410-442 (`centerFocus()`), only the `elseif ($this->isChunked())` branch changes:
```php
    public function centerFocus(): string
    {
        // Init position in the middle of the map
        $latitude = $longitude = 0;
        if ($this->isReal()) {
            $latitude = 46.205;
            $longitude = 6.147;
        } elseif ($this->isTiled()) {
            $latitude = 0;
            $longitude = 0;
        } else {
            $latitude = floor($this->height / 2);
            $longitude = floor($this->width / 2);
        }

        // If we have a center marker
        if ($this->centerMarker != null) {
            // use his position
            $latitude = $this->centerMarker->latitude;
            $longitude = $this->centerMarker->longitude;
        } else {
            // Use the center positions if they exist
            if (! empty($this->center_y)) {
                $latitude = $this->center_y;
            }

            if (! empty($this->center_x)) {
                $longitude = $this->center_x;
            }
        }

        return "{$latitude}, {$longitude}";
    }
```

Replace lines 508-521 (`explorable()`) — drop the permanent-error block:
```php
    /**
     * Determine if a map can be explored
     */
    public function explorable(): bool
    {
        if ($this->isReal()) {
            return true;
        }
        if (! $this->entity->hasImage()) {
            return false;
        }

        return ! $this->tilingRunning();
    }
```

Replace lines 542-577 (`isReal()` through `chunkingRunning()`):
```php
    /**
     * Check if a map is using the "real" world (openstreetmaps)
     */
    public function isReal(): bool
    {
        return (bool) $this->is_real;
    }

    /**
     * Check if a map's base image has a finished tile pyramid ready to serve
     */
    public function isTiled(): bool
    {
        return $this->entity->image?->isTiled() ?? false;
    }

    /**
     * Check if a map's base image can render one way or another (tiled, errored-fallback,
     * or never tiled) — only an in-progress tiling job blocks rendering.
     */
    public function tilingReady(): bool
    {
        return $this->entity->image === null || $this->entity->image->tilingReady();
    }

    /**
     * Check if a map's base image permanently failed tiling
     */
    public function tilingError(): bool
    {
        return $this->entity->image?->tilingError() ?? false;
    }

    /**
     * Check if a map's base image is currently being tiled
     */
    public function tilingRunning(): bool
    {
        return $this->entity->image?->tilingRunning() ?? false;
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/Map.php tests/Feature/Entities/MapTest.php
git commit -m "feat: rename Map chunking methods to tiling, proxy to gallery image"
```

---

## Task 4: `MapLayer` model tiling proxies

**Files:**
- Modify: `app/Models/MapLayer.php`
- Test: `tests/Feature/Entities/MapLayerTest.php` (append)

**Interfaces:**
- Consumes: `Image::isTiled()/tilingRunning()/tilingError()/tilingReady()` (Task 2), `MapLayer::image()` (existing `BelongsTo`).
- Produces: `MapLayer::isTiled()`, `tilingRunning()`, `tilingError()`, `tilingReady()`.

- [ ] **Step 1: Write the failing test**

Append to `tests/Feature/Entities/MapLayerTest.php`:
```php
it('proxies tiling state from its gallery image', function () {
    $this->asUser()->withCampaign();
    $map = \App\Models\Map::factory()->create(['campaign_id' => 1]);
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_RUNNING]);
    $layer = \App\Models\MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    expect($layer->isTiled())->toBeFalse();
    expect($layer->tilingRunning())->toBeTrue();
    expect($layer->tilingReady())->toBeFalse();
});

it('is not tiled for a legacy image_path-only layer', function () {
    $this->asUser()->withCampaign();
    $map = \App\Models\Map::factory()->create(['campaign_id' => 1]);
    $layer = \App\Models\MapLayer::factory()->create(['map_id' => $map->id]);
    $layer->image_path = 'maps/legacy-layer.png';
    $layer->saveQuietly();

    expect($layer->isTiled())->toBeFalse();
    expect($layer->tilingRunning())->toBeFalse();
    expect($layer->tilingReady())->toBeTrue();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: FAIL with "Call to undefined method App\Models\MapLayer::isTiled()"

- [ ] **Step 3: Implement on `MapLayer`**

In `app/Models/MapLayer.php`, add after `isExplorable()` (line 148):
```php
    /**
     * Check if this layer's image has a finished tile pyramid ready to serve
     */
    public function isTiled(): bool
    {
        return $this->image?->isTiled() ?? false;
    }

    /**
     * Check if this layer's image is currently being tiled
     */
    public function tilingRunning(): bool
    {
        return $this->image?->tilingRunning() ?? false;
    }

    /**
     * Check if this layer's image permanently failed tiling
     */
    public function tilingError(): bool
    {
        return $this->image?->tilingError() ?? false;
    }

    /**
     * Check if this layer's image can render one way or another
     */
    public function tilingReady(): bool
    {
        return $this->image === null || $this->image->tilingReady();
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=MapLayerTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapLayer.php tests/Feature/Entities/MapLayerTest.php
git commit -m "feat: add tiling proxy methods to MapLayer"
```

---

## Task 5: `TilingTriggerService`

**Files:**
- Create: `app/Services/Maps/TilingTriggerService.php`
- Test: `tests/Feature/Services/Maps/TilingTriggerServiceTest.php`

**Interfaces:**
- Consumes: `Image::TILING_RUNNING` (Task 2), `config('maps.tiling_threshold_kb')` (Task 1).
- Produces: `TilingTriggerService::maybeTrigger(Image $image, bool $force = false): bool` — atomically flips `tiling_status` to `RUNNING` and dispatches `TileImageJob` on the `heavy` queue, returns whether it actually triggered. Used by Task 9 (observers) and Task 14 (migration prompt / CLI command). `TileImageJob` doesn't exist yet — this task fakes the queue and asserts the dispatch by class name string only (no import needed beyond `Illuminate\Support\Facades\Queue`), so it can be written before Task 6.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Facades\Limit;
use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    Queue::fake();
});

it('triggers tiling for an oversized untiled image', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeTrue();
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertPushedOn('heavy', TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('does not trigger for an image below the threshold', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 50]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeFalse();
    expect($image->fresh()->tiling_status)->toBeNull();
    Queue::assertNotPushed(TileImageJob::class);
});

it('does not trigger twice for an image that is already tiled/running/errored', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200, 'tiling_status' => Image::TILING_FINISHED]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeFalse();
    Queue::assertNotPushed(TileImageJob::class);
});

it('force-triggers below the threshold when force is true (manual migrate/CLI path)', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 50]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image, force: true);

    expect($triggered)->toBeTrue();
    Queue::assertPushedOn('heavy', TileImageJob::class);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=TilingTriggerServiceTest`
Expected: FAIL — `App\Services\Maps\TilingTriggerService` doesn't exist (and `App\Jobs\TileImageJob` doesn't exist yet either, so this will fail at class-not-found; that's expected until Task 6 exists — for now write both the service AND a minimal stub `TileImageJob` so this test can pass standalone)

Create a minimal stub now (Task 6 will replace it): `app/Jobs/TileImageJob.php`:
```php
<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TileImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Image $image)
    {
        $this->onConnection('heavy');
    }

    public function handle(): void
    {
        // Implemented in Task 6.
    }
}
```

- [ ] **Step 3: Implement `TilingTriggerService`**

`app/Services/Maps/TilingTriggerService.php`:
```php
<?php

namespace App\Services\Maps;

use App\Jobs\TileImageJob;
use App\Models\Image;

class TilingTriggerService
{
    /**
     * Trigger tiling for an image if it isn't already tiled/running/errored, and it's over the
     * size threshold (unless $force bypasses the threshold — used for the manual migration
     * prompt / artisan command paths). Atomically guards against dispatching the job twice for
     * the same image, even if two maps/layers are assigned the same oversized image concurrently.
     */
    public function maybeTrigger(Image $image, bool $force = false): bool
    {
        if ($image->tiling_status !== null) {
            return false;
        }

        if (! $force && $image->size < config('maps.tiling_threshold_kb')) {
            return false;
        }

        $updated = Image::where('id', $image->id)
            ->whereNull('tiling_status')
            ->update(['tiling_status' => Image::TILING_RUNNING]);

        if (! $updated) {
            return false;
        }

        TileImageJob::dispatch($image)->onQueue('heavy');

        return true;
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=TilingTriggerServiceTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Services/Maps/TilingTriggerService.php app/Jobs/TileImageJob.php tests/Feature/Services/Maps/TilingTriggerServiceTest.php
git commit -m "feat: add TilingTriggerService with atomic dedup guard"
```

---

## Task 6: `TilingService` (libvips engine)

**Files:**
- Create: `app/Services/Maps/TilingService.php`
- Delete: `app/Services/Maps/ChunkingService.php` (dead, replaced)
- Test: `tests/Feature/Services/Maps/TilingServiceTest.php`

**Interfaces:**
- Consumes: `Image::tilesPath()` (Task 2), `Symfony\Component\Process\Process` (already a transitive dependency).
- Produces: `TilingService::tile(Image $image): void` — throws on any `vips` failure (caller, Task 8's `TileImageJob`, catches and records it). `TilingService::command(Image $image, $disk): array` — pure, unit-testable command-building method, extracted so the test doesn't need to mock `Process`/shell out to a real `vips` binary.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Image;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Storage;

it('builds the vips dzsave command with native aspect ratio and an image-keyed destination', function () {
    Storage::fake();
    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    $disk = Storage::disk(config('images.disk'));
    $service = new TilingService;

    $command = $service->command($image, $disk);

    expect($command[0])->toBe('vips');
    expect($command[1])->toBe('dzsave');
    expect($command[2])->toBe($disk->path($image->path));
    expect($command[3])->toBe($disk->path($image->tilesPath()));
    expect($command)->toContain('--layout=google');
    expect($command)->toContain('--suffix=.jpg[Q=85]');
    expect($command)->not->toContain('--square'); // no padding to square — native aspect ratio only
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=TilingServiceTest`
Expected: FAIL — `App\Services\Maps\TilingService` doesn't exist

- [ ] **Step 3: Implement `TilingService`**

`app/Services/Maps/TilingService.php`:
```php
<?php

namespace App\Services\Maps;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class TilingService
{
    /**
     * Generate a Leaflet-servable ("google" layout: {z}/{x}/{y}.jpg) tile pyramid for the given
     * image via the `vips` CLI (libvips-tools), honoring the image's native aspect ratio (no
     * padding to square). Writes to {disk}/images/{uuid}/tiles/. Throws on any vips failure —
     * the caller (TileImageJob) is responsible for catching and recording it.
     */
    public function tile(Image $image): void
    {
        $disk = Storage::disk(config('images.disk'));

        $disk->deleteDirectory($image->tilesPath());
        $disk->makeDirectory($image->tilesPath());

        $process = new Process($this->command($image, $disk));
        $process->setTimeout(0);
        $process->mustRun();
    }

    /**
     * @return string[]
     */
    public function command(Image $image, Filesystem $disk): array
    {
        return [
            'vips', 'dzsave',
            $disk->path($image->path),
            $disk->path($image->tilesPath()),
            '--layout=google',
            '--suffix=.jpg[Q=85]',
            '--tile-size=256',
            '--overlap=0',
        ];
    }
}
```

Delete `app/Services/Maps/ChunkingService.php` — it is dead code (never dispatched, reads a stale `maps.image` column nothing populates, uses slow GD, pads to square) fully replaced by the above.

```bash
git rm app/Services/Maps/ChunkingService.php
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=TilingServiceTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Services/Maps/TilingService.php tests/Feature/Services/Maps/TilingServiceTest.php
git commit -m "feat: add libvips-based TilingService, remove dead ChunkingService"
```

---

## Task 7: `TilingChanged` broadcast event

**Files:**
- Create: `app/Events/Maps/TilingChanged.php`
- Test: `tests/Feature/Events/Maps/TilingChangedTest.php`

**Interfaces:**
- Consumes: `Map::entity()` relation (`whereHas`), `MapLayer::image_uuid` column, `Image::tilingRunning()/tilingError()` (Task 2).
- Produces: `TilingChanged::broadcastForImage(Image $image): void` (static helper, used by Task 8's `TileImageJob`); event broadcasts as `MapTilingChanged` on `PresenceChannel('map.{id}')`, payload `{'status': 'running'|'error'|'finished'}`.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Events\Maps\TilingChanged;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Event;

it('broadcasts running/error/finished status derived from the image', function () {
    $running = new TilingChanged(1, 'running');
    expect($running->broadcastAs())->toBe('MapTilingChanged');
    expect($running->broadcastWith())->toBe(['status' => 'running']);
    expect($running->broadcastOn()[0])->toBeInstanceOf(PresenceChannel::class);
});

it('broadcasts once per distinct map whose base image matches, via broadcastForImage', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    TilingChanged::broadcastForImage($image);

    Event::assertDispatched(TilingChanged::class, fn ($event) => $event->mapId === $map->id && $event->status === 'finished');
});

it('broadcasts for every map layer referencing the image too', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    TilingChanged::broadcastForImage($image);

    Event::assertDispatched(TilingChanged::class, fn ($event) => $event->mapId === $map->id && $event->status === 'running');
});

it('deduplicates when a map\'s base image and one of its layers are the same image', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    TilingChanged::broadcastForImage($image);

    Event::assertDispatchedTimes(TilingChanged::class, 1);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=TilingChangedTest`
Expected: FAIL — `App\Events\Maps\TilingChanged` doesn't exist

- [ ] **Step 3: Implement the event**

`app/Events/Maps/TilingChanged.php`:
```php
<?php

namespace App\Events\Maps;

use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TilingChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public int $mapId,
        public string $status,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [new PresenceChannel('map.' . $this->mapId)];
    }

    public function broadcastAs(): string
    {
        return 'MapTilingChanged';
    }

    public function broadcastWith(): array
    {
        return ['status' => $this->status];
    }

    /**
     * Broadcast this image's tiling status to every map/layer currently referencing it.
     */
    public static function broadcastForImage(Image $image): void
    {
        $status = match (true) {
            $image->tilingRunning() => 'running',
            $image->tilingError() => 'error',
            default => 'finished',
        };

        $mapIds = Map::whereHas('entity', fn ($query) => $query->where('image_uuid', $image->id))
            ->pluck('id')
            ->merge(MapLayer::where('image_uuid', $image->id)->pluck('map_id'))
            ->unique();

        foreach ($mapIds as $mapId) {
            static::dispatch($mapId, $status);
        }
    }
}
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=TilingChangedTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Events/Maps/TilingChanged.php tests/Feature/Events/Maps/TilingChangedTest.php
git commit -m "feat: add TilingChanged broadcast event"
```

---

## Task 8: `TileImageJob`

**Files:**
- Modify: `app/Jobs/TileImageJob.php` (replace Task 5's stub with the real job)
- Delete: `app/Jobs/ChunkMapJob.php` (dead, replaced)
- Test: `tests/Feature/Jobs/TileImageJobTest.php`

**Interfaces:**
- Consumes: `TilingService::tile(Image $image)` (Task 6), `TilingChanged::broadcastForImage(Image $image)` (Task 7).
- Produces: `TileImageJob::handle()` (success path), `TileImageJob::failed()` (sets `TILING_ERROR` after exhausting retries), `$tries = 3`, `$backoff = [30, 60, 120]`.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Events\Maps\TilingChanged;
use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Event;

it('marks the image finished and broadcasts on successful tiling', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);

    $this->mock(TilingService::class, function ($mock) {
        $mock->shouldReceive('tile')->once();
    });

    (new TileImageJob($image))->handle(app(TilingService::class));

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_FINISHED);
    expect($image->fresh()->tiling_error)->toBeNull();
    Event::assertDispatched(TilingChanged::class);
});

it('sets a permanent tiling error and broadcasts after exhausting retries', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);

    (new TileImageJob($image))->failed(new Exception('vips exploded'));

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_ERROR);
    expect($image->fresh()->tiling_error)->toBe('vips exploded');
    Event::assertDispatched(TilingChanged::class);
});

it('retries three times with backoff before giving up', function () {
    $job = new TileImageJob(Image::factory()->create(['campaign_id' => 1]));

    expect($job->tries)->toBe(3);
    expect($job->backoff())->toBe([30, 60, 120]);
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=TileImageJobTest`
Expected: FAIL — `handle()` is currently a no-op stub, `failed()` doesn't exist yet, `tries`/`backoff()` don't match

- [ ] **Step 3: Implement the real job**

`app/Jobs/TileImageJob.php`:
```php
<?php

namespace App\Jobs;

use App\Events\Maps\TilingChanged;
use App\Models\Image;
use App\Services\Maps\TilingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TileImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(public Image $image)
    {
        $this->onConnection('heavy');
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [30, 60, 120];
    }

    public function handle(TilingService $service): void
    {
        $service->tile($this->image);

        $this->image->update([
            'tiling_status' => Image::TILING_FINISHED,
            'tiling_error' => null,
        ]);

        TilingChanged::broadcastForImage($this->image->fresh());
    }

    public function failed(Throwable $e): void
    {
        $this->image->update([
            'tiling_status' => Image::TILING_ERROR,
            'tiling_error' => $e->getMessage(),
        ]);

        report($e);

        TilingChanged::broadcastForImage($this->image->fresh());
    }
}
```

Delete the dead `app/Jobs/ChunkMapJob.php` (never dispatched anywhere, wraps the now-deleted `ChunkingService`):
```bash
git rm app/Jobs/ChunkMapJob.php
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=TileImageJobTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Jobs/TileImageJob.php tests/Feature/Jobs/TileImageJobTest.php
git commit -m "feat: implement TileImageJob, remove dead ChunkMapJob"
```

---

## Task 9: Wire triggers into `EntityObserver` and `MapLayerObserver`

**Files:**
- Modify: `app/Observers/EntityObserver.php`
- Modify: `app/Observers/MapLayerObserver.php`
- Test: `tests/Feature/Observers/EntityObserverTilingTest.php`
- Test: `tests/Feature/Observers/MapLayerObserverTilingTest.php`

**Interfaces:**
- Consumes: `TilingTriggerService::maybeTrigger(Image $image)` (Task 5).
- Produces: assigning an oversized gallery image as a map's base image (create or update) or a `MapLayer`'s image triggers tiling automatically.

- [ ] **Step 1: Write the failing tests**

`tests/Feature/Observers/EntityObserverTilingTest.php`:
```php
<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['maps.tiling_threshold_kb' => 100]);
    Queue::fake();
});

it('triggers tiling when an existing map\'s entity is assigned a new oversized gallery image', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $map->entity->image_uuid = $image->id;
    $map->entity->save();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
});

it('does not trigger tiling for a non-map entity\'s image change', function () {
    $character = \App\Models\Character::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $character->entity->image_uuid = $image->id;
    $character->entity->save();

    Queue::assertNotPushed(TileImageJob::class);
});

it('does not trigger tiling when a map\'s other fields are updated without an image change', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);

    $map->entity->name = 'Renamed';
    $map->entity->save();

    Queue::assertNotPushed(TileImageJob::class);
});
```

`tests/Feature/Observers/MapLayerObserverTilingTest.php`:
```php
<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['maps.tiling_threshold_kb' => 100]);
    Queue::fake();
});

it('triggers tiling when a new map layer is created with an oversized image', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('triggers tiling when an existing layer\'s image is changed', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $layer->image_uuid = $image->id;
    $layer->save();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('does not trigger tiling when a layer is updated without an image change', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);
    Queue::fake(); // reset after the create() above already triggered one dispatch

    $layer->name = 'Renamed layer';
    $layer->save();

    Queue::assertNotPushed(TileImageJob::class);
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=EntityObserverTilingTest`
Run: `vendor/bin/sail artisan test --compact --filter=MapLayerObserverTilingTest`
Expected: FAIL — no job is pushed yet, observers don't call the trigger service

- [ ] **Step 3: Wire the observers**

In `app/Observers/EntityObserver.php`, add the import and update `updating()`, add a new check in `created()`:
```php
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;
```

Replace the `updating()` method:
```php
    public function updating(Entity $entity): void
    {
        if ($entity->isDirty('image_uuid') && $entity->isMap()) {
            $entity->map->height = null;
            $entity->map->width = null;
            $entity->map->saveQuietly();

            $this->maybeTriggerTiling($entity);
        }
    }
```

Add a call at the end of `created()` (after the existing `EntityWebhookJob::dispatch(...)` block, still inside the method, before its closing brace):
```php
        if ($entity->isMap() && $entity->image_uuid) {
            $this->maybeTriggerTiling($entity);
        }
    }

    protected function maybeTriggerTiling(Entity $entity): void
    {
        if (! $entity->image_uuid) {
            return;
        }

        $image = Image::find($entity->image_uuid);
        if ($image) {
            app(TilingTriggerService::class)->maybeTrigger($image);
        }
    }
```

In `app/Observers/MapLayerObserver.php`, add the import:
```php
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;
```

Replace `created()` and `updated()`:
```php
    public function created(MapLayer $mapLayer): void
    {
        $this->reorder($mapLayer);
        $this->broadcastContents($mapLayer->map);
        $this->maybeTriggerTiling($mapLayer);
    }

    public function updated(MapLayer $mapLayer): void
    {
        if ($mapLayer->wasChanged('position')) {
            $this->reorder($mapLayer);
        }
        $this->broadcastContents($mapLayer->map);

        if ($mapLayer->wasChanged('image_uuid')) {
            $this->maybeTriggerTiling($mapLayer);
        }
    }

    protected function maybeTriggerTiling(MapLayer $mapLayer): void
    {
        if (! $mapLayer->image_uuid) {
            return;
        }

        $image = Image::find($mapLayer->image_uuid);
        if ($image) {
            app(TilingTriggerService::class)->maybeTrigger($image);
        }
    }
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=EntityObserverTilingTest`
Run: `vendor/bin/sail artisan test --compact --filter=MapLayerObserverTilingTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/EntityObserver.php app/Observers/MapLayerObserver.php \
        tests/Feature/Observers/EntityObserverTilingTest.php tests/Feature/Observers/MapLayerObserverTilingTest.php
git commit -m "feat: trigger image tiling from map/layer image assignment"
```

---

## Task 10: Clean up tiles when an `Image` is deleted

**Files:**
- Modify: `app/Observers/ImageObserver.php`
- Test: `tests/Feature/Observers/ImageObserverTilingTest.php`

**Interfaces:**
- Consumes: `Image::tilesPath()` (Task 2).
- Produces: deleting an `Image` also deletes its `images/{uuid}/tiles/` folder.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

it('deletes the tile folder when an image is deleted', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    Storage::put($image->tilesPath() . '/0/0_0.jpg', 'fake-tile-bytes');

    expect(Storage::exists($image->tilesPath() . '/0/0_0.jpg'))->toBeTrue();

    $image->delete();

    expect(Storage::exists($image->tilesPath() . '/0/0_0.jpg'))->toBeFalse();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ImageObserverTilingTest`
Expected: FAIL — tile file still exists after deletion

- [ ] **Step 3: Update `ImageObserver::deleted()`**

In `app/Observers/ImageObserver.php`, replace `deleted()`:
```php
    public function deleted(Image $image)
    {
        Storage::disk(config('images.disk'))
            ->delete($image->path);
        Storage::disk(config('images.disk'))
            ->deleteDirectory($image->tilesPath());

        CampaignCache::campaign($image->campaign)->clear();
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ImageObserverTilingTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Observers/ImageObserver.php tests/Feature/Observers/ImageObserverTilingTest.php
git commit -m "feat: delete tile folder when an image is deleted"
```

---

## Task 11: Routes & tile serving (base image + layers)

**Files:**
- Modify: `routes/campaigns/entities.php:81-82`
- Modify: `app/Http/Controllers/Maps/ExploreController.php`
- Modify: `resources/views/maps/_setup.blade.php:129` (its `route('maps.chunks', ...)` call — the only other place in the codebase that builds a URL for this route; must be updated in the same commit that renames the route, or the legacy explore page and dashboard widget's base tile layer break immediately)
- Test: `tests/Feature/Maps/ExploreControllerTilesTest.php`

**Interfaces:**
- Consumes: `Image::tilesPath()` (Task 2), `Map::tilingRunning()`/`tilingError()` (Task 3).
- Produces: route `maps.tiles` (renamed from `maps.chunks`) serving the base image's tiles; new route `maps.layers.tiles` serving a layer's tiles; `ExploreController::tiles()`/`layerTiles()`; `ExploreController::index()` redirects (with a message) only while tiling is running, no longer on permanent error.

- [ ] **Step 1: Write the failing test**

```php
<?php

use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Storage;

it('serves a tile from the map\'s base image tiles folder', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    Storage::put($image->tilesPath() . '/3/1_2.jpg', 'fake-tile-bytes');

    $response = $this->get(route('maps.tiles', [1, $map->id]) . '?z=3&x=1&y=2');

    $response->assertRedirect(Storage::url($image->tilesPath() . '/3/1_2.jpg'));
});

it('falls back to the transparent placeholder for a missing tile', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('maps.tiles', [1, $map->id]) . '?z=3&x=1&y=2');

    $response->assertOk();
});

it('serves a tile from a layer\'s own tiles folder', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);
    Storage::put($image->tilesPath() . '/2/0_0.jpg', 'fake-layer-tile');

    $response = $this->get(route('maps.layers.tiles', [1, $map->id, $layer->id]) . '?z=2&x=0&y=0');

    $response->assertRedirect(Storage::url($image->tilesPath() . '/2/0_0.jpg'));
});

it('redirects the explore page with an error message while tiling is running, but not on permanent error', function () {
    $this->asUser()->withCampaign();
    $runningImage = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $runningMap = Map::factory()->create(['campaign_id' => 1]);
    $runningMap->entity->image_uuid = $runningImage->id;
    $runningMap->entity->saveQuietly();

    $this->get(route('maps.explore', [1, $runningMap->id]))
        ->assertRedirect(route('entities.show', [1, $runningMap->entity->id]));

    $erroredImage = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $erroredMap = Map::factory()->create(['campaign_id' => 1]);
    $erroredMap->entity->image_uuid = $erroredImage->id;
    $erroredMap->entity->saveQuietly();

    $this->get(route('maps.explore', [1, $erroredMap->id]))->assertOk();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreControllerTilesTest`
Expected: FAIL — `maps.tiles`/`maps.layers.tiles` routes don't exist yet, errored map still redirects

- [ ] **Step 3: Update routes and controller**

In `routes/campaigns/entities.php`, replace line 82:
```php
Route::get('/w/{campaign}/maps/{map}/tiles/', 'Maps\ExploreController@tiles')->name('maps.tiles');
Route::get('/w/{campaign}/maps/{map}/layers/{map_layer}/tiles/', 'Maps\ExploreController@layerTiles')->name('maps.layers.tiles');
```

In `app/Http/Controllers/Maps/ExploreController.php`, add the import and replace `index()` and `chunks()`:
```php
use App\Models\MapLayer;
```

```php
    /**
     * Exploration view for a map
     */
    public function index(Campaign $campaign, Map $map)
    {
        if (empty($map->entity)) {
            abort(404);
        }
        $this->campaign($campaign)->authEntityView($map->entity);

        if ($map->tilingRunning()) {
            return redirect()
                ->route('entities.show', [$campaign, $map->entity])
                ->withError(__('maps.errors.tiling.running.explore'));
        }

        if (! $map->explorable()) {
            return redirect()
                ->route('entities.show', [$campaign, $map->entity])
                ->withError(__('maps.errors.explore.missing'));
        }

        // Error handling
        try {
            $map->bounds();
        } catch (Exception $e) {
            return redirect()->route('entities.show', [$campaign, $map->entity])
                ->with('error_raw', __('Error getting bounds from the map. This sometimes happens with animated WebP files, which aren\'t supported. Please contact us on :discord or at at :email.', [
                    'discord' => '<a href="http://kanka.io/go/discord" class="text-link">Discord</a>',
                    'email' => '<a href="mailto:' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>',
                ]));
        }

        return view('maps.explore')
            ->with('map', $map)
            ->with('campaign', $campaign);
    }
```

```php
    /**
     * Serve a tile from the map's base image tile pyramid
     */
    public function tiles(Campaign $campaign, Map $map)
    {
        $image = $map->entity->image;

        return $this->serveTile($image);
    }

    /**
     * Serve a tile from a map layer's own tile pyramid
     */
    public function layerTiles(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        return $this->serveTile($mapLayer->image);
    }

    protected function serveTile(?\App\Models\Image $image)
    {
        $headers = ['Expires', Carbon::now()->addDays(1)->toDateTimeString()];
        if (! $image || ! request()->has(['z', 'x', 'y'])) {
            return response()
                ->file(public_path('/images/map_chunks/transparent.png'), $headers);
        }

        $path = $image->tilesPath() . '/' . request()->get('z')
            . '/' . request()->get('x') . '_' . request()->get('y')
            . '.jpg';

        if (! Storage::exists($path)) {
            return response()
                ->file(public_path('/images/map_chunks/transparent.png'), $headers);
        }

        return redirect()->to(Storage::url($path));
    }
```

Remove the old `chunks()` method entirely (replaced by `tiles()`/`layerTiles()`/`serveTile()` above).

In `resources/views/maps/_setup.blade.php:129`, update the one other place in the codebase that builds a URL for this route:
```blade
    L.tileLayer('{{ route('maps.tiles', [$campaign, $map->id]) }}/?z={z}&x={x}&y={y}', {
        attribution: '&copy; Kanka',
    }).addTo(map{{ $map->id }});
```
(Only the route name changes, `maps.chunks` → `maps.tiles` — this partial is shared by the legacy explore page and the dashboard widget preview, both of which build their base tile layer through it.)

- [ ] **Step 4: Run test to verify it passes**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreControllerTilesTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add routes/campaigns/entities.php app/Http/Controllers/Maps/ExploreController.php resources/views/maps/_setup.blade.php tests/Feature/Maps/ExploreControllerTilesTest.php
git commit -m "feat: serve tiles per-image for base maps and layers, rename chunks route to tiles"
```

---

## Task 12: New Vue explorer gating, payload, and layer filtering

**Files:**
- Modify: `app/Http/Controllers/Entity/Maps/ShowController.php`
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php`
- Modify: `app/Http/Resources/Entities/ExploreResource.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php` (modify existing "chunked" test, append new ones)
- Test: `tests/Feature/Entities/Maps/ShowControllerTest.php` (create if it doesn't exist; check first)

**Interfaces:**
- Consumes: `Map::isTiled()/tilingRunning()/tilingError()` (Task 3), `MapLayer::tilingRunning()` (Task 4).
- Produces: `entities.map-api` payload gains `tiling: 'running'|'error'|null` and `tiling_prompt_eligible: bool`, renames `is_chunked`→`is_tiled`/`chunks_url`→`tiles_url`; `ShowController` no longer redirects while tiling is running (only when the map has no explorable content at all); tiling-running layers excluded from the `layers` payload array. (Task 14 adds a further `tiling_prompt_url` field to this same `MapResource`, once its owning route exists — deliberately deferred there rather than forward-referencing a not-yet-registered route from this task.)

- [ ] **Step 1: Write the failing tests**

Replace the existing chunking test in `tests/Feature/Entities/Maps/ExploreApiControllerTest.php` (lines 70-83):
```php
it('marks a finished tiled map with a tiles url', function () {
    $this->asUser()->withCampaign();
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);
    $tilesUrl = $response->json('map.tiles_url');

    expect($response->json('map.is_tiled'))->toBeTrue();
    expect($tilesUrl)->toStartWith(route('maps.tiles', [1, $map->id]));
    expect($tilesUrl)->toEndWith('?z={z}&x={x}&y={y}');
    expect($response->json('map.tiling'))->toBeNull();
});

it('reports a running tiling status without a tiles url', function () {
    $this->asUser()->withCampaign();
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_tiled'))->toBeFalse();
    expect($response->json('map.tiling'))->toBe('running');
    expect($response->json('map.tiles_url'))->toBeNull();
});

it('reports an error tiling status and still omits the tiles url (falls back to plain image)', function () {
    $this->asUser()->withCampaign();
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_ERROR]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_tiled'))->toBeFalse();
    expect($response->json('map.tiling'))->toBe('error');
    expect($response->json('map.tiles_url'))->toBeNull();
});

it('flags tiling_prompt_eligible for an oversized untiled gallery image', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $this->asUser()->withCampaign();
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_eligible'))->toBeTrue();
});

it('does not flag tiling_prompt_eligible once dismissed', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $this->asUser()->withCampaign();
    $image = \App\Models\Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->tiling_prompt_dismissed_at = now();
    $map->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_eligible'))->toBeFalse();
});

it('excludes a layer whose image is still tiling from the layers payload', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $tilingImage = \App\Models\Image::factory()->create(['campaign_id' => 1, 'tiling_status' => \App\Models\Image::TILING_RUNNING]);
    $readyLayer = \App\Models\MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Ready', 'type_id' => 2]);
    $readyLayer->image_path = 'maps/ready.png';
    $readyLayer->saveQuietly();
    \App\Models\MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Tiling', 'type_id' => 2, 'image_uuid' => $tilingImage->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('layers'))->toHaveCount(1);
    expect($response->json('layers.0.name'))->toBe('Ready');
});
```

Update the existing `assertJsonStructure` in the same file (line 39) — replace `is_chunked`/`chunks_url` with `is_tiled`, `tiles_url`, `tiling`, `tiling_prompt_eligible`.

Create `tests/Feature/Entities/Maps/ShowControllerTest.php` (check first if a similarly-named file already covers `entities.map` — if it exists, append instead of creating):
```php
<?php

use App\Models\Image;
use App\Models\Map;

it('does not redirect away from the map page while tiling is running (shows inline placeholder instead)', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->get(route('entities.map', [1, $map->entity]))->assertOk();
});

it('still redirects when the map has no image at all', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertRedirect(route('entities.show', [1, $map->entity->id]));
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Run: `vendor/bin/sail artisan test --compact --filter=ShowControllerTest`
Expected: FAIL — fields don't exist yet, `ShowController` still redirects while tiling runs

- [ ] **Step 3: Implement**

`app/Http/Controllers/Entity/Maps/ShowController.php` — replace lines 28-36:
```php
        if (! $map->explorable() && ! $map->tilingRunning()) {
            return redirect()
                ->route('entities.show', [$campaign, $entity])
                ->withError(__('maps.errors.explore.missing'));
        }
```

`app/Services/Maps/ExploreApiService.php` — replace line 37 (the layers filter):
```php
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->isExplorable() && ! $layer->tilingRunning())
                    ->values()
            ),
```

`app/Http/Resources/Maps/Explore/MapResource.php` — replace lines 21 and 48-50, and add the new fields:
```php
        $map = $this->resource;
        $isTiled = $map->isTiled();
        $tiling = $map->tilingRunning() ? 'running' : ($map->tilingError() ? 'error' : null);
        $center = array_map('floatval', explode(', ', $map->centerFocus()));
```

```php
            'is_tiled' => $isTiled,
            'tiling' => $tiling,
            'tiling_prompt_eligible' => $this->tilingPromptEligible($map),
```

(place these three lines where `is_chunked`/`chunks_url` used to be, i.e. replacing line 38 and updating line 48-50)

```php
            'tile_url' => $map->isReal() ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : null,
            'tiles_url' => $isTiled
                ? route('maps.tiles', [$this->campaign->id, $map->id]) . '/?z={z}&x={x}&y={y}'
                : null,
```

Add this protected method to `MapResource` (anywhere after `toArray()`):
```php
    protected function tilingPromptEligible(Map $map): bool
    {
        $image = $map->entity->image;
        if (! $image || $map->tiling_prompt_dismissed_at !== null || $image->tiling_status !== null) {
            return false;
        }

        return $image->size >= config('maps.tiling_threshold_kb');
    }
```

`app/Http/Resources/Entities/ExploreResource.php` — replace lines 174-187:
```php
                if ($this->hasColumn('explore')) {
                    if ($child->isReal()) {
                        $data['explore'] = ['url' => route('maps.explore', [$campaign, $child->id])];
                    } elseif (! $entity->hasImage()) {
                        $data['explore'] = null;
                    } elseif ($child->tilingError()) {
                        $data['explore'] = ['url' => null, 'status' => 'error'];
                    } elseif ($child->tilingRunning()) {
                        $data['explore'] = ['url' => null, 'status' => 'running'];
                    } else {
                        $data['explore'] = ['url' => route('maps.explore', [$campaign, $child->id])];
                    }
                }
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Run: `vendor/bin/sail artisan test --compact --filter=ShowControllerTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Controllers/Entity/Maps/ShowController.php app/Services/Maps/ExploreApiService.php \
        app/Http/Resources/Maps/Explore/MapResource.php app/Http/Resources/Entities/ExploreResource.php \
        tests/Feature/Entities/Maps/ExploreApiControllerTest.php tests/Feature/Entities/Maps/ShowControllerTest.php
git commit -m "feat: gate new map explorer on per-image tiling state, expose tiling fields in API"
```

---

## Task 13: Translation keys — rename chunking → tiling

**Files:**
- Modify: `lang/en/maps.php`
- Modify: `lang/en/maps/explorer.php`

**Interfaces:**
- Produces: `maps.errors.tiling.error`, `maps.errors.tiling.running.edit`, `maps.errors.tiling.running.explore`, `maps.errors.tiling.running.time`, `maps.errors.dashboard.tiling` (new — distinguishes "being tiled" from "missing image" on the dashboard widget), `maps.tooltips.tiling.running`, `maps.helpers.tiled_zoom` (renamed from `maps.helpers.chunked_zoom`, referenced by `resources/views/maps/form/_settings.blade.php`); `maps/explorer.tiling.*` and `maps/explorer.tiling_prompt.*` (new — inline placeholder and migration-prompt copy for the Vue explorer's i18n payload).

- [ ] **Step 1: No test — this is copy-only; verified by Task 14/15's usages (which will fail to find the keys if misnamed, since Laravel's `__()` returns the key itself untranslated rather than throwing)**

- [ ] **Step 2: N/A**

- [ ] **Step 3: Update `lang/en/maps.php`**

Replace lines 12-27:
```php
    'errors'        => [
        'tiling'    => [
            'error'     => 'There was an error while tiling the map. Please contact the team on :discord for support.',
            'running'   => [
                'edit'      => 'The map cannot be edited while it\'s being tiled.',
                'explore'   => 'The map cannot be displayed while it\'s being tiled.',
                'time'      => 'This can take several minutes to several hours, depending on the size of the map.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'This map needs an image to be able to render on the dashboard.',
            'tiling'    => 'This map\'s resources are being tiled. Please check back soon.',
        ],
        'explore'   => [
            'missing'   => 'Please add an image to the map before being able to explore it.',
        ],
    ],
```

Replace lines 84-88:
```php
    'tooltips'      => [
        'tiling'    => [
            'running'   => 'Map is being tiled. This process can take several minutes to hours.',
        ],
    ],
```

Also, in the `helpers` array (the same file), rename the `chunked_zoom` key to `tiled_zoom` (referenced by `resources/views/maps/form/_settings.blade.php`):
```php
        'tiled_zoom'            => 'Automatically cluster markers together when they are close to each other.',
```
(replaces the existing `'chunked_zoom' => '...'` line — same value, key renamed only.)

- [ ] **Step 4: Add tiling copy to `lang/en/maps/explorer.php`**

Add a new top-level `tiling`/`tiling_prompt` array (near the existing `errors` array at the top):
```php
    'tiling'    => [
        'running'   => 'This map\'s resources are being tiled. Please try again soon.',
    ],
    'tiling_prompt' => [
        'message'   => 'This map has a large image and is using an older, slower rendering mode. Do you want to migrate to a new version? This will mean the map is unavailable for a few minutes, but in exchange the map will load much faster in the future.',
        'migrate'   => 'Migrate',
        'dismiss'   => 'No thanks',
    ],
```

- [ ] **Step 5: Commit**

```bash
git add lang/en/maps.php lang/en/maps/explorer.php
git commit -m "i18n: rename chunking translation keys to tiling, add placeholder/prompt copy"
```

---

## Task 14: Migration-prompt endpoint & `artisan maps:tile` command

**Files:**
- Create: `app/Http/Controllers/Entity/Maps/TilingPromptController.php`
- Modify: `routes/campaigns/entities.php`
- Modify: `app/Http/Resources/Maps/Explore/MapResource.php` (adds `tiling_prompt_url`, now that its route exists)
- Create: `app/Console/Commands/TileMapCommand.php`
- Test: `tests/Feature/Entities/Maps/TilingPromptControllerTest.php`
- Test: `tests/Feature/Console/TileMapCommandTest.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php` (append one assertion)

**Interfaces:**
- Consumes: `TilingTriggerService::maybeTrigger(Image $image, bool $force)` (Task 5), `MapResource` (Task 12).
- Produces: route `entities.map-tiling-prompt.update` (PATCH), dismisses/migrates; `artisan maps:tile {map}` command; `MapResource`'s `tiling_prompt_url` field (consumed by Task 17's migration-prompt banner).

- [ ] **Step 1: Write the failing tests**

`tests/Feature/Entities/Maps/TilingPromptControllerTest.php`:
```php
<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

it('dismisses the prompt without triggering tiling', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'dismiss'])
        ->assertOk();

    expect($map->fresh()->tiling_prompt_dismissed_at)->not->toBeNull();
    Queue::assertNotPushed(TileImageJob::class);
});

it('migrates by dismissing and force-triggering tiling regardless of the threshold', function () {
    Queue::fake();
    config(['maps.tiling_threshold_kb' => 999999]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'migrate'])
        ->assertOk();

    expect($map->fresh()->tiling_prompt_dismissed_at)->not->toBeNull();
    Queue::assertPushed(TileImageJob::class);
});

it('forbids a non-editor from dismissing the prompt', function () {
    $this->asUser()->withCampaign(role: 'viewer');
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'dismiss'])
        ->assertForbidden();
});
```

`tests/Feature/Console/TileMapCommandTest.php`:
```php
<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

it('force-triggers tiling for a map\'s gallery image regardless of size', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])->assertSuccessful();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('fails gracefully for a map with no gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->artisan('maps:tile', ['map' => $map->id])->assertFailed();
});

it('fails gracefully for an unknown map id', function () {
    $this->artisan('maps:tile', ['map' => 999999])->assertFailed();
});
```

Append to `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`:
```php
it('exposes the tiling prompt url for the migration banner', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_url'))->toBe(route('entities.map-tiling-prompt.update', [1, $map->entity->id]));
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=TilingPromptControllerTest`
Run: `vendor/bin/sail artisan test --compact --filter=TileMapCommandTest`
Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: FAIL — route/command/field don't exist

- [ ] **Step 3: Implement**

`app/Http/Controllers/Entity/Maps/TilingPromptController.php`:
```php
<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Maps\TilingTriggerService;
use App\Traits\CampaignAware;
use Illuminate\Support\Carbon;

class TilingPromptController extends Controller
{
    use CampaignAware;

    public function __construct(protected TilingTriggerService $trigger) {}

    public function update(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign);
        abort_unless(auth()->user()->can('update', $entity), 403);

        if (! $entity->isMap()) {
            abort(404);
        }

        $map = $entity->child;
        $map->tiling_prompt_dismissed_at = Carbon::now();
        $map->saveQuietly();

        if (request()->input('action') === 'migrate' && $entity->image) {
            $this->trigger->maybeTrigger($entity->image, force: true);
        }

        return response()->json(['success' => true]);
    }
}
```

Add to `routes/campaigns/entities.php` (near the other `entities.map*` routes, e.g. after line 61):
```php
Route::patch('/w/{campaign}/entities/{entity}/map/tiling-prompt', [EntityMapTilingPromptController::class, 'update'])->name('entities.map-tiling-prompt.update');
```
(Add the corresponding `use App\Http\Controllers\Entity\Maps\TilingPromptController as EntityMapTilingPromptController;` import at the top of the file, matching the existing aliasing convention already used for `EntityMapApiController`/`EntityMapShowController`/`EntityMapSettingsController`/`EntityMapMarkerController` in that same file.)

In `app/Http/Resources/Maps/Explore/MapResource.php`, add this line to `toArray()`'s returned array, next to the other `*_url` fields (e.g. right after `'settings_url' => ...`):
```php
            'tiling_prompt_url' => route('entities.map-tiling-prompt.update', [$this->campaign->id, $map->entity->id]),
```

`app/Console/Commands/TileMapCommand.php`:
```php
<?php

namespace App\Console\Commands;

use App\Models\Map;
use App\Services\Maps\TilingTriggerService;
use Illuminate\Console\Command;

class TileMapCommand extends Command
{
    protected $signature = 'maps:tile {map : The ID of the map to tile}';

    protected $description = "Manually trigger tiling for a map's gallery-backed base image";

    public function handle(TilingTriggerService $trigger): int
    {
        $map = Map::find($this->argument('map'));
        if (! $map) {
            $this->error('Map not found.');

            return self::FAILURE;
        }

        $image = $map->entity->image;
        if (! $image) {
            $this->error('This map has no gallery-backed image to tile (legacy image_path maps are not supported).');

            return self::FAILURE;
        }

        $triggered = $trigger->maybeTrigger($image, force: true);
        if (! $triggered) {
            $this->info('Tiling not triggered (already tiled, running, or errored).');

            return self::SUCCESS;
        }

        $this->info('Tiling job dispatched for image ' . $image->id . '.');

        return self::SUCCESS;
    }
}
```

- [ ] **Step 4: Run tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=TilingPromptControllerTest`
Run: `vendor/bin/sail artisan test --compact --filter=TileMapCommandTest`
Run: `vendor/bin/sail artisan test --compact --filter=ExploreApiControllerTest`
Expected: PASS

- [ ] **Step 5: Pint and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Http/Controllers/Entity/Maps/TilingPromptController.php routes/campaigns/entities.php \
        app/Http/Resources/Maps/Explore/MapResource.php app/Console/Commands/TileMapCommand.php \
        tests/Feature/Entities/Maps/TilingPromptControllerTest.php tests/Feature/Console/TileMapCommandTest.php \
        tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: add tiling-prompt dismiss/migrate endpoint, artisan maps:tile command, and prompt url"
```

---

## Task 15: Frontend — `useMapPresence.js` live tiling updates

**Files:**
- Modify: `resources/js/composables/useMapPresence.js`

**Interfaces:**
- Consumes: reverb broadcast `.MapTilingChanged` (Task 8), payload `{status: 'running'|'error'|'finished'}`.
- Produces: `useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged, onMarkerChanged, onTilingChanged })` — new `onTilingChanged` callback, listened on the **public** channel unconditionally (like `onMapUpdated`), since non-editors are blocked by tiling too and need the update regardless of edit rights.

No dedicated automated frontend test exists for this composable (established precedent — no JS test runner is configured in this project, per `package.json`; see Task 17's manual verification instead).

- [ ] **Step 1: Implement**

In `resources/js/composables/useMapPresence.js`, update the function signature (line 19):
```js
export function useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged, onMarkerChanged, onTilingChanged } = {}) {
```

Add a new listener right after the existing `channel.listen('.MapUpdated', ...)` block (after line 87):
```js
        channel.listen('.MapTilingChanged', (payload) => {
            onTilingChanged?.(payload)
        })
```

- [ ] **Step 2: No automated test — manual verification happens in Task 17 once `MapExplorer.vue` wires this up end-to-end.**

- [ ] **Step 3: Commit**

```bash
git add resources/js/composables/useMapPresence.js
git commit -m "feat: listen for live tiling status updates on the map presence channel"
```

---

## Task 16: Frontend — `LeafletCanvas.vue` rename & reactive layer additions

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`

**Interfaces:**
- Consumes: `props.map.is_tiled`/`tiles_url` (Task 12, renamed from `is_chunked`/`chunks_url`).
- Produces: `buildBaseLayer()` reads the renamed fields; a new watcher adds newly-appearing overlay layers to the live Leaflet map (layers whose image finishes tiling after the map first mounted, or after a live `MapContentsChanged` update).

No dedicated automated frontend test exists for this component (established precedent). Manual verification happens in Task 17.

- [ ] **Step 1: Rename the base-layer branch**

In `resources/js/components/maps/LeafletCanvas.vue`, replace lines 139-143:
```js
    if (props.map.is_tiled) {
        L.tileLayer(props.map.tiles_url, { attribution: '&copy; Kanka' }).addTo(leafletMap)

        return
    }
```

- [ ] **Step 2: Add a reactive watcher so newly-ready layers appear without a page reload**

`buildLayers()` (lines 148-152) currently only runs once on mount, so a layer that goes from excluded (mid-tiling) to present (once ready, delivered by a `MapContentsChanged` broadcast into `props.layers`) never gets added to the live map today. Track which layer ids are currently on the map and add any new ones reactively. Replace `buildLayers()`:
```js
const renderedLayerIds = new Set()

function buildLayers() {
    props.layers.forEach((layer) => {
        L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
        renderedLayerIds.add(layer.id)
    })
}

watch(
    () => props.layers,
    (layers) => {
        layers.forEach((layer) => {
            if (renderedLayerIds.has(layer.id)) {
                return
            }
            L.imageOverlay(layer.image, bounds()).addTo(leafletMap)
            renderedLayerIds.add(layer.id)
        })
    },
)
```
(`watch` is already imported in this file's `<script setup>` block for the other reactive props — confirm the import at the top includes `watch` from `'vue'`; if not already present, add it to the existing `import { ... } from 'vue'` line.)

- [ ] **Step 3: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue
git commit -m "feat: rename is_chunked/chunks_url to is_tiled/tiles_url, add newly-tiled layers reactively"
```

---

## Task 17: Frontend — `MapExplorer.vue` inline placeholder, migration prompt, live updates

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `data.map.tiling`/`tiling_prompt_eligible` (Task 12), `useMapPresence`'s `onTilingChanged` (Task 15), `entities.map-tiling-prompt.update` endpoint (Task 14), `data.i18n.tiling`/`tiling_prompt` (Task 13).

- [ ] **Step 1: Add the inline "tiling in progress" placeholder**

Replace the top-level template block (lines 2-16):
```html
    <div
        class="w-full h-screen flex items-center justify-center text-2xl"
        v-if="loading || error || isTilingRunning"
    >
        <div class="flex items-center gap-2" v-if="loading && !error && !isTilingRunning">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ loadingText }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2 text-error-content"
            v-else-if="error"
        >
            <span>{{ error }}</span>
        </div>
        <div
            class="flex flex-col items-center gap-2"
            v-else-if="isTilingRunning"
        >
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>{{ data.i18n.tiling.running }}</span>
        </div>
    </div>
```

Add near the top of `<script setup>` (after the `markersCountText` computed, e.g. after line 229):
```js
const isTilingRunning = computed(() => data.value.map.tiling === 'running');
```

- [ ] **Step 2: Add the migration-prompt banner**

Add inside the `<template v-else>` block, right after the opening `<div class="fixed top-4 left-4 ...">` header block closes (after line 82, before `<LegendPanel`):
```html
        <div
            v-if="canEdit && data.map.tiling_prompt_eligible && !tilingPromptDismissed"
            class="fixed top-4 right-4 z-[1200] max-w-sm bg-base-100 border border-base-300 rounded-xl p-4 flex flex-col gap-2 shadow-lg"
        >
            <p class="text-sm text-base-content">{{ data.i18n.tiling_prompt.message }}</p>
            <div class="flex gap-2 justify-end">
                <button class="btn2 btn-default btn-sm" @click="respondToTilingPrompt('dismiss')">
                    {{ data.i18n.tiling_prompt.dismiss }}
                </button>
                <button class="btn2 btn-primary btn-sm" @click="respondToTilingPrompt('migrate')">
                    {{ data.i18n.tiling_prompt.migrate }}
                </button>
            </div>
        </div>
```

Add state and the handler function (near `openSettings()`, e.g. after line 245):
```js
const tilingPromptDismissed = ref(false);

async function respondToTilingPrompt(action) {
    tilingPromptDismissed.value = true;
    await axios.patch(data.value.map.tiling_prompt_url, { action });
}
```

`data.value.map.tiling_prompt_url` is already present in the payload as of Task 14.

- [ ] **Step 3: Wire the live broadcast update**

Update the `useMapPresence` call (lines 208-222) to pass the new callback:
```js
const {
    activeUsers,
    remoteCursors,
    error: presenceError,
    sendCursor,
} = useMapPresence(
    () => data.value.interactive,
    () => data.value.i18n?.presence,
    {
        canEdit: props.canEdit,
        onMapUpdated: handleRemoteMapUpdate,
        onContentsChanged: handleContentsChanged,
        onMarkerChanged: handleMarkerChanged,
        onTilingChanged: handleTilingChanged,
    },
);
```

Add the handler (near `handleRemoteMapUpdate`, e.g. after line 297):
```js
function handleTilingChanged({ status }) {
    data.value.map = { ...data.value.map, tiling: status === 'running' ? 'running' : null };

    if (status !== 'running') {
        axios.get(props.api).then((res) => {
            data.value = res.data;
        });
    }
}
```
(A finished/errored status re-fetches the full payload rather than patching piecemeal, since `is_tiled`/`tiles_url`/`min_zoom`/`max_zoom`/`center` all potentially change together once a tile pyramid completes — simpler and safer than hand-reconciling every derived field.)

- [ ] **Step 4: Manual verification**

Since no JS test runner exists in this project (confirmed: no `vitest`/`jest` in `package.json`), verify manually per this repo's `run`/`verify` conventions: start `vendor/bin/sail yarn run dev`, open a map whose entity has an image over the configured threshold, confirm the inline "being tiled" message shows while `tiling_status` is `RUNNING` (set directly via tinker or the artisan command from Task 14), confirm it flips to the live map automatically (no refresh) once you manually update the image's `tiling_status` to `FINISHED` and the broadcast fires, confirm the migration-prompt banner appears once for an eligible pre-existing large map and disappears after clicking either button, and does not reappear on reload once dismissed.

- [ ] **Step 5: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: show inline tiling placeholder, migration prompt, and live tiling updates in map explorer"
```

---

## Task 18: Dashboard widget fallback copy

**Files:**
- Modify: `resources/views/dashboard/widgets/previews/map.blade.php`

**Interfaces:**
- Consumes: `Map::tilingRunning()` (Task 3), `maps.errors.dashboard.tiling` (Task 13).

- [ ] **Step 1: Distinguish "tiling in progress" from "missing image" in the fallback**

Replace lines 11-17:
```php
@if(!$map->explorable())
    <x-alert type="warning">
        <a href="{{ $entity->url() }}" class="text-link">{!! $entity->name !!}</a>
        <p class="">{{ $map->tilingRunning() ? __('maps.errors.dashboard.tiling') : __('maps.errors.dashboard.missing') }}</p>
    </x-alert>
    @php return @endphp
@endif
```

- [ ] **Step 2: Manual verification**

No automated test exists for this Blade widget (legacy vanilla-Leaflet dashboard preview, untested by precedent). Verify manually: add a map with a base image mid-tiling to a campaign dashboard, confirm the widget shows the tiling-specific message rather than the generic "needs an image" message; confirm a map with no image at all still shows the original missing-image message.

- [ ] **Step 3: Commit**

```bash
git add resources/views/dashboard/widgets/previews/map.blade.php
git commit -m "feat: distinguish tiling-in-progress from missing-image on the dashboard map widget"
```

---

## Task 19: Local dev Docker image — add `libvips-tools`

**Files:**
- Create: `docker-compose.override.yml` build context / `docker/8.4/Dockerfile` (exact path depends on `sail:publish` output — Sail publishes to `docker/{php-version}/Dockerfile` by default)

**Interfaces:**
- Produces: the `vips` CLI binary available on `PATH` inside the local Sail PHP container, so `TilingService` (Task 6) actually works when tested end-to-end locally. Production install of `libvips-tools` is out of scope (handled separately, per prior discussion).

- [ ] **Step 1: Publish the Sail Dockerfile**

Run: `vendor/bin/sail artisan sail:publish`
Expected: creates `docker/8.4/Dockerfile` (and other version dirs) as a local, editable copy of the stock Sail image definition.

- [ ] **Step 2: Add `libvips-tools` to the apt-get install list**

In the newly-published `docker/8.4/Dockerfile`, find the `apt-get install -y \` block that lists `libgd3`, `php8.4-cli`, etc. (matches the stock list seen in `vendor/laravel/sail/runtimes/8.4/Dockerfile`), and add `libvips-tools` to it:
```dockerfile
    && apt-get install -y \
        libgd3 \
        libvips-tools \
        php8.4-cli \
        php8.4-dev \
```

- [ ] **Step 3: Rebuild the container and verify `vips` is on PATH**

Run: `vendor/bin/sail build --no-cache && vendor/bin/sail up -d`
Run: `vendor/bin/sail exec laravel.test which vips`
Expected: prints a path like `/usr/bin/vips`

- [ ] **Step 4: Commit**

```bash
git add docker/
git commit -m "chore: add libvips-tools to the local Sail dev image for map tiling"
```

---

## Post-implementation checklist

- Run the full test suite: `vendor/bin/sail artisan test --compact` and confirm no regressions in unrelated map tests (`MapTest`, `MapLayerTest`, `ExploreApiControllerTest`, `ExploreControllerTilesTest`, etc.).
- Run `vendor/bin/sail bin pint --format agent` (not `--dirty`) once at the very end to catch any cross-file style drift.
- Manually verify the golden path end-to-end per Task 17/18's manual verification steps, using `vendor/bin/sail artisan tinker` to flip an image's `tiling_status` between states and confirm every rendering surface (legacy explore page, new Vue explorer, dashboard widget, grid/search "explore" link) reacts correctly.
