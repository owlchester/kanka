# Image Dimensions & Map/Layer Bounds Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Move image dimension storage onto `Image.metadata`, populate it at upload time, and make `Map` and `MapLayer` source their leaflet bounds from the image itself when it's a gallery image — fixing the bug where every map layer overlay is drawn using the base map's bounds instead of its own image's dimensions.

**Architecture:** A new `metadata` json column on `images` stores `{width, height}`. A single static helper (`Image::dimensionsForPath()`) reads dimensions from a stored file (SVG XML attributes, or the first 64KB of a raster header) — this replaces the SVG/raster-parsing logic currently duplicated inline in `Map::prepareBounds()`, and is reused by both `Map` and the new `MapLayer` legacy branch. `Map::prepareBounds()` and the new `MapLayer::dimensions()` each branch on image source: a gallery image (`Image` model) is asked for its own dimensions (self-healing via `ensureDimensions()`, calculated once and cached on the `Image` row); a legacy direct-upload image (`entity->image_path` / `MapLayer->image_path`) keeps the existing calculate-and-cache-onto-the-model behavior. Frontend (blade + Vue) changes make each layer's overlay use its own bounds instead of the map's.

**Tech Stack:** PHP 8.4, Laravel 11 (legacy/Laravel-10-style file structure — no `bootstrap/app.php`), Pest 3 for tests, Vue 3 + Leaflet for the map explorer, plain Node (`node --test`) for JS unit tests, all commands run through `vendor/bin/sail`.

## Global Constraints

- All PHP/Artisan/Composer/Node commands must be prefixed with `vendor/bin/sail`.
- Run `vendor/bin/sail bin pint --dirty --format agent` after any PHP file changes, before considering a task done.
- Tests are Pest; create new test files with `vendor/bin/sail artisan make:test --pest {Name}` when a task calls for a new file, or add to an existing file when noted.
- Curly braces are required on every control structure, even single-line bodies.
- Use explicit return type declarations and parameter type hints on every method.
- Never hardcode user-facing strings — this plan introduces none, so this shouldn't come up, but if it does, use `__()`.
- Don't create documentation files beyond what's already specced (the design doc and this plan).
- Migrations: when modifying a column, all previously-defined attributes on that column must be repeated — not applicable here, this plan only adds a new column.

---

### Task 1: `metadata` column on `images`

**Files:**
- Create: `database/migrations/2026_07_31_000001_add_metadata_to_images_table.php`

**Interfaces:**
- Produces: an `images.metadata` nullable json column, consumed by Task 2's `Image` model changes.

- [ ] **Step 1: Generate the migration**

Run: `vendor/bin/sail artisan make:migration add_metadata_to_images_table --table=images --no-interaction`

- [ ] **Step 2: Write the migration**

