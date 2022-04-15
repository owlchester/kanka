<?php

return [
    'provider' => env('ADS_PROVIDER'),

    'dScryb' => [
        'sidebar' => env('ADS_SIDEBAR'),
        'url' => env('ADS_URL'),
        'banner' => env('ADS_BANNER'),
        'footer' => env('ADS_FOOTER'),

        'posters' => [
            'sidebar' => env('ADS_SIDEBAR_POSTER'),
            'banner' => env('ADS_BANNER_POSTER'),
        ],
    ],

    'ks' => [
        'url' => ' https://www.kickstarter.com/projects/thedmlair/lairs-and-legends?ref=dyvst5',
        'sidebar' => 'https://kanka-app-assets.s3.amazonaws.com/images/ads/lair-legends/Lairs-_-Legends-Banner-280x280.jpg',
        'banner' => 'https://kanka-app-assets.s3.amazonaws.com/images/ads/lair-legends/Lairs-_-Legends-Banner-900x225.jpg',
    ],
];
