<?php

return [
    'actions'       => [
        'add'   => 'Add a new group',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count group.|[2,*] Removed :count groups.',
        'patch'     => '{1} Updated :count group.|[2,*] Updated :count groups.',
    ],
    'create'        => [
        'helper'    => 'Add a new group to :name. Markers can then be assigned to this group.',
        'success'   => 'Group :name created.',
        'title'     => 'New Group',
    ],
    'delete'        => [
        'success'   => 'Group :name deleted.',
    ],
    'edit'          => [
        'success'   => 'Group :name updated.',
        'title'     => 'Edit Group',
    ],
    'fields'        => [
        'is_shown'  => 'Show group markers',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount_v3' => 'Markers can be grouped together using map groups. Each group can then be clicked when exploring a map to quickly show or hide all markers in it.',
    ],
    'hints'         => [
        'is_shown'  => 'Show markers in this group by default on the map.',
    ],
    'index'         => [
        'title' => 'Groups of :name',
    ],
    'pitch'         => [
        'max'       => [
            'helper'    => 'You can\'t add any more groups unless you remove an existing one.',
            'limit'     => 'This map has reached its group limit',
        ],
        'upgrade'   => [
            'limit'     => 'You\'ve reached the limit of :limit groups for this map',
            'upgrade'   => 'Upgrade to a premium campaign to add up to :limit groups and unlock even more creative flexibility.',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Shops, Treasure, NPCs',
        'position'      => 'First',
        'position_list' => 'After :name',
    ],
    'reorder'       => [
        'save'      => 'Save new order',
        'success'   => '{1} Reordered :count group.|[2,*] Reordered :count groups.',
        'title'     => 'Reorder groups',
    ],
];