Replace the generated file's contents with:

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
            $table->json('metadata')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table): void {
            $table->dropColumn('metadata');
        });
    }
};
```

(If the generated filename's timestamp differs from `2026_07_31_000001_add_metadata_to_images_table.php`, keep the generated filename — Laravel only cares about the timestamp ordering, not this exact name.)

- [ ] **Step 3: Run the migration**

Run: `vendor/bin/sail artisan migrate`
Expected: `add_metadata_to_images_table ... DONE`

- [ ] **Step 4: Commit**

```bash
git add database/migrations/*add_metadata_to_images_table.php
git commit -m "feat: add metadata json column to images table"
```

---

### Task 2: `Image` model dimension methods

**Files:**
- Modify: `app/Models/Image.php`
- Test: `tests/Feature/Models/ImageDimensionsTest.php`

**Interfaces:**
- Consumes: `images.metadata` column from Task 1.
- Produces (used by Tasks 3, 4, 5):
  - `Image::dimensionsForPath(string $path): array{width: int, height: int}` (static)
  - `Image::calculateDimensions(): array{width: int, height: int}` (instance)
  - `Image::ensureDimensions(): void`
  - `Image::width(): ?int`
  - `Image::height(): ?int`
  - `Image::hasDimensions(): bool`

- [ ] **Step 1: Write the failing tests**

Run: `vendor/bin/sail artisan make:test --pest ImageDimensionsTest` (creates `tests/Feature/ImageDimensionsTest.php` — move it into `tests/Feature/Models/` to match the existing `ImageTilingTest.php` location: `mv tests/Feature/ImageDimensionsTest.php tests/Feature/Models/ImageDimensionsTest.php`)

Replace its contents with:

```php
<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('has no dimensions by default', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);

    expect($image->hasDimensions())->toBeFalse();
    expect($image->width())->toBeNull();
    expect($image->height())->toBeNull();
});

it('calculates raster dimensions from a partial image stream without downloading the full file', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);
    Storage::put($image->path, $pngBytes);

    expect($image->calculateDimensions())->toBe(['width' => 80, 'height' => 40]);
});

it('calculates svg dimensions from the root element attributes', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'svg']);

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="60"></svg>';
    Storage::put($image->path, $svg);

    expect($image->calculateDimensions())->toBe(['width' => 120, 'height' => 60]);
});

it('ensures dimensions get calculated and persisted only once', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);
    Storage::put($image->path, $pngBytes);

    $image->ensureDimensions();

    expect($image->width())->toBe(80);
    expect($image->height())->toBe(40);
    expect($image->fresh()->width())->toBe(80);

    // Deleting the file doesn't change anything: metadata is already cached, so
    // ensureDimensions() should not try (and fail) to recalculate.
    Storage::delete($image->path);
    $image->ensureDimensions();
    expect($image->width())->toBe(80);
});

it('never calculates dimensions for fonts', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'woff2']);

    $image->ensureDimensions();

    expect($image->hasDimensions())->toBeFalse();
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Models/ImageDimensionsTest.php`
Expected: FAIL — `Call to undefined method App\Models\Image::calculateDimensions()` (and similar for the other new methods)

- [ ] **Step 3: Implement the model changes**

In `app/Models/Image.php`, add the `Str` import next to the existing `Storage` import:

```php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
```

Add `metadata` to the `$casts` array:

```php
    public $casts = [
        'visibility_id' => Visibility::class,
        'metadata' => 'array',
    ];
```

Add to the class docblock, next to `@property ?string $tiling_error`:

```php
 * @property ?array $metadata
```

Add the following methods (placed after `hasThumbnail()`, before the tiling methods):

```php
    public function width(): ?int
    {
        return $this->metadata['width'] ?? null;
    }

    public function height(): ?int
    {
        return $this->metadata['height'] ?? null;
    }

    public function hasDimensions(): bool
    {
        return ! empty($this->width()) && ! empty($this->height());
    }

    /**
     * Read an image's pixel dimensions straight from its stored file, without
     * downloading the whole thing. SVGs carry their dimensions as attributes on the
     * root element; raster formats carry them in the first few dozen bytes to a few KB
     * of the file header, so only the first 64KB is read from Storage.
     *
     * @return array{width: int, height: int}
     */
    public static function dimensionsForPath(string $path): array
    {
        if (Str::endsWith($path, '.svg')) {
            $contents = Storage::get($path);
            $xml = simplexml_load_string($contents);

            return [
                'width' => (int) $xml->attributes()->width,
                'height' => (int) $xml->attributes()->height,
            ];
        }

        $stream = Storage::readStream($path);
        $header = fread($stream, 65536);
        fclose($stream);
        $size = getimagesizefromstring($header);

        return [
            'width' => $size[0] ?? 0,
            'height' => $size[1] ?? 0,
        ];
    }

    /**
     * @return array{width: int, height: int}
     */
    public function calculateDimensions(): array
    {
        return static::dimensionsForPath($this->path);
    }

    /**
     * Calculate and cache this image's dimensions if they aren't already known. Skips
     * file types that don't have pixel dimensions (fonts). Guarded against writing from
     * an unauthenticated read-replica request, same as Map::prepareBounds().
     */
    public function ensureDimensions(): void
    {
        if ($this->hasDimensions()) {
            return;
        }
        if (! $this->hasThumbnail() && ! $this->isSvg()) {
            return;
        }

        $this->metadata = array_merge($this->metadata ?? [], $this->calculateDimensions());

        if (auth()->check()) {
            $this->saveQuietly();
        }
    }
