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
        'is_private' => 'Private',
        'characters' => 'Characters',
        'locations' => 'Locations',
    ],
    'placeholders' => [
        'name' => 'Name of the quest',
        'type' => 'Character Arc, Sidequest, Main',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
    ],
    'characters' => [
        'create' => [
            'title' => 'New Character for :name',
            'description' => 'Set an character to a location',
            'success' => 'Character added to :name.',
        ],
        'actions' => [
            'add' => 'Add an character',
        ],
        'edit' => [
            'title' => 'Update character for :name',
            'description' => '',
            'success' => 'Location character for :name updated.',
        ],
        'fields' => [
            'character' => 'Character',
            'value' =>  'Value',
            'description' => 'Description',
            'is_private' => 'Private',
        ],
        'hints' => [
            'is_private' => 'Hide from "Viewers"',
        ],
        'placeholders' => [
            'character' => 'Population, Number of floods, Garrison size',
            'value' => 'Value of the character'
        ],
        'destroy' => [
            'success' => 'Location character for :name removed.',
        ]
    ],
    'locations' => [
        'create' => [
            'title' => 'New Location for :name',
            'description' => 'Set an location to a location',
            'success' => 'Location added to :name.',
        ],
        'actions' => [
            'add' => 'Add an location',
        ],
        'edit' => [
            'title' => 'Update location for :name',
            'description' => '',
            'success' => 'Location location for :name updated.',
        ],
        'fields' => [
            'location' => 'Location',
            'value' =>  'Value',
            'is_private' => 'Private',
            'description' => 'Description',
        ],
        'hints' => [
            'is_private' => 'Hide from "Viewers"',
        ],
        'placeholders' => [
            'location' => 'Population, Number of floods, Garrison size',
            'value' => 'Value of the location'
        ],
        'destroy' => [
            'success' => 'Location location for :name removed.',
        ]
    ],
];
