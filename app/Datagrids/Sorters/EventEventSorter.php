<?php

namespace App\Datagrids\Sorters;

/**
 * Class EventEventSorter
 * @package App\Datagrids\Sorters
 */
class EventEventSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'crud.fields.name',
        'event.date' => 'events.fields.date'
    ];
}
