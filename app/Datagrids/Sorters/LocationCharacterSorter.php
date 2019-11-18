<?php

namespace App\Datagrids\Sorters;

/**
 * Class LocationCharacterSorter
 * @package App\Datagrids\Sorters
 */
class LocationCharacterSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'characters.fields.name',
        'family.name' => 'characters.fields.family',
        'location.name' => 'crud.fields.location',
        'age' => 'characters.fields.age',
        'race.name' => 'characters.fields.race',
    ];

    public $orderCasting = [
        'age' => 'unsigned'
    ];
}
