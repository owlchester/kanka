<?php

return [
    'create'        => [
        'description'   => 'Create a new quest',
        'success'       => 'Quest \':name\' created.',
        'title'         => 'New Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' removed.',
    ],
    'edit'          => [
        'description'   => 'Edit a quest',
        'success'       => 'Quest \':name\' updated.',
        'title'         => 'Edit Quest :name',
    ],
    'elements'      => [
        'create'    => [
            'success'   => 'Element :entity added to the quest.',
            'title'     => 'New element for :name',
        ],
        'destroy'   => [
            'success'   => 'Element :entity removed.',
        ],
        'edit'      => [
            'success'   => 'Element :entity updated.',
            'title'     => 'Update element for :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'quest'         => 'Quest',
            'name'          => 'Name',
            'entity_or_name' => 'Either select either an entity of the campaign, or give a name for this element.',
        ],
        'title'     => 'Quest :name Elements',
    ],
    'fields'        => [
        'character'     => 'Instigator',
        'copy_elements' => 'Copy elements attached to the quest',
        'date'          => 'Date',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completed',
        'name'          => 'Name',
        'quest'         => 'Parent Quest',
        'quests'        => 'Sub Quests',
        'role'          => 'Role',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Displaying the quests of :parent.',
        'nested_without'=> 'Displaying all quests that don\'t have a parent quest. Click on a row to see the children quests.',
    ],
    'hints'         => [
        'quests'    => 'A web of interlocking quests can be built using the Parent Quest field.',
    ],
    'index'         => [
        'add'           => 'New Quest',
        'description'   => 'Manage the quests of :name.',
        'header'        => 'Quests of :name',
        'title'         => 'Quests',
    ],
    'placeholders'  => [
        'date'  => 'Real world date for the quest',
        'name'  => 'Name of the quest',
        'quest' => 'Parent Quest',
        'role'  => 'This entity\'s role in the quest',
        'type'  => 'Character Arc, Sidequest, Main',
    ],
    'show'          => [
        'actions'       => [
            'add_element'   => 'Add an element',
        ],
        'description'   => 'A detailed view of a quest',
        'tabs'          => [
            'elements'      => 'Elements',
            'information'   => 'Information',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quest :name',
    ],
];
