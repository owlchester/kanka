<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class Note extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'type',
        'is_private',
        'section_id',
        'is_pinned',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'type', 'entry'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'is_pinned',
        'section_id',
        'is_private',
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
    use ExportableTrait;

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
