<?php

return [
    'campaigns' => [
        /**
         * The last campaign ID before the feature changes of Summer 2022.
         * Defaults to null on local installs due to them not having this limitation
         */
        'grandfathered' => env('APP_CAMPAIGN_GRANDFATHERED', 1),

        /**
         * Limits in place for non-grandfathered unboosted campaigns
         */
        'member_limit' => 10,
        'role_limit' => 3,
        'quick_link_limit' => 3,
        'entity_limit' => 250,
    ]
];
