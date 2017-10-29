<?php

namespace App;

use App\Scopes\CampaignScope;

class Character extends MiscModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'location_id',
        'title',
        'history',
        'age',
        'height',
        'weight',
        'sex',
        'race',
        'eye_colour',
        'hair',
        'skin',
        'image',
        'traits',
        'goals',
        'fears',
        'mannerisms',
        'languages',
        'free',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'title', 'race', 'sex'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany('App\CharacterRelation', 'first_id', 'id');
    }
}
