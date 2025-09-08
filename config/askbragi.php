<?php

return [
    'providers' => [
        'openai' => 'OpenAI'
    ],

    'openai' => [
        'gpt-5' => 'gpt-5',
        'gpt-5-mini' => 'gpt-5-mini',
    ],

    'system-prompt' => env('ASKBRAGI_SYSTEM_PROMPT', 'You are the lorekeeper of this campaign. You only answer questions not generate anything new, and answer based only on the campaign content provided.')

];