<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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
 * @property bool $is_defunct
 */
class Organisation extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        Nested,
        SoftDeletes,
        SortableTrait,
        Acl
    ;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'location_id',
        'organisation_id',
        'type',
        'is_private',
        'is_defunct'
    ];

    protected $sortable = [
        'name',
        'type',
        'organisation.name',
        'is_defunct'
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'organisation';

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'organisation.name',
        'location.name',
        'is_defunct',
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'members',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'location_id',
        'organisation_id'
    ];

    protected $organisationAndDescendantIds = false;

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query
            ->with([
                'entity',
                'entity.image',
                'location',
                'location.entity',
                'organisation',
                'members',
                'organisations'
            ]);
    }

    /**
     * Filter for organisations with specific member
     * @param Builder $query
     * @param string|null $value
     * @param FilterOption $filter
     * @return Builder
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
     * @return array
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
    public function getParentIdName()
    {
        return 'organisation_id';
    }


    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setOrganisationIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
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
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $count = $this->descendants()->count();
        if ($count > 0) {
            $items['second']['organisations'] = [
                'name' => 'organisations.show.tabs.organisations',
                'route' => 'organisations.organisations',
                'count' => $count,
            ];
        }

        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.organisation');
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->type) || !empty($this->location) || !$this->entity->elapsedEvents->isEmpty();
    }

    /**
     * Get the value of the is_defunct variable
     * @return bool
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
