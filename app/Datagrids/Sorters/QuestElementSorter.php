<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestLocationSorter
 * @package App\Datagrids\Sorters
 */
class QuestElementSorter extends DatagridSorter
{
    public $default = 'role';

    /**
     * @var array
     */
    public $options = [
        'entity.name' => 'crud.fields.name',
        'role' => 'quests.fields.role',
    ];
}