```

- [ ] **Step 4: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Models/ImageDimensionsTest.php`
Expected: PASS (5 tests)

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/Image.php tests/Feature/Models/ImageDimensionsTest.php
git commit -m "feat: calculate and cache image dimensions on the Image model"
```

---

### Task 3: Populate dimensions at upload time

**Files:**
- Modify: `app/Services/Gallery/UploadService.php`
- Test: `tests/Feature/Gallery/UploadServiceDimensionsTest.php`

**Interfaces:**
- Consumes: `Image::ensureDimensions()`, `Image::width()`, `Image::height()` from Task 2.

- [ ] **Step 1: Write the failing test**

Run: `vendor/bin/sail artisan make:test --pest UploadServiceDimensionsTest` then `mv tests/Feature/UploadServiceDimensionsTest.php tests/Feature/Gallery/UploadServiceDimensionsTest.php`

Replace its contents with:

```php
<?php

use App\Models\Campaign;
use App\Models\User;
use App\Services\Gallery\UploadService;
use Illuminate\Http\UploadedFile;

it('saves the uploaded image dimensions to metadata', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign();
    $campaign = Campaign::find(1);

    $file = UploadedFile::fake()->image('map.png', 80, 40);

    $service = app(UploadService::class)->campaign($campaign)->user($user);
    $service->file($file);

    $image = $service->image();

    expect($image->width())->toBe(80);
    expect($image->height())->toBe(40);
});
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Gallery/UploadServiceDimensionsTest.php`
Expected: FAIL — `expect($image->width())->toBe(80)` fails because `width()` is `null` (metadata never populated)

- [ ] **Step 3: Wire `ensureDimensions()` into both upload paths**

In `app/Services/Gallery/UploadService.php`, in `file()`, right after the line `$file->storePubliclyAs($this->image->folder, $this->image->file);`, add:

```php
        $file->storePubliclyAs($this->image->folder, $this->image->file);
        $this->image->ensureDimensions();
        $this->storage->campaign($this->campaign)->clearCache();
```

In `url()`, right after the `if ($this->image->isSvg()) { ... } else { ... }` block that writes the file to `Storage::put($this->image->path, ...)` and right before `unlink($tempImage);`, add:

```php
        $this->image->ensureDimensions();
        unlink($tempImage);
```

- [ ] **Step 4: Run the test to verify it passes**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Gallery/UploadServiceDimensionsTest.php`
Expected: PASS

