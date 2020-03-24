<?php

namespace App\Datagrids\Sorters;

/**
 * Class AbilityAbilitySorter
 * @package App\Datagrids\Sorters
 */
class AbilityAbilitySorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'abilities.fields.name',
        'ability.name' => 'crud.fields.ability',
    ];
}
