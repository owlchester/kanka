<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Creature
 * @package App\Models
 *
 * @property Creature[]|Collection $descendants
 *
 * @property int|null $creature_id
 * @property Creature|null $creature
 * @property Creature[] $creatures
 * @property Location|null $location
 * @property Collection|Location[] $locations
 * @property bool $is_extinct
 */
class Creature extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'slug',
        'type',
        'entry',
        'is_private',
        'creature_id',
        'is_extinct',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'creature';

    protected array $sortableColumns = [
        'is_extinct',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
        'is_extinct',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'creature_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'pivotLocations',
    ];

    protected array $exportFields = [
        'base',
        'is_extinct',
    ];

    protected array $exploreGridFields = ['is_extinct'];

    /**
     * @return string
     */
    public function getParentKeyName()
    {
        return 'creature_id';
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'creatures' => function ($sub) {
                $sub->select('id', 'name', 'creature_id');
            },
            'locations' => function ($sub) {
                $sub->select('id', 'name');
            },
            //            'descendants',
            'children' => function ($sub) {
                $sub->select('id', 'creature_id');
            },
        ]);
    }

    /**
     * Filter on creatures in specific locations
     */
    public function scopeLocation(Builder $query, int|null $location, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            if (!empty($location)) {
                return $query;
            }
            return $query
                ->whereRaw('(select count(*) from creature_location as cl where cl.creature_id = ' .
                    $this->getTable() . '.id and cl.location_id = ' . ((int) $location) . ') = 0');
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from creature_location as cl where cl.creature_id = ' .
                    $this->getTable() . '.id and cl.location_id = ' . ((int) $location) . ') = 0');
        }

        $ids = [$location];
        if ($filter === FilterOption::CHILDREN) {
            /** @var Location|null $model */
            $model = Location::find($location);
            if (!empty($model)) {
                $ids = [...$model->descendants->pluck('id')->toArray(), $model->id];
            }
        }
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('creature_location as cl', function ($join) {
                $join->on('cl.creature_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('cl.location_id', $ids)->distinct();
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['creature_id', 'is_extinct'];
    }

    /**
     * Parent creature
     */
    public function creature(): BelongsTo
    {
        return $this->belongsTo(Creature::class, 'creature_id', 'id');
    }

    /**
     * Children creatures
     */
    public function creatures(): HasMany
    {
        return $this->hasMany(Creature::class, 'creature_id', 'id');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.creature');
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'creature_id',
            'location_id',
            'is_extinct',
        ];
    }

    /**
     * Creatures have multiple locations
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Location', 'creature_location')
            ->with('entity');
    }
    public function pivotLocations()
    {
        return $this->hasMany('App\Models\CreatureLocation');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if ($this->locations->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Determine if the model is extinct.
     */
    public function isExtinct(): bool
    {
        return (bool) $this->is_extinct;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        // Pivot tables can be deleted directly
        $this->locations()->detach();
    }
}
