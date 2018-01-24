<?php

return [
    'add' => 'Add',
    'create' => 'Create',
    'update' => 'Update',
    'save' => 'Save',
    'edit' => 'Edit',
    'remove' => 'Remove',
    'view' => 'View',
    'filter' => 'Filter',
    'filters' => 'Filters',
    'select' => 'Select',
    'cancel' => 'Cancel',
    'search' => 'Search',
    'or_cancel' => 'or <a href=":url">cancel</a>',
    'save_and_new' => 'Save and New',
    'is_private' => 'This entity is private and not visible by the viewer users.',

    'tabs' => [
        'relations' => 'Relations',
    ],

    'actions' => [
        'move' => 'Move',
    ],

    'relations' => [
        'fields' => [
            'relation' => 'Relation',
            'name' => 'Name',
            'location' => 'Location'
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
    ],

    'panels' => [
        'general_information' => 'General Information',
        'history' => 'History',
        'description' => 'Description',
        'appearance' => 'Appearance',
        'move' => 'Move',
    ],

    'delete_modal' => [
        'title' => 'Delete confirmation',
        'description' => 'Are you sure you want to remove :tag?',
        'close' => 'Close',
        'delete' => 'Delete'
    ],
    'click_modal' => [
        'title' => 'Confirm your action',
        'close' => 'Close',
        'confirm' => 'Confirm',
    ],
    'fields' => [
        'is_private' => 'Private',
        'location' => 'Location',
        'character' => 'Character',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
    ],
    'placeholders' => [
        'character' => 'Choose a character',
        'location' => 'Choose a location',
    ],
    'linking_help' => 'How can I link to other entries?',

    'move' => [
        'title' => 'Move :name to another place',
        'description' => '',
        'success' => 'Entity :name moved.',
        'fields' => [
            'target' => 'New type',
        ],
        'hints' => [
            'target' => 'Please be aware that some data might be lost when moving an element from one type to another.',
        ]
    ],

    'new_entity' => [
        'error' => 'Please review your values.',
        'title' => 'New entity',
        'fields' => [
            'name' => 'Name',
        ]
    ]
];
