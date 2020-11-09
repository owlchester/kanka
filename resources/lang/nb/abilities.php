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
        'nested'        => 'I Rede Visning kan man se dine Egenskaper som i et rede. Egenskaper uten forelder egenskap blir vist som standard. Egenskaper med datter-egenskaper kan klikkes for å vise dets datter-egenskaper. Du kan klikke helt til det ikke er flere datter-egenskaper å se.',
    ],
    'index'         => [
        'add'           => 'Ny egenskap',
        'description'   => 'Opprett krefter, Spells, Feats og mer til dine Objekter.',
        'header'        => 'Egenskaper til :name',
        'title'         => 'Egenskaper',
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
