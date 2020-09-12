<?php

return [
    'actions' => [
        'go_to_marketplace' => 'Go to the Marketplace',
        'enable' => 'Enable plugin',
        'disable' => 'Disable plugin',
        'remove' => 'Remove plugin',
        'update' => 'Update plugin',
        'update_available' => 'Update available!',
    ],
    'title' => 'Campaign :name Plugins',
    'helper' => 'The Kanka community is constantly creating amazing plugins on our marketplace. If your campaign is boosted, you can install plugins from the marketplace. Use this interface to uninstall plugins in your campaign.',
    'fields' => [
        'name' => 'Plugin name',
        'type' => 'Plugin type',
        'status' => 'Status',
    ],
    'types' => [
        'theme' => 'Theme',
        'attributes' => 'Attribute Template',
        'pack' => 'Content Pack',
    ],
    'info' => [
        'title' => 'Plugin :plugin updates',
        'updates' => 'Updates',
        'helper' => 'When a new version of a plugin is released, you can update it to the latest version for your campaign.',
        'your_version' => 'Your version'
    ],
    'status' => [
        'enabled' => 'Enabled',
        'disabled' => 'Disabled',
    ],
    'enabled' => [
        'success' => 'Plugin :plugin enabled.',
    ],
    'disabled' => [
        'success' => 'Plugin :plugin disabled.',
    ],
    'update' => [
        'success' => 'Plugin :plugin updated.',
    ],
    'empty_list' => 'The campaign doesn\'t currently have any plugins. Go to the marketplace to install a few and come back to activate them.',
];
