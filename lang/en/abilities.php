<?php

return [
    'abilities'     => [
        'title' => 'Child abilities of :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Add ability to entity',
        ],
        'create'        => [
            'success'   => 'Added the ability :name to the entity.',
            'title'     => 'Add an entity to :name',
        ],
        'description'   => 'Entities having the ability',
        'title'         => 'Ability :name Entities',
    ],
    'create'        => [
        'title' => 'New Ability',
    ],
    'entities'      => [
        'title' => 'Entities with the :name ability',
    ],
    'fields'        => [
        'abilities' => 'Sub abilities',
        'ability'   => 'Parent ability',
        'charges'   => 'Charges',
    ],
    'helpers'       => [
        'descendants'       => 'This list contains all abilities which are descendants of this ability, and not only those directly under it.',
        'nested_without'    => 'Displaying all abilities that don\'t have a parent ability. Click on a row to see the children abilities.',
    ],
    'placeholders'  => [
        'charges'   => 'Amount of charges. Reference attributes with {Level}*{CHA}',
        'name'      => 'Fireball, Alert, Cunning Strike',
        'type'      => 'Spell, Feat, Attack',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Sub abilities',
            'entities'  => 'Entities',
            'reorder'   => 'Reorder Abilities',
        ],
    ],
    'reorder'       => [
        'title' => 'Reorder the abilities',
        'parentless' => 'No Parent',
        'success' => 'Abilities succesfully reordered',
    ],
];
