<?php

namespace App\Datagrids\Sorters;

/**
 * Class EntityRelationSorter
 * @package App\Datagrids\Sorters
 */
class EntityRelationSorter extends DatagridSorter
{
    public $default = 'relation';

    /**
     * @var array
     */
    public $options = [
        'relation' => 'entities/relations.fields.relation',
        'attitude' => 'entities/relations.fields.attitude',
        'target.name' => 'entities/relations.fields.target',
        'visibility' => 'crud.fields.visibility'
    ];
}
