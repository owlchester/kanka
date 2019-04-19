<?php

return [
    'actions' => [
        'add' => 'Add Item',
    ],
    'create' => [
        'title' => 'Add an Item to :name',
        'success' => 'Item :item added to :entity.',
    ],
    'destroy' => [
        'success' => 'Item :item removed from :entity.'
    ],
    'fields' => [
        'amount' => 'Amount',
        'position' => 'Position',
    ],
    'placeholders' => [
        'amount' => 'Any amount',
        'position' => 'Equipped, Backpack, Storage, Bank',
    ],
    'show' => [
        'title' => 'Entity :name Inventory',
        'helper' => 'Entities can have items attached to them to create an inventory.'
    ],
    'update' => [
        'title' => 'Update an item on :name',
        'success' => 'Item :item updated for :entity.',
    ]
];
