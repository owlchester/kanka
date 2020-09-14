<?php

return [
    'actions'       => [
        'add'   => 'Add a new group',
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
        'amount'            => 'A marker can be attached to a group, allowing you to show or hide all Shops of a city. A map can have up to :amount groups.',
        'boosted_campaign'  => ':boosted can have up to :amount groups.',
    ],
    'hints'         => [
        'is_shown'  => 'If checked, the group markers will be shown on the map by default.',
    ],
    'placeholders'  => [
        'name'      => 'Shops, Treasure, NPCs',
        'position'  => 'Optional field to set the order in which the groups appear.',
    ],
];
