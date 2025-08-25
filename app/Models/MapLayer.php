<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
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
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Map, $this>
     */
    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Image, $this>
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
        return $this->updateQuietly($data);
    }

    /**
     * Override the get link
     */
    public function getLink(): string
    {
        $campaign = CampaignLocalization::getCampaign();

        return route('maps.map_layers.edit', [$campaign, 'map' => $this->map_id, $this->id]);
    }

    public function hasImage(): bool
    {
        return $this->image || ! empty($this->image_path);
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
