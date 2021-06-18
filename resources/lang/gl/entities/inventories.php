<?php

return [
    'actions'       => [
        'add'   => 'Engadir obxecto',
    ],
    'create'        => [
        'success'   => 'Obxecto ":item" engadido a :entity.',
        'title'     => 'Engadir un obxecto a :name',
    ],
    'destroy'       => [
        'success'   => 'Obxecto ":item" eliminado de :entity.',
    ],
    'fields'        => [
        'amount'        => 'Cantidade',
        'description'   => 'Descrición',
        'is_equipped'   => 'Equipado',
        'name'          => 'Nome',
        'position'      => 'Posición',
    ],
    'placeholders'  => [
        'amount'        => 'Calquera cantidade',
        'description'   => 'Usado, danado, sintonizado...',
        'name'          => 'Requerido se non se selecciona ningún obxecto',
        'position'      => 'Equipado, mochila, almacenamento, banco...',
    ],
    'show'          => [
        'helper'    => 'As entidades poden ter obxectos asociados, creando un inventario.',
        'title'     => 'Inventario de :name',
        'unsorted'  => 'Sen ordenar',
    ],
    'update'        => [
        'success'   => 'Obxecto ":item" actualizado en :entity.',
        'title'     => 'Actualizar un obxecto de :name',
    ],
];
