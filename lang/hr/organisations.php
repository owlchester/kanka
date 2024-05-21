<?php

return [
    'create'        => [
        'title' => 'Nova organizacija',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Članovi',
    ],
    'helpers'       => [],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'   => 'Dodaj člana',
        ],
        'create'        => [
            'success'   => 'Član dodan u organizaciju.',
            'title'     => 'Novi član organizacije za :name',
        ],
        'destroy'       => [
            'success'   => 'Član uklonjen iz organizacije.',
        ],
        'edit'          => [
            'success'   => 'Član organizacije ažuriran.',
            'title'     => 'Ažuriraj člana za :name',
        ],
        'fields'        => [
            'role'  => 'Uloga',
        ],
        'helpers'       => [
            'all_members'   => 'Svi likovi koji su članovi ove organizacije i njenih podorganizacija.',
            'members'       => 'Sljedeća lista prikazuje sve likove koji su u ovoj organizaciji i svim njenim podorganizacijama. Možeš filtrirati stranicu da prikaže samo direktne članove.',
        ],
        'placeholders'  => [
            'role'  => 'Voditelj, Član, Visoki Svećenik, Majstor Špijun',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Kult, Banda, Pobuna, Klub obožavatelja',
    ],
    'show'          => [],
];
