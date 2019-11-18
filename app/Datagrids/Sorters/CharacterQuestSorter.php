<?php

namespace App\Datagrids\Sorters;

/**
 * Class CharacterQuestSorter
 * @package App\Datagrids\Sorters
 */
class CharacterQuestSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'quests.fields.name',
        'quest_characters.role' => 'quests.fields.role',
        'is_completed' => 'quests.fields.is_completed',
    ];
}
