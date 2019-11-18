<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestItemSorter
 * @package App\Datagrids\Sorters
 */
class QuestItemSorter extends DatagridSorter
{
    public $default = 'item.name';

    /**
     * @var array
     */
    public $options = [
        'item.name' => 'items.fields.name',
        'role' => 'quests.fields.role',
        'item.type' => 'crud.fields.type',
    ];
}
