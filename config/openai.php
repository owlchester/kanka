<?php

return [

    /*
     * API Key
     */
    'secret' => env('OPEN_AI_SECRET', 0),

    /*
     * AI model to use.
     *
     * Available models:
     * "text-babbage-001"
     * "text-curie-001"
     * "text-ada-001"
     * "text-davinci-003"
     */
    'engine' => env('OPEN_AI_ENGINE', 'text-davinci-003'),

    /*
     * Number of tokens to use for prompt generation.
     */
    'tokens' => 400,

    'prompt' =>  "Write and format with html three paragraphs for a character's backstory, 
                the first one should provide details about their apearance, 
                the second one should be about their origins 
                and the third one should be about their routine, all of them written as a short story inspired by the following prompt: '",

    'prompt2' =>  ".' the character's name is: '",
];