- [ ] **Step 5: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Services/Gallery/UploadService.php tests/Feature/Gallery/UploadServiceDimensionsTest.php
git commit -m "feat: calculate image dimensions on gallery upload"
```

Note: `UploadService::url()` downloads from an external URL over the network, so it isn't covered by an automated test here (no network calls in tests) — its `ensureDimensions()` call is the same one line verified by the `file()` test above, applied to the same `Image` instance/method.

---

### Task 4: `Map` sources bounds from the gallery image

**Files:**
- Modify: `app/Models/Map.php:436-498` (`bounds()`/`prepareBounds()`)
- Modify: `app/Http/Resources/MapResource.php`
- Modify: `resources/views/maps/_setup.blade.php`
- Test: `tests/Feature/Entities/MapTest.php`

**Interfaces:**
- Consumes: `Image::dimensionsForPath()`, `Image::ensureDimensions()`, `Image::width()`, `Image::height()` from Task 2.
- Produces: no new public methods — `Map::bounds()`'s behavior changes, `Map::prepareBounds()`'s internals change but its signature and "populates `$this->height`/`$this->width` in-memory" contract is unchanged, so every existing caller keeps working unmodified except the two explicit fixes below.

**Why `Map::height`/`Map::width` still get set in-memory:** Several places read `$map->height`/`$map->width` directly without calling `bounds()` first — `Map::centerFocus()`, `App\Http\Resources\MapResource` (the CRUD API resource), and `App\Http\Resources\Maps\Explore\MapResource` (the map explorer's API resource, which already explicitly calls `prepareBounds()` first for exactly this reason). To avoid hunting down and changing every one of these call sites, `prepareBounds()` keeps setting `$this->height`/`$this->width` as in-memory attributes for both branches — it just only **persists** them to the `maps` table row for the legacy `image_path` branch. Gallery-image maps get the correct values on every instance that calls `prepareBounds()`, but nothing is written to the `maps` row.

- [ ] **Step 1: Write the failing test**

In `tests/Feature/Entities/MapTest.php`, the existing test at line 98 (`'calculates bounds from a partial image stream...'`) covers the **legacy** `image_path` branch already and needs no changes — it will keep passing throughout this task.

Add this new test right after it (still inside the same file, using the `Image` import already at the top):

```php
it('uses the gallery image dimensions for bounds without caching them on the map row', function () {
    $this->asUser()->withCampaign();

    $map = Map::factory()->create(['campaign_id' => 1]);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $entity = $map->entity;
    $entity->image_uuid = $image->id;
    $entity->saveQuietly();
    $map->load('entity.image');

    expect($map->bounds())->toBe('[[0, 0], [40, 80]]');
    expect($map->height)->toBe(40);
    expect($map->width)->toBe(80);
    expect($map->fresh()->height)->toBeNull();
    expect($map->fresh()->width)->toBeNull();
});
```

- [ ] **Step 2: Run the tests to verify the new one fails**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Entities/MapTest.php`
Expected: the pre-existing bounds test PASSes; the new gallery-image test FAILs (today, `prepareBounds()` only checks `entity->image` for the *path*, but always falls through to the same raster/SVG-parsing code against that path, then unconditionally persists onto the map row — so `$map->fresh()->height` would currently be `40`, not `null`, and the third assertion fails)

- [ ] **Step 3: Rewrite `Map::prepareBounds()`**

In `app/Models/Map.php`, remove the `use Illuminate\Support\Str;` import (it's only used inside `prepareBounds()`, which no longer needs it after this change — the codebase's Pint/Larastan setup will flag an unused import otherwise).

Replace the entire `prepareBounds()` method body with:

```php
    /**
     * Whenever a map gets updated, its height and width are reset to re-calculate them on rendering.
     * A gallery image (entity->image) is the single source of truth for its own dimensions — they're
     * read live off the Image and never persisted onto this row. A legacy directly-uploaded image
     * (entity->image_path) keeps the old calculate-once-and-cache-on-the-map behavior.
     */
    public function prepareBounds(): void
    {
        if (! empty($this->height)) {
            return;
        }

        if (! empty($this->entity->image)) {
            $this->entity->image->ensureDimensions();
            $this->height = $this->entity->image->height() ?: 1000;
            $this->width = $this->entity->image->width() ?: 1000;

            return;
        }

        $path = $this->entity->image_path;
        if (empty($path) || ! Storage::exists($path)) {
            return;
        }

        $dimensions = Image::dimensionsForPath($path);
        $this->height = $dimensions['height'];
        $this->width = $dimensions['width'];

        // Don't save on the replica db
        if (auth()->check()) {
            $this->saveQuietly();
        }
    }
```

`Map::bounds()` itself needs no changes — it already just reads `$this->height`/`$this->width` after calling `prepareBounds()`.

