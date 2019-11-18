<?php

namespace App\Datagrids\Sorters;

/**
 * Class LocationFamilySorter
 * @package App\Datagrids\Sorters
 */
class LocationFamilySorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'families.fields.name',
        'location.name' => 'crud.fields.location',
        'family.name' => 'crud.fields.family',
        'type' => 'families.fields.type',
    ];

    public $orderCasting = [
        'age' => 'unsigned'
    ];
}
