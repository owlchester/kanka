<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;

class Journal extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'campaign_id', 'slug', 'type', 'image', 'history', 'date', 'is_private'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'history', 'type'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'journal';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type', 'date'];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
}