- [ ] **Step 4: Fix the two call sites that read `$map->height`/`$map->width` without calling `prepareBounds()` first**

In `app/Http/Resources/MapResource.php`, add a `prepareBounds()` call at the top of `toArray()`:

```php
    public function toArray($request)
    {
        /** @var Map $model */
        $model = $this->resource;
        $model->prepareBounds();

        return $this->entity([
```

In `resources/views/maps/_setup.blade.php`, the file currently computes `$focus = $map->centerFocus();` (which reads `$map->height`/`$map->width` when there's no center marker/coordinates) before `$map->bounds()` is ever called. Add a `$map->prepareBounds();` call as the very first line inside the existing top `<?php ... ?>` block, before `$focus = $map->centerFocus();`:

```php
<?php
/**
 * @var \App\Models\Map $map
 */
$map->prepareBounds();
$focus = $map->centerFocus();
```

- [ ] **Step 5: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Entities/MapTest.php`
Expected: PASS (both the pre-existing and the new test)

- [ ] **Step 6: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/Map.php app/Http/Resources/MapResource.php resources/views/maps/_setup.blade.php tests/Feature/Entities/MapTest.php
git commit -m "feat: source map bounds from the gallery image's own dimensions"
```

---

### Task 5: `MapLayer` gets its own bounds

**Files:**
- Modify: `app/Models/MapLayer.php`
- Modify: `app/Http/Resources/MapLayerResource.php`
- Modify: `app/Http/Resources/Maps/Explore/LayerResource.php`
- Test: `tests/Feature/Entities/MapLayerTest.php`

**Interfaces:**
- Consumes: `Image::dimensionsForPath()`, `Image::ensureDimensions()`, `Image::width()`, `Image::height()` from Task 2.
- Produces (used by Task 6):
  - `MapLayer::dimensions(): array{width: int, height: int}`
  - `MapLayer::bounds(): string` (leaflet bounds string, same format as `Map::bounds(false)`)

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/MapLayerTest.php`, add `use Illuminate\Support\Facades\Storage;` to the top imports, then add these two tests at the end of the file:

```php
it('uses the gallery image dimensions for a layer without caching them on the layer row', function () {
    $this->asUser()->withCampaign()->withMaps();

    $gd = imagecreatetruecolor(60, 30);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => $image->id]);

    expect($layer->bounds())->toBe('[[0, 0], [30, 60]]');
    expect($layer->fresh()->width)->toBeNull();
    expect($layer->fresh()->height)->toBeNull();
});

