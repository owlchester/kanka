<?php

namespace App\Models;

use App\Facades\Img;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Sanitizable;
use App\Traits\ExportableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class Image
 *
 * @property string $id
 * @property string $name
 * @property string $ext
 * @property int $size
 * @property ?int $focus_x
 * @property ?int $focus_y
 * @property ?string $folder_id
 * @property bool|int $is_default
 * @property bool|int $is_folder
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
 */
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
    ];

    public $casts = [
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected string $userField = 'created_by';

    protected array $sanitizable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Image, $this>
     */
    public function imageFolder(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'folder_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Image, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'folder_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Image, $this>
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Image::class, 'folder_id', 'id')
            ->where('is_folder', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Entity, $this>
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'image_uuid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\MapLayer, $this>
     */
    public function mapLayers(): HasMany
    {
        return $this->hasMany(MapLayer::class, 'image_uuid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Inventory, $this>
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'image_uuid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityAsset, $this>
     */
    public function entityAssets(): HasMany
    {
        return $this->hasMany(EntityAsset::class, 'image_uuid', 'id')
            ->with('entity')
            ->has('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Entity, $this>
     */
    public function headers(): HasMany
    {
        return $this->hasMany(Entity::class, 'header_uuid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ImageMention, $this>
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
        $entities = count($this->inEntities());
        $mentions = $this->mentions()->count();
        $layers = $this->mapLayers()->count();
        $inventories = $this->inventories()->count();

        return $entities || $mentions || $layers || $inventories;
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
        return $this->id . '.' . $this->ext;
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

    public function hasNoFolders(): bool
    {
        return $this->images()->where('is_folder', '1')->count() == 0;
    }

    public function getImagePath($width = 40, $height = 40): string
    {
        return Img::resetCrop()->crop($width, $height)->url($this->path);
    }

    public function isFolder(): bool
    {
        return (bool) $this->is_folder;
    }

    public function isFont(): bool
    {
        return in_array($this->ext, ['woff', 'woff2']);
    }

    public function hasThumbnail(): bool
    {
        return in_array($this->ext, ['jpg', 'png', 'jpeg', 'gif', 'webp']);
    }

    public function getUrl(?int $sizeX = null, ?int $sizeY = null): string
    {
        if ($this->isSvg()) {
            return $this->url();
        }
        Img::reset();

        if (! $sizeY && $sizeX) {
            $sizeY = $sizeX;
        } elseif (! $sizeX && $sizeY) {
            $sizeX = $sizeY;
        }
        if ($sizeX && $sizeY) {
            if (! $this->focus_x && ! $this->focus_y) {
                return Img::crop($sizeX, $sizeY)->url($this->path);
            }

            return Img::focus($this->focus_x, $this->focus_y)->crop($sizeX, $sizeY)->url($this->path);
        }

        if ($this->focus_x && $this->focus_y) {
            return Img::focus($this->focus_x, $this->focus_y)->url($this->path);
        }

        return Img::url($this->path);
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
}
