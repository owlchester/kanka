<?php

return [
    'actions'       => [
        'add'   => 'Engadir obxeto',
    ],
    'create'        => [
        'success'   => 'Obxeto ":item" engadido a :entity.',
        'title'     => 'Engadir un obxeto a :name',
    ],
    'destroy'       => [
        'success'   => 'Obxeto ":item" eliminado de :entity.',
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
        'name'          => 'Requerido se non se selecciona ningún obxeto',
        'position'      => 'Equipado, mochila, almacenamento, banco...',
    ],
    'show'          => [
        'helper'    => 'As entidades poden ter obxetos asociados, creando un inventario.',
        'title'     => 'Inventario de :name',
        'unsorted'  => 'Sen ordenar',
    ],
    'update'        => [
        'success'   => 'Obxeto ":item" actualizado en :entity.',
        'title'     => 'Actualizar un obxeto de :name',
    ],
];
