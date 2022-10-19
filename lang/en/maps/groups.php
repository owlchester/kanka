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
        'amount_v3' => 'Markers can be grouped together using map groups. Each group can then be clicked when exploring a map to quickly show or hide all markers in it.',
    ],
    'hints'         => [
        'is_shown'  => 'If checked, the group markers will be shown on the map by default.',
    ],
    'pitch'         => [
        'error' => 'Max number of groups reached.',
        'until' => 'Create up to :max groups to each map.',
    ],
    'placeholders'  => [
        'name'           => 'Shops, Treasure, NPCs',
        'position'       => 'First',
        'position_list'  => 'After :name',
    ],
    'reorder'   => [
        'save'      => 'Save new order',
        'success'   => '{1} Reordered :count group.|[2,*] Reordered :count groups.',
        'title'     => 'Reorder groups',
    ],
];
