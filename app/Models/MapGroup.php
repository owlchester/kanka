<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class MapGroup
 *
 * @property int $id
 * @property int $map_id
 * @property int $parent_id
 * @property string $name
 * @property int $position
 * @property bool|int $is_shown
 * @property ?MapGroup $parent
 * @property Map $map
 *
 * @method static self|Builder ordered()
 */
class MapGroup extends Model
{
    use Blameable;
    use HasFactory;
    use HasRecursiveRelationships;
    use HasVisibility;
    use Nested;
    use Paginatable;
    use Sanitizable;
    use SortableTrait;

    protected array $sortable = [
        'name',
        'position',
        'parent_id',
    ];

    protected $fillable = [
        'map_id',
        'parent_id',
        'name',
        'position',
        'visibility_id',
        'is_shown',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\MapGroup, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MapGroup::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\MapGroup, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MapGroup::class, 'parent_id')->with('children');
    }

    public function descendantGroupIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->descendantGroupIds());
        }

        return $ids;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\MapMarker, $this>
     */
    public function markers(): HasMany
    {
        return $this->hasMany(MapMarker::class, 'group_id');
    }

    public function markersWithEntity()
    {
        $ids = $this->descendantGroupIds();
        $ids[] = $this->id; // include this group itself

        return MapMarker::whereIn('group_id', $ids)
            ->with(['entity', 'entity.entityType', 'group'])
            ->get();
    }

    public function markerGroupHtml(): string
    {
        $data = [];
        /** @var MapMarker[] $markers */
        $markers = $this->markersWithEntity();
        // dd($markers);

        foreach ($markers as $marker) {
            if ($marker->visible()) {
                $data[] = 'marker' . $marker->id;
            }
        }

        return implode(',', $data);
    }

    /**
     * Functions for the datagrid2
     */
    public function url(string $where): string
    {
        return 'maps.map_groups.' . $where;
    }

    public function routeParams(array $options = []): array
    {
        return $options + ['map' => $this->map_id, 'map_group' => $this->id];
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

        return route('maps.map_groups.edit', [$campaign, 'map' => $this->map_id, $this->id]);
    }
}
