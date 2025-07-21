<?php

return [
    'create'        => [
        'title' => 'Nieuwe Organisatie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Leden',
    ],
    'helpers'       => [],
    'index'         => [],
    'members'       => [
        'destroy'       => [
            'success'   => 'Lid verwijderd van de organisatie',
        ],
        'edit'          => [
            'title' => 'Werk Lid bij voor :name',
        ],
        'fields'        => [
            'role'  => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Alle personages die lid zijn van deze organisaties en zijn suborganisaties.',
            'members'       => 'Alle personages die lid zijn van deze organisatie.',
        ],
        'placeholders'  => [
            'role'  => 'Leider, Lid, Hoog-lid, Spymaster',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Sekte, Gang, Rebellie, Fandom',
    ],
    'show'          => [],
];
