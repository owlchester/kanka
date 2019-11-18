<?php

namespace App\Datagrids\Sorters;

/**
 * Class FamilyCharacterSorter
 * @package App\Datagrids\Sorters
 */
class FamilyCharacterSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'characters.fields.name',
        'location.name' => 'crud.fields.location',
        'age' => 'characters.fields.age',
        'race.name' => 'characters.fields.race',
        'sex' => 'characters.fields.sex',
        'is_dead' => 'characters.fields.is_dead',
    ];

    public $orderCasting = [
        'age' => 'unsigned'
    ];
}
