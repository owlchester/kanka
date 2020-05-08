<?php

return [
    'actions'       => [
        'add'   => 'Nova bilješka entiteta',
    ],
    'create'        => [
        'description'   => 'Kreiraj novu bilješku entiteta',
        'success'       => 'Dodana bilješka entiteta ":name" na :entity.',
        'title'         => 'Nova bilješka entiteta za :name',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena bilješka entiteta ":name" s :entity.',
    ],
    'edit'          => [
        'description'   => 'Ažuriraj postojeću bilješku entiteta',
        'success'       => 'Ažurirana bilješka entiteta ":name" za :entity.',
        'title'         => 'Ažuriraj bilješku entiteta za :name',
    ],
    'fields'        => [
        'creator'   => 'Tvorac',
        'entry'     => 'Unos',
        'name'      => 'Naziv',
    ],
    'hint'          => 'Informacije koje se ne uklapaju u standardna polja entiteta ili koje bi trebale biti privatne mogu se dodati kao bilješke entiteta.',
    'index'         => [
        'title' => 'Bilješke entiteta za :name',
    ],
    'placeholders'  => [
        'name'  => 'Naziv bilješke entiteta, opažanja ili primjedbe.',
    ],
    'show'          => [
        'title' => 'Bilješka entiteta :name za :entity',
    ],
];
