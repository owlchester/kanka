<?php

return [
    'actions'       => [
        'add'   => 'Añadir objeto',
    ],
    'create'        => [
        'success'   => 'Objeto :item añadido a :name',
        'title'     => 'Añade un objeto a :name',
    ],
    'destroy'       => [
        'success'   => 'Objeto :item eliminado de :entity.',
    ],
    'fields'        => [
        'amount'        => 'Cantidad',
        'description'   => 'Descripción',
        'position'      => 'Localización',
    ],
    'placeholders'  => [
        'amount'        => 'Cualquier cantidad',
        'description'   => 'Usado, dañado, roto',
        'position'      => 'Equipado, Mochila, Almacenamiento, Banco...',
    ],
    'show'          => [
        'helper'    => 'Las entidades pueden tener objetos asociados a ellas, creando así un inventario.',
        'title'     => 'Inventario de :name',
    ],
    'update'        => [
        'success'   => 'Objeto :item actualizado en :entity.',
        'title'     => 'Actualizar un objeto de :name',
    ],
];
