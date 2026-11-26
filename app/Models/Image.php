<?php

namespace App\Models;

use App\Enums\Visibility;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Sanitizable;
use App\Observers\ImageObserver;
use App\Services\Images\Img;
use App\Traits\ExportableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Image
 *
 * @property string $id
 * @property string $name
 * @property string $ext
 * @property ?int $version
 * @property int $size
 * @property ?int $focus_x
 * @property ?int $focus_y
 * @property ?int $tiling_status
 * @property ?string $tiling_error
 * @property ?array $metadata
 * @property ?string $description
 * @property ?string $author
 * @property ?string $folder_id
 * @property bool $is_default
 * @property bool $is_folder
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Image $imageFolder
 * @property Image[] $folders
 * @property Image[] $images
 * @property Entity[] $entities
 * @property Collection|ImageMention[] $mentions
 * @property Collection|EntityAsset[] $entityAssets
 * @property MapLayer[] $mapLayers
 * @property Inventory[] $inventories
 * @property Entity[] $headers
 * @property string $path
 * @property string $file
 * @property string $folder
 * @property int $_usageCount
 *
 * @method static Builder|self acl(bool $browse)
 * @method static Builder|self named(string|null $term)
 * @method static Builder|self imageFolder(string|null $folder)
 * @method static Builder|self search(?string $folder, ?string $term)
 * @method static Builder|self withoutFonts()
 * @method static Builder|self searchMetadata(?string $term)
 * @method static Builder|self ofType(?string $type)
 * @method static Builder|self orientation(?string $orientation)
 * @method static Builder|self notUsed()
 * @method static Builder|self used()
 */
#[ObservedBy(ImageObserver::class)]
class Image extends Model
{
    use Blameable;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasUser;
    use HasUuids;
    use HasVisibility;
    use LastSync;
    use Sanitizable;

    public $fillable = [
        'name',
        'is_folder',
        'folder_id',
        'visibility_id',
        'focus_x',
        'focus_y',
        'description',
        'author',
    ];

    public $casts = [
        'visibility_id' => Visibility::class,
        'metadata' => 'array',
        'version' => 'integer',
        'is_folder' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $attributes = [
        'version' => 1,
    ];

    public const TILING_RUNNING = 1;

    public const TILING_FINISHED = 2;

    public const TILING_ERROR = 3;

    public const FONT_EXTENSIONS = ['woff', 'woff2'];

    protected string $userField = 'created_by';

    protected array $sanitizable = [
        'name',
        'description',
        'author',
    ];

    /**
     * @return BelongsTo<Image, $this>
     */
    public function imageFolder(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'folder_id', 'id');
    }

    /**
     * @return HasMany<Image, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'folder_id', 'id');
    }

    /**
     * @return HasMany<Image, $this>
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Image::class, 'folder_id', 'id')
            ->where('is_folder', true);
    }

    /**
     * @return HasMany<Entity, $this>
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'image_uuid', 'id');
    }

    /**
     * @return HasMany<MapLayer, $this>
     */
    public function mapLayers(): HasMany
    {
        return $this->hasMany(MapLayer::class, 'image_uuid', 'id');
    }

    /**
     * @return HasMany<Inventory, $this>
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'image_uuid', 'id');
    }

    /**
     * @return HasMany<EntityAsset, $this>
     */
    public function entityAssets(): HasMany
    {
        return $this->hasMany(EntityAsset::class, 'image_uuid', 'id')
            ->with('entity')
            ->has('entity');
    }

    /**
     * @return HasMany<Entity, $this>
     */
    public function headers(): HasMany
    {
        return $this->hasMany(Entity::class, 'header_uuid', 'id');
    }

    /**
     * @return HasMany<ImageMention, $this>
     */
    public function mentions(): HasMany
    {
        return $this->hasMany(ImageMention::class, 'image_id', 'id')
            ->with('entity')
            ->with('post')
            ->has('entity');
    }

