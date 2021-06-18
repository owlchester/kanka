<?php

return [
    'characters'    => [
        'description'   => 'Personaxes desta raza.',
        'helpers'       => [
            'all_characters'    => 'Mostrando todas as personaxes relacionadas a esta raza e ás súas subrazas.',
            'characters'        => 'Mostrando todas as personaxes directamente relacionadas a esta raza.',
        ],
        'title'         => 'Personaxes da raza :name',
    ],
    'create'        => [
        'description'   => 'Crear unha nova raza',
        'success'       => 'Raza ":name" creada.',
        'title'         => 'Nova raza',
    ],
    'destroy'       => [
        'success'   => 'Raza ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Raza ":name" actualizada.',
        'title'     => 'Editar raza ":name"',
    ],
    'fields'        => [
        'characters'    => 'Personaxes',
        'name'          => 'Nome',
        'race'          => 'Raza nai',
        'races'         => 'Subrazas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as razas de :parent.',
        'nested_without'=> 'Mostrando todas as razas que non teñen unha raza nai. Fai clic nunha fila para ver as súas subrazas.',
    ],
    'index'         => [
        'add'           => 'Nova raza',
        'description'   => 'Xestionar as razas de :name',
        'header'        => 'Razas de :name',
        'title'         => 'Razas',
    ],
    'placeholders'  => [
        'name'  => 'Nome da raza',
        'type'  => 'Humana, fada, borg...',
    ],
    'races'         => [
        'description'   => 'Subrazas desta raza.',
        'title'         => 'Subrazas da raza :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada dunha raza',
        'tabs'          => [
            'characters'    => 'Personaxes',
            'menu'          => 'Menú',
            'races'         => 'Subrazas',
        ],
        'title'         => 'Raza :name',
    ],
];
