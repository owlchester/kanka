<?php

namespace App\Datagrids\Sorters;

/**
 * Class RaceCharacterSorter
 * @package App\Datagrids\Sorters
 */
class RaceCharacterSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'characters.fields.name',
        'location.name' => 'crud.fields.location',
        'family.name' => 'crud.fields.family',
        'age' => 'characters.fields.age',
    ];

    public $orderCasting = [
        'age' => 'unsigned'
    ];
}
