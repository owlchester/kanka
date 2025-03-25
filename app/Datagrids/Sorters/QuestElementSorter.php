<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestLocationSorter
 */
class QuestElementSorter extends DatagridSorter
{
    public $default = 'role';

    public array $options = [
        'entity.name' => 'crud.fields.name',
        'role' => 'quests.fields.role',
    ];
}
