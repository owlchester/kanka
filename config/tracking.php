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
     * Facebook tracking pixel on homepage for "join now"
     * If empty, tracking will be disabled
     */
    'fb' => env('TRACKING_FB'),

    /*
     * Reddit tracking pixel on homepage for reddit ads
     * If empty, tracking will be disabled
     */
    'reddit' => env('TRACKING_REDDIT'),

    /*
     * AdSense ID
     */
    'adsense' => env('TRACKING_ADSENSE'),
    'adsense_sidebar' => env('TRACKING_ADSENSE_SIDEBAR'),
    'adsense_dashboard' => env('TRACKING_ADSENSE_DASHBOARD'),
    'adsense_entity' => env('TRACKING_ADSENSE_ENTITY'),
    'adsense_footer' => env('TRACKING_ADSENSE_FOOTER'),

    /*
     * Hotjar tracking
     */
    'hotjar' => env('TRACKING_HOTJAR'),

    /**
     * Google optimize
     */
    'optimize' => env('TRACKING_OPTIMIZE')
];
