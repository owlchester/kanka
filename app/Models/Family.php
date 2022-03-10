<?php

namespace App\Models;

use App\Models\Concerns\Nested;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Family
 * @package App\Models
 * @property int $family_id
 * @property Character[] $members
 * @property Family $family
 * @property Family[] $families
 * @property Family[] $descendants
 */
class Family extends MiscModel
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
        'family_id',
        'is_private',
        'type',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'location_id',
        'family_id',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'family.name',
        'location.name',
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
     * @var array
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
     * @param $value
     */
    public function setFamilyIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
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

        return Character
            ::select('characters.*')
            ->distinct('characters.id')
            ->leftJoin('character_family as cf', function ($join) {
                $join->on('cf.character_id', '=', 'characters.id');
            })
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
        return false;
    }
}
