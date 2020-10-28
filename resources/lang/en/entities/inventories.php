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
        'amount'        => 'Amount',
        'description'   => 'Description',
        'is_equipped'   => 'Equipped',
        'name'          => 'Name',
        'position'      => 'Position',
    ],
    'placeholders'  => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'name'          => 'Required if no item is selected',
        'position'      => 'Equipped, Backpack, Storage, Bank',
    ],
    'show'          => [
        'helper'    => 'Entities can have items attached to them to create an inventory.',
        'title'     => 'Entity :name Inventory',
        'unsorted'  => 'Unsorted',
    ],
    'update'        => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
