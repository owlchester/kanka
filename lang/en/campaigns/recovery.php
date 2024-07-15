<?php

return [
    'actions'       => [
        'recover'   => 'Recover',
    ],
    'error'         => 'An error occurred trying to recover entities.',
    'fields'        => [
        'deleted'   => 'Deleted',
    ],
    'helper'        => 'Deleted entities of the campaign can be recovered for up to :count days. Entities deleted while the campaign isn\'t upgraded to premium status are still recoverable once the campaign is upgraded.',
    'post-title'    => 'Post Recovery',
    'posts'         => [
        'error'     => 'An error occurred trying to recover posts.',
        'success'   => '{1} :count post was recovered.|[2,*] :count posts were recovered.',
    ],
    'success'       => '{1} :count entity was recovered.|[2,*] :count entities were recovered.',
    'title'         => 'Entity Recovery',
    'toggle'        => [
        'entity'    => 'Switch to entity recovery',
        'post'      => 'Switch to post recovery',
    ],
];
