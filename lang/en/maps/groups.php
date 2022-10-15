<?php

return [
    'actions'       => [
        'add'   => 'Add a new group',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count group.|[2,*] Removed :count groups.',
    ],
    'create'        => [
        'success'   => 'Group :name created.',
        'title'     => 'New Group',
    ],
    'delete'        => [
        'success'   => 'Group :name deleted.',
    ],
    'edit'          => [
        'success'   => 'Group :name updated.',
        'title'     => 'Edit Group :name',
    ],
    'fields'        => [
        'is_shown'  => 'Show group markers',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount_v2' => 'Create marker groups and attach markers to them, enabling to quickly show or hide multiple markers with a single click.',
    ],
    'hints'         => [
        'is_shown'  => 'If checked, the group markers will be shown on the map by default.',
    ],
    'pitch'         => [
        'error' => 'Max number of groups reached.',
        'until' => 'Create up to :max groups to each map.',
    ],
    'placeholders'  => [
        'name'      => 'Shops, Treasure, NPCs',
        'position'  => 'Optional field to set the order in which the groups appear.',
    ],
    'reorder'   => [
        'save'      => 'Save new order',
        'success'   => '{1} Reordered :count group.|[2,*] Reordered :count groups.',
        'title'     => 'Reorder groups',
    ],
];
