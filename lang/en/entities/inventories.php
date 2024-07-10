<?php

return [
    'actions'           => [
        'add'               => 'Add Item',
        'copy_from'         => 'Copy from',
        'copy_inventory'    => 'Copy inventory',
    ],
    'copy'              => [
        'title' => 'Copy inventory to :name',
    ],
    'create'            => [
        'success'       => 'Item :item added to :entity.',
        'success_bulk'  => '{0} No item added to :entity.|{1} Added :count item to :entity.|[2,*] Added :count items to :entity.',
        'title'         => 'Add an Item to :name',
    ],
    'default_position'  => 'Unorganised',
    'destroy'           => [
        'success'           => 'Item :item removed from :entity.',
        'success_position'  => 'Items in :position removed from :entity.',
    ],
    'fields'            => [
        'amount'                => 'Quantity',
        'copy_entity_entry_v2'  => 'Use object entry',
        'description'           => 'Description',
        'is_equipped'           => 'Equipped',
        'name'                  => 'Name',
        'position'              => 'Position',
        'qty'                   => 'QTY',
    ],
    'helpers'           => [
        'amount'                => 'Number of items',
        'copy_entity_entry_v2'  => 'Display the object\'s entry instead of the custom description.',
        'description'           => 'Add a custom description to the item',
        'is_equipped'           => 'Mark this item as being equipped.',
        'name'                  => 'Give the name to the item. A name is required if no object is selected',
    ],
    'placeholders'      => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'name'          => 'Sleeping bag',
        'position'      => 'Select or create a position',
    ],
    'show'              => [
        'helper'    => 'To create this entity\'s inventory, start by adding an item to it.',
        'title'     => ':name Inventory',
        'unsorted'  => 'Unsorted',
    ],
    'tooltips'          => [
        'equipped'  => 'This item is equipped',
    ],
    'tutorial'          => 'Keep track of what an entity possesses with by adding items to its inventory.',
    'update'            => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
