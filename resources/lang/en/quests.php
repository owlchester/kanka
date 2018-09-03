<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Set a character to a Quest',
            'success'       => 'Character added to :name.',
            'title'         => 'New Character for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest character for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s character',
            'success'       => 'Quest character for :name updated.',
            'title'         => 'Update character for :name',
        ],
        'fields'    => [
            'character'     => 'Character',
            'description'   => 'Description',
        ],
    ],
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
    'fields'        => [
        'character'     => 'Instigator',
        'characters'    => 'Characters',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completed',
        'locations'     => 'Locations',
        'name'          => 'Name',
        'quest'         => 'Parent Quest',
        'type'          => 'Type',
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
    'locations'     => [
        'create'    => [
            'description'   => 'Set an location to a Quest',
            'success'       => 'Location added to :name.',
            'title'         => 'New Location for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest location for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s location',
            'success'       => 'Quest location for :name updated.',
            'title'         => 'Update location for :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'location'      => 'Location',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the quest',
        'quest' => 'Parent Quest',
        'type'  => 'Character Arc, Sidequest, Main',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Add a character',
            'add_location'  => 'Add a location',
        ],
        'description'   => 'A detailed view of a quest',
        'tabs'          => [
            'characters'    => 'Characters',
            'information'   => 'Information',
            'locations'     => 'Locations',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quest :name',
    ],
];
