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
        'first-title'   => 'Select an entry',
        'helper'        => 'Replace the entry with another from the campaign',
        'relation'      => 'Relation',
        'title'         => 'Replace entry',
    ],
    'modals'    => [
        'clear'     => [
            'confirm'   => 'Are you sure you want to reinitialise all the data from the family tree?',
        ],
        'entity'    => [
            'add'       => [
                'founder'   => 'Founder',
                'member'    => 'Member',
                'success'   => 'Entry added.',
                'title'     => 'Add an entry',
            ],
            'child'     => [
                'success'   => 'Child added.',
                'title'     => 'Add a child',
            ],
            'edit'      => [
                'helper'    => 'Check this option if the relation is unknown. A character can be added later.',
                'success'   => 'Entry updated.',
                'title'     => 'Update an entry',
            ],
            'founder'   => [
                'title' => 'Add a new founder',
            ],
            'remove'    => [
                'confirm'   => 'Are you sure you want to remove this entry from the family tree?',
                'success'   => 'Entry removed.',
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
