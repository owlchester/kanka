<?php

namespace App\Models;

use App\Enums\FilterOption;
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
 * Class Family
 * @package App\Models
 * @property int|null $family_id
 * @property int|null $location_id
 * @property Collection|Character[] $members
 * @property Family $family
 * @property FamilyTree|null $familyTree
 * @property Collection|Family[] $families
 * @property Collection|Family[] $descendants
 */
class Family extends MiscModel
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
        'location_id',
        'family_id',
        'is_private',
        'type',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'location.name',
    ];

    protected array $sortable = [
        'name',
        'type',
        'location.name',
        'parent.name',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'pivotMembers',
    ];

    protected array $exportFields = [
        'base',
        'family_id',
        'location_id',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        'family_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'family';

    /**
     * Parent ID used for the Node Trait
     * @return string
     */
    public function getParentKeyName()
    {
        return 'family_id';
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
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'families' => function ($sub) {
                $sub->select('id', 'family_id', 'name');
            },
            'members',
            'children' => function ($sub) {
                $sub->select('id', 'family_id');
            },
        ]);
    }

    /**
     * Filter for family with specific member
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

    public function pivotMembers()
    {
        return $this->hasMany(CharacterFamily::class);
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
    public function detach(): void
    {
        foreach ($this->members as $child) {
            $child->family_id = null;
            $child->save();
        }

        foreach ($this->families as $family) {
            $family->family_id = null;
            $family->save();
        }

        parent::detach();
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.family');
    }

    /**
     * Determine if the model has profile data to be displayed
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
            'parent'
        ];
    }
}
