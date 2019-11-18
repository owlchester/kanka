<?php

namespace App\Datagrids\Sorters;

/**
 * Class TagTagSorter
 * @package App\Datagrids\Sorters
 */
class TagTagSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'crud.fields.name',
        'type' => 'crud.fields.type',
        'tag.name' => 'crud.fields.tag'
    ];
}
