<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocations;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Observers\OrganisationObserver;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Organisation
 *
 * @property ?int $organisation_id
 * @property ?int $location_id
 * @property Collection|OrganisationMember[] $members
 * @property Collection|Organisation[] $descendants
 * @property bool|int $is_defunct
 */
class Organisation extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocations;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'organisation_id',
        'is_private',
        'is_defunct',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
        'is_defunct',
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

    protected string $locationPivot = 'organisation_location';

    protected string $locationPivotKey = 'organisation_id';

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'organisation_id',
    ];

    protected array $sanitizable = [
        'name',
    ];

    protected array $organisationAndDescendantIds;

    protected static function booted()
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(OrganisationObserver::class);
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'locations' => function ($sub) {
                $sub->select('id', 'name');
            },
        ]))
            ->withCount('members');
    }

    /**
     * Filter for organisations with specific member
     */
    public function scopeMember(Builder $query, ?string $value, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            // If called with a param, it's being called too early and will be called later in the process
            if (! empty($value)) {
                return $query;
            }
            $query
                ->select($this->getTable() . '.*')
                ->leftJoin('organisation_member as memb', function ($join) {
                    $join->on('memb.organisation_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.character_id', null);
            if (auth()->guest() || ! auth()->user()->isAdmin()) {
                $query->where('memb.is_private', 0);
            }

            return $query;

        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from organisation_member as memb where memb.organisation_id = ' .
                    $this->getTable() . '.id and memb.character_id = ' . ((int) $value) . ' ' . $this->subPrivacy('and memb.is_private') . ') = 0');
        }
        $ids = [$value];

        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('organisation_member as memb', function ($join) {
                $join->on('memb.organisation_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.character_id', $ids);

        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            $query->where('memb.is_private', 0);
        }

        return $query->distinct();
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['organisation_id', 'is_defunct', 'location_id'];
    }

    public function pinnedMembers()
    {
        return $this
            ->members()
            ->has('character')
            ->with(['character', 'character.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_ORGANISATION, OrganisationMember::PIN_BOTH])
            ->orderBy('role');
    }

    /**
     * @return string
     */
    public function getParentKeyName()
    {
        return 'organisation_id';
    }

    public function pivotLocations(): HasMany
    {
        return $this->hasMany('App\Models\OrganisationLocation');
    }

    public function members(): HasMany
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
     */
    public function organisationAndDescendantIds(): array
    {
        if (! isset($this->organisationAndDescendantIds)) {
            $this->organisationAndDescendantIds = [$this->id];
            foreach ($this->descendants as $descendant) {
                $this->organisationAndDescendantIds[] = $descendant->id;
            }
        }

        return $this->organisationAndDescendantIds;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        // Pivot tables can be deleted directly
        $this->members()->delete();
        $this->locations()->detach();
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
        if ($this->entity->elapsedEvents->isNotEmpty() || $this->locations->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
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
     *
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
