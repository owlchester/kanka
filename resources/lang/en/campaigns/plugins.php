<?php

return [
    'actions'       => [
        'bulks' => [
            'enable' => 'Enable plugins',
            'disable' => 'Disable plugins',
            'update' => 'Update plugins',
        ],
        'disable'           => 'Disable plugin',
        'enable'            => 'Enable plugin',
        'go_to_marketplace' => 'Go to the Marketplace',
        'import'            => 'Import',
        'remove'            => 'Remove plugin',
        'update'            => 'Update plugin',
        'update_available'  => 'Update available!',
    ],
    'bulks' => [
        'enable' => '{1} Enabled :count plugin.|[2,*] Enabled :count plugins.',
        'disable' => '{1} Disabled :count plugin.|[2,*] Disabled :count plugins.',
        'delete' => '{1} Removed :count plugin.|[2,*] Removed :count plugins.',
        'update' => '{1} Updated :count plugin.|[2,*] Updated :count plugins.',
    ],
    'destroy'       => [
        'success'   => 'Plugin :plugin removed.',
    ],
    'disabled'      => [
        'success'   => 'Plugin :plugin disabled.',
    ],
    'empty_list'    => 'The campaign doesn\'t currently have any plugins. Go to the marketplace to install a few and come back to activate them.',
    'enabled'       => [
        'success'   => 'Plugin :plugin enabled.',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Invalid plugin.',
    ],
    'fields'        => [
        'name'      => 'Plugin name',
        'status'    => 'Status',
        'type'      => 'Plugin type',
    ],
    'helper'        => 'The Kanka community is constantly creating amazing plugins on our marketplace. If this campaign is boosted, you can install plugins from the marketplace. Use this interface to uninstall plugins in your campaign.',
    'import'        => [
        'button'                => 'Import',
        'created'               => 'Created the following entities:',
        'helper'                => 'You are about to import :count entities from the :plugin plugin. If this plugin was previously imported, changes you have made to the imported entities can be lost.',
        'no_new_entities'       => 'There are no new entities to be imported.',
        'option_only_import'    => 'Only import new entities, skipping previously imported entities.',
        'option_private'        => 'Import all entities as private.',
        'success'               => '{1} Imported :count entity from the plugin :plugin.|[2,*] Imported :count entities from the plugin :plugin.',
        'title'                 => 'Import :plugin',
        'updated'               => 'Updated the following entities:',
    ],
    'info'          => [
        'helper'        => 'When a new version of a plugin is released, you can update it to the latest version for your campaign.',
        'title'         => 'Plugin :plugin updates',
        'updates'       => 'Updates',
        'your_version'  => 'Your version',
    ],
    'status'        => [
        'disabled'  => 'Disabled',
        'enabled'   => 'Enabled',
    ],
    'templates'     => [
        'name'  => ':name by :user',
    ],
    'title'         => 'Campaign :name Plugins',
    'types'         => [
        'attribute' => 'Attribute Template',
        'pack'      => 'Content Pack',
        'theme'     => 'Theme',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin updated.',
    ],
];
