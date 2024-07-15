<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
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
 * Class Family
 * @package App\Models
 * @property int|null $family_id
 * @property int|null $location_id
 * @property Collection|Character[] $members
 * @property Family $family
 * @property FamilyTree|null $familyTree
 * @property Collection|Family[] $families
 * @property Collection|Family[] $descendants
 * @property Collection|CharacterFamily[] $pitvotMembers
 */
class Family extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
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
            $query
                ->select($this->getTable() . '.*')
                ->leftJoin('character_family as memb', function ($join) {
                    $join->on('memb.family_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.character_id', null);

            if (auth()->guest() || !auth()->user()->isAdmin()) {
                $query->where('memb.is_private', 0);
            }

            return $query;
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from character_family as memb where memb.family_id = ' .
                    $this->getTable() . '.id and memb.family_id = ' . ((int) $value) . ' ' . $this->subPrivacy('and memb.is_private') . ') = 0');
        }

        $ids = [$value];
        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('character_family as memb', function ($join) {
                $join->on('memb.family_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.character_id', $ids);


        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $query->where('memb.is_private', 0);
        }

        return $query->distinct();
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['family_id', 'location_id'];
    }

    /**
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function familyTree()
    {
        return $this->hasOne(FamilyTree::class);
    }

    /**
     */
    public function members(): BelongsToMany
    {
        $query = $this->belongsToMany('App\Models\Character', 'character_family');
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $query->wherePivot('is_private', false);
        }

        return $query;
    }

    public function pivotMembers(): HasMany
    {
        return $this->hasMany(CharacterFamily::class)
            ->with(['character', 'character.entity']);

    }

    /**
     * Parent
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
    }

    /**
     * Children
     */
    public function families(): HasMany
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

        $query = Character::select('characters.*')
            ->distinct('characters.id')
            ->leftJoin('character_family as cf', function ($join) {
                $join->on('cf.character_id', '=', 'characters.id');
            })
            ->has('entity')
            ->whereIn('cf.family_id', $familyId);

        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $query->where('cf.is_private', false);
        }

        return $query;
    }

    /**
     * Get all characters in the family and descendants
     */
    public function allCharacterFamilies()
    {
        $familyIDs = [$this->id];
        foreach ($this->descendants as $descendant) {
            $familyIDs[] = $descendant->id;
        };
        return CharacterFamily::groupBy('character_id')->distinct('character_id')->whereIn('character_family.family_id', $familyIDs)->with('character');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        $this->members()->detach();
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
