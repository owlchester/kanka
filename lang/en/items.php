<?php

return [
    'create'        => [
        'title' => 'New Item',
    ],
    'fields'        => [
        'character'     => 'Creator',
        'is_equipped'   => 'Equipped',
        'price'         => 'Price',
        'size'          => 'Size',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all items that don\'t have a parent item. Click on a row to see the children items.',
    ],
    'hints'         => [
        'items' => 'Organise items by using the parent item field.',
    ],
    'placeholders'  => [
        'price' => 'Price of the item',
        'size'  => 'Size, Weight, Dimensions',
        'type'  => 'Weapon, Potion, Artefact',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventories',
        ],
    ],
];
