<?php

namespace App\Datagrids\Sorters;

/**
 * Class EntityInventorySorter
 * @package App\Datagrids\Sorters
 */
class EntityInventorySorter extends DatagridSorter
{
    public $default = ['position', 'item.name'];

    /**
     * @var array
     */
    public $options = [
        'position' => 'entities/inventories.fields.position',
        'item.name' => 'crud.fields.item',
        'amount' => 'entities/inventories.fields.amount',
        'visibility' => 'crud.fields.visibility'
    ];
}
