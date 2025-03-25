<?php

return [
    /*
     * Google Tag Manager
     * Used to track various events on the application.
     * If empty, event tracking will be disabled
     */
    'gtm' => env('TRACKING_GTM'),

    /*
     * Google Analytics
     * Used to track visits to the application.
     * If empty, tracking will be disabled
     */
    'ga' => env('TRACKING_GA'),

    /*
     * Google Analytics conversation tracking
     * Used to track who converts to the app
     * If empty, tracking will be disabled
     */
    'ga_convo' => env('TRACKING_GA_CONVERSION'),

    /*
     * AdSense ID
     */
    'adsense' => env('TRACKING_ADSENSE'),
    'adsense_sidebar' => env('TRACKING_ADSENSE_SIDEBAR'),
    'adsense_dashboard' => env('TRACKING_ADSENSE_DASHBOARD'),
    'adsense_entity' => env('TRACKING_ADSENSE_ENTITY'),
    'adsense_footer' => env('TRACKING_ADSENSE_FOOTER'),

    /*
     * Venatus ad-manager
     */
    'venatus' => [
        'enabled' => ! empty(env('TRACKING_VENATUS')),
        'id' => env('TRACKING_VENATUS'),
        'sidebar' => env('TRACKING_VENATUS_DYNAMIC_MOBILE'),
        'entity' => env('TRACKING_VENATUS_STATIC_BANNER'),
        'hybrid' => env('TRACKING_VENATUS_DYNAMIC_BANNER'),
        'profile' => env('TRACKING_VENATUS_DYNAMIC_MOBILE'),
        'inline' => env('TRACKING_VENATUS_DYNAMIC_MOBILE'),
        'rich' => env('TRACKING_VENATUS_RICH'),

    ],

    'consent' => env('TRACKING_CONSENT') == 'True',
];
