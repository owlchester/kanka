<?php

return [
    'index' => [
        'title' => 'Locations',
        'description' => 'Manage the location of :name.',
        'add' => 'New Location',
        'header' => 'Locations in :name'
    ],
    'create' => [
        'title' => 'Create a new location',
        'description' => '',
        'success' => 'Location \':name\' created.',
    ],
    'show' => [
        'title' => 'Location :name',
        'description' => 'A detailed view of a location',
        'tabs' => [
            'information' => 'Information',
            'characters' => 'Characters',
            'locations' => 'Locations',
            'relations' => 'Relations',
            'attributes' => 'Attributes',
        ],
    ],
    'edit' => [
        'title' => 'Edit Location :name',
        'description' => '',
        'success' => 'Location \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Location \':name\' removed.',
    ],
    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'characters' => 'Characters',
        'description' => 'Description',
        'history' => 'History',
        'image' => 'Image',
        'is_private' => 'Private',
        'relation' => 'Relation',
    ],
    'placeholders' => [
        'name' => 'Name of the location',
        'type' => 'City, Kingdom, Ruin',
        'location' => 'Choose a parent location',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
    ],
    'relations' => [
        'create' => [
            'title' => 'New Location Relation for :name',
            'description' => 'Create a new relation between two locations',
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
            'second' => 'Location',
            'relation' => 'Relation',
            'two_way' => 'Create mirror relation',
        ],
        'placeholders' => [
            'second' => 'Choose a location',
            'relation' => 'Ally, Enemy, Vassal'
        ],
        'hints' => [
            'two_way' => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
        ],
        'destroy' => [
            'success' => 'Relation removed.',
        ],
    ],
    'attributes' => [
        'create' => [
            'title' => 'New Attribute for :name',
            'description' => 'Set an attribute to a location',
            'success' => 'Attribute added to :name.',
        ],
        'actions' => [
            'add' => 'Add an attribute',
        ],
        'edit' => [
            'title' => 'Update attribute for :name',
            'description' => '',
            'success' => 'Location attribute for :name updated.',
        ],
        'fields' => [
            'attribute' => 'Attribute',
            'value' =>  'Value',
            'is_private' => 'Private',
        ],
        'hints' => [
            'is_private' => 'Hide from "Viewers"',
        ],
        'placeholders' => [
            'attribute' => 'Population, Number of floods, Garrison size',
            'value' => 'Value of the attribute'
        ],
        'destroy' => [
            'success' => 'Location attribute for :name removed.',
        ]
    ],
];
