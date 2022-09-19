<?php

return [
    'campaigns' => [
        /**
         * The last campaign ID before the feature changes of Summer 2022.
         * Defaults to null on local installs due to them not having this limitation
         */
        'grandfathered' => env('APP_CAMPAIGN_GRANDFATHERED', 1),

        /**
         * Limits in place for non-grandfathered unboosted campaigns
         */
        'members' => 10,
        'roles' => 3,
        'quick-links' => 3,
        'entities' => 300,

        /**
         * Entities have a limited number of files (a type of entity_asset) available on each entity
         */
        'files' => [
            'standard' => 3,
            'boosted' => 5,
            'superboosted' => 10
        ]
    ],

    'filesize' => [
        'image' => env('APP_IMAGE_SIZE_MB', 1),
    ]
];
