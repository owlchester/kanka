<?php

namespace App\Datagrids\Sorters;

/**
 * Class AbilityAbilitySorter
 * @package App\Datagrids\Sorters
 */
class MapMapSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'maps.fields.name',
        'map.name' => 'crud.fields.map',
    ];
}
