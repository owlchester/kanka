<?php


namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Traits\VisibilityIDTrait;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MapGroup
 * @package App\Models
 *
 * @property int $id
 * @property int $map_id
 * @property string $name
 * @property int $position
 * @property boolean $is_shown
 *
 * @property Map $map
 *
 * @method static self|Builder ordered()
 */
class MapGroup extends Model
{
    use VisibilityIDTrait, Blameable, Paginatable, SortableTrait;

    protected $sortable = [
        'name',
        'position',
    ];

    /** @var string[]  */
    protected $fillable = [
        'map_id',
        'name',
        'position',
        'visibility_id',
        'is_shown',
    ];

    /**
     * If set to false, skip the saving observer
     * @var bool
     */
    public $savingObserver = true;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function markers()
    {
        return $this->hasMany(MapMarker::class, 'group_id');
    }

    /**
     * @return string
     */
    public function markerGroupHtml(): string
    {
        $data = [];
        /** @var MapMarker[] $markers */
        $markers = $this->markers()->with('entity', 'group')->get();
        foreach ($markers as $marker) {
            if ($marker->visible()) {
                $data[] = 'marker' . $marker->id;
            }
        }

        return implode(',', $data);
    }

    /**
     * Functions for the datagrid2
     * @return string
     */
    public function deleteName(): string
    {
        return (string) $this->name;
    }
    public function url(string $where): string
    {
        return 'maps.map_groups.' . $where;
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
        return route('maps.map_groups.edit', ['map' => $this->map_id, $this->id]);
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
