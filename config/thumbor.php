<?php
/**
 * Config for the Thumbor service
 */

return [
    'key' => getenv('THUMBOR_KEY'),
    'bases' => [
        'user' => 'https://' . env('AWS_BUCKET') . '.s3.eu-central-1.amazonaws.com/',
        'app' => 'https://' . env('AWS_BUCKET_APP') . '.s3.eu-central-1.amazonaws.com/',
    ],
    'url' => 'https://images.kanka.io/',
];
