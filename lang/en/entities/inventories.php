<?php

return [
    'actions'       => [
        'add'   => 'Add Item',
        'copy_from'   => 'Copy from',
        'copy_inventory' => 'Copy inventory',
    ],
    'copy' => [
        'title' => 'Copy inventory to :name',
    ],
    'create'        => [
        'success'            => 'Item :item added to :entity.',
        'success_bulk'       => '{1} Added :count item to :entity.|[2,*] Added :count items to :entity.',
        'title'              => 'Add an Item to :name',
    ],
    'destroy'       => [
        'success'   => 'Item :item removed from :entity.',
    ],
    'fields'        => [
        'amount'               => 'Quantity',
        'copy_entity_entry_v2' => 'Use object entry',
        'description'          => 'Description',
        'is_equipped'          => 'Equipped',
        'name'                 => 'Name',
        'position'             => 'Position',
        'qty'                  => 'QTY',
    ],
    'helpers'       => [
        'copy_entity_entry_v2' => 'Display the object\'s entry instead of the custom description.',
        'is_equipped'          => 'Mark this item as being equipped.',
    ],
    'placeholders'  => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'name'          => 'Required if no item is selected',
        'position'      => 'Equipped, Backpack, Storage, Bank',
    ],
    'show'          => [
        'helper'    => 'To create this entity\'s inventory, start by adding an item to it.',
        'title'     => ':name Inventory',
        'unsorted'  => 'Unsorted',
    ],
    'tutorial'      => 'Keep track of what an entity possesses with by adding items to its inventory.',
    'update'        => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
