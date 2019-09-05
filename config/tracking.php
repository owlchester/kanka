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
];
