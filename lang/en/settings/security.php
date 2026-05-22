<?php

return [
    'title' => 'Security',
    'helper' => 'Manage where you are logged in. Revoking a device will log it out immediately.',
    'devices' => [
        'title' => 'Active Sessions',
        'current' => 'This device',
        'revoke_others' => 'Log out all other devices',
        'revoked' => 'Device has been logged out.',
        'revoked_others' => 'All other devices have been logged out.',
        'unknown' => 'Unknown device',
        'unknown_browser' => 'Unknown browser',
        'last_active' => 'Last active',
        'ip_address' => 'IP address',
        'empty' => 'No active sessions found.',
    ],
];
