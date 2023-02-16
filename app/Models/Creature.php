<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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
 */
class Creature extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait
    ;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'campaign_id',
        'slug',
        'type',
        'image',
        'entry',
        'is_private',
        'creature_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'creature';

    protected $sortableColumns = [
        'creature.name',
    ];

    protected $sortable = [
        'name',
        'type',
        'creature.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'creature_id',
    ];

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'creature_id';
    }


    /**
     * Specify parent id attribute mutator
     * @param int $value
     * @throws \Exception
     */
    public function setCreatureIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext');
            },
            'creatures' => function ($sub) {
                $sub->select('id', 'name', 'creature_id');
            },
            'locations' => function ($sub) {
                $sub->select('locations.id', 'locations.name', 'campaign_id');
            },
            'descendants'
        ]);
    }

    /**
     * Filter on creatures in specific locations
     * @param Builder $query
     * @param int|null $location
     * @param FilterOption $filter
     * @return Builder
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
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['creature_id'];
    }

    /**
     * Parent creature
     */
    public function creature()
    {
        return $this->belongsTo(Creature::class, 'creature_id', 'id');
    }

    /**
     * Children creatures
     */
    public function creatures()
    {
        return $this->hasMany(Creature::class, 'creature_id', 'id');
    }

    /**
     * Menu elements for the rendering
     */
    public function menuItems(array $items = []): array
    {
        $count = $this->descendants()->count();
        if ($count > 0) {
            $items['second']['creatures'] = [
                'name' => 'creatures.show.tabs.creatures',
                'route' => 'creatures.creatures',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
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
            'location_id'
        ];
    }

    /**
     * Creatures have multiple locations
     */
    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'creature_location');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if ($this->locations) {
            return true;
        }

        return parent::showProfileInfo();
    }
}
