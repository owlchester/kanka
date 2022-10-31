<?php

namespace App\Models;

use App\Facades\Img;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SortableTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
    use VisibilityIDTrait, Blameable, Paginatable, SortableTrait;

    /** @var bool If set to false, skip the saving observer */
    public $savingObserver = true;

    /** @var string[]  */
    protected $fillable = [
        'map_id',
        'name',
        'entry',
        'image',
        'position',
        'visibility_id',
        'type_id',
    ];

    protected $sortable = [
        'name',
        'position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo(Map::class, 'map_id');
    }

    /**
     * @param Builder $query
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
     * @param int $width
     * @param int|null $height
     * @return string
     */
    public function thumbnail(int $width = 400, int $height = null)
    {
        return Img::crop($width, (!empty($height) ? $height : $width))->url($this->image);
    }

    /**
     * @return string
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
     * @return string
     */
    public function url(string $where): string
    {
        return 'maps.map_layers.' . $where;
    }
    public function routeParams(array $options = []): array
    {
        return [$this->map_id, $this->id];
    }

    /**
     * Patch an entity from the datagrid2 batch editing
     * @param array $data
     * @return bool
     */
    public function patch(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Override the get link
     * @return string
     */
    public function getLink(): string
    {
        return route('maps.map_layers.edit', ['map' => $this->map_id, $this->id]);
    }

    /**
     * Override the tooltiped link for the datagrid
     * @param string|null $displayName
     * @return string
     */
    public function tooltipedLink(string $displayName = null): string
    {
        return '<a href="' . $this->getLink() . '">' .
            (!empty($displayName) ? $displayName : e($this->name)) .
        '</a>';
    }
}
