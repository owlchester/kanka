<?php

return [
    'enabled' => (bool) env('MCP_ENABLED', false),

    'redirect_domains' => array_filter(explode(',', env('MCP_REDIRECT_DOMAINS', 'http://localhost'))),

    'custom_schemes' => [],

    'authorization_server' => null,

    'tool_search' => [
        'max_tool_calls' => 4,
        'max_output_bytes' => 65_536,
    ],
];
