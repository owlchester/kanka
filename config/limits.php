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
            'premium' => 20,
        ],
        'modules' => env('APP_MODULE_LIMIT', 5),
    ],

    /**
     * Default file upload size for standard user, in MB
     */
    'filesize' => [
        'image' => env('APP_IMAGE_SIZE_MB', 3),
        'map' => env('APP_MAP_SIZE_MB', 5),
    ],

    'gallery' => [
        'standard' => env('APP_GALLERY_STANDARD', 150 * 1024),
        'premium' => env('APP_GALLERY_PREMIUM', 3 * 1024 * 1024),
        //'premium' => 20 * 1024,
    ],

    'pagination' => env('APP_PAGINATION', 15),
];
