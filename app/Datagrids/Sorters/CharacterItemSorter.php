<?php

namespace App\Datagrids\Sorters;

/**
 * Class CharacterItemSorter
 * @package App\Datagrids\Sorters
 */
class CharacterItemSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'items.fields.name',
        'type' => 'items.fields.type',
        'location.name' => 'items.fields.location'
    ];
}