it('calculates and caches dimensions for a legacy image_path layer', function () {
    $this->asUser()->withCampaign()->withMaps();

    $gd = imagecreatetruecolor(100, 50);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $path = 'maps/test-layer-bounds.png';
    Storage::put($path, $pngBytes);

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => null]);
    $layer->image_path = $path;
    $layer->saveQuietly();

    expect($layer->bounds())->toBe('[[0, 0], [50, 100]]');
    expect($layer->fresh()->width)->toBe(100);
    expect($layer->fresh()->height)->toBe(50);
});
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Entities/MapLayerTest.php`
Expected: FAIL — `Call to undefined method App\Models\MapLayer::bounds()`

- [ ] **Step 3: Implement `MapLayer::dimensions()` and `bounds()`**

In `app/Models/MapLayer.php`, add the import:

```php
use Illuminate\Support\Facades\Storage;
```

Add the following methods (placed after `hasImage()`, before `isExplorable()`):

```php
    /**
     * Resolve this layer's pixel dimensions: a gallery image (own dimensions, live, never
     * cached on this row) takes priority, then a legacy directly-uploaded image (calculated
     * once and cached on this row, same as Map's own legacy handling), then finally the
     * parent map's own dimensions as a last-resort fallback.
     *
     * @return array{width: int, height: int}
     */
    public function dimensions(): array
    {
        if ($this->image) {
            $this->image->ensureDimensions();
            if ($this->image->hasDimensions()) {
                return ['width' => $this->image->width(), 'height' => $this->image->height()];
            }
        } elseif ($this->image_path) {
            $this->prepareLegacyDimensions();
            if (! empty($this->width) && ! empty($this->height)) {
                return ['width' => $this->width, 'height' => $this->height];
            }
        }

        return [
            'width' => $this->map->width ?: 1000,
            'height' => $this->map->height ?: 1000,
        ];
    }

    /**
     * Build this layer's own image bounds for leaflet, independently of the base map's.
     */
    public function bounds(): string
    {
        $dimensions = $this->dimensions();
        $height = floor($dimensions['height'] / 1);
        $width = floor($dimensions['width'] / 1);

        return "[[0, 0], [{$height}, {$width}]]";
    }

    /**
     * Calculate and cache this legacy (pre-gallery) layer's dimensions directly on the
     * map_layers row, mirroring Map::prepareBounds()'s own legacy-image_path handling.
     */
    protected function prepareLegacyDimensions(): void
    {
        if (! empty($this->width)) {
            return;
        }
        if (empty($this->image_path) || ! Storage::exists($this->image_path)) {
            return;
        }

        $dimensions = Image::dimensionsForPath($this->image_path);
        $this->width = $dimensions['width'];
        $this->height = $dimensions['height'];

        if (auth()->check()) {
            $this->saveQuietly();
        }
    }
```

- [ ] **Step 4: Update `MapLayerResource` to report real dimensions**

In `app/Http/Resources/MapLayerResource.php`, replace the raw column reads with the computed dimensions:

```php
    public function toArray($request)
    {
        /** @var MapLayer $model */
        $model = $this->resource;
        $dimensions = $model->dimensions();

        return $this->entity([
            'map_id' => (int) $model->map_id,
            'name' => $model->name,
            'position' => (int) $model->position,
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
            'visibility_id' => $model->visibility_id,
            'type_id' => (bool) $model->type_id,
            'type' => (string) $model->typeName(),
        ]);
    }
```

- [ ] **Step 5: Add dimensions to the Explore layer resource (feeds the Vue map explorer)**

In `app/Http/Resources/Maps/Explore/LayerResource.php`, add `width`/`height`:

```php
    public function toArray(Request $request): array
    {
        $layer = $this->resource;
        $dimensions = $layer->dimensions();

        return [
            'id' => $layer->id,
            'name' => $layer->name,
            'type_id' => $layer->type_id,
            'image' => $layer->image ? $layer->image->url() : Storage::url($layer->image_path),
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
            'position' => $layer->position,
        ];
    }
```

- [ ] **Step 6: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact tests/Feature/Entities/MapLayerTest.php`
Expected: PASS (all tests in the file, including the two new ones)

- [ ] **Step 7: Format and commit**

```bash
vendor/bin/sail bin pint --dirty --format agent
git add app/Models/MapLayer.php app/Http/Resources/MapLayerResource.php app/Http/Resources/Maps/Explore/LayerResource.php tests/Feature/Entities/MapLayerTest.php
git commit -m "feat: give map layers their own bounds instead of reusing the map's"
```

---

### Task 6: Frontend renders each layer with its own bounds

