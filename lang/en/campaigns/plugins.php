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
        'update-to'         => 'Update to version :version',
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
    'empty_list'    => 'The campaign doesn\'t currently have any plugins. Go to the plugin library to install a few and come back to activate them.',
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
        'fields'                => [
            'only_new'  => 'Only new entities',
            'private'   => 'Private entities',
        ],
        'helper'                => 'You are about to import :count entities from the :plugin plugin. If this plugin was previously imported, changes you have since made to the imported entities may be lost.',
        'no_new_entities'       => 'There are no new entities to be imported.',
        'option_only_import'    => 'Only import new entities, skipping previously imported entities.',
        'option_private'        => 'Import all entities as private.',
        'success'               => '{1} Imported :count entity from the plugin :plugin.|[2,*] Imported :count entities from the plugin :plugin.',
        'title'                 => 'Import content pack',
        'updated'               => 'Updated the following entities:',
    ],
    'info'          => [
        'description' => 'Showing the latest updates for the :plugin plugin.',
        'helper'        => 'When a new version of a plugin is released, you can update it to the latest version for your campaign.',
        'title'         => 'Plugin :plugin updates',
        'updates'       => 'Updates',
        'versions'      => 'Versions',
        'installed'     => 'Installed',
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
