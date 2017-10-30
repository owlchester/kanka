<?php

namespace App;

class Journal extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'campaign_id', 'slug', 'type', 'image', 'history', 'date'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type'];
}
