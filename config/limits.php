<?php

return [
    'campaigns' => [
        /**
         * Limits in place for standard campaigns. Premium campaigns are unlimited
         */
        'members' => 10,
        'roles' => 3,
        'bookmarks' => 3,

        /**
         * Entities have a limited number of files (a type of entity_asset) available on each entity
         */
        'files' => [
            'standard' => 3,
            'premium' => 20,
        ],
        'modules' => env('APP_MODULE_LIMIT', 5),
        'export' => 6, // hours after which exports get deleted
        'maps' => [
            // Maximum number of groups per map
            'groups' => [
                'standard' => 1,
                'premium' => 20,
            ],
            'layers' => [
                'standard' => 1,
                'premium' => 20,
            ],
        ],
        'logs' => [
            'standard' => 7,
            'premium' => 180,
        ],
    ],

    /**
     * Default file upload size for standard user, in MB
     */
    'filesize' => [
        'image' => env('APP_IMAGE_SIZE_MB', 3),
        'image_wyvern' => env('APP_IMAGE_SIZE_WYVERN_MB', 10),
        'image_elemental' => env('APP_IMAGE_SIZE_WYVERN_MB', 25),
        'map' => env('APP_MAP_SIZE_MB', 5),
    ],

    'gallery' => [
        'standard' => env('APP_GALLERY_STANDARD', 150 * 1024),
        'premium' => env('APP_GALLERY_PREMIUM', 3 * 1024 * 1024),
        // 'premium' => 20 * 1024,
    ],

    'pagination' => env('APP_PAGINATION', 15),

    'api' => [
        // Throttling values of requests per minute before a 421 "back down" response is thrown
        'throttle' => [
            'subscriber' => env('API_THROTTLE_SUBSCRIBER_LIMIT', 90),
            'default' => env('API_THROTTLE_LIMIT', 30),
        ],
    ],
];
