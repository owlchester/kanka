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
        'confirm'   => 'Write :code if you are sure you want to permanently delete the :name custom module.',
        'helper'    => 'Are you sure you want to remove the :name custom module? This will also permanently delete all entities, bookmarks and widgets linked to this module.',
        'success'   => 'Module :name deleted.',
        'title'     => 'Module deletion',
    ],
    'errors'        => [
        'disabled'  => 'The :name module is disabled. :fix',
        'limit'     => 'Campaigns are currently limited to only :max custom modules while we iron out this new feature.',
    ],
    'fields'        => [
        'icon'      => 'Module icon',
        'plural'    => 'Module plural name',
        'singular'  => 'Module singular name',
    ],
    'helpers'       => [
        'custom'    => 'This is a custom module.',
        'icon'      => 'Give this module a special :fontawesome icon, for example :example.',
        'info'      => 'A campaign is split into several modules that interact with each other. Enable or disable those you don\'t need. Deactivating a module doesn\'t delete any of its data, it only hides it.',
        'plural'    => 'The plural name for entities of the new module. For example, potions',
        'roles'     => 'Select roles that should have permission to view entities of this new module. This can later be changed in the role permissions.',
        'singular'  => 'The singular name for an entity of the new module. For example, potion',
    ],
    'pitch'         => 'Rename this module and choose a custom icon to better match your campaign\'s theme and style. Perfect for tailoring the experience to your world and players.',
    'pitch-custom'  => 'Create custom modules to represent any kind of entity in your world. No limits, just creativity.',
    'rename'        => [
        'helper'    => 'Change the name and icon of the module throughout the campaign. Leave blank to use Kanka\'s default.',
        'success'   => 'Module customised.',
        'title'     => 'Customise the :module module',
    ],
    'reset'         => [
        'default'   => 'This will only reset the default modules, not any custom ones.',
        'success'   => 'The campaign modules have been reset.',
        'title'     => 'Reset module custom names and icons',
        'warning'   => 'Are you sure you want to reset the campaign modules to their original names and icons?',
    ],
    'sections'      => [
        'custom'    => 'Custom modules',
        'default'   => 'Default modules',
        'features'  => 'Features',
    ],
    'states'        => [
        'disable'   => 'Disable',
        'enable'    => 'Enable',
    ],
];
