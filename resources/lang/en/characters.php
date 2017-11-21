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
            'relations' => 'Relations',
            'organisations' => 'Organisations'
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
        'is_private' => 'Private',
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
        'is_private' => 'Hide from "Viewers"',
        'is_personality_visible' => 'You can hide the whole personality section from your Viewers.',
    ],
    'sections' => [
        'general' => 'General information',
        'appearance' => 'Appearance',
        'personality' => 'Personality',
        'history' => 'History',
    ],
    'relations' => [
        'create' => [
            'title' => 'New Character Relation for :name',
            'description' => 'Create a new relation between two characters',
            'success' => 'Relation created.',
        ],
        'edit' => [
            'title' => 'Update Relation for :name',
            'description' => '',
            'success' => 'Relation updated.',
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
        'fields' => [
            'second' => 'Character',
            'relation' => 'Relation',
            'two_way' => 'Create mirror relation',
        ],
        'placeholders' => [
            'second' => 'Choose a character',
            'relation' => 'Friends, Rivals, Lovers, Childhood friends',
        ],
        'hints' => [
            'two_way' => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
        ],
        'destroy' => [
            'success' => 'Relation removed.',
        ],
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
    ]
];