**Files:**
- Create: `resources/js/maps/layerBounds.js`
- Test: `resources/js/maps/layerBounds.test.js`
- Modify: `resources/js/components/maps/LeafletCanvas.vue:218`
- Modify: `resources/views/maps/_setup.blade.php` (layer overlay lines, currently 34-38 after Task 4's edit shifts line numbers by one)

**Interfaces:**
- Consumes: `layer.width`/`layer.height` now present on the JSON payload from `Maps\Explore\LayerResource` (Task 5).
- Produces: `layerBounds(layer, map): [[number, number], [number, number]]`, used by `LeafletCanvas.vue`.

- [ ] **Step 1: Write the failing test**

Create `resources/js/maps/layerBounds.js` as an empty stub first so the test file has something to import:

```javascript
export function layerBounds(layer, map) {
    throw new Error('not implemented')
}
```

Create `resources/js/maps/layerBounds.test.js`:

```javascript
import test from 'node:test'
import assert from 'node:assert/strict'
import { layerBounds } from './layerBounds.js'

test('layerBounds uses the layer\'s own dimensions when present', () => {
    const layer = { width: 800, height: 400 }
    const map = { width: 2000, height: 1000 }

    assert.deepEqual(layerBounds(layer, map), [[0, 0], [400, 800]])
})

test('layerBounds falls back to the map dimensions when the layer has none', () => {
    const layer = { width: null, height: null }
    const map = { width: 2000, height: 1000 }

    assert.deepEqual(layerBounds(layer, map), [[0, 0], [1000, 2000]])
})
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test resources/js/maps/layerBounds.test.js`
Expected: FAIL — both tests throw `not implemented`

- [ ] **Step 3: Implement `layerBounds`**

Replace the stub in `resources/js/maps/layerBounds.js`:

```javascript
export function layerBounds(layer, map) {
    const height = layer.height || map.height
    const width = layer.width || map.width

    return [[0, 0], [height, width]]
}
```

- [ ] **Step 4: Run the test to verify it passes**

Run: `node --test resources/js/maps/layerBounds.test.js`
Expected: PASS (2 tests)

- [ ] **Step 5: Wire it into `LeafletCanvas.vue`**

In `resources/js/components/maps/LeafletCanvas.vue`, add the import next to the other `../../maps/*.js` imports (around line 13):

```javascript
import { layerBounds } from '../../maps/layerBounds.js'
```

In `buildLayers()`, change:

```javascript
        const leafletLayer = L.imageOverlay(layer.image, bounds())
```

to:

```javascript
        const leafletLayer = L.imageOverlay(layer.image, layerBounds(layer, props.map))
```

- [ ] **Step 6: Wire the blade-rendered map into per-layer bounds too**

In `resources/views/maps/_setup.blade.php`, in the `@foreach ($map->layers as $layer)` block, change both branches from using the map's bounds to the layer's own:

```blade
    @if ($layer->image)
        var layer{{ $layer->id }} = L.imageOverlay('{{ $layer->image->url() }}', {!! $layer->bounds() !!});
    @else
        var layer{{ $layer->id }} = L.imageOverlay('{{ Storage::url($layer->image_path) }}', {!! $layer->bounds() !!});
    @endif
```

- [ ] **Step 7: Build the frontend and manually verify**

Run: `vendor/bin/sail yarn run build`

Then start the app (`vendor/bin/sail up -d` if not already running) and manually check, in the browser, a map that has at least one layer whose image is a different size than the base map: confirm the layer now visually aligns/scales independently instead of being stretched to the base map's dimensions. Check both the classic map view (`_setup.blade.php`) and the Vue map explorer (`MapExplorer.vue` → `LeafletCanvas.vue`).

- [ ] **Step 8: Commit**

```bash
git add resources/js/maps/layerBounds.js resources/js/maps/layerBounds.test.js resources/js/components/maps/LeafletCanvas.vue resources/views/maps/_setup.blade.php
git commit -m "fix: render each map layer with its own image bounds instead of the base map's"
```

---

## Final verification

- [ ] Run the full relevant test suite: `vendor/bin/sail artisan test --compact tests/Feature/Models/ImageDimensionsTest.php tests/Feature/Gallery/UploadServiceDimensionsTest.php tests/Feature/Entities/MapTest.php tests/Feature/Entities/MapLayerTest.php`
- [ ] Run `node --test resources/js/maps/layerBounds.test.js`
- [ ] Run `vendor/bin/sail bin pint --format agent` (full, not just `--dirty`, as a final sweep)
