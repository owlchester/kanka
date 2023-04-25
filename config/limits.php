<?php

return [
    'campaigns' => [
        /**
         * Limits in place for non-grandfathered unboosted campaigns
         */
        'members' => 10,
        'roles' => 3,
        'quick-links' => 3,

        /**
         * Entities have a limited number of files (a type of entity_asset) available on each entity
         */
        'files' => [
            'standard' => 3,
            'boosted' => 5,
            'superboosted' => 10,
            'premium' => 10,
        ]
    ],

    /**
     * Default file upload size for standard user, in MB
     */
    'filesize' => [
        'image' => env('APP_IMAGE_SIZE_MB', 1),
    ]
];
