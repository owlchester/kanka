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
    ],
    'create'        => [
        'title' => 'Nova oznaka',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Djeca',
    ],
    'helpers'       => [
        'nested_without'    => 'Prikazuju se sve oznake koje nemaju oznaku roditelj. Klikni redak da bi vidio/la oznake djecu.',
    ],
    'hints'         => [
        'children'  => 'Popis sadrži sve oznake koje su unutar trenutne oznake, a ne samo one koje su direktno ispod nje.',
        'tag'       => 'Ispod su prikazane sve oznake koje su izravno pod ovom oznakom.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Legende, Ratovi, Povijest, Religija, Veksologija',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Djeca',
        ],
    ],
    'tags'          => [],
];
