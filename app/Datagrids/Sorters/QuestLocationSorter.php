<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestLocationSorter
 * @package App\Datagrids\Sorters
 */
class QuestLocationSorter extends DatagridSorter
{
    public $default = 'location.name';

    /**
     * @var array
     */
    public $options = [
        'location.name' => 'locations.fields.name',
        'role' => 'quests.fields.role',
        'location.type' => 'locations.fields.type',
    ];
}
