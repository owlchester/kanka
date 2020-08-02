<?php

return [
    /*
     * Google Tag Manager
     * Used to track various events on the application.
     * If empty, event tracking will be disabled
     */
    'gtm' => env('TRACKING_GTM', null),

    /*
     * Google Analytics
     * Used to track visits to the application.
     * If empty, tracking will be disabled
     */
    'ga' => env('TRACKING_GA', null),

    /*
     * Google Analytics conversation tracking
     * Used to track who converts to the app
     * If empty, tracking will be disabled
     */
    'ga_convo' => env('TRACKING_GA_CONVERSION', null),

    /*
     * Facebook tracking pixel on homepage for "join now"
     * If empty, tracking will be disabled
     */
    'fb' => env('TRACKING_FB', null),


    /*
     * AdSense ID
     */
    'adsense' => env('TRACKING_ADSENSE', null),
];
