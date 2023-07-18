<?php

/**
 * Config for the Thumbor service. This is used to generate thumbnails of every image.
 * When running Kanka locally with docker, it comes with a lightweight thumbor instance
 * that will read and save thumbnails from minio.
 */

return [
    'key' => env('THUMBOR_KEY'),
    'bases' => [
        'user' => 'https://' . env('AWS_BUCKET') . '.s3.eu-central-1.amazonaws.com/',
        'app' => 'https://' . env('AWS_BUCKET_APP') . '.s3.eu-central-1.amazonaws.com/',
    ],
    'url' => env('THUMBOR_URL', 'http://localhost:8889/'),
];
