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
    'helpers'       => [
        'descendants'       => 'Popis sadrži sve organizacije koje su unutar trenutne organizacije, a ne samo one koje su direktno ispod nje.',
        'nested_without'    => 'Prikazuju se sve organizacije koje nemaju organizaciju roditelj. Klikni redak da bi vidio/la organizacije djecu.',
    ],
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
