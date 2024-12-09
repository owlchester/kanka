<?php

return [
    'campaigns' => [
        /**
         * Limits in place for standard campaigns
         */
        'members' => 10,
        'roles' => 3,
        'bookmarks' => 3,

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
    ],

    'gallery' => [
        'standard' => env('APP_GALLERY_STANDARD', 100 * 1024),
        'premium' => env('APP_GALLERY_PREMIUM', 2 * 1024 * 1024),
        //'premium' => 20 * 1024,
    ],

    'pagination' => env('APP_PAGINATION', 15),
];
