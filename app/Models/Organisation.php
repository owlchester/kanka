<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organisation
 * @package App\Models
 *
 * @property int $organisation_id
 * @property Organisation $organisation
 * @property Organisation[] $descendants
 * @property Organisation[] $organisations
 */
class Organisation extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        Nested,
        SimpleSortableTrait,
        SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'location_id',
        'organisation_id',
        'type',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry', 'type'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'organisation';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'location_id',
        'organisation_id',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'organisation.name',
        'location.name',
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'members',
        'quests'
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'organisation_id'
    ];

    protected $organisationAndDescendantIds = false;

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany[]|OrganisationMember
     */
    public function pinnedMembers()
    {
        return $this
            ->members()
            ->has('character')
            ->with(['character', 'character.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_ORGANISATION, OrganisationMember::PIN_BOTH])
            ->orderBy('role')
            ->get()
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
     * @param $value
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quests()
    {
        return $this->belongsToMany('App\Models\Quest', 'quest_organisations')
            ->using('App\Models\Pivots\QuestOrganisation')
            ->withPivot('role', 'is_private');
    }

    /**
     * @return mixed
     */
    public function relatedQuests()
    {
        $query = $this->quests()
            ->orderBy('name', 'ASC')
            ->with(['characters', 'locations', 'quests']);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('quest_organisations.is_private', false);
        }

        return $query;
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
        foreach ($this->children(true)->get() as $child) {
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
        $campaign = CampaignLocalization::getCampaign();
        $canEdit = auth()->check() && auth()->user()->can('update', $this);

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
        return !empty($this->type) || !empty($this->location);
    }
}
