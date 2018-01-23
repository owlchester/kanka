<?php

return [
    'index' => [
        'title' => 'Quests',
        'description' => 'Manage the quests of :name.',
        'add' => 'New Quest',
        'header' => 'Quests of :name',
    ],
    'create' => [
        'title' => 'Create a new quest',
        'description' => '',
        'success' => 'Quest \':name\' created.',
    ],
    'show' => [
        'title' => 'Quest :name',
        'description' => 'A detailed view of an quest',
        'tabs' => [
            'information' => 'Information',
            'characters' => 'Characters',
            'locations' => 'Locations',
        ],
        'actions' => [
            'add_location' => 'Add a location',
            'add_character' => 'Add a character',
        ],
    ],
    'edit' => [
        'title' => 'Edit Quest :name',
        'description' => '',
        'success' => 'Quest \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Quest \':name\' removed.',
    ],

    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'description' => 'Description',
        'image' => 'Image',
        'characters' => 'Characters',
        'locations' => 'Locations',
    ],
    'placeholders' => [
        'name' => 'Name of the quest',
        'type' => 'Character Arc, Sidequest, Main',
    ],
    'characters' => [
        'create' => [
            'title' => 'New Character for :name',
            'description' => 'Set an character to a Quest',
            'success' => 'Character added to :name.',
        ],
        'edit' => [
            'title' => 'Update character for :name',
            'description' => '',
            'success' => 'Quest character for :name updated.',
        ],
        'fields' => [
            'character' => 'Character',
            'description' => 'Description',
        ],
        'destroy' => [
            'success' => 'Quest character for :name removed.',
        ]
    ],
    'locations' => [
        'create' => [
            'title' => 'New Location for :name',
            'description' => 'Set an location to a Quest',
            'success' => 'Location added to :name.',
        ],
        'edit' => [
            'title' => 'Update location for :name',
            'description' => '',
            'success' => 'Quest location for :name updated.',
        ],
        'fields' => [
            'location' => 'Location',
            'description' => 'Description',
        ],
        'destroy' => [
            'success' => 'Quest location for :name removed.',
        ]
    ],
];
