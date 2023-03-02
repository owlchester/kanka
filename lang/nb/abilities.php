<?php

return [
    'abilities'     => [
        'title' => 'Datter egenskap til :name',
    ],
    'create'        => [
        'title' => 'Ny Egenskap',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'abilities' => 'Egenskaper',
        'ability'   => 'Forelder Egenskap',
        'charges'   => 'Ladninger',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Antall ladninger. Referer atributt med {Level}*{CHA}',
        'name'      => 'Fireball, Alert, Cunning Strike eller andre Spells',
        'type'      => 'Spell, Feat, Angrep',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Egenskaper',
        ],
    ],
];
