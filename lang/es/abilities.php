<?php

return [
    'abilities'     => [
        'title' => 'Habilidades descendientes de :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Añadir habilidad a la entidad',
        ],
        'create'        => [
            'success'   => 'Se ha añadido la habilidad :name a la entidad.',
            'title'     => 'Añadir entidad a :name',
        ],
        'description'   => 'Entidades con esta habilidad',
        'title'         => 'Entidades de la habilidad :name',
    ],
    'create'        => [
        'title' => 'Nueva habilidad',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Entidades con la habilidad :name',
    ],
    'fields'        => [
        'abilities' => 'Habilidades',
        'ability'   => 'Habilidad superior',
        'charges'   => 'Usos',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas las habilidades que no tienen superior. Haz clic sobre una fila para mostrar las habilidades anidadas.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Cantidad de usos. Puedes hacer referencia a un atributo con {Nivel}*{CHA}',
        'name'      => 'Bola de fuego, Alerta, Puñalada trasera',
        'type'      => 'Hechizo, Proeza, Ataque',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilidades',
            'entities'  => 'Entidades',
        ],
    ],
];
