<?php

return [
    'create'        => [
        'description'   => 'Create a new item',
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
        'description'   => 'Manage the items of :name.',
        'header'        => 'Items of :name',
        'title'         => 'Items',
    ],
    'inventories'   => [
        'description'   => 'Entity Inventories the item is in.',
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
    'quests'        => [
        'description'   => 'Quests the item is a part of.',
        'title'         => 'Item :name Quests',
    ],
    'show'          => [
        'description'   => 'A detailed view of an item',
        'tabs'          => [
            'information'   => 'Information',
            'inventories'   => 'Inventories',
            'quests'        => 'Quests',
        ],
        'title'         => 'Item :name',
    ],
];
