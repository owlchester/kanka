<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'Vincular a entidades',
        ],
        'create'        => [
            'attach_success'    => '{1}Se ha vinculado la habilidad :name a :count entidad.|[2,*] Se ha vinculado la habilidad :name a :count entidades.',
            'helper'            => 'Vincular :name a una o varias entidades.',
            'title'             => 'Vincular entidades',
        ],
        'description'   => 'Entidades con esta habilidad',
        'title'         => 'Entidades de la habilidad :name',
    ],
    'create'        => [
        'title' => 'Nueva habilidad',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Usos',
    ],
    'helpers'       => [],
    'index'         => [],
    'lists'         => [
        'empty' => 'Agrega poderes, hechizos o talentos. Muchos creadores usan esto para modelar clases de D&D.',
    ],
    'placeholders'  => [
        'charges'   => 'Cantidad de usos. Puedes hacer referencia a un atributo con {Nivel}*{CHA}',
        'name'      => 'Bola de fuego, Alerta, Puñalada trasera',
        'type'      => 'Hechizo, Proeza, Ataque',
    ],
    'reorder'       => [
        'parentless'    => 'Sin padre',
        'success'       => 'Habilidades reordenadas exitosamente.',
        'title'         => 'Reordenar las habilidades',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Reordenar Habilidades',
        ],
    ],
];
