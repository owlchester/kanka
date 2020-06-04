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
    'fields'        => [
        'abilities' => 'Abilities',
        'ability'   => 'Parent Ability',
        'charges'   => 'Charges',
        'name'      => 'Name',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all abilities which are descendants of this ability, and not only those directly under it.',
        'nested'        => 'When in Nested View, you can view your Abilities in a nested manner. Abilities with no parent ability will be shown by default. Abilities with sub abilities can be clicked to view those children. You can keep clicking until there are no more children to view.',
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
        ],
        'title' => 'Ability :name',
    ],
];
