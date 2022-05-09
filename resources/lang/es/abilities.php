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
        'success'   => 'Habilidad ":name" creada.',
        'title'     => 'Nueva habilidad',
    ],
    'destroy'       => [
        'success'   => 'Habilidad ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Habilidad ":name" actualizada.',
        'title'     => 'Editar habilidad :name',
    ],
    'entities'      => [
        'title' => 'Entidades con la habilidad :name',
    ],
    'fields'        => [
        'abilities' => 'Habilidades',
        'ability'   => 'Habilidad superior',
        'charges'   => 'Usos',
        'name'      => 'Nombre',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contiene todas las habilidades descendientes de esta habilidad, no solo las que están en el nivel inmediatamente inferior.',
        'nested_parent' => 'Mostrando habilidades de :parent.',
        'nested_without'=> 'Mostrando todas las habilidades que no tienen superior. Haz clic sobre una fila para mostrar las habilidades anidadas.',
    ],
    'index'         => [
        'title' => 'Habilidades',
    ],
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
