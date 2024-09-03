<?php

return [
    'actions'       => [
        'recover'           => 'Recover',
        'recover_selected'  => 'Recover selected'
    ],
    'error'         => 'An error occurred trying to recover entities.',
    'fields'        => [
        'deleted'    => 'Deleted',
        'deleted_at' => 'Deleted :date by :user.',
    ],
    'name_link'     => ':name was successfully recovered',
    'helper'        => 'Deleted entities of the campaign can be recovered for up to :count days. Entities deleted while the campaign isn\'t upgraded to premium status are still recoverable once the campaign is upgraded.',
    'success_v2'    => '{1} :count element was recovered.|[2,*] :count elements were recovered.',
    'premium'       => 'Recovering elements is a premium campaign feature.',
    'title'         => 'Entity Recovery',
    'order'         => [
        'newest'    => 'Order by: Newest',
        'oldest'    => 'Order by: Oldest',
        'type'      => 'Order by: Type',
        'newest_first'  => 'Newest first',
        'oldest_first'  => 'Oldest first',
        'type_order'    => 'Type',
    ],
];
