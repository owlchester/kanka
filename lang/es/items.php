<?php

return [
    'create'        => [
        'title' => 'Nuevo objeto',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personaje',
        'price'     => 'Precio',
        'size'      => 'Tamaño',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrar todos los ítems que no tienen un ítem padre. Haz clic en una fila para ver los ítems hijos.',
    ],
    'hints'         => [
        'items' => 'Organice los ítems utilizando el campo del ítem padre.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Precio del objeto',
        'size'  => 'Tamaño, peso, dimensiones',
        'type'  => 'Arma, Poción, Artefacto...',
    ],
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventarios',
        ],
    ],
];
