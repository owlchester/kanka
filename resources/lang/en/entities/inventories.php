<?php

return [
    'actions'       => [
        'add'   => 'Add Item',
    ],
    'create'        => [
        'success'   => 'Item :item added to :entity.',
        'title'     => 'Add an Item to :name',
    ],
    'destroy'       => [
        'success'   => 'Item :item removed from :entity.',
    ],
    'fields'        => [
        'amount'    => 'Amount',
        'position'  => 'Position',
        'description' => 'Description',
    ],
    'placeholders'  => [
        'amount'    => 'Any amount',
        'position'  => 'Equipped, Backpack, Storage, Bank',
        'description' => 'Used, Damaged, Attuned'
    ],
    'show'          => [
        'helper'    => 'Entities can have items attached to them to create an inventory.',
        'title'     => 'Entity :name Inventory',
    ],
    'update'        => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
