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
        'amount'            => 'Cantidade',
        'copy_entity_entry' => 'Usar a entrada do obxecto',
        'description'       => 'Descrición',
        'is_equipped'       => 'Equipado',
        'name'              => 'Nome',
        'position'          => 'Posición',
        'qty'               => 'Cantidade',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Mostra a entrada do obxecto en vez da descrición personalizada.',
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
