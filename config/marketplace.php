<?php

return [
    /*
    |-------------------------------------------
    | Marketplace enabled
    |-------------------------------------------
    |
    | This value tells the app if the marketplace is available or not.
     */
    'enabled' => !empty(env('APP_MARKETPLACE_URL', null)),

    /*
    |-------------------------------------------
    | Marketplace url
    |-------------------------------------------
    |
    | This value tells us the url for the marketplace
     */
    'url' => env('APP_MARKETPLACE_URL', 'https://plugins.kanka.io'),
];
