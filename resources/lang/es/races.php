<?php

return [
    'characters'    => [
        'description'   => 'Personajes de esta raza.',
        'title'         => 'Personajes de raza :name',
    ],
    'create'        => [
        'description'   => 'Crear nueva raza',
        'success'       => 'Raza ":name" creada.',
        'title'         => 'Nueva raza',
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
        'nested'    => 'Con la vista anidada, puedes ver tus razas de forma anidada. Las razas que no tengan raza superior se mostrarán por defecto. A las razas con subrazas se les puede hacer click para mostrar sus descendientes. Puedes seguir haciendo click hasta que no haya más descendientes que mostrar.',
    ],
    'index'         => [
        'add'           => 'Nueva raza',
        'description'   => 'Gestiona las razas de :name.',
        'header'        => 'Razas de :name',
        'title'         => 'Razas',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la raza',
        'type'  => 'Humano, Elfo, Troll...',
    ],
    'races'         => [
        'description'   => 'Razas pertenecientes a esta raza.',
        'title'         => 'Subrazas de la raza :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la raza',
        'tabs'          => [
            'characters'    => 'Personajes',
            'menu'          => 'Menú',
            'races'         => 'Subrazas',
        ],
        'title'         => 'Raza :name',
    ],
];
