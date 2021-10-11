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
        'amount'            => 'Quantity',
        'copy_entity_entry' => 'Use item entry',
        'description'       => 'Description',
        'is_equipped'       => 'Equipped',
        'name'              => 'Name',
        'position'          => 'Position',
        'qty'               => 'QTY',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Display the item\'s entry instead of the custom description.',
    ],
    'placeholders'  => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'name'          => 'Required if no item is selected',
        'position'      => 'Equipped, Backpack, Storage, Bank',
    ],
    'show'          => [
        'helper'    => 'To create this entity\'s inventory, start by adding an item to it.',
        'title'     => 'Entity :name Inventory',
        'unsorted'  => 'Unsorted',
    ],
    'update'        => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
