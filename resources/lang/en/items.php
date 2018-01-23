<?php

return [
    'index' => [
        'title' => 'Items',
        'description' => 'Manage the items of :name.',
        'add' => 'New Item',
        'header' => 'Items of :name',
    ],
    'create' => [
        'title' => 'Create a new item',
        'description' => '',
        'success' => 'Item \':name\' created.',
    ],
    'show' => [
        'title' => 'Item :name',
        'description' => 'A detailed view of an item',
        'tabs' => [
            'information' => 'Information',
        ],
    ],
    'edit' => [
        'title' => 'Edit Item :name',
        'description' => '',
        'success' => 'Item \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Item \':name\' removed.',
    ],
    'fields' => [
        'relation' => 'Relation',
        'name' => 'Name',
        'location' => 'Location',
        'type' => 'Type',
        'character' => 'Character',
        'history' => 'History',
        'image' => 'Image',
        'description' => 'Description',
    ],
    'placeholders' => [
        'name' => 'Name of the item',
        'type' => 'Weapon, Potion, Artefact',
        'location' => 'Choose a location',
        'character' => 'Choose a character',
    ],
];