    public function inEntities(): array
    {
        $entities = [];
        foreach ($this->entities as $entity) {
            if (isset($entities[$entity->id])) {
                continue;
            }
            $entities[$entity->id] = $entity;
        }
        foreach ($this->headers as $entity) {
            if (isset($entities[$entity->id])) {
                continue;
            }
            $entities[$entity->id] = $entity;
        }
        foreach ($this->entityAssets as $asset) {
            if (isset($entities[$asset->entity->id])) {
                continue;
            }
            $entities[$asset->entity->id] = $asset->entity;
        }

        return $entities;
    }

    public function isUsed(): bool
    {
        if ($this->is_default) {
            return true;
        }

        $entities = count($this->inEntities());
        $mentions = $this->mentions()->count();
        $layers = $this->mapLayers()->count();
        $inventories = $this->inventories()->count();

        return $entities || $mentions || $layers || $inventories;
    }

    /**
     * Check whether this folder is a descendant of the given folder ID.
     */
    public function isDescendantOf(string $potentialAncestorId): bool
    {
        $visited = [$this->id => true];
        $currentFolderId = $this->folder_id;
        $depth = 0;

        while (! empty($currentFolderId) && $depth < 50) {
            if ($currentFolderId === $potentialAncestorId) {
                return true;
            }
            if (isset($visited[$currentFolderId])) {
                return false;
            }
            $visited[$currentFolderId] = true;
            $currentFolderId = self::withoutGlobalScopes()
                ->where('id', $currentFolderId)
                ->value('folder_id');
            $depth++;
        }

        return false;
    }

