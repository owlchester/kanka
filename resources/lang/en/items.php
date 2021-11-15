<?php

return [
    'create'        => [
        'success'       => 'Item \':name\' created.',
        'title'         => 'New Item',
    ],
    'destroy'       => [
        'success'   => 'Item \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Item \':name\' updated.',
        'title'     => 'Edit Item :name',
    ],
    'fields'        => [
        'character' => 'Character',
        'image'     => 'Image',
        'location'  => 'Location',
        'name'      => 'Name',
        'price'     => 'Price',
        'relation'  => 'Relation',
        'size'      => 'Size',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'New Item',
        'header'        => 'Items of :name',
        'title'         => 'Items',
    ],
    'inventories'   => [
        'title'         => 'Item :name Inventories',
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
        'tabs'          => [
            'inventories'   => 'Inventories',
        ],
        'title'         => 'Item :name',
    ],
];
