<?php

/**
 * Discord config
 */
return [
    /**
     * The Discord URL to join the Kanka server.
     */
    'url' => 'https://discord.gg/rhsyZJ4',

    'client_id' => getenv('DISCORD_CLIENT_ID'),
    'client_secret' => getenv('DISCORD_SECRET'),
    'channel_id' => getenv('DISCORD_CHANNEL_ID'),
    'bot_secret' => getenv('DISCORD_BOT_SECRET'),
    'bot_token' => getenv('DISCORD_BOT_TOKEN'),

    'roles' => [
        'owlbear' => 435813101506527233,
        'elemental' => 501452722273386496,
    ]
];
