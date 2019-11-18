<?php

namespace App\Datagrids\Sorters;

/**
 * Class LocationLocationSorter
 * @package App\Datagrids\Sorters
 */
class LocationLocationSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'locations.fields.name',
        'type' => 'locations.fields.type',
        'location.name' => 'crud.fields.location',
    ];
}
