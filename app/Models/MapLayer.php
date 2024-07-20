<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SortableTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MapLayer
 * @package App\Models
 *
 * @property int $id
 * @property int $map_id
 * @property string $name
 * @property string $entry
 * @property string $image
 * @property int $position
 * @property int $height
 * @property int $width
 * @property int|null $type_id
 *
 * @property Map $map
 *
 * @method static self|Builder ordered()
 */
class MapLayer extends Model
{
    use Blameable;
    use HasFactory;
    use Paginatable;
    use SortableTrait;
    use VisibilityIDTrait;

    protected $fillable = [
        'map_id',
        'name',
        'entry',
        'image',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @return Builder
     */
    public function scopeOrdered(Builder $query)
    {
        return $query
            ->orderByDesc('position')
            ->orderBy('name');
    }

    /**
     * Get the image (or default image) of an entity
     * @return string
     */
    public function thumbnail(int $width = 400, ?int $height = null)
    {
        return Img::crop($width, (!empty($height) ? $height : $width))->url($this->image);
    }

    /**
     */
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

    /**
     */
    public function getEntryForEditionAttribute()
    {
        return Mentions::parseForEdit($this);
    }
}
