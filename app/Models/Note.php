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
        'section_id',
        'is_pinned',
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
    protected $filterableColumns = [
        'name',
        'type',
        'is_pinned',
        'section_id',
    ];

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

    /**
     * Prepare the notes for the dashboard
     * @param $query
     * @return mixed
     */
    public function scopeDashboard($query)
    {
        return $query->where(['is_pinned' => 1])->orderBy('name', 'ASC')->take(3);
    }
}
