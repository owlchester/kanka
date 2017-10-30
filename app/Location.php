<?php

namespace App;

use App\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Model;

class Location extends MiscModel
{
    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'type', 'image',
        'description', 'history', 'parent_location_id',
        'campaign_id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CampaignScope());
    }

    /**
     *
     */
    public function parentLocation()
    {
        return $this->belongsTo('App\Location', 'parent_location_id', 'id');
    }

    /**
     *
     */
    public function characters()
    {
        return $this->hasMany('App\Character', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationAttributes()
    {
        return $this->hasMany('App\LocationAttribute', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item', 'location_id', 'id');
    }
}
