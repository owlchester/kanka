<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;

class Note extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'type',
        'is_private',
    ];

    /**
     * Field used for tooltip (default is history)
     * @var string
     */
    protected $tooltipField = 'description';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'type', 'description'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'note';

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
}
