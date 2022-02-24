<?php

return [
    'abilities'     => [
        'title' => 'Datter egenskap til :name',
    ],
    'create'        => [
        'success'   => 'Egenskap \':name\' opprettet.',
        'title'     => 'Ny Egenskap',
    ],
    'destroy'       => [
        'success'   => 'Egenskap \':name\' fjernet.',
    ],
    'edit'          => [
        'success'   => 'Egenskap \':name\' oppdatert.',
        'title'     => 'Rediger Egenskap :name',
    ],
    'fields'        => [
        'abilities' => 'Egenskaper',
        'ability'   => 'Forelder Egenskap',
        'charges'   => 'Ladninger',
        'name'      => 'Navn',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Denne listen inneholder alle egenskaper som er etterkommere av denne egenskapen, ikke bare de som stammer direkte fra den.',
    ],
    'index'         => [
        'add'       => 'Ny egenskap',
        'header'    => 'Egenskaper til :name',
        'title'     => 'Egenskaper',
    ],
    'placeholders'  => [
        'charges'   => 'Antall ladninger. Referer atributt med {Level}*{CHA}',
        'name'      => 'Fireball, Alert, Cunning Strike eller andre Spells',
        'type'      => 'Spell, Feat, Angrep',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Egenskaper',
        ],
        'title' => 'Egenskap :name',
    ],
];
