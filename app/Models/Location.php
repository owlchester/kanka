<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;use Kalnoy\Nestedset\NodeTrait;

class Location extends MiscModel
{
    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'description', 'history', 'type'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type', 'parent_location_id'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'image',
        'map',
        'description',
        'history',
        'parent_location_id',
        'campaign_id',
        'is_private',
        'type',
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
     * @return string
     */
    public function getParentIdName()
    {
        return 'parent_location_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setParentLocationIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }
}
