<?php

return [
    // To allow running multiple ad providers, define the one that is currently being used
    'provider' => env('AD_PROVIDER'),

    'freestar' => [
        'enabled' => ! empty(env('FREESTAR_SITE')),
        'site' => env('FREESTAR_SITE'),
        'tags' => [
            'incontent' => 'kanka_incontent_reusable',
            'siderail_right' => 'kanka_siderail_right_1',
            'siderail_left' => 'kanka_siderail_left',
            'leaderboard' => 'kanka_leaderboard_atf',
        ],
    ],
];
