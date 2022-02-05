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
        'success'   => 'Raza ":name" creada.',
        'title'     => 'Nueva raza',
    ],
    'destroy'       => [
        'success'   => 'Raza ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Raza ":name" actualizada.',
        'title'     => 'Editar raza :name',
    ],
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
        'add'       => 'Nueva raza',
        'header'    => 'Razas de :name',
        'title'     => 'Razas',
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
        'title' => 'Raza :name',
    ],
];
