<?php

return [
    'actions'       => [
        'add'       => 'Nova bilješka entiteta',
        'add_user'  => 'Dodaj korisnika',
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
        'collapsed' => 'Prema zadanim postavkama zatvori prikvačenu bilješku entiteta',
        'creator'   => 'Tvorac',
        'entry'     => 'Unos',
        'is_pinned' => 'Pričvršćeno',
        'name'      => 'Naziv',
        'position'  => 'Pozicija na kojoj je pričvršteno',
    ],
    'hint'          => 'Informacije koje se ne uklapaju u standardna polja entiteta ili koje bi trebale biti privatne mogu se dodati kao bilješke entiteta.',
    'hints'         => [
        'is_pinned' => 'Pričvrstene bilješke entiteta prikazuju se ispod teksta entiteta na primarnom prikazu entiteta. Redoslijed pričvršćenih bilješki entiteta se kontrolira pomoću polja pozicije.',
    ],
    'index'         => [
        'title' => 'Bilješke entiteta za :name',
    ],
    'placeholders'  => [
        'name'  => 'Naziv bilješke entiteta, opažanja ili primjedbe.',
    ],
    'show'          => [
        'advanced'  => 'Napredne postavke',
        'title'     => 'Bilješka entiteta :name za :entity',
    ],
];
