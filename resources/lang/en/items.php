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
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'New Item',
        'description'   => 'Manage the items of :name.',
        'header'        => 'Items of :name',
        'title'         => 'Items',
    ],
    'placeholders'  => [
        'character' => 'Choose a character',
        'location'  => 'Choose a location',
        'name'      => 'Name of the item',
        'type'      => 'Weapon, Potion, Artefact',
    ],
    'show'          => [
        'description'   => 'A detailed view of an item',
        'tabs'          => [
            'information'   => 'Information',
            'quests'        => 'Quests',
        ],
        'title'         => 'Item :name',
    ],
];
