<?php

namespace App\Models;

use App\Enums\Visibility;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Class MapLayer
 *
 * @property int $id
 * @property int $map_id
 * @property ?string $image_uuid
 * @property ?string $image_path
 * @property string $name
 * @property string $entry
 * @property int $position
 * @property int $height
 * @property int $width
 * @property ?int $type_id
 * @property Map $map
 * @property Image $image
 *
 * @method static self|Builder ordered()
 */
class MapLayer extends Model
{
    use Blameable;
    use HasEntry;
    use HasFactory;
    use HasVisibility;
    use Paginatable;
    use Sanitizable;
    use SortableTrait;

    protected $fillable = [
        'map_id',
        'name',
        'image_uuid',
        'entry',
        'position',
        'visibility_id',
        'type_id',
    ];

    protected array $sortable = [
        'name',
        'position',
    ];

    public $casts = [
        'visibility_id' => Visibility::class,
        'type_id' => 'integer',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * @return BelongsTo<Map, $this>
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @return BelongsTo<Image, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_uuid');
    }

    /**
     * Default order maps based on their position field
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderByDesc('position')
            ->orderBy('name');
    }

    /**
     * Get the image (or default image) of an entity
     */
    public function thumbnail(int $width = 400, ?int $height = null): string
    {
        if ($this->image) {
            return $this->image->getUrl($width, $height);
        }

        return Img::crop($width, (! empty($height) ? $height : $width))->url($this->image_path);
    }

    public function typeName(): string
    {
        if (empty($this->type_id)) {
            return 'standard';
        } elseif ($this->type_id == 1) {
            return 'overlay';
        }

        return 'overlay_shown';
    }

    /**
     * Functions for the datagrid2
     */
    public function url(string $where): string
    {
        return 'maps.map_layers.' . $where;
    }

    public function routeParams(array $options = []): array
    {
        return $options + ['map' => $this->map_id, 'map_layer' => $this->id];
    }

    /**
     * Patch an entity from the datagrid2 batch editing
     */
    public function patch(array $data): bool
    {
        return $this->update($data);
    }

    public function hasImage(): bool
    {
        return $this->image || ! empty($this->image_path);
    }

    /**
     * Resolve this layer's pixel dimensions: a gallery image (own dimensions, live, never
     * cached on this row) takes priority, then a legacy directly-uploaded image (calculated
     * once and cached on this row, same as Map's own legacy handling), then finally the
     * parent map's own resolved dimensions as a last-resort fallback (never the map's
     * possibly-null persisted columns directly, since a gallery-image map never persists
     * its width/height — prepareBounds() must run first to resolve them).
     *
     * @return array{width: int, height: int}
     */
    public function dimensions(): array
    {
        if ($this->image) {
            $this->image->ensureDimensions();
            if ($this->image->hasDimensions() && $this->image->width() && $this->image->height()) {
                return ['width' => $this->image->width(), 'height' => $this->image->height()];
            }
        } elseif ($this->image_path) {
            $this->prepareLegacyDimensions();
            if (! empty($this->width) && ! empty($this->height)) {
                return ['width' => $this->width, 'height' => $this->height];
            }
        }

        $this->map->prepareBounds();

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

    public function isExplorable(): bool
    {
        return $this->hasImage();
    }

    public function getEntryForEditionAttribute()
    {
        return Mentions::parseForEdit($this);
    }

    public function exportFields(): array
    {
        return [
            'id',
            'map_id',
            'image_uuid',
            'image_path',
            'name',
            'entry',
            'position',
            'height',
            'width',
            'visibility_id',
            'type_id',
        ];
    }
}
