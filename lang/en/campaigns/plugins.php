<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Disable themes',
            'enable'    => 'Enable themes',
            'update'    => 'Update plugins',
        ],
        'changelog'         => 'Changelog',
        'disable'           => 'Disable theme',
        'enable'            => 'Enable theme',
        'find-plugins'      => 'Find plugins',
        'import'            => 'Import',
        'update'            => 'Update plugin',
        'update_available'  => 'Update available!',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count plugin.|[2,*] Removed :count plugins.',
        'disable'   => '{1} Disabled :count theme.|[2,*] Disabled :count themes.',
        'enable'    => '{1} Enabled :count themes.|[2,*] Enabled :count themes.',
        'update'    => '{1} Updated :count plugin.|[2,*] Updated :count plugins.',
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
        'name'      => 'Plugin',
        'obsolete'  => 'This plugin has been marked as obsolete by the Kanka team, meaning it no longer works as originally intended by its author.',
        'status'    => 'Status',
        'type'      => 'Type',
    ],
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
    'pitch'         => 'Install and manage plugins from the :marketplace.',
    'status'        => [
        'always'    => 'This plugin type is always active unless removed.',
        'disabled'  => 'Disabled',
        'enabled'   => 'Enabled',
    ],
    'templates'     => [
        'name'  => ':name by :user',
    ],
    'title'         => 'Plugins - :name',
    'types'         => [
        'attribute' => 'Attribute Template',
        'pack'      => 'Content Pack',
        'theme'     => 'Theme',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin updated.',
    ],
];
