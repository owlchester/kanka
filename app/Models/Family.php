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
 * Class Family
 * @package App\Models
 * @property int|null $family_id
 * @property int|null $location_id
 * @property Collection|Character[] $members
 * @property Family $family
 * @property FamilyTree $familyTree
 * @property Collection|Family[] $families
 * @property Collection|Family[] $descendants
 */
class Family extends MiscModel
{
    use Acl
    ;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'location_id',
        'family_id',
        'is_private',
        'type',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'family.name',
        'location.name',
    ];

    protected $sortable = [
        'name',
        'type',
        'location.name',
        'family.name',
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
        'family_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'family';

    /**
     * Parent ID used for the Node Trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'family_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setFamilyIdAttribute($value)
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
            'entity',
            'entity.image',
            'location',
            'location.entity',
            'families',
            'members',
        ]);
    }

    /**
     * Filter for family with specific member
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
                ->leftJoin('character_family as memb', function ($join) {
                    $join->on('memb.family_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.character_id', null);
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from character_family as memb where memb.family_id = ' .
                    $this->getTable() . '.id and memb.character_id in (' . (int) $value . ')) = 0');
        }

        $ids = [$value];
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('character_family as memb', function ($join) {
                $join->on('memb.family_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.character_id', $ids)->distinct();
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['family_id', 'location_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function familyTree()
    {
        return $this->hasOne(FamilyTree::class);
    }

    /**
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\Character', 'character_family');
    }

    /**
     * Parent
     */
    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
    }

    /**
     * Children
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family', 'family_id', 'id');
    }

    /**
     * All members of a family and descendants
     * @return mixed
     */
    public function allMembers()
    {
        $familyId = [$this->id];
        foreach ($this->descendants as $descendant) {
            $familyId[] = $descendant->id;
        };

        return Character::select('characters.*')
            ->distinct('characters.id')
            ->leftJoin('character_family as cf', function ($join) {
                $join->on('cf.character_id', '=', 'characters.id');
            })
            ->has('entity')
            ->whereIn('cf.family_id', $familyId);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->members as $child) {
            $child->family_id = null;
            $child->save();
        }

        foreach ($this->families as $family) {
            $family->family_id = null;
            $family->save();
        }

        return parent::detach();
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $items['second']['families'] = [
            'name' => 'families.show.tabs.families',
            'route' => 'families.families',
            'count' => $this->descendants()->count()
        ];

        if (config('services.stripe.enabled')) {
            $items['second']['tree'] = [
                'name' => 'families.show.tabs.tree',
                'route' => 'families.family-tree',
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
        return (int) config('entities.ids.family');
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        // Test text fields first
        if (!empty($this->type)) {
            return true;
        }
        if (!empty($this->family)) {
            return true;
        }
        return (bool) (!$this->entity->elapsedEvents->isEmpty());
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'location_id',
            'family_id',
            'member_id',
        ];
    }
}
