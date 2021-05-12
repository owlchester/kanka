<?php

return [
    'abilities'     => [
        'title' => 'Habilidades descendientes de :name',
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
        'add'           => 'Nueva habilidad',
        'description'   => 'Crea poderes, hechizos, mejoras y más para tus entidades.',
        'header'        => 'Habilidades de :name',
        'title'         => 'Habilidades',
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
        'title' => 'Habilidad :name',
    ],
];
