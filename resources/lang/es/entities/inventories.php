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
        'amount'            => 'Cantidad',
        'copy_entity_entry' => 'Usar la descripción del objeto',
        'description'       => 'Observaciones',
        'is_equipped'       => 'Equipado',
        'name'              => 'Nombre',
        'position'          => 'Localización',
        'qty'               => 'Cantidad',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Muestra la descripción del objeto en lugar de una descripción personalizada.',
    ],
    'placeholders'  => [
        'amount'        => 'Cualquier cantidad',
        'description'   => 'Usado, dañado, roto',
        'name'          => 'Requerido si no se selecciona ningún objeto',
        'position'      => 'Equipado, Mochila, Almacenamiento, Banco...',
    ],
    'show'          => [
        'helper'    => 'Las entidades pueden tener objetos asociados a ellas, creando así un inventario.',
        'title'     => 'Inventario de :name',
        'unsorted'  => 'Sin clasificar',
    ],
    'update'        => [
        'success'   => 'Objeto :item actualizado en :entity.',
        'title'     => 'Actualizar un objeto de :name',
    ],
];
