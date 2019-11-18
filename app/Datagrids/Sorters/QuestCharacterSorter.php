<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestCharacterSorter
 * @package App\Datagrids\Sorters
 */
class QuestCharacterSorter extends DatagridSorter
{
    public $default = 'character.name';

    /**
     * @var array
     */
    public $options = [
        'character.name' => 'characters.fields.name',
        'role' => 'quests.fields.role',
        'character.type' => 'crud.fields.type',
        'character.age' => 'characters.fields.age',
    ];

    public $orderCasting = [
        'character.age' => 'unsigned'
    ];
}
