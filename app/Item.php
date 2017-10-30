<?php

namespace App;

class Item extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'campaign_id', 'slug', 'type', 'image', 'description', 'history', 'character_id', 'location_id'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Character', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }
}
