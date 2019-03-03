<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Kalnoy\Nestedset\NodeTrait;

class Family extends MiscModel
{
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
        //'type',
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
        'name',
        'location_id',
        'family_id',
        'tag_id',
        'is_private',
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
     * Traits
     */
    use CampaignTrait, VisibleTrait, ExportableTrait, NodeTrait;

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
        return $query->with(['entity', 'location', 'location.entity']);
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
        return $this->hasMany('App\Models\Character', 'family_id', 'id');
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

        return Character::whereIn('family_id', $familyId)->with(['family', 'location']);
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
    public function menuItems($items = [])
    {
        $campaign = $this->campaign;

        $items['families'] = [
            'name' => 'families.show.tabs.families',
            'route' => 'families.families',
            'count' => $this->descendants()->acl()->count()
        ];

        $count = $this->members()->acl()->count();
        if ($campaign->enabled('characters') && $count > 0) {
            $items['members'] = [
                'name' => 'families.show.tabs.members',
                'route' => 'families.members',
                'count' => $count
            ];
        }
        $count = $this->allMembers()->acl()->count();
        if ($campaign->enabled('characters') && $count > 0) {
            $items['all_members'] = [
                'name' => 'families.show.tabs.all_members',
                'route' => 'families.all-members',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }
}
