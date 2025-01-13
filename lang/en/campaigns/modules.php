<?php

return [
    'actions'   => [
        'customise' => 'Customise',
        'create' => 'Create module',
    ],
    'create'   => [
        'title' => 'New module',
        'helper' => 'Create a new custom module to store entities that don\'t fit in the other modules.',
        'success' => 'New module created.',
    ],
    'fields'    => [
        'icon'      => 'Module icon',
        'plural'    => 'Module plural name',
        'singular'  => 'Module singular name',
    ],
    'helpers'   => [
        'custom' => 'This is a custom module found only here.',
        'info'  => 'A campaign is split into several modules that interact with each other. Enable or disable those you don\'t need. Deactivating a module doesn\'t delete any of its data, it only hides it.',
        'singular' => 'The singular name for an entity of the new module. For example, potion',
        'plural' => 'The plural name for entities of the new module. For example, potions',
        'icon' => 'The :fontawesome icon, for example :example.',
    ],
    'pitch'     => 'Rename and change the icon associated with this module for the whole campaign.',
    'rename'    => [
        'helper'    => 'Change the name and icon of the module throughout the campaign. Leave blank to use Kanka\'s default.',
        'success'   => 'Module customised.',
        'title'     => 'Customise the :module module',
    ],
    'reset'     => [
        'success'   => 'The campaign modules have been reset.',
        'title'     => 'Reset module custom names and icons',
        'warning'   => 'Are you sure you want to reset the campaign modules to their original names and icons?',
    ],
    'states'    => [
        'disable'   => 'Disable',
        'enable'    => 'Enable',
    ],
];
