<?php

return [
    'actions' => [
        'clear' => 'Clear tree',
        'reset' => 'Reset tree',
        'save' => 'Save tree',
        'first' => 'Add a founder',
        'rename-relation' => 'Rename relation',
    ],
    'title' => ':name Family Tree',
    'modal'   => [
        'title'         => 'Replace entity',
        'first-title'   => 'Select an entity',
        'helper'        => 'Replace the entity with another from your campaign',
        'relation'      => 'Relation',
    ],
    'modals' => [
        'clear' => [
            'confirm' => 'Are you sure you want to clear the family tree?',
        ],
        'relations' => [
            'add' => [
                'title' => 'Add a relation',
                'success' => 'Relation added',
            ],
            'edit' => [
                'title' => 'Update a relation',
                'success' => 'Relation updated',
            ],
        ],
        'entity' => [
            'add' => [
                'title' => 'Add a character',
                'member' => 'Member',
                'success' => 'Character added.',
            ],
            'edit' => [
                'title' => 'Update a character',
                'success' => 'Character updated.',
            ],
            'child' => [
                'title' => 'Add a child',
                'success' => 'Child added',
            ],
            'remove' => [
                'confirm' => 'Are you sure you want to remove this character from the family tree?',
                'success' => 'Character removed.',
            ],
        ],
        'reset' => [
            'confirm' => 'Are you sure you want to reset the family tree?',
        ],
    ],
    'pitch' => 'Create a detailed family tree for your families.',
    'unknown' => 'unknown',
    'success' => [
        'saved' => 'Family tree saved.',
        'cleared' => 'Family tree cleared.',
        'reseted' => 'Family tree has been reset.',
    ],
];
