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
            'tame fashion style',
            'flashy fashion style',
            'questionable fashion style',
            'popularity',
            'unpopularity',
            'physical condition',
            'injury',
        ],
        'second' => [
            'origin',
            'upbringing',
            'education',
            'childhood',
            'childhood home',
            'craft',
            'childhood friends',
            'parents',
            'children',
            'partner',
            'partners',
        ],
        'third' => [
            'routine',
            'goals',
            'fears',
            'business',
            'travels',
            'successes',
            'failures',
            'accident',
            'lies',
            'crimes',
            'dreams',
            'mistakes',
            'successful gambles',
            'endeavours',
            'risks',
            'fall from grace',
            'rise to riches',
            'ingenuity',
        ],
    ],
];
