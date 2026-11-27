<?php

return [
    /**
     * We use FontAwesome Pro (via a self-hosted stylesheet URL or a FontAwesome Kit) to load
     * additional icons. `pro_url` takes precedence over `kit`; when neither is set, the local
     * free stylesheet is used.
     * https://fontawesome.com/kits
     */
    'pro_url' => env('FONTAWESOME_PRO_URL'),

    'kit' => env('FONTAWESOME_KIT'),

    'search' => 'https://fontawesome.com/search',
];
