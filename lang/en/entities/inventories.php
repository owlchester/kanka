<?php

return [
    'actions'           => [
        'copy_from_entity'  => 'Copy from another entity',
        'copy_inventory'    => 'Copy inventory',
        'generate'          => 'Generate',
        'multiple'          => 'Add items',
    ],
    'copy'              => [
        'helper'    => 'Copy the whole inventory of an entry to :name.',
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
        'match_all'             => 'Match all tags',
        'name'                  => 'Name',
        'position'              => 'Position',
        'qty'                   => 'QTY',
        'replace'               => 'Replace Inventory',
    ],
    'generate'          => [
        'helper'    => 'Generate an inventory for :name based on existing items in the campaign.',
        'title'     => 'Generate inventory',
    ],
    'helpers'           => [
        'amount'                => 'Number of items',
        'copy_entity_entry_v2'  => 'Display the object\'s entry instead of the custom description.',
        'description'           => 'Add a custom description to the item',
        'is_equipped'           => 'Mark this item as being equipped.',
        'name'                  => 'Give the name to the item. A name is required if no object is selected',
        'replace'               => 'Replaces current inventory with the generated one',
    ],
    'placeholders'      => [
        'amount'        => 'Any amount',
        'description'   => 'Used, Damaged, Attuned',
        'name'          => 'Sleeping bag',
        'position'      => 'Select or create a position',
    ],
    'show'              => [
        'helper'    => 'To create this entry\'s inventory, start by adding an item to it.',
        'title'     => ':name Inventory',
        'unsorted'  => 'Unsorted',
    ],
    'togglers'          => [
        'hide'  => [
            'price'     => 'Hide price',
            'quantity'  => 'Hide quantity',
            'size'      => 'Hide size',
            'weight'    => 'Hide weight',
        ],
        'show'  => [
            'price'     => 'Show price',
            'quantity'  => 'Show quantity',
            'size'      => 'Show size',
            'weight'    => 'Show weight',
        ],
    ],
    'tooltips'          => [
        'equipped'  => 'This item is equipped',
    ],
    'tutorials'         => [
        'all'   => 'Track what :name owns, stores, or offers by adding items to this inventory.',
    ],
    'update'            => [
        'success'   => 'Item :item updated for :entity.',
        'title'     => 'Update an item on :name',
    ],
];
