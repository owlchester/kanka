<?php

namespace App\Datagrids\Sorters;

/**
 * Class EntityInventorySorter
 * @package App\Datagrids\Sorters
 */
class EntityTimelineSorter extends DatagridSorter
{
    public $default = ['timeline.name'];

    /**
     * @var array
     */
    public $options = [
        'timeline.name' => 'crud.fields.timeline',
        'visibility' => 'crud.fields.visibility'
    ];
}
