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
    'helpers'       => [
        'descendants'   => 'Deze lijst bevat alle organisaties die afstammen van deze organisatie, en niet alleen de direct daaronder vallende organisaties.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'   => 'Voeg een lid toe',
        ],
        'create'        => [
            'success'   => 'Lid toegevoegd aan de organisatie.',
            'title'     => 'Nieuw Organisatie Lid voor :name',
        ],
        'destroy'       => [
            'success'   => 'Lid verwijderd van de organisatie',
        ],
        'edit'          => [
            'success'   => 'Organisatie lid bijgewerkt.',
            'title'     => 'Werk Lid bij voor :name',
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
