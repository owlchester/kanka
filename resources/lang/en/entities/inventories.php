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
        'position'      => 'Position',
        'name'          => 'Name',
        'is_equipped'   => 'Equipped',
    ],
    'placeholders'  => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'position'      => 'Equipped, Backpack, Storage, Bank',
        'name'          => 'Required if no item is selected',
    ],
    'show'          => [
        'helper'    => 'Entities can have items attached to them to create an inventory.',
        'title'     => 'Entity :name Inventory',
        'unsorted' => 'Unsorted',
    ],
    'update'        => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
