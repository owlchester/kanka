<?php

namespace App\Datagrids\Sorters;

/**
 * Class TagCharacterSorter
 * @package App\Datagrids\Sorters
 */
class TagChildrenSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'crud.fields.name',
        'type' => 'crud.fields.entity'
    ];
}
