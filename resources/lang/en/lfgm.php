<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Synchronize',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Invalid LFGM campaign id. Please try again.',
        ],
        'helper'    => 'Select a campaign to sync your upcoming events from :lfgm. This will add a Note with your upcoming events to that campaign and pin it to the campaign dashboard.',
        'successes' => [
            'sync'  => 'LFGM calendar synced.',
        ],
        'title'     => 'LookingForGM.com Campaign Sync',
    ],
];
