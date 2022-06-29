<?php

return [
    'create'        => [
        'title' => 'New Item',
    ],
    'fields'        => [
        'character' => 'Creator',
        'image'     => 'Image',
        'location'  => 'Location',
        'name'      => 'Name',
        'price'     => 'Price',
        'size'      => 'Size',
        'type'      => 'Type',
        'item_id'   => 'Parent Item',
        'items'     => 'Sub Items',      
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
        'parent'    => 'Parent Item'
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventories',
        ],
    ],
    'hints'         => [
        'items'    => 'Organise items by using the parent item field.',
    ],
];
