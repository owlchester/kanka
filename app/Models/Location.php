<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Kalnoy\Nestedset\NodeTrait;

class Location extends MiscModel
{
    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'entry', 'entry', 'type'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'parent_location_id',
        'is_private',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'image',
        'map',
        'entry',
        'parent_location_id',
        'campaign_id',
        'is_private',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'location';

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use NodeTrait;
    use ExportableTrait;

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'parent_location_id';
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'parentLocation', 'parentLocation.entity']);
    }

    /**
     *
     */
    public function parentLocation()
    {
        return $this->belongsTo('App\Models\Location', 'parent_location_id', 'id');
    }

    /**
     *
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationAttributes()
    {
        return $this->hasMany('App\Models\LocationAttribute', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany('App\Models\Location', 'parent_location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'location_id', 'id');
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allCharacters()
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        return Character::whereIn('location_id', $locationIds)->with('location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mapPoints()
    {
        return $this->hasMany('App\Models\MapPoint', 'location_id', 'id');
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setParentLocationIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->characters as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->locations as $child) {
            $child->parent_location_id = null;
            $child->save();
        }

        foreach ($this->organisations as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->families as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->items as $child) {
            $child->location_id = null;
            $child->save();
        }

        // Remove all the map points as they wouldn't make any sense in the new campaign
        foreach ($this->mapPoints as $child) {
            $child->delete();
        }

        return parent::detach();
    }
}
