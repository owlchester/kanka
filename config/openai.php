<?php

return [

    /**
     * API Key
     */
    'secret' => env('OPEN_AI_SECRET', 0),

    /**
     * Custom URL
     */
    'custom_url' => env('OPEN_AI_URL', ''),

    /**
     * Number of tokens to use for prompt generation.
     */
    'tokens' => 650,
];
