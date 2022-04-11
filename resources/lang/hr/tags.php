<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Dodaj novu oznaku',
        ],
        'create'    => [
            'success'   => 'Dodana oznaka :name entitetu.',
            'title'     => 'Dodaj oznaku na :name',
        ],
        'title'     => 'Djeca oznake :name',
    ],
    'create'        => [
        'success'   => 'Kreirana oznaka ":name".',
        'title'     => 'Nova oznaka',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena oznaka ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana oznaka ":name".',
        'title'     => 'Uredi oznaku :name',
    ],
    'fields'        => [
        'children'  => 'Djeca',
        'name'      => 'Naziv',
        'tag'       => 'Oznaka roditelj',
        'tags'      => 'Pod-oznake',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'nested_parent' => 'Prikaz oznake od :parent.',
        'nested_without'=> 'Prikazuju se sve oznake koje nemaju oznaku roditelj. Klikni redak da bi vidio/la oznake djecu.',
    ],
    'hints'         => [
        'children'  => 'Popis sadrži sve oznake koje su unutar trenutne oznake, a ne samo one koje su direktno ispod nje.',
        'tag'       => 'Ispod su prikazane sve oznake koje su izravno pod ovom oznakom.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Ugniježđeni pregled',
        ],
        'add'       => 'Nova oznaka',
        'header'    => 'Oznake u :name',
        'title'     => 'Oznake',
    ],
    'new_tag'       => 'Nova oznaka',
    'placeholders'  => [
        'name'  => 'Naziv oznake',
        'tag'   => 'Odaberite oznaku roditelj',
        'type'  => 'Legende, Ratovi, Povijest, Religija, Veksologija',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Djeca',
            'tags'      => 'Oznake',
        ],
        'title' => 'Oznaka :name',
    ],
    'tags'          => [
        'title' => 'Djeca oznake :name',
    ],
];
