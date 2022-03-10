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
        'type' => 'characters.fields.type',
        //'family.name' => 'characters.fields.family',
        'location.name' => 'crud.fields.location',
        'age' => 'characters.fields.age',
        'is_dead' => 'characters.fields.is_dead',
        //'race.name' => 'characters.fields.race',
    ];

    public $orderCasting = [
        'age' => 'unsigned'
    ];
}
