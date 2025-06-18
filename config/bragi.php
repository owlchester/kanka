<?php

return [
    'tokens' => [
        'admin' => env('BRAGI_ADMIN_LIMIT', 99),
        'elemental' => env('BRAGI_ELEMENTAL_LIMIT', 50),
        'wyvern' => env('BRAGI_WYVERN_LIMIT', 25),
        'all' => 0,
    ],
    'limit' => [
        'prompt' => 180,
    ],
    'backstory' => [
        'temperature' => 0.9,
        'presence_penalty' => 0.5,
        'frequency_penalty' => 0.2,
        /**
         * AI model to use.
         *
         * Available models:
         * "text-babbage-001"
         * "text-curie-001"
         * "text-ada-001"
         * "text-davinci-003"
         * "gpt-3.5-turbo"
         */
        'engine' => env('OPEN_AI_ENGINE', 'gpt-3.5-turbo'),

        /**
         * Max number of tokens used for generating a backstory
         */
        'tokens' => 400,
    ],
    /**
     * Decimal point after 0 of a chance of being a disciple of Kankappy.
     */
    'kankappy' => 5,
];
