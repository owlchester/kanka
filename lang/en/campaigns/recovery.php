<?php

return [
    'actions'   => [
        'recover'           => 'Recover',
        'recover_selected'  => 'Recover selected',
    ],
    'error'     => 'An error occurred trying to recover entities.',
    'fields'    => [
        'deleted'       => 'Deleted',
        'deleted_at'    => 'Deleted :date by :user',
    ],
    'helper'    => 'Deleted entities of the campaign can be recovered for up to :count days. Entities deleted while the campaign isn\'t upgraded to premium status are still recoverable once the campaign is upgraded.',
    'name_link' => ':name was successfully recovered',
    'order'     => [
        'newest'        => 'Order by: Newest',
        'newest_first'  => 'Newest first',
        'oldest'        => 'Order by: Oldest',
        'oldest_first'  => 'Oldest first',
        'type'          => 'Order by: Type',
        'type_order'    => 'Type',
    ],
    'premium'   => 'Recovering elements is a premium campaign feature.',
    'success_v2'=> '{1} :count element was recovered.|[2,*] :count elements were recovered.',
    'title'     => 'Entity Recovery',
];