    public function inEntitiesCount(): int
    {
        if (isset($this->_usageCount)) {
            return $this->_usageCount;
        }

        return $this->_usageCount = count($this->inEntities());
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    public function getPathAttribute(): string
    {
        return $this->folder . '/' . $this->file;
    }

    public function getFileAttribute(): string
    {
        if ($this->version === null) {
            return $this->id . '.' . $this->ext;
        }

        return $this->id . '/' . $this->version . '.' . $this->ext;
    }

    public function getFolderAttribute(): string
    {
        return 'campaigns/' . $this->campaign_id;
    }

    public function niceSize(): string
    {
        if ($this->size > 1000) {
            return round($this->size / 1024, 2) . ' MB';
        }

        return $this->size . ' KB';
    }

    public function scopeImageFolder(Builder $query, ?string $folder = null): Builder
    {
        if (empty($folder)) {
            return $query->whereNull('folder_id');
        }

        return $query->where('folder_id', $folder);
    }

    public function scopeDefaultOrder(Builder $query): Builder
    {
        return $query
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->orderBy('name', 'asc');
    }

    public function scopeSortOrder(Builder $query, string $sort = 'asc'): Builder
    {
        return $query
            ->orderBy('is_folder', 'desc')
            ->orderBy('name', $sort)
            ->orderBy('updated_at', 'desc');
    }

    public function scopeFolders(Builder $query): Builder
    {
        return $query
            ->where('is_folder', true)
            ->orderBy('name', 'asc');
    }

    public function scopeAcl(Builder $query, bool $browse): Builder
    {
        if (! $browse) {
            return $query->where('created_by', auth()->user()->id);
        }

        return $query;
    }

    public function scopeNamed(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where($this->getTable() . '.name', 'like', '%' . $term . '%');
    }

    public function scopeSearch(Builder $query, ?string $folder, ?string $term): Builder
    {
        if (empty($term)) {
            // @phpstan-ignore-next-line
            return $query->imageFolder($folder);
        }

        // @phpstan-ignore-next-line
        return $query->named($term);
    }

    public function scopeWithoutFonts(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->whereNull($this->getTable() . '.ext')
                ->orWhereNotIn($this->getTable() . '.ext', self::FONT_EXTENSIONS);
        });
    }

    public function scopeSearchMetadata(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        $table = $this->getTable();
        $like = '%' . $term . '%';

        return $query->where(function (Builder $q) use ($table, $like): void {
            $q->where($table . '.name', 'like', $like)
                ->orWhere($table . '.description', 'like', $like)
                ->orWhere($table . '.author', 'like', $like)
                ->orWhere($table . '.ext', 'like', $like);
        });
    }

    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        if (empty($type) || $type === 'all') {
            return $query;
        }

        $table = $this->getTable();

        return match ($type) {
            'image' => $query->where($table . '.is_folder', false)
                ->whereIn($table . '.ext', ['jpg', 'jpeg', 'png', 'gif', 'webp']),
            'svg' => $query->where($table . '.is_folder', false)
                ->where($table . '.ext', 'svg'),
            'font' => $query->where($table . '.is_folder', false)
                ->whereIn($table . '.ext', self::FONT_EXTENSIONS),
            default => $query->where($table . '.is_folder', false)
                ->where($table . '.ext', $type),
        };
    }

    public function scopeOrientation(Builder $query, ?string $orientation): Builder
    {
        if (empty($orientation) || $orientation === 'all') {
            return $query;
        }

        $table = $this->getTable();
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $widthExpr = "CAST(json_extract({$table}.metadata, '$.width') AS INTEGER)";
            $heightExpr = "CAST(json_extract({$table}.metadata, '$.height') AS INTEGER)";
        } else {
            $widthExpr = "CAST(JSON_UNQUOTE(JSON_EXTRACT({$table}.metadata, '$.width')) AS UNSIGNED)";
            $heightExpr = "CAST(JSON_UNQUOTE(JSON_EXTRACT({$table}.metadata, '$.height')) AS UNSIGNED)";
        }

        $query->where($table . '.is_folder', false)
            ->whereNotNull($table . '.metadata')
            ->whereRaw("{$widthExpr} > 0 AND {$heightExpr} > 0");

        return match ($orientation) {
            'landscape' => $query->whereRaw("{$widthExpr} > {$heightExpr}"),
            'portrait' => $query->whereRaw("{$heightExpr} > {$widthExpr}"),
            'square' => $query->whereRaw("{$widthExpr} = {$heightExpr}"),
            default => $query,
        };
    }

    public function scopeNotUsed(Builder $query): Builder
    {
        $table = $this->getTable();

        return $query
            ->where($table . '.is_folder', false)
            ->where($table . '.is_default', false)
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('entities')
                    ->whereColumn('entities.image_uuid', $table . '.id');
            })
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('entities')
                    ->whereColumn('entities.header_uuid', $table . '.id');
            })
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('image_mentions')
                    ->whereColumn('image_mentions.image_id', $table . '.id');
            })
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('entity_assets')
                    ->whereColumn('entity_assets.image_uuid', $table . '.id');
            })
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('map_layers')
                    ->whereColumn('map_layers.image_uuid', $table . '.id');
            })
            ->whereNotExists(function ($q) use ($table): void {
                $q->select(DB::raw(1))
                    ->from('inventories')
                    ->whereColumn('inventories.image_uuid', $table . '.id');
            });
    }

    public function scopeUsed(Builder $query): Builder
    {
        $table = $this->getTable();

        return $query
            ->where($table . '.is_folder', false)
            ->where(function (Builder $q) use ($table): void {
                $q->where($table . '.is_default', true)
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('entities')
                            ->whereColumn('entities.image_uuid', $table . '.id');
                    })
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('entities')
                            ->whereColumn('entities.header_uuid', $table . '.id');
                    })
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('image_mentions')
                            ->whereColumn('image_mentions.image_id', $table . '.id');
                    })
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('entity_assets')
                            ->whereColumn('entity_assets.image_uuid', $table . '.id');
                    })
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('map_layers')
                            ->whereColumn('map_layers.image_uuid', $table . '.id');
                    })
                    ->orWhereExists(function ($sub) use ($table): void {
                        $sub->select(DB::raw(1))
                            ->from('inventories')
                            ->whereColumn('inventories.image_uuid', $table . '.id');
                    });
            });
    }

    public function hasNoFolders(): bool
    {
        return $this->images()->where('is_folder', '1')->count() == 0;
    }

    public function getImagePath($width = 40, $height = 40): string
    {
        return Img::for($this->path)->crop($width, $height)->url();
    }

    public function isFolder(): bool
    {
        return (bool) $this->is_folder;
    }

    public function isFont(): bool
    {
        return in_array($this->ext, self::FONT_EXTENSIONS);
    }

    public function hasThumbnail(): bool
    {
        return in_array($this->ext, ['jpg', 'png', 'jpeg', 'gif', 'webp']);
    }

    public function width(): ?int
    {
        return $this->metadata['width'] ?? null;
    }

    public function height(): ?int
    {
        return $this->metadata['height'] ?? null;
    }

    public function tileMinZoom(): int
    {
        return (int) ($this->metadata['tile_min_zoom'] ?? 0);
    }

    public function tileMaxZoom(): int
    {
        if (isset($this->metadata['tile_max_zoom'])) {
            return (int) $this->metadata['tile_max_zoom'];
        }

        $longestSide = max($this->width() ?? 0, $this->height() ?? 0);

        return $longestSide > 256 ? (int) ceil(log($longestSide / 256, 2)) : 0;
    }

    public function hasDimensions(): bool
    {
        return isset($this->metadata['width'], $this->metadata['height']);
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
        if (! Storage::exists($path)) {
            return ['width' => 0, 'height' => 0];
        }

        if (Str::endsWith($path, '.svg')) {
            $contents = Storage::get($path);
            libxml_use_internal_errors(true); // Suppress warnings for malformed svg/xml
            $xml = simplexml_load_string($contents);

            if ($xml === false) {
                return ['width' => 0, 'height' => 0];
            }

            return [
                'width' => (int) $xml->attributes()->width,
                'height' => (int) $xml->attributes()->height,
            ];
        }

        $stream = Storage::readStream($path);
        $header = fread($stream, 65536);
        fclose($stream);
        $size = getimagesizefromstring($header);

        if (! is_array($size)) {
            return ['width' => 0, 'height' => 0];
        }

        return [
            'width' => $size[0],
            'height' => $size[1],
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
     *
     * A file that's missing from storage (transient: S3 blip, upload race) is left
     * uncached so the next call retries; only a file that exists but fails to parse
     * gets its {0,0} result permanently cached, since retrying that won't help.
     */
    public function ensureDimensions(): void
    {
        if ($this->hasDimensions()) {
            return;
        }
        if (! $this->hasThumbnail() && ! $this->isSvg()) {
            return;
        }
        if (! Storage::exists($this->path)) {
            return;
        }

        $this->metadata = array_merge($this->metadata ?? [], $this->calculateDimensions());

        if (auth()->check()) {
            $this->saveQuietly();
        }
    }

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
        return 'campaigns/' . $this->campaign_id . '/tiles/' . $this->id;
    }

    public function getUrl(?int $sizeX = null, ?int $sizeY = null): string
    {
        if ($this->isSvg()) {
            return $this->url();
        }
        if (! $sizeY && $sizeX) {
            $sizeY = $sizeX;
        } elseif (! $sizeX && $sizeY) {
            $sizeX = $sizeY;
        }

        $img = Img::for($this->path);

        if ($sizeX && $sizeY) {
            $img->crop($sizeX, $sizeY);
        }

        if ($this->focus_x || $this->focus_y) {
            $img->focus($this->focus_x, $this->focus_y);
        }

        return $img->url();
    }

    public function isSvg(): bool
    {
        return $this->ext == 'svg';
    }

    public function url(): string
    {
        $path = $this->path;
        $cdn = config('cdn.ugc');
        if ($cdn) {
            return $cdn . '/' . $path;
        }

        return Storage::url($path);
    }

    /**
     * Leaflet tile URL template for this image's tile pyramid, e.g. ".../tiles/{z}/{y}/{x}.webp".
     * Tiles are always webp (see TilingService), so the extension is fixed and never needs to be
     * tracked per-image. Points straight at storage/CDN rather than a PHP route, so tile requests
     * skip the app entirely (no session overhead, cacheable by a CDN in front of storage).
     */
    public function tilesUrlTemplate(): string
    {
        $path = $this->tilesPath() . '/{z}/{y}/{x}.webp';
        $cdn = config('cdn.ugc');
        if ($cdn) {
            return $cdn . '/' . $path;
        }

        return Storage::url($path);
    }
}
