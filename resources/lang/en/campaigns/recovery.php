<?php

return [
    'actions'   => [
        'recover'   => 'Recover',
    ],
    'error'     => 'An error occurred trying to recover entities.',
    'fields'    => [
        'deleted'   => 'Deleted',
    ],
    'helper'    => 'Deleted entities of the campaign can be recovered for up to :count days. Entities deleted while the campaign isn\'t boosted are still recoverable once the campaign becomes boosted.',
    'success'   => '{1} :count entity was recovered.|[2,*] :count entities were recovered.',
    'title'     => 'Entity Recovery for :campaign',
];
