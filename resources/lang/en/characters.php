<?php

return [
    'index' => [
        'title' => 'Characters',
        'description' => 'Manage the characters of :name.',
        'add' => 'New Character',
        'header' => 'Characters in :name',
        'actions' => [
            'random' => 'New Random Character',
        ]
    ],
    'create' => [
        'title' => 'Create a new character',
        'description' => '',
        'success' => 'Character \':name\' created.',
    ],
    'show' => [
        'title' => 'Character :name',
        'description' => 'A detailed view of a character',
        'tabs' => [
            'history' => 'History',
            'personality' => 'Personality',
            'free' => 'Free Text',
            'organisations' => 'Organisations',
        ]
    ],
    'edit' => [
        'title' => 'Edit Character :name',
        'description' => '',
        'success' => 'Character \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Character \':name\' removed.',
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
        'is_personality_visible' => 'Is personality visible',
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
    'hints' => [
        'is_personality_visible' => 'You can hide the whole personality section from your Viewers.',
    ],
    'sections' => [
        'general' => 'General information',
        'appearance' => 'Appearance',
        'personality' => 'Personality',
        'history' => 'History',
    ],
    'organisations' => [
        'create' => [
            'title' => 'New Organisation for :name',
            'description' => 'Associate an organisation to a character',
            'success' => 'Character added to organisation.',
        ],
        'actions' => [
            'add' => 'Add organisation',
        ],
        'edit' => [
            'title' => 'Update Organisation for :name',
            'description' => '',
            'success' => 'Character organisation updated.',
        ],
        'fields' => [
            'organisation' => 'Organisation',
            'role' =>  'Role',
        ],
        'placeholders' => [
            'organisation' => 'Choose an organisation...',
        ],
        'destroy' => [
            'success' => 'Character organisation removed.',
        ]
    ],
];
