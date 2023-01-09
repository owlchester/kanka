<?php

return [

    /**
     * API Key
     */
    'secret' => env('OPEN_AI_SECRET', 0),

    /**
     * AI model to use.
     *
     * Available models:
     * "text-babbage-001"
     * "text-curie-001"
     * "text-ada-001"
     * "text-davinci-003"
     */
    'engine' => env('OPEN_AI_ENGINE', 'text-davinci-003'),

    /**
     * Number of tokens to use for prompt generation.
     */
    'tokens' => 400,

    /**
     * English keywords to use for various generations
     */
    'prompts' => [
        'first' => [
            'appearance',
            'clothing',
            'fashion style',
            'popularity',
        ],
        'second' => [
            'origins',
            'upbringing',
            'education',
            'childhood',
            'childhood home',
            'craft',
        ],
        'third' => [
            'routine',
            'goals',
            'fears',
            'business',
            'travels',
            'successes',
            'failures',
        ],
    ],
];
