<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            // Root folder is prefixed outside of prod
            'root' => env('APP_ENV') != 'production' ? env('APP_ENV') : null,
            'visibility' => 'public',
            // Url for including the assets in the browser
            'url' => env('AWS_URL_S3', env('AWS_URL')),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'backup' => [
            'driver' => 's3',
            'key' => env('HETZNER_S3_ACCESS_KEY_ID'),
            'secret' => env('HETZNER_S3_ACCESS_KEY_SECRET'),
            'region' => env('HETZNER_S3_REGION'),
            'bucket' => env('S3_BUCKET_BACKUP'),
            'root' => env('APP_ENV'),
            'endpoint' => env('HETZNER_S3_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'throw' => false,
            'visibility' => 'private',
        ],

        'export' => [
            'driver' => 's3',
            'key' => env('HETZNER_S3_ACCESS_KEY_ID'),
            'secret' => env('HETZNER_S3_ACCESS_KEY_SECRET'),
            'region' => env('HETZNER_S3_REGION'),
            'bucket' => env('S3_BUCKET_EXPORT'),
            'root' => env('APP_ENV'),
            'endpoint' => env('HETZNER_S3_ENDPOINT'),
            'use_path_style_endpoint' => true,
        ],

        's3-assets' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET_APP'),
            'visibility' => 'public',
            'url' => env('AWS_URL_ASSETS', env('AWS_URL')),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        's3-marketplace' => [
            'driver' => 's3',
            'key' => env('HETZNER_S3_ACCESS_KEY_ID'),
            'secret' => env('HETZNER_S3_ACCESS_KEY_SECRET'),
            'region' => env('HETZNER_S3_REGION'),
            'bucket' => env('AWS_BUCKET_MARKETPLACE'),
            'endpoint' => env('HETZNER_S3_ENDPOINT'),
            'root' => env('APP_ENV') != 'production' ? env('APP_ENV') : null,
            'use_path_style_endpoint' => true,
        ],

        /**
         * On production, we use cloudfront in front of the default s3
         */
        'cloudfront' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'visibility' => 'public',
            // Url for including the assets in the browser
            'url' => env('AWS_CLOUDFRONT'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

];
