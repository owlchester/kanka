<?php

return [
    'index' => [
        'title' => 'Characters',
        'description' => 'Manage the characters in :name.',
        'add' => 'New Character',
        'header' => 'Characters in :name',
    ],
    'create' => [
        'title' => 'Create a new character',
        'description' => '',
        'success' => 'Character created.',
    ],
    'show' => [
        'title' => 'Character :character',
        'description' => 'A detailed view of a character',
        'tabs' => [
            'history' => 'History',
            'personality' => 'Personality',
            'free' => 'Free Text',
            'relations' => 'Relations',
            'organisations' => 'Organisations'
        ]
    ],
    'edit' => [
        'title' => 'Edit Character :character',
        'description' => '',
        'success' => 'Character updated.',
    ],
    'destroy' => [
        'success' => 'Character removed.',
    ],
    'fields' =>  [
        'name' => 'Name',
        'title' => 'Title',
        'age' => 'Age',
        'sex' => 'Sex',
        'height' => 'Height',
        'weight' => 'Weight',
        'eye' => 'Eye colour',
        'hair' => 'Hair',
        'skin' => 'Skin',
        'languages' => 'Languages',
        'race' => 'Race',
        'location' => 'Location',
        'relation' => 'Relation',
        'family' => 'Family',
        'physical' => 'Physical',
        'goals' => 'Goals',
        'traits' => 'Traits',
        'fears' => 'Fears',
        'free' => 'Free text',
        'mannerisms' => 'Mannerisms',
        'history' => 'History',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Name',
        'title' => 'Title',
        'age' => 'Age',
        'sex' => 'Sex',
        'height' => 'Height',
        'weight' => 'Weight',
        'eye' => 'Eye colour',
        'hair' => 'Hair',
        'skin' => 'Skin',
        'languages' => 'Languages',
        'race' => 'Race',
        'location' => 'Please select a location',
        'family' => 'Please select a character',
        'physical' => 'Physical',
        'goals' => 'Goals',
        'traits' => 'Traits',
        'fears' => 'Fears',
        'mannerisms' => 'Mannerisms',
        'history' => 'History',
        'image' => 'Image',
        'free' => 'Free text',
    ],
    'relations' => [
        'create' => [
            'title' => 'Character Relationships',
            'description' => 'Define the relationship between two characters',
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
        'fields' => [
            'second' => 'Character',
            'relation' => 'Relation',
        ],
        'placeholders' => [
            'second' => 'Choose a character',
            'relation' => 'Nature of the relation',
        ],
    ]
];
