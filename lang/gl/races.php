<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Mostrando todas as personaxes relacionadas a esta raza e ás súas subrazas.',
            'characters'        => 'Mostrando todas as personaxes directamente relacionadas a esta raza.',
        ],
        'title'     => 'Personaxes da raza :name',
    ],
    'create'        => [
        'title' => 'Nova raza',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personaxes',
        'name'          => 'Nome',
        'race'          => 'Raza nai',
        'races'         => 'Subrazas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as razas que non teñen unha raza nai. Fai clic nunha fila para ver as súas subrazas.',
    ],
    'index'         => [
        'title' => 'Razas',
    ],
    'placeholders'  => [
        'name'  => 'Nome da raza',
        'type'  => 'Humana, fada, borg...',
    ],
    'races'         => [
        'title' => 'Subrazas da raza :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personaxes',
            'races'         => 'Subrazas',
        ],
    ],
];
