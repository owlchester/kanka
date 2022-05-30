<?php

return [
    'create'        => [
        'title'     => 'New Item',
    ],
    'fields'        => [
        'character' => 'Creator',
        'image'     => 'Image',
        'location'  => 'Location',
        'name'      => 'Name',
        'price'     => 'Price',
        'size'      => 'Size',
        'type'      => 'Type',
    ],
    'index'         => [
        'title' => 'Items',
    ],
    'inventories'   => [
        'title' => 'Item :name Inventories',
    ],
    'placeholders'  => [
        'character' => 'Choose a character',
        'location'  => 'Choose a location',
        'name'      => 'Name of the item',
        'price'     => 'Price of the item',
        'size'      => 'Size, Weight, Dimensions',
        'type'      => 'Weapon, Potion, Artefact',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventories',
        ],
    ],
];
