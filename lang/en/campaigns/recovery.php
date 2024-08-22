<?php

return [
    'actions'       => [
        'recover'   => 'Recover',
    ],
    'error'         => 'An error occurred trying to recover entities.',
    'fields'        => [
        'deleted'    => 'Deleted',
        'deleted_at' => 'Deleted :date'
    ],
    'helper'        => 'Deleted entities of the campaign can be recovered for up to :count days. Entities deleted while the campaign isn\'t upgraded to premium status are still recoverable once the campaign is upgraded.',
    'success_v2'    => '{1} :count post or entity was recovered.|[2,*] :count posts and/or entities were recovered.',
    'title'         => 'Entity Recovery',
];
