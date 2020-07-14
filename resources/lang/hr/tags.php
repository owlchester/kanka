<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Dodaj novu oznaku',
        ],
        'create'        => [
            'title' => 'Dodaj oznaku na :name',
        ],
        'description'   => 'Entiteti koji pripadaju oznaci',
        'title'         => 'Djeca oznake :name',
    ],
    'create'        => [
        'description'   => 'Kreiraj novu oznaku',
        'success'       => 'Kreirana oznaka ":name".',
        'title'         => 'Nova oznaka',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena oznaka ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana oznaka ":name".',
        'title'     => 'Uredi oznaku :name',
    ],
    'fields'        => [
        'characters'    => 'Likovi',
        'children'      => 'Djeca',
        'name'          => 'Naziv',
        'tag'           => 'Oznaka roditelj',
        'tags'          => 'Pod-oznake',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested'    => 'U "Ugniježđenom pregledu" možeš vidjeti oznake na ugniježđeni način. Oznake bez oznake roditelj će biti prikazane na osnovnom pregledu. Oznake s oznakam djecom se mogu kliknuti kako bi se prikazale te oznake djeca. Možeš nastaviti klikati dok ima oznaka za prikazati.',
    ],
    'hints'         => [
        'children'  => 'Popis sadrži sve oznake koje su unutar trenutne oznake, a ne samo one koje su direktno ispod nje.',
        'tag'       => 'Ispod su prikazane sve oznake koje su izravno pod ovom oznakom.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Ugniježđeni pregled',
        ],
        'add'           => 'Nova oznaka',
        'description'   => 'Upravljanje oznakama u :name.',
        'header'        => 'Oznake u :name',
        'title'         => 'Oznake',
    ],
    'new_tag'       => 'Nova oznaka',
    'placeholders'  => [
        'name'  => 'Naziv oznake',
        'tag'   => 'Odaberite oznaku roditelj',
        'type'  => 'Legende, Ratovi, Povijest, Religija, Veksologija',
    ],
    'show'          => [
        'description'   => 'Detaljan prikaz oznake',
        'tabs'          => [
            'children'      => 'Djeca',
            'information'   => 'Informacije',
            'tags'          => 'Oznake',
        ],
        'title'         => 'Oznaka :name',
    ],
    'tags'          => [
        'description'   => 'Oznake djeca',
        'title'         => 'Djeca oznake :name',
    ],
];
