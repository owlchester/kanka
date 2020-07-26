<?php


namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MapGroup
 * @package App\Models
 *
 * @property int $id
 * @property int $map_id
 * @property string $name
 * @property string $visibility
 * @property int $position
 *
 * @property Map $map
 *
 * @method static self|Builder ordered()
 */
class MapGroup extends Model
{
    use VisibilityTrait, Blameable;

    /** Fillable fields */
    protected $fillable = [
        'map_id',
        'name',
        'position',
        'visibility',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function markers()
    {
        return $this->hasMany(MapMarker::class, 'group_id');
    }

    public function markerGroupHtml(): string
    {
        $data = [];
        $ids = $this->markers->pluck('id');
        foreach ($ids as $id) {
            $data[] = 'marker' . $id;
        }

        return implode(',', $data);
    }
}
