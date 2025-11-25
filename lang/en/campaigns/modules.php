<?php

return [
    'actions'       => [
        'create'    => 'Create module',
        'customise' => 'Customise',
    ],
    'create'        => [
        'helper'    => 'Create a new custom module to store entities that don\'t fit in the other modules.',
        'success'   => 'New module created.',
        'title'     => 'New module',
    ],
    'delete'        => [
        'confirm'           => 'Write :code if you are sure you want to permanently delete the :name custom module.',
        'confirm-button'    => '{0} Permanently delete :name|{1} Permanently delete :name and :count entity|[2,*] Permanently delete :name and :count entities',
        'helper'            => 'Are you sure you want to remove the :name custom module? This will also permanently delete all entities, bookmarks and widgets linked to this module.',
        'entities'          => '{1} This will permanently delete :count entity.|[2,*] This will permanently delete :count entities.',
        'success'           => 'Module :name deleted.',
        'title'             => 'Module deletion',
    ],
    'errors'        => [
        'disabled'              => 'The :name module is disabled. :fix',
        'limit'                 => 'Campaigns are currently limited to only :max custom modules while we iron out this new feature.',
        'limit-title'           => 'Custom Module limit reached',
        'subscription-limit'    => 'The campaign has reached the maximum amount of custom modules available. The person unlocking premium features can subscribe to a higher tier to increase this limit.',
        'empty-custom' => 'Add custom modules to organise data that doesn\'t fit in the default ones.',
    ],
    'fields'        => [
        'status' => 'Module status',
        'icon'          => 'Module icon',
        'plural'        => 'Module plural name',
        'singular'      => 'Module singular name',
        'update_name'   => 'Rename module bookmark with new name',
    ],
    'status' => [
        'enabled' => 'Module enabled',
    ],
    'helpers'       => [
        'status' => 'Disabled modules are hidden from navigation and menus. No data is deleted.',
        'custom'    => 'This is a custom module.',
        'icon'      => 'Give this module a special :fontawesome icon, for example :example.',
        'tutorial' => 'Modules control which features are visible in the campaign. Enable the ones you use and hide the rest. Turning a module off never deletes data; it only removes it from navigation and creation menus.',
        'plural'    => 'Used in navigation and lists (.e.g, "view all potions")',
        'roles'     => 'Select roles that should have permission to view entities of this new module. This can later be changed in the role permissions.',
        'singular'  => 'Used when referring to a single item (e.g., "new potion")',
    ],
    'pitch'         => 'Rename this module and choose a custom icon to better match the campaign\'s theme and style. Perfect for tailoring the experience to your world and players.',
    'pitch-custom'  => 'Create custom modules for any entity type your world needs. Track deities, potions, succession laws, or whatever makes your campaign unique. Premium gives you complete flexibility.',
    'pitch-title' => 'Unlock custom modules',
    'rename'        => [
        'helper'    => 'Customise how this module appears throughout the campaign. Leave fields blank to use default values.',
        'success'   => 'Module customised.',
        'title'     => 'Customise :module',
    ],
    'reset'         => [
        'default'   => 'This will only reset the default modules, not any custom ones.',
        'success'   => 'The campaign modules have been reset.',
        'title'     => 'Reset module custom names and icons',
        'warning'   => 'Are you sure you want to reset the campaign modules to their original names and icons?',
    ],
    'sections'      => [
        'custom'        => 'Custom modules',
        'default'       => 'Default modules',
        'early-access'  => 'Early access',
        'features'      => 'Features',
    ],
    'states'        => [
        'disable'   => 'Disable',
        'enable'    => 'Enable',
        'enabled' => 'Module is enabled',
        'disabled' => 'Module is disabled',
    ],
];
