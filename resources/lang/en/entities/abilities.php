<?php

return [
    'actions'   => [
        'add'   => 'Add abilities',
        'import_from_race' => 'Add race abilities',
        'reset' => 'Reset ability usages',
    ],
    'create'    => [
        'success'           => 'Ability :ability added to :entity.',
        'success_multiple'  => 'Abilities :abilities added to :entity.',
        'title'             => 'Add abilities to :name',
    ],
    'fields'    => [
        'position' => 'Position',
        'note' => 'Note',
    ],
    'show'      => [
        'helper'    => 'Attach abilities to this entity. You can always edit the visibility or remove an ability. Abilities belonging to the same parent ability will display as filter boxes.',
        'title'     => 'Entity Abilities for :name',
    ],
    'update'    => [
        'title'     => 'Entity Ability for :name',
    ],
    'import' => [
        'success' => '{1} :count ability imported.|[2,*] :count abilities imported.',
        'errors' => [
            'not_character' => 'The entity isn\'t a character.',
            'no_race' => 'The character has no race.',
        ]
    ]
];
