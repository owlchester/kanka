<?php

return [
    'actions'           => [
        'add'               => 'Add Item',
        'generate'          => 'Generate',
        'copy_from'         => 'Copy from',
        'copy_inventory'    => 'Copy inventory',
    ],
    'copy'              => [
        'helper'    => 'Copy the whole inventory of an entity to :name.',
    ],
    'generate'              => [
        'title' => 'Generate inventory',
        'helper'    => 'Generate an inventory for :name based on existing items in the campaign.',
    ],
    'create'            => [
        'helper'        => 'Add an item to :name\'s inventory. It can optionally be linked to an existing object from the campaign.',
        'success'       => 'Item :item added to :entity.',
        'success_bulk'  => '{0} No item added to :entity.|{1} Added :count item to :entity.|[2,*] Added :count items to :entity.',
        'title'         => 'Add to inventory',
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
        'item_amount'           => 'Number of Items',
        'name'                  => 'Name',
        'match_all'             => 'Match all tags',
        'position'              => 'Position',
        'qty'                   => 'QTY',
        'replace'               => 'Replace Inventory',
    ],
    'helpers'           => [
        'amount'                => 'Number of items',
        'copy_entity_entry_v2'  => 'Display the object\'s entry instead of the custom description.',
        'description'           => 'Add a custom description to the item',
        'is_equipped'           => 'Mark this item as being equipped.',
        'name'                  => 'Give the name to the item. A name is required if no object is selected',
        'replace'   => 'Replaces current inventory with the generated one',
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
    'tutorials'         => [
        'character' => 'Keep track of what :name possesses or has for sale by adding items to their inventory.',
        'location'  => 'Keep track of what :name has for sale or to loot by adding items to its inventory.',
        'other'     => 'Keep track of what :name possesses by adding items to its inventory.',
    ],
    'update'            => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
