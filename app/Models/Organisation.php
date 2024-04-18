<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Organisation
 * @package App\Models
 *
 * @property int|null $organisation_id
 * @property int|null $location_id
 * @property Organisation|null $organisation
 * @property Collection|OrganisationMember[] $members
 * @property Collection|Organisation[] $descendants
 * @property Collection|Organisation[] $organisations
 * @property Collection|Location[] $locations
 * @property bool $is_defunct
 */
class Organisation extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'entry',
        'organisation_id',
        'type',
        'is_private',
        'is_defunct'
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
        'is_defunct'
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'organisation';

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'is_defunct',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'members',
        'pivotLocations',
    ];

    protected array $exportFields = [
        'base',
        'is_defunct',
    ];

    protected array $exploreGridFields = ['is_defunct'];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'organisation_id'
    ];

    protected $organisationAndDescendantIds = false;

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query
            ->with([
                'entity',
                'entity.image',
                'locations' => function ($sub) {
                    $sub->select('id', 'name');
                },
                'parent' => function ($sub) {
                    $sub->select('id', 'name');
                },
                'parent.entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
                'members',
                'organisations',
                'children' => function ($sub) {
                    $sub->select('id', 'organisation_id');
                },
            ]);
    }

    /**
     * Filter on organisations in specific locations
     */
    public function scopeLocation(Builder $query, int|null $location, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            if (!empty($location)) {
                return $query;
            }
            return $query
                ->whereRaw('(select count(*) from organisation_location as ol where ol.organisation_id = ' .
                    $this->getTable() . '.id and ol.location_id = ' . ((int) $location) . ') = 0');
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from organisation_location as ol where ol.organisation_id = ' .
                    $this->getTable() . '.id and ol.location_id = ' . ((int) $location) . ') = 0');
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
            ->leftJoin('organisation_location as ol', function ($join) {
                $join->on('ol.organisation_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('ol.location_id', $ids)->distinct();
    }

    /**
     * Filter for organisations with specific member
     */
    public function scopeMember(Builder $query, string|null $value, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            // If called with a param, it's being called too early and will be called later in the process
            if (!empty($value)) {
                return $query;
            }
            return $query
                ->select($this->getTable() . '.*')
                ->leftJoin('organisation_member as memb', function ($join) {
                    $join->on('memb.organisation_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.character_id', null);
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from organisation_member as memb where memb.organisation_id = ' .
                    $this->getTable() . '.id and memb.character_id in (' . (int) $value . ')) = 0');
        }
        $ids = [$value];
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('organisation_member as memb', function ($join) {
                $join->on('memb.organisation_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.character_id', $ids)->distinct();
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['organisation_id', 'is_defunct', 'location_id'];
    }

    /**
     */
    public function pinnedMembers()
    {
        return $this
            ->members()
            ->has('character')
            ->with(['character', 'character.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_ORGANISATION, OrganisationMember::PIN_BOTH])
            ->orderBy('role')
        ;
    }

    /**
     * Parent
     */
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id', 'id');
    }

    /**
     * Children
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation', 'organisation_id', 'id');
    }

    /**
     * @return string
     */
    public function getParentKeyName()
    {
        return 'organisation_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * Creatures have multiple locations
     */
    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'organisation_location')
            ->with('entity');
    }

    public function pivotLocations()
    {
        return $this->hasMany('App\Models\OrganisationLocation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany('App\Models\OrganisationMember', 'organisation_id', 'id');
    }

    /**
     * Get all characters in the organisation and descendants
     */
    public function allMembers()
    {
        $organisationId = $this->organisationAndDescendantIds();

        return OrganisationMember::whereIn('organisation_member.organisation_id', $organisationId)->with('character');
    }

    /**
     * Get a list of this organisation and descendant ids
     * @return array|bool
     */
    public function organisationAndDescendantIds()
    {
        if ($this->organisationAndDescendantIds === false) {
            $this->organisationAndDescendantIds = [$this->id];
            foreach ($this->descendants as $descendant) {
                $this->organisationAndDescendantIds[] = $descendant->id;
            };
        }
        return $this->organisationAndDescendantIds;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->children()->get() as $child) {
            $child->organisations()->detatch($this->id);
        }
        foreach ($this->members as $child) {
            $child->delete();
        }

        return parent::detach();
    }

    /**
     */
    public function menuItems(array $items = []): array
    {
        $count = $this->descendants()->count();
        if ($count > 0) {
            $items['second']['organisations'] = [
                'name' => Module::plural($this->entityTypeId(), 'entities.organisations'),
                'route' => 'organisations.organisations',
                'count' => $count,
            ];
        }

        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.organisation');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->type) || !empty($this->location) || !$this->entity->elapsedEvents->isEmpty() || $this->locations->isNotEmpty();
    }

    /**
     * Get the value of the is_defunct variable
     */
    public function isDefunct(): bool
    {
        return (bool) $this->is_defunct;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'location_id',
            'organisation_id',
            'is_defunct',
            'member_id',
        ];
    }
}
