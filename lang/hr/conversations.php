<?php

return [
    'create'        => [
        'title' => 'Novi razgovor',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Zatvoreno',
        'messages'      => 'Poruke',
        'participants'  => 'Sudionici',
    ],
    'hints'         => [
        'participants'  => 'Dodaj sudionike u razgovor pritiskom na ikonu :icon u gornjem desnom kutu.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Poruka uklonjena.',
        ],
        'is_updated'    => 'Ažurirano',
        'load_previous' => 'Učitaj prethodne poruke',
        'placeholders'  => [
            'message'   => 'Tvoja poruka',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Sudionik :entity dodan u razgovor.',
        ],
        'destroy'   => [
            'success'   => 'Sudionik :entity uklonjen iz razgovora.',
        ],
        'modal'     => 'Sudionici',
        'title'     => 'Sudionici u :name',
    ],
    'placeholders'  => [
        'name'  => 'Naziv razgovora',
        'type'  => 'U igri, Priprema, Zaplet',
    ],
    'show'          => [
        'is_closed' => 'Razgovor je zatvoren.',
    ],
    'tabs'          => [
        'participants'  => 'Sudionici',
    ],
    'targets'       => [
        'characters'    => 'Likovi',
        'members'       => 'Članovi',
    ],
];
