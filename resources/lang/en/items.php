<?php

return [
    'index' => [
        'title' => 'Items',
        'description' => 'Manage the items of your campaign.',
        'add' => 'New Item',
        'header' => 'Items of :name',
    ],
    'create' => [
        'title' => 'Create a new item',
        'description' => '',
        'success' => 'Item created.',
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
        'success' => 'Item updated.',
    ],
    'destroy' => [
        'success' => 'Item removed.',
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
        'is_private' => 'Private',
    ],
    'placeholders' => [
        'name' => 'Name of the item',
        'type' => 'Weapon, Potion, Artefact',
        'location' => 'Choose a location',
        'character' => 'Choose a character',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
    ],
];
