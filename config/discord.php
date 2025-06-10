<?php

/**
 * Discord config
 */

return [
    'client_id' => getenv('DISCORD_CLIENT_ID'),
    'client_secret' => getenv('DISCORD_SECRET'),
    'channel_id' => getenv('DISCORD_CHANNEL_ID'),
    'bot_secret' => getenv('DISCORD_BOT_SECRET'),
    'bot_token' => getenv('DISCORD_BOT_TOKEN'),

    'webhooks' => [
        'features' => env('DISCORD_WEBHOOK_FEATURES', null),
    ],
    'color' => env('DISCORD_COLOR', '7506394'),

    'roles' => [
        'owlbear' => 435813101506527233,
        'wyvern' => 805183678153621514,
        'elemental' => 501452722273386496,
    ],
];
