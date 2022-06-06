<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Mostrando todos los personajes relativos a esta raza y sus subrazas.',
            'characters'        => 'Mostrando todos los personajes directamente relacionados con esta raza.',
        ],
        'title'     => 'Personajes de raza :name',
    ],
    'create'        => [
        'title' => 'Nueva raza',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personajes',
        'name'          => 'Nombre',
        'race'          => 'Raza superior',
        'races'         => 'Subrazas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando razas de :parent.',
        'nested_without'=> 'Mostrando todas las razas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'index'         => [
        'title' => 'Razas',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la raza',
        'type'  => 'Humano, Elfo, Troll...',
    ],
    'races'         => [
        'title' => 'Subrazas de la raza :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personajes',
            'races'         => 'Subrazas',
        ],
    ],
];
