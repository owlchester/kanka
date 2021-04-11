<?php

return [
    'abilities'     => [
        'title' => 'Child abilities of :name',
    ],
    'create'        => [
        'success'   => 'Ability \':name\' created.',
        'title'     => 'New Ability',
    ],
    'destroy'       => [
        'success'   => 'Ability \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Ability \':name\' updated.',
        'title'     => 'Edit Ability :name',
    ],
    'entities'     => [
        'title' => 'Entities with the :name ability',
    ],
    'fields'        => [
        'abilities' => 'Abilities',
        'ability'   => 'Parent Ability',
        'charges'   => 'Charges',
        'name'      => 'Name',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all abilities which are descendants of this ability, and not only those directly under it.',
        'nested_parent' => 'Displaying the abilities of :parent.',
        'nested_without' => 'Displaying all abilities that don\'t have a parent ability. Click on a row to see the children abilities.',
    ],
    'index'         => [
        'add'           => 'New Ability',
        'description'   => 'Create Powers, Spells, Feats and more for your entities.',
        'header'        => 'Abilities of :name',
        'title'         => 'Abilities',
    ],
    'placeholders'  => [
        'charges'   => 'Amount of charges. Reference attributes with {Level}*{CHA}',
        'name'      => 'Fireball, Alert, Cunning Strike',
        'type'      => 'Spell, Feat, Attack',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Abilities',
            'entities'  => 'Entities',
        ],
        'title' => 'Ability :name',
    ],
];
