<?php

return [
    'actions'   => [
        'add'                       => 'Add abilities',
        'sync'          => 'Add from races',
        'reset'                     => 'Recharge',
    ],
    'create'    => [
        'success'           => 'Ability :ability added to :entity.',
        'success_multiple'  => 'Abilities :abilities added to :entity.',
        'title'             => 'Add abilities to :name',
    ],
    'fields'    => [
        'note'      => 'Note',
        'position'  => 'Position',
    ],
    'helpers'   => [
        'note'  => 'You can reference entities using advanced mentions (ex :code) and attributes of the entity (ex :attr) in this field.',
        'recharge'  => 'Reset all charges for abilities that have been used.',
        'sync'  => 'Import abilities that are defined on the character\'s races.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'The character has no race.',
            'not_character' => 'The entity isn\'t a character.',
        ],
        'success'   => '{1} :count race ability imported.|[2,*] :count race abilities imported.',
    ],
    'reorder'   => [
        'parentless'    => 'No Parent',
        'success'       => 'Abilities successfully reordered',
    ],
    'recharge' => [
        'success' => 'All charges have been reset.',
    ],
    'show'      => [
        'helper'    => 'Attach abilities to this entity. You can always edit the visibility or remove an ability. Abilities belonging to the same parent ability will display as filter boxes.',
        'reorder'   => 'Reorder',
        'title'     => ':name Abilities',
    ],
    'update'    => [
        'success'   => 'Entity ability :ability updated.',
        'title'     => 'Entity Ability for :name',
    ],
];
