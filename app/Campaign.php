<?php

namespace App;

class Campaign extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'locale'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->using('App\CampaignUser');
    }
}
