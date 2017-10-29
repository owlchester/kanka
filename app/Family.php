<?php

namespace App;

use App\Scopes\CampaignScope;

class Family extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'history', 'banner'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

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
}
