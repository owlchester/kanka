<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Family
 *
 * @property ?int $family_id
 * @property bool|int $is_extinct
 * @property Collection|Character[] $members
 * @property ?FamilyTree $familyTree
 * @property Collection|Family[] $descendants
 * @property Collection|CharacterFamily[] $pitvotMembers
 */
class Family extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'location_id',
        'family_id',
        'is_private',
        'is_extinct',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'location.name',
        'is_extinct',
    ];

    protected array $sortable = [
        'name',
        'location.name',
        'parent.name',
        'is_extinct',
        'type',
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
        'is_extinct',
    ];

    protected array $exploreGridFields = ['is_extinct'];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        'family_id',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * Parent ID used for the Node Trait
     *
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
        return parent::scopePreparedWith($query->with([
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]))->withCount('members');
    }

    /**
     * Filter for family with specific member
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
                ->leftJoin('character_family as memb', function ($join) {
                    $join->on('memb.family_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.character_id', null);

            if (auth()->guest() || ! auth()->user()->isAdmin()) {
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
        return ['family_id', 'location_id', 'is_extinct'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\FamilyTree, $this>
     */
    public function familyTree(): HasOne
    {
        return $this->hasOne(FamilyTree::class);
    }

    public function members(): BelongsToMany
    {
        $query = $this->belongsToMany('App\Models\Character', 'character_family');
        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            $query->wherePivot('is_private', false);
        }

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CharacterFamily, $this>
     */
    public function pivotMembers(): HasMany
    {
        return $this->hasMany(CharacterFamily::class)
            ->with(['character', 'character.entity']);
    }

    /**
     * All members of a family and descendants
     */
    public function allMembers()
    {
        $familyId = [$this->id];
        foreach ($this->descendants as $descendant) {
            $familyId[] = $descendant->id;
        }

        $query = Character::select('characters.*')
            ->distinct('characters.id')
            ->leftJoin('character_family as cf', function ($join) {
                $join->on('cf.character_id', '=', 'characters.id');
            })
            ->has('entity')
            ->whereIn('cf.family_id', $familyId);

        if (auth()->guest() || ! auth()->user()->isAdmin()) {
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
        }

        return CharacterFamily::groupBy('character_id')
            ->distinct('character_id')
            ->whereIn('character_family.family_id', $familyIDs)
            ->with('character');
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
     * Determine if the model is extinct.
     */
    public function isExtinct(): bool
    {
        return (bool) $this->is_extinct;
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        // Test text fields first
        if (! empty($this->type)) {
            return true;
        }
        if (! empty($this->parent)) {
            return true;
        }
        if ($this->entity->elapsedEvents->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
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
            'family_id',
            'member_id',
            'is_extinct',
            'parent',
        ];
    }
}
