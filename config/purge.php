<?php

return [
    'users' => [
        'first' => [
            'inactivity' => 18,
            'limit' => 30,
        ],
        'second' => [
            'limit' => 7,
        ],
    ],
    'hard_delete' => env('APP_CAMPAIGN_HARD_DELETE', 24),
];
