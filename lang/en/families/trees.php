<?php

return [
    'actions'   => [
        'clear'             => 'Erase all',
        'first'             => 'Add a founder',
        'founder'           => 'Add a new founder',
        'rename-relation'   => 'Rename relation',
        'reset'             => 'Discard changes',
        'save'              => 'Save',
    ],
    'modal'     => [
        'first-title'   => 'Select an entity',
        'helper'        => 'Replace the entity with another from the campaign',
        'relation'      => 'Relation',
        'title'         => 'Replace entity',
    ],
    'modals'    => [
        'clear'     => [
            'confirm'   => 'Are you sure you want to reinitialise all the data from the family tree?',
        ],
        'entity'    => [
            'add'       => [
                'founder'   => 'Founder',
                'member'    => 'Member',
                'success'   => 'Entity added.',
                'title'     => 'Add an entity',
            ],
            'child'     => [
                'success'   => 'Child added.',
                'title'     => 'Add a child',
            ],
            'edit'      => [
                'helper'    => 'Check this option if the relation is unknown. A character can be added later.',
                'success'   => 'Entity updated.',
                'title'     => 'Update an entity',
            ],
            'founder'   => [
                'title' => 'Add a new founder',
            ],
            'remove'    => [
                'confirm'   => 'Are you sure you want to remove this entity from the family tree?',
                'success'   => 'Entity removed.',
            ],
        ],
        'relations' => [
            'add'       => [
                'success'   => 'Relation added.',
                'title'     => 'Add a relation',
            ],
            'edit'      => [
                'success'   => 'Relation updated.',
                'title'     => 'Update a relation',
            ],
            'unknown'   => 'Unknown',
        ],
        'reset'     => [
            'confirm'   => 'Are you sure you want to discard any changes made to the family tree?',
        ],
    ],
    'pitch'     => 'Build a detailed family tree to visualize relationships and lineage within your world\'s families.',
    'success'   => [
        'cleared'   => 'Family tree erased.',
        'reseted'   => 'Family tree has been reset.',
        'saved'     => 'Family tree saved.',
    ],
    'title'     => ':name Family Tree',
    'unknown'   => 'unestablished',
];
